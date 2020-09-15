<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sitemap generator';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = public_path('sitemap');
        if(!is_dir($path))mkdir($path, 0777);
        sitemap_posts();
        sitemap_tags();
        sitemap_challenge();
        sitemap_media();
        sitemap_result();
        $files = array_diff(scandir($path), array('.', '..'));

        $sitemap_index = SitemapIndex::create();
        foreach ($files as $item) {
            $sitemap_index->add("sitemap/" . $item);
        }
        $sitemap_index->writeToFile(public_path('sitemap_index.xml'));
        ping_SE('bing');
        ping_SE('google');
        ping_SE('pingomatic');
    }
}
