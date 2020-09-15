<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function quizes()
    {
        return $this->hasMany(ChallengeQuiz::class);
    }
    public function getUrlAttribute()
    {
        return route('challenge.show', $this->challenge_slug);
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getAuthorAttribute()
    {
        return $this->user->name;
    }
    public function getCreatedAtIsoAttribute()
    {
        return $this->created_at->format('c');
    }

    public function getUpdatedAtIsoAttribute()
    {
        return $this->updated_at->format('c');
    }
}
