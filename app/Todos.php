<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todos extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function log()
    {
        return $this->hasMany(TodoLog::class, 'todo_id');
    }

    public function members()
    {
        return $this->belongsToMany(TodoMember::class, 'todo_members', 'todo_id', 'user_id');
    }

    public function lists()
    {
        return $this->hasMany(TodoList::class, 'todo_id');
    }
}
