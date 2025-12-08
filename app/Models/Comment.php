<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id', 'author_type',
        'target_id', 'target_type',
        'content', 'is_edited'
    ];

    // Ai viết
    public function author()
    {
        return $this->morphTo();
    }

    // Comment thuộc về đâu
    public function target()
    {
        return $this->morphTo();
    }
}
