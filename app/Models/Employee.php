<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    //
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'manager_id',
        'phone',
    ];
    protected $table = 'employees';
    protected $primaryKey = 'id';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function manager(){
        return $this->belongsTo(Manager::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }
    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }
}
