<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        $filepath = public_path('uploads/' . $this->filename);
        if (file_exists($filepath)) {
            $data = file_get_contents($filepath);
        }else{
            $data = file_get_contents(public_path('images/baner.png'));
        }
        $base64 = base64_encode($data);
        header("Content-type: image/png");
        echo base64_decode($base64);
    }
}
