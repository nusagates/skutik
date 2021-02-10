<?php

namespace Database\Factories;

use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => User::all()->random()->id,
            "post_title" => $this->faker->unique()->sentence.' '.mt_rand(0,1000),
            "post_content" => $this->faker->paragraph,
            'post_status' => 'publish',
            'slug' => $this->faker->slug
        ];
    }
}
