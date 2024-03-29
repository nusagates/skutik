<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = ['avatar', 'url'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }

    public function todos()
    {
        return $this->belongsToMany(Todos::class, 'todo_members', 'user_id', 'todo_id');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_members', 'user_id', 'room_id');
    }

    public function getUrlAttribute()
    {
        return url("author/" . $this->username);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['username'] = strrev(Carbon::now()->timestamp);
    }

    public function getAvatarAttribute()
    {
        $default = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?d=https%3A%2F%2Fui-avatars.com%2Fapi%2F/' . urlencode($this->name) . '/64/EBF4FF/7F9CF5';
        return $default;
    }
}
