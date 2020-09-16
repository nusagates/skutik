<?php

use App\Post;
use App\Tags;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use App\Challenge;

if (!function_exists('set_title')) {
    function set_title($title = '')
    {
        if (empty($title)) return config('app.name') . " - Sederhana & Unik";
        return ucwords($title) . " - " . config('app.name');
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
if (!function_exists('set_image_slug')) {
    function set_image_slug($title, $ext='.png')
    {
        $url = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = get_image_slug($url);

        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('url', $url)) {
            return $url;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $urls = substr($url, 0 , (strrpos($url, ".")));
            $newSlug = $url . '-' . $i.$ext;
            if (!$allSlugs->contains('url', $newSlug)) {
                return $newSlug.$ext;
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
if (!function_exists("get_image_slug")) {
    function get_image_slug($url)
    {

        return \App\Media::select('url')->where('url', 'like', $url. '%')
            ->get();
    }
}
if (!function_exists('upload_image_error')) {
    function upload_image_error($msg)
    {
        return [
            'error' => [
                'message' => $msg
            ]
        ];
    }
}
if (!function_exists('get_all_tags')) {
    function get_all_tags()
    {
        if (Schema::hasTable('tags')) {
            $tags = \App\Tags::withCount(['tag'])
                ->orderBy('tag_count', 'desc')
                ->paginate(20);
            foreach ($tags as $item) {
                if ($item->tag_count != 0) {
                    echo '<a class="btn btn-sm btn-outline-success my-1 mx-1" href="' . $item->url . '">' . strtolower($item->name) . '[' . $item->tag_count . ']</a>';
                }
            }
        }
    }
}
if (!function_exists('get_latest_posts')) {
    function get_latest_post()
    {
        if (Schema::hasTable('posts')) {
            $post = Post::where('post_type', 'post')
                ->where('post_status', 'publish')
                ->latest()->paginate(5);
            $html = '<ul>';
            foreach ($post as $item) {
                $html .= '<li><a href="' . $item->url . '">' . $item->post_title . '</a></li>';
            }
            $html .= '</ul>';
            return $html;
        }
    }
}
if (!function_exists('get_popular_posts')) {
    function get_popular_post()
    {
        if (Schema::hasTable('posts')) {
            $post = Post::where('post_type', 'post')
                ->where('post_status', 'publish')
                ->orderBy('post_view', 'desc')
                ->paginate(5);
            $html = '<ul>';
            foreach ($post as $item) {
                $html .= '<li><a class="text-success" href="' . $item->url . '">' . $item->post_title . '</a></li>';
            }
            $html .= '</ul>';
            return $html;
        }
    }
}
if (!function_exists('get_latest_challenge')) {
    function get_latest_challenge()
    {
        if (Schema::hasTable('challenges')) {
            $post = Challenge::where('challenge_type', 'post')
                ->where('challenge_status', 'publish')
                ->latest()->paginate(5);
            $html = '<ul>';
            foreach ($post as $item) {
                $html .= '<li><a href="' . $item->url . '">' . $item->challenge_title . '</a></li>';
            }
            $html .= '</ul>';
            return $html;
        }
    }
}
if (!function_exists('sitemap_posts')) {
    function sitemap_posts()
    {
        if (Schema::hasTable('posts')) {
            $xmlString = '<?xml version="1.0" encoding="UTF-8"?>';
            $xmlString .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            $post = Post::where('post_status', 'publish')->latest()->get();
            foreach ($post as $item) {
                $xmlString .= '<url>';
                $xmlString .= '<loc>' . $item->url . '</loc>';
                $xmlString .= '<lastmod>' . $item->updated_at_iso . '</lastmod>';
                $xmlString .= '<changefreq>daily</changefreq>';
                $xmlString .= '<priority>1.0</priority>';
                $xmlString .= '</url>';
            }


            $xmlString .= '</urlset>';

            $dom = new DOMDocument;
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($xmlString);

            $dom->save(public_path('sitemap/sitemap_post.xml'));
        }
    }
}
if (!function_exists('sitemap_challenge')) {
    function sitemap_challenge()
    {
        if (Schema::hasTable('challenges')) {
            $xmlString = '<?xml version="1.0" encoding="UTF-8"?>';
            $xmlString .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';


            $post = Challenge::where('challenge_status', 'publish')->latest()->get();
            foreach ($post as $item) {
                $xmlString .= '<url>';
                $xmlString .= '<loc>' . $item->url . '</loc>';
                $xmlString .= '<lastmod>' . $item->updated_at_iso . '</lastmod>';
                $xmlString .= '<changefreq>daily</changefreq>';
                $xmlString .= '<priority>1.0</priority>';
                $xmlString .= '</url>';
            }


            $xmlString .= '</urlset>';

            $dom = new DOMDocument;
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($xmlString);

            $dom->save(public_path('sitemap/sitemap_challenge.xml'));
        }
    }
}
if (!function_exists('sitemap_result')) {
    function sitemap_result()
    {
        if (Schema::hasTable('quiz_answers')) {
            $xmlString = '<?xml version="1.0" encoding="UTF-8"?>';
            $xmlString .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';


            $post = \App\QuizAnswer::latest()->get();
            foreach ($post as $item) {
                $xmlString .= '<url>';
                $xmlString .= '<loc>' . $item->url . '</loc>';
                $xmlString .= '<lastmod>' . $item->updated_at_iso . '</lastmod>';
                $xmlString .= '<changefreq>daily</changefreq>';
                $xmlString .= '<priority>1.0</priority>';
                $xmlString .= '</url>';
            }


            $xmlString .= '</urlset>';

            $dom = new DOMDocument;
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($xmlString);

            $dom->save(public_path('sitemap/sitemap_result.xml'));
        }
    }
}
if (!function_exists('sitemap_media')) {
    function sitemap_media()
    {
        if (Schema::hasTable('media')) {
            ob_start();
            $xmlString = '<?xml version="1.0" encoding="UTF-8"?>';
            $xmlString .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            $media = \App\Media::latest()->get();
            foreach ($media as $item) {
                $xmlString .= '<url>';
                $xmlString .= '<loc>' . url('media/image/' . $item->url) . '</loc>';
                $xmlString .= '<lastmod>' . $item->updated_at_iso . '</lastmod>';
                $xmlString .= '<image:image>';
                $xmlString .= '<image:loc>' . url('media/image/' . $item->url) . '</image:loc>';
                $xmlString .= '<image:title><![CDATA[' . $item->title . ']]></image:title>';
                $xmlString .= '<image:caption><![CDATA[' . $item->description . ']]></image:caption>';
                $xmlString .= '</image:image>';
                $xmlString .= '<changefreq>daily</changefreq>';
                $xmlString .= '<priority>1.0</priority>';
                $xmlString .= '</url>';
            }


            $xmlString .= '</urlset>';

            $dom = new DOMDocument;
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($xmlString);

            $dom->save(public_path('sitemap/sitemap_media.xml'));
        }
    }
}
if (!function_exists('sitemap_tags')) {
    function sitemap_tags()
    {
        if (Schema::hasTable('posts')) {
            $xmlString = '<?xml version="1.0" encoding="UTF-8"?>';
            $xmlString .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
            $tid = array();

            //ambil semua tag yang digunakan pada post
            $post_tags = \App\PostTags::all();
            foreach ($post_tags as $tag) {
                $tid[] = [$tag->tag_id];
            }

            //hapus semua tags yang tidak digunakan pada post
            Tags::whereNotIn('id', $tid)->delete();

            //ambil semua tags untuk dimasukkan ke dalam sitemap
            $tags = Tags::all();
            foreach ($tags as $item) {
                $xmlString .= '<url>';
                $xmlString .= '<loc>' . $item->url . '</loc>';
                $xmlString .= '<lastmod>' . date(DATE_ATOM, time()) . '</lastmod>';
                $xmlString .= '<changefreq>daily</changefreq>';
                $xmlString .= '<priority>1.0</priority>';
                $xmlString .= '</url>';
            }


            $xmlString .= '</urlset>';

            $dom = new DOMDocument;
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($xmlString);

            $dom->save(public_path('sitemap/sitemap_tag.xml'));
        }
    }
}
