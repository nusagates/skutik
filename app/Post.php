<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function setPostTitleAttribute($value)
    {
        $this->attributes['post_title'] = $value;
        $this->attributes['slug'] = Str::slug($value) . "_" . strrev(Carbon::now()->timestamp);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUrlAttribute()
    {
        return url($this->user->username . "/" . $this->slug);
    }
}
