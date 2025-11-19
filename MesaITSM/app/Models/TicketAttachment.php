<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TicketAttachment extends Model
{
    protected $fillable = [
        'ticket_id',
        'filename',
        'filepath',
        'uploaded_by',
        'mime_type',
        'file_size',
    ];

    /**
     * The ticket this attachment belongs to
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * The user who uploaded this attachment
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the formatted file size
     */
    public function getFormattedSize(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return round($bytes, 2) . ' ' . $units[$index];
    }

    /**
     * Get the URL to download the file
     */
    public function getDownloadUrl(): string
    {
        return route('tickets.attachments.download', $this->id);
    }

    /**
     * Delete the file from storage when the model is deleted
     */
    protected static function booted()
    {
        static::deleting(function ($attachment) {
            Storage::delete($attachment->filepath);
        });
    }
}