<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {

    $title = $faker->sentence(rand(3, 6));
    return [
        'post_title' => ucwords(str_replace('.', '', $title)),
        'post_content' => $faker->paragraph(rand(4, 10), true),
        'slug' => \Illuminate\Support\Str::slug($title),
        'post_view' => rand(12, 114),
    ];
});
