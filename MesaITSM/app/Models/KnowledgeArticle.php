<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class KnowledgeArticle extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'content',
        'tags',
        'is_published',
        'views',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'views' => 'integer',
    ];

    /**
     * Generar slug automáticamente
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Relación con el usuario creador
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Obtener etiquetas como array
     */
    public function getTagsArrayAttribute(): array
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    /**
     * Scope para artículos publicados
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope por categoría
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Incrementar vistas
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Obtener nombre de categoría
     */
    public function getCategoryNameAttribute(): string
    {
        return match($this->category) {
            'guias' => 'Guías y Tutoriales',
            'faq' => 'Preguntas Frecuentes',
            'tecnica' => 'Documentación Técnica',
            'politicas' => 'Políticas y Procedimientos',
            default => $this->category,
        };
    }
}
