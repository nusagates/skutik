<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomChat extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $appends =['created_date'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
