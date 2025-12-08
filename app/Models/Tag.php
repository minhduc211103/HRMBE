<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'color'];

    public function projects()
    {
        return $this->morphedByMany(Project::class, 'taggable');
    }

    public function tasks()
    {
        return $this->morphedByMany(Task::class, 'taggable');
    }
}
