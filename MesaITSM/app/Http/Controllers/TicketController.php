<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Service;
use App\Models\TicketAttachment;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\CloseTicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the user's tickets.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        
        // Los administradores ven todos los tickets
        if ($user->role === 'administrador') {
            $query = Ticket::with(['assignedTo', 'creator']);
        } 
        // Los técnicos ven tickets asignados a ellos o sin asignar
        elseif ($user->role === 'tecnico') {
            $query = Ticket::where(function($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhereNull('assigned_to');
            })->with(['assignedTo', 'creator']);
        } 
        // Los usuarios solo ven sus propios tickets
        else {
            $query = Ticket::where('created_by', $user->id)
                ->with('assignedTo');
        }

        // Aplicar filtros
        if ($request->filled('status') && $request->status !== 'todos' && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('category') && $request->category !== 'todas' && $request->category !== '') {
            $query->where('category', $request->category);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59'
            ]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $tickets = $query->latest()
            ->paginate(15)
            ->withQueryString();

        // Obtener conteos según el rol
        if ($user->role === 'administrador') {
            $counts = [
                'total' => Ticket::count(),
                'abiertos' => Ticket::whereIn('status', ['nuevo', 'asignado', 'en_proceso'])->count(),
                'pendientes' => Ticket::where('status', 'pendiente_usuario')->count(),
                'resueltos' => Ticket::where('status', 'resuelto')->count(),
                'cerrados' => Ticket::where('status', 'cerrado')->count(),
            ];
        } elseif ($user->role === 'tecnico') {
            $counts = [
                'total' => Ticket::where('assigned_to', $user->id)->orWhereNull('assigned_to')->count(),
                'abiertos' => Ticket::where(function($q) use ($user) {
                    $q->where('assigned_to', $user->id)->orWhereNull('assigned_to');
                })->whereIn('status', ['nuevo', 'asignado', 'en_proceso'])->count(),
                'pendientes' => Ticket::where('assigned_to', $user->id)->where('status', 'pendiente_usuario')->count(),
                'resueltos' => Ticket::where('assigned_to', $user->id)->where('status', 'resuelto')->count(),
                'cerrados' => Ticket::where('assigned_to', $user->id)->where('status', 'cerrado')->count(),
            ];
        } else {
            $counts = [
                'total' => Ticket::where('created_by', $user->id)->count(),
                'abiertos' => Ticket::where('created_by', $user->id)
                    ->whereIn('status', ['nuevo', 'asignado', 'en_proceso'])
                    ->count(),
                'pendientes' => Ticket::where('created_by', $user->id)
                    ->where('status', 'pendiente_usuario')
                    ->count(),
                'resueltos' => Ticket::where('created_by', $user->id)
                    ->where('status', 'resuelto')
                    ->count(),
                'cerrados' => Ticket::where('created_by', $user->id)
                    ->where('status', 'cerrado')
                    ->count(),
            ];
        }

        return view('usuario.tickets.index', compact('tickets', 'counts'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create(Request $request): View
    {
        $selectedService = null;
        if ($request->has('service_id')) {
            $selectedService = Service::find($request->get('service_id'));
        }
        
        return view('tickets.create', compact('selectedService'));
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            DB::beginTransaction();

            // Crear el ticket (el Observer generará el folio automáticamente)
            $ticket = Ticket::create([
                'created_by' => auth()->id(),
                'assigned_to' => $request->assigned_to,
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'subcategory' => $request->subcategory,
                'priority' => $request->priority,
            ]);

            // Procesar archivos adjuntos
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Guardar el archivo
                    $path = $file->store($ticket->getAttachmentsPath(), 'public');
                    
                    // Crear el registro de adjunto
                    $ticket->attachments()->create([
                        'filename' => $file->getClientOriginalName(),
                        'filepath' => $path,
                        'uploaded_by' => auth()->id(),
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            DB::commit();

            // Registrar en el log
            Log::info("Ticket {$ticket->folio} creado por el usuario " . auth()->user()->name);

            // Si es una petición AJAX, retornar JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ticket creado exitosamente',
                    'folio' => $ticket->folio,
                    'ticket_id' => $ticket->id
                ]);
            }

            return redirect()
                ->route('tickets.show', $ticket)
                ->with('success', "Ticket creado exitosamente. Tu número de folio es: {$ticket->folio}");

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error("Error al crear ticket: " . $e->getMessage());

            // Si es una petición AJAX, retornar error JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el ticket. Por favor intenta nuevamente.'
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Error al crear el ticket. Por favor intenta nuevamente.');
        }
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket): View
    {
        // Usar la policy para autorizar el acceso
        $this->authorize('view', $ticket);

        $ticket->load([
            'user', 
            'assignedTo', 
            'attachments.uploader',
            'history.user'
        ]);
        
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the ticket.
     */
    public function edit(Ticket $ticket): View
    {
        // Verificar permisos - solo el creador o administrador pueden editar
        if (auth()->user()->role !== 'administrador' && $ticket->created_by !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este ticket.');
        }

        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified ticket.
     */
    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        // Verificar permisos
        $user = auth()->user();
        if ($user->role !== 'administrador' && $user->role !== 'tecnico' && $ticket->created_by !== $user->id) {
            abort(403, 'No tienes permiso para editar este ticket.');
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:baja,media,alta,critica',
            'status' => 'nullable|in:nuevo,asignado,en_proceso,pendiente_usuario,resuelto,cerrado',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            $updateData = array_filter([
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'status' => $request->status,
                'assigned_to' => $request->assigned_to,
            ], function($value) {
                return $value !== null;
            });

            $ticket->update($updateData);

            // Registrar el cambio en el historial
            $action = isset($request->assigned_to) ? 'asignado' : 'actualizado';
            $ticket->history()->create([
                'user_id' => auth()->id(),
                'action' => $action,
                'comment' => $action === 'asignado' ? 'Ticket asignado a técnico' : 'Ticket actualizado',
            ]);

            DB::commit();

            return back()->with('success', 'Ticket actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al actualizar ticket: " . $e->getMessage());

            return back()->with('error', 'Error al actualizar el ticket. Por favor intenta nuevamente.');
        }
    }

    /**
     * Remove the specified ticket from storage.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        // Solo administradores pueden eliminar tickets
        if (auth()->user()->role !== 'administrador') {
            abort(403, 'No tienes permiso para eliminar tickets.');
        }

        try {
            DB::beginTransaction();

            // Eliminar archivos adjuntos del storage
            foreach ($ticket->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->filepath);
            }

            // Eliminar ticket (cascade eliminará attachments e history)
            $ticket->delete();

            DB::commit();

            return redirect()
                ->route('tickets.index')
                ->with('success', 'Ticket eliminado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar ticket: " . $e->getMessage());

            return back()->with('error', 'Error al eliminar el ticket. Por favor intenta nuevamente.');
        }
    }

    /**
     * Close a resolved ticket with rating.
     */
    public function close(CloseTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        // Verificar que el usuario sea el dueño del ticket
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        // Verificar que el ticket esté resuelto
        if ($ticket->status !== 'resuelto') {
            return back()->with('error', 'Solo se pueden cerrar tickets resueltos.');
        }

        try {
            DB::beginTransaction();

            $ticket->update([
                'status' => 'cerrado',
                'rating' => $request->rating,
                'rating_comment' => $request->rating_comment,
            ]);

            DB::commit();

            return redirect()
                ->route('tickets.show', $ticket)
                ->with('success', 'Ticket cerrado exitosamente. ¡Gracias por tu calificación!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al cerrar ticket: " . $e->getMessage());

            return back()->with('error', 'Error al cerrar el ticket. Por favor intenta nuevamente.');
        }
    }

    /**
     * Download a ticket attachment.
     */
    public function downloadAttachment(TicketAttachment $attachment)
    {
        // Verificar que el usuario tenga acceso al ticket
        $ticket = $attachment->ticket;
        if (auth()->user()->role === 'usuario' && $ticket->user_id !== auth()->id()) {
            abort(403);
        }

        return Storage::disk('public')->download(
            $attachment->filepath,
            $attachment->filename
        );
    }
}