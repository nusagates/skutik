<?php

namespace App\Http\Controllers;

use App\Media;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
class MediaController extends Controller
{
    public function image_upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $time = date('Y') . '/' . date('m') . "/";
            $path = public_path('uploads/' . $time);
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $file = $request->file('upload');

            $name = $file->getClientOriginalName();
            $name = explode('.', $name);
            $name = $name[0];
            $ext = $file->getClientOriginalExtension();
            $name_formated = Str::slug($name) . ".png";
            $filename = $time . $name_formated;
            $data = [
                'user_id' => Auth::id(),
                'type' => 'image',
                'filename' => $filename,
                'url' => $name_formated,
                'alt' => $name,
                'title' => $name,
                'description' => $name,
            ];
            if (!file_exists($path . $name_formated)) {
                $media = Media::create($data);
            } else {
                $media = Media::where('filename', $filename)->first();
            }
            $file->move($path, $name_formated);
            $filesource = $path . $name_formated;
            ImageOptimizer::optimize($filesource, $filesource);
            $this->convert($filesource, $filesource);
            return ['fileName' => $filename, 'uploaded' => true, 'url' => route('media.image', $media->url)];
        }
    }

    public function image($filename)
    {
        $media = Media::where('url', $filename)->first();
        return $media->image_url;
    }
    public function convert($from, $to)
    {
        $command = 'convert '
            . $from
            .' '
            . '-sampling-factor 4:2:0 -strip -quality 65'
            .' '
            . $to;
        return `$command`;
    }
}
