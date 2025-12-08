<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    //
    use HasFactory , SoftDeletes ;
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'position',
    ];
    protected $table = 'managers';
    protected $primaryKey = 'id';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function projects(){
        return $this->hasMany(Project::class);
    }
    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }
    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }
}
