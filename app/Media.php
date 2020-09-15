<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        header("Content-type: image/png");
        $filepath = public_path('uploads/' . $this->filename);
        if (file_exists($filepath)) {
            $data = file_get_contents($filepath);
        }else{
            $data = file_get_contents(public_path('images/baner.png'));
        }
        $base64 = base64_encode($data);
        echo base64_decode($base64);
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
