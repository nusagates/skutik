<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

if (!function_exists('set_title')) {
    function set_title($title = '')
    {
        if (empty($title)) return config('app.name')." - Sederhana & Unik";
        return $title . " - " . config('app.name');
    }
}
if (!function_exists('ping_SE')) {
    function ping_SE($service)
    {
        $sitemap = url('sitemap_index.xml');
        switch ($service) {
            case 'bing':
                $ping = "http://www.bing.com/webmaster/ping.aspx?siteMap=$sitemap";
                break;
            case 'pingomatic':
                $ping = "http://pingomatic.com/ping/?blogurl=$sitemap";
                break;
            case 'google':
                $ping = "http://www.google.com/webmasters/sitemaps/ping?sitemap=$sitemap";
                break;
            default:
                return false;
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $ping);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);


    }
}

if (!function_exists('set_post_slug')) {
    function set_post_slug($title, $id = 0)
    {
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = get_related_slug($slug, $id);

        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }
}
if (!function_exists("get_related_slug")) {
    function get_related_slug($slug, $id = 0)
    {

        return \App\Post::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}
if (!function_exists('upload_image_error')){
    function upload_image_error($msg){
        return [
            'error'=> [
                'message'=> $msg
            ]
        ];
    }
}
