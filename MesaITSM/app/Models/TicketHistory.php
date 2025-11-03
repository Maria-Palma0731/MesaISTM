<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketHistory extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'action',
        'old_value',
        'new_value',
        'comment',
    ];

    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
    ];

    /**
     * Get the ticket that owns this history record
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user who made this change
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the action icon class
     */
    public function getActionIconClass(): string
    {
        return match($this->action) {
            'creado' => 'text-blue-500',
            'asignado' => 'text-purple-500',
            'actualizado' => 'text-yellow-500',
            'cerrado' => 'text-red-500',
            default => 'text-gray-500',
        };
    }

    /**
     * Get the icon class for the timeline display
     */
    public function getIconClass(): string
    {
        return match($this->action) {
            'creado' => 'bg-blue-500',
            'asignado' => 'bg-purple-500',
            'actualizado' => 'bg-yellow-500',
            'comentario' => 'bg-green-500',
            'cerrado' => 'bg-red-500',
            'reabierto' => 'bg-orange-500',
            default => 'bg-gray-500',
        };
    }

    /**
     * Get the icon for the timeline display
     */
    public function getIcon(): string
    {
        return match($this->action) {
            'creado' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/></svg>',
            'asignado' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>',
            'actualizado' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>',
            'comentario' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/></svg>',
            'cerrado' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
            'reabierto' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/></svg>',
            default => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>',
        };
    }

    /**
     * Get the description for the timeline display
     */
    public function getDescription(): string
    {
        $userName = $this->user->name ?? 'Sistema';
        
        return match($this->action) {
            'creado' => "<strong>{$userName}</strong> creó el ticket",
            'asignado' => "<strong>{$userName}</strong> asignó el ticket a <strong>" . ($this->new_value['assigned_to'] ?? 'un técnico') . "</strong>",
            'actualizado' => "<strong>{$userName}</strong> actualizó " . ($this->comment ?? 'el ticket'),
            'comentario' => "<strong>{$userName}</strong> agregó un comentario" . ($this->comment ? ": <em>{$this->comment}</em>" : ''),
            'cerrado' => "<strong>{$userName}</strong> cerró el ticket",
            'reabierto' => "<strong>{$userName}</strong> reabrió el ticket",
            default => "<strong>{$userName}</strong> realizó una acción en el ticket",
        };
    }
}