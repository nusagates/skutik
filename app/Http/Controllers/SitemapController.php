<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;

class SitemapController extends Controller
{
    public function index()
    {
        $path = public_path('sitemap');
        if (!is_dir($path)) {
            mkdir($path, 0777);
        }
        $sitemap = SitemapGenerator::create(config('app.url'))->maxTagsPerSitemap(5000)->writeToFile($path . "/sitemap.xml");
        $files = array_diff(scandir($path), array('.', '..'));

        $sitemap_index = SitemapIndex::create();
        foreach ($files as $item) {
            $sitemap_index->add("sitemap/" . $item);
        }
        $sitemap_index->writeToFile(public_path('sitemap_index.xml'));

        return $files;
    }
}
