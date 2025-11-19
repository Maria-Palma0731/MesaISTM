<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\TicketHistory;
use Illuminate\Support\Facades\DB;

class TicketObserver
{
    /**
     * Handle the Ticket "creating" event.
     */
    public function creating(Ticket $ticket): void
    {
        // Generar el folio: TKT-YYYYMMDD-0001
        $date = now()->format('Ymd');
        
        // Obtener el último número de secuencia para hoy
        $lastTicket = DB::table('tickets')
            ->where('folio', 'like', "TKT-{$date}-%")
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastTicket 
            ? (int)substr($lastTicket->folio, -4) + 1 
            : 1;

        $ticket->folio = sprintf("TKT-%s-%04d", $date, $sequence);
        $ticket->status = 'nuevo';
    }

    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        // Registrar la creación en el historial
        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => $ticket->created_by,
            'action' => 'creado',
            'new_value' => $ticket->toArray(),
        ]);
    }

    /**
     * Handle the Ticket "updating" event.
     */
    public function updating(Ticket $ticket): void
    {
        // Si el estado cambia a resuelto o cerrado, actualizar closed_at
        if ($ticket->isDirty('status') && in_array($ticket->status, ['resuelto', 'cerrado'])) {
            $ticket->closed_at = now();
        }
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        // Determinar qué acción se realizó
        $action = 'actualizado';
        if ($ticket->wasChanged('assigned_to')) {
            $action = 'asignado';
        } elseif ($ticket->wasChanged('status') && $ticket->status === 'cerrado') {
            $action = 'cerrado';
        }

        // Registrar el cambio en el historial
        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => $action,
            'old_value' => $ticket->getOriginal(),
            'new_value' => $ticket->getChanges(),
        ]);
    }
}