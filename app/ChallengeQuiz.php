<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallengeQuiz extends Model
{
    protected $guarded = [];

    public function choices()
    {
        return $this->hasMany(Choice::class, 'quiz_id');
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
