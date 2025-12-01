<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\EscalateTicketRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TecnicoTicketController extends Controller
{
    /**
     * Lista de tickets asignados al técnico (index)
     */
    public function index(Request $request): View
    {
        $query = Ticket::where('assigned_to', auth()->id())
            ->with(['user', 'service.category']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('folio', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Ordenamiento
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $tickets = $query->paginate(15)->withQueryString();

        return view('tecnico.tickets.index', compact('tickets'));
    }

    /**
     * Muestra un ticket específico
     */
    public function show(Ticket $ticket): View
    {
        // Verificar que el ticket esté asignado al técnico
        if ($ticket->assigned_to !== auth()->id()) {
            abort(403, 'No tienes permiso para ver este ticket');
        }

        $ticket->load([
            'user',
            'service.category',
            'assignedTo',
            'comments.user',
            'timeLogs.user',
            'history.user',
            'attachments'
        ]);

        // Obtener lista de técnicos para escalamiento
        $tecnicos = User::where('role', 'tecnico')
            ->where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get();

        return view('tecnico.tickets.show', compact('ticket', 'tecnicos'));
    }

    /**
     * Actualiza el estado de un ticket
     */
    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        // Verificar que el ticket esté asignado al técnico
        if ($ticket->assigned_to !== auth()->id()) {
            abort(403, 'No tienes permiso para actualizar este ticket');
        }

        $validated = $request->validate([
            'status' => 'required|in:asignado,en_proceso,pendiente_usuario,resuelto',
            'comment' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $ticket->update([
                'status' => $validated['status']
            ]);

            if (!empty($validated['comment'])) {
                $ticket->comments()->create([
                    'user_id' => auth()->id(),
                    'comment' => $validated['comment'],
                    'is_internal' => false
                ]);
            }

            DB::commit();

            return redirect()
                ->route('tecnico.tickets.show', $ticket)
                ->with('success', 'Ticket actualizado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar ticket: ' . $e->getMessage());
            
            return back()->with('error', 'Error al actualizar el ticket');
        }
    }

    /**
     * Muestra el dashboard del técnico
     */
    public function dashboard(): View
    {
        // Obtener tickets asignados al técnico
        $ticketsAsignados = Ticket::where('assigned_to', auth()->id());
        
        // Contadores para el dashboard
        $counts = [
            'total_asignados' => (clone $ticketsAsignados)->count(),
            'abiertos' => (clone $ticketsAsignados)
                ->whereIn('status', ['asignado', 'en_proceso'])
                ->count(),
            'resueltos_hoy' => (clone $ticketsAsignados)
                ->where('status', 'resuelto')
                ->whereDate('updated_at', Carbon::today())
                ->count(),
            'proximos_vencer' => 0, // Se implementará en próximo sprint
        ];

        // Tickets por estado para la gráfica
        $ticketsPorEstado = (clone $ticketsAsignados)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Últimos 5 tickets asignados
        $ultimosTickets = (clone $ticketsAsignados)
            ->with(['user'])
            ->latest()
            ->take(5)
            ->get();

        return view('tecnico.dashboard', compact('counts', 'ticketsPorEstado', 'ultimosTickets'));
    }

    /**
     * Lista de tickets asignados al técnico
     */
    public function asignados(Request $request): View
    {
        $query = Ticket::where('assigned_to', auth()->id())
            ->with(['user']);

        // Aplicar filtros
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled(['date_from', 'date_to'])) {
            $query->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59'
            ]);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('tecnico.tickets.asignados', compact('tickets'));
    }

    /**
     * Lista de tickets disponibles para tomar
     */
    public function disponibles(): View
    {
        $tickets = Ticket::whereNull('assigned_to')
            ->where('status', 'nuevo')
            ->with(['user'])
            ->latest()
            ->paginate(15);

        return view('tecnico.tickets.disponibles', compact('tickets'));
    }

    /**
     * Tomar un ticket disponible
     */
    public function tomar(Ticket $ticket): RedirectResponse
    {
        // Verificar que el ticket esté disponible
        if ($ticket->assigned_to !== null || $ticket->status !== 'nuevo') {
            return back()->with('error', 'El ticket ya no está disponible.');
        }

        try {
            DB::beginTransaction();

            $ticket->update([
                'assigned_to' => auth()->id(),
                'status' => 'asignado',
            ]);

            DB::commit();

            return redirect()
                ->route('tecnico.tickets.atender', $ticket)
                ->with('success', 'Ticket asignado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al tomar el ticket. Por favor intenta nuevamente.');
        }
    }

    /**
     * Vista de atención del ticket
     */
    public function atender(Ticket $ticket): View
    {
        // Cargar relaciones necesarias
        $ticket->load([
            'user',
            'assignedTo',
            'attachments.uploader',
            'history.user',
            'comments.user',
            'timeLogs.user'
        ]);

        // Obtener lista de técnicos para escalar
        $tecnicos = User::where('role', 'tecnico')
            ->where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get();

        return view('tecnico.tickets.atender', compact('ticket', 'tecnicos'));
    }

    /**
     * Actualizar estado del ticket
     */
    public function updateStatus(UpdateTicketStatusRequest $request, Ticket $ticket): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Actualizar ticket
            $oldStatus = $ticket->status;
            $oldPriority = $ticket->priority;

            $ticket->update([
                'status' => $request->status,
                'priority' => $request->priority ?? $ticket->priority,
            ]);

            // Registrar tiempo
            $ticket->timeLogs()->create([
                'user_id' => auth()->id(),
                'minutes' => $request->time_minutes,
                'description' => $request->time_description,
            ]);

            // Agregar comentario
            $ticket->comments()->create([
                'user_id' => auth()->id(),
                'comment' => $request->comment,
                'is_internal' => $request->boolean('is_internal', false),
            ]);

            // Si es comentario público, registrar en el log
            if (!$request->boolean('is_internal')) {
                Log::info("Nuevo comentario público en ticket {$ticket->folio} por " . auth()->user()->name);
            }

            DB::commit();

            return back()->with('success', 'Ticket actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al actualizar ticket: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el ticket. Por favor intenta nuevamente.');
        }
    }

    /**
     * Agregar comentario al ticket
     */
    public function addComment(StoreCommentRequest $request, Ticket $ticket): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Crear comentario
            $comment = $ticket->comments()->create([
                'user_id' => auth()->id(),
                'comment' => $request->comment,
                'is_internal' => $request->boolean('is_internal', false),
            ]);

            // Procesar archivos si los hay
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store($ticket->getAttachmentsPath(), 'public');
                    
                    $ticket->attachments()->create([
                        'filename' => $file->getClientOriginalName(),
                        'filepath' => $path,
                        'uploaded_by' => auth()->id(),
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            // Si es comentario público, registrar en el log
            if (!$request->boolean('is_internal')) {
                Log::info("Nuevo comentario público en ticket {$ticket->folio} por " . auth()->user()->name);
            }

            DB::commit();

            return back()->with('success', 'Comentario agregado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al agregar comentario: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al agregar el comentario. Por favor intenta nuevamente.');
        }
    }

    /**
     * Escalar ticket a otro técnico
     */
    public function escalate(EscalateTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $oldTecnico = $ticket->assignedTo;
            
            // Actualizar asignación
            $ticket->update([
                'assigned_to' => $request->assigned_to,
            ]);

            // Agregar comentario interno
            $ticket->comments()->create([
                'user_id' => auth()->id(),
                'comment' => $request->comment,
                'is_internal' => true,
            ]);

            DB::commit();

            return redirect()
                ->route('tecnico.tickets.asignados')
                ->with('success', 'Ticket escalado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al escalar ticket: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al escalar el ticket. Por favor intenta nuevamente.');
        }
    }

    /**
     * Resolver ticket
     */
    public function resolve(StoreCommentRequest $request, Ticket $ticket): RedirectResponse
    {
        if ($ticket->status !== 'en_proceso') {
            return back()->with('error', 'Solo se pueden resolver tickets en proceso.');
        }

        try {
            DB::beginTransaction();

            // Actualizar estado
            $ticket->update([
                'status' => 'resuelto',
            ]);

            // Agregar comentario con la solución
            $ticket->comments()->create([
                'user_id' => auth()->id(),
                'comment' => $request->comment,
                'is_internal' => false, // La solución siempre es pública
            ]);

            Log::info("Ticket {$ticket->folio} marcado como resuelto por " . auth()->user()->name);

            DB::commit();

            return back()->with('success', 'Ticket resuelto correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al resolver ticket: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al resolver el ticket. Por favor intenta nuevamente.');
        }
    }
}