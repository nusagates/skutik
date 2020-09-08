<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $guarded = [];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function detail()
    {
        return $this->hasMany(QuizAnswerDetail::class, 'answer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
