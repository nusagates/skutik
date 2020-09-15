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
    public function getCreatedAtIsoAttribute()
    {
        return $this->created_at->format('c');
    }

    public function getUpdatedAtIsoAttribute()
    {
        return $this->updated_at->format('c');
    }
}
