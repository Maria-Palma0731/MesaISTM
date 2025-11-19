<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine if the user can view any tickets.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver tickets según su rol
    }

    /**
     * Determine if the user can view the ticket.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        // Administradores pueden ver todos los tickets
        if ($user->role === 'administrador') {
            return true;
        }

        // Técnicos pueden ver:
        // - Tickets asignados a ellos
        // - Tickets sin asignar (para tomarlos)
        if ($user->role === 'tecnico') {
            return $ticket->assigned_to === $user->id || $ticket->assigned_to === null;
        }

        // Usuarios normales solo pueden ver sus propios tickets
        return $ticket->created_by === $user->id;
    }

    /**
     * Determine if the user can create tickets.
     */
    public function create(User $user): bool
    {
        // Todos los roles pueden crear tickets
        return in_array($user->role, ['usuario', 'tecnico', 'administrador']);
    }

    /**
     * Determine if the user can take the ticket.
     */
    public function take(User $user, Ticket $ticket): bool
    {
        return $user->role === 'tecnico' && 
               $ticket->assigned_to === null && 
               $ticket->status === 'nuevo';
    }

    /**
     * Determine if the user can attend the ticket.
     */
    public function attend(User $user, Ticket $ticket): bool
    {
        return $user->role === 'tecnico' && $ticket->assigned_to === $user->id;
    }

    /**
     * Determine if the user can close the ticket.
     */
    public function close(User $user, Ticket $ticket): bool
    {
        // El usuario que creó el ticket puede cerrarlo si está resuelto
        return $ticket->created_by === $user->id && 
               $ticket->status === 'resuelto';
    }
}