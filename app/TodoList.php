<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function children(){
        return $this->hasMany(TodoListChild::class);
    }
    public function todo(){
        return $this->belongsTo(Todos::class);
    }
}
