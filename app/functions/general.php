<?php
if (!function_exists('set_title')) {
    function set_title($title = '')
    {
        if (empty($title)) return config('app.name');
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
