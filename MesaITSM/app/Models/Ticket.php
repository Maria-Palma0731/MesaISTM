<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    /**
     * Estados permitidos para transición de tickets
     */
    public const STATUS_TRANSITIONS = [
        'asignado' => ['en_proceso'],
        'en_proceso' => ['pendiente_usuario', 'resuelto'],
        'pendiente_usuario' => ['en_proceso'],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'folio',
        'created_by',
        'assigned_to',
        'title',
        'description',
        'category',
        'subcategory',
        'priority',
        'status',
        'rating',
        'rating_comment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'closed_at' => 'datetime',
        'rating' => 'integer',
    ];

    /**
     * The user who created the ticket
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Alias for user() - the creator of the ticket
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The technician assigned to the ticket
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * The service associated with this ticket
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * The attachments for this ticket
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }

    /**
     * Get the storage path for attachments
     */
    public function getAttachmentsPath(): string
    {
        return "tickets/{$this->id}";
    }

    /**
     * Check if the ticket can be rated
     */
    public function canBeRated(): bool 
    {
        return $this->status === 'resuelto' && !$this->rating;
    }

    /**
     * Get the priority badge color class
     */
    public function getPriorityColorClass(): string
    {
        return match($this->priority) {
            'baja' => 'bg-blue-100 text-blue-800',
            'media' => 'bg-yellow-100 text-yellow-800',
            'alta' => 'bg-orange-100 text-orange-800',
            'critica' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the status badge color class
     */
    public function getStatusColorClass(): string
    {
        return match($this->status) {
            'nuevo' => 'bg-blue-100 text-blue-800',
            'asignado' => 'bg-purple-100 text-purple-800',
            'en_proceso' => 'bg-yellow-100 text-yellow-800',
            'pendiente_usuario' => 'bg-orange-100 text-orange-800',
            'resuelto' => 'bg-green-100 text-green-800',
            'cerrado' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * The history entries for this ticket
     */
    public function history(): HasMany
    {
        return $this->hasMany(TicketHistory::class);
    }

    /**
     * The comments on this ticket
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }

    /**
     * The time logs for this ticket
     */
    public function timeLogs(): HasMany
    {
        return $this->hasMany(TicketTimeLog::class);
    }

    /**
     * Check if the current status can transition to the given status
     */
    public function canTransitionTo(string $newStatus): bool
    {
        return isset(self::STATUS_TRANSITIONS[$this->status]) &&
               in_array($newStatus, self::STATUS_TRANSITIONS[$this->status]);
    }

    /**
     * Calculate total time logged on this ticket
     */
    public function getTotalTimeLogged(): int
    {
        return $this->timeLogs()->sum('minutes');
    }
}