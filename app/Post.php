<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $guarded = [];

    protected $appends = ['created_date', 'all_tags'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function attribute()
    {
        return $this->hasMany(PostTags::class);
    }


    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getCreatedAtIsoAttribute()
    {
        return $this->created_at->format('c');
    }

    public function getUpdatedAtIsoAttribute()
    {
        return $this->updated_at->format('c');
    }

    public function getUrlAttribute()
    {
        return route('post.show', $this->slug);
    }

    public function getFeaturedImageAttribute()
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($this->post_content);
        libxml_clear_errors();
        $imgTags = $dom->getElementsByTagName('img');
        if ($imgTags->length > 0) {
            $imgElement = $imgTags->item(0);
            return $imgElement->getAttribute('src');
        }
        return url("images/baner.png");
    }

    public function getDescriptionAttribute()
    {
        return !is_null($this->post_excerpt) ? $this->post_excerpt : Str::limit(strip_tags($this->post_content), 160, '...');
    }

    public function getAllTagsAttribute()
    {
        $tagId = [];
        foreach ($this->attribute as $item) {
            $tagId[] = [$item->tag_id];
        }
        $tags = Tags::find($tagId);
        $t = array();
        foreach ($tags as $tag) {
            array_push($t, $tag->name);
        }
        return implode(",", $t);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

}
