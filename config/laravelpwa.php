<?php

return [
    'name' => 'Skutik.Com',
    'manifest' => [
        'name' => env('APP_NAME', 'Skutik.Com'),
        'short_name' => 'Skutik',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '128x128' => [
                'path' => '/images/logo_128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/logo_144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/logo_152.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/logo.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/skutik.png',
            '750x1334' => '/images/skutik.png',
            '828x1792' => '/images/skutik.png',
            '1125x2436' => '/images/skutik.png',
            '1242x2208' => '/images/skutik.png',
            '1242x2688' => '/images/skutik.png',
            '1536x2048' => '/images/skutik.png',
            '1668x2224' => '/images/skutik.png',
            '1668x2388' => '/images/skutik.png',
            '2048x2732' => '/images/skutik.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Artikel',
                'description' => 'Kumpulan Artikel Skutik',
                'url' => '/post',
                'icons' => [
                    "src" => "/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Challenge',
                'description' => 'Kumpulan challenge Skutik',
                'url' => '/challenge'
            ]
        ],
        'custom' => []
    ]
];
