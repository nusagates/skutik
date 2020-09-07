<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        $filepath = public_path('uploads/' . $this->filename);
        $data = file_get_contents($filepath);
        $base64 = base64_encode($data);
        header("Content-type: image/png");
        echo base64_decode($base64);
    }
}
