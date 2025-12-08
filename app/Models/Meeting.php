<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id', 'title', 'description',
        'start_date', 'end_date', 'location',
        'is_online', 'meeting_url', 'created_by'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // N-N user
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_meeting');
    }
}
