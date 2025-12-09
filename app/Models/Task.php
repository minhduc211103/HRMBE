<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id', 'employee_id', 'name',
        'description', 'status', 'start_date',
        'end_date', 'progress'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // polymorphic comment (target)
    public function comments()
    {
        return $this->morphMany(Comment::class, 'target');
    }

    // polymorphic document
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    // polymorphic tag
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
