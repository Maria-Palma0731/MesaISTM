<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeArticle extends Model
{
    use HasFactory;

    protected $fillable = ['author_id','title','content','published'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
