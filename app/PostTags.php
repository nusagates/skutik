<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
    protected $guarded = [];

    public function tag()
    {
        return $this->belongsTo(Tags::class);
    }
}
