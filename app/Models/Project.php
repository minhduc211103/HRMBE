<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    //
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'manager_id', 'name', 'description',
        'status', 'start_date', 'end_date', 'progress'
    ];
    protected $table = 'projects';
    protected $primaryKey = 'id';
    public function manager(){
        return $this->belongsTo(Manager::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function meetings(){
        return $this->hasMany(Meeting::class);
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
