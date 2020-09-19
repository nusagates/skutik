<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded =[];
    use HasFactory;
    public function chats()
    {
        return $this->hasMany(RoomChat::class, 'room_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'room_members', 'room_id', 'user_id');
    }
}
