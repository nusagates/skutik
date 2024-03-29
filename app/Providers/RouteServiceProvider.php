<?php

namespace App\Providers;

use App\Challenge;
use App\Post;
use App\Room;
use App\Tags;
use App\Todos;
use App\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('post_slug', function ($slug) {
            return Post::with('tags')
                    ->where('slug', $slug)
                    ->where('post_status', 'publish')
                    ->first() ?? abort(404);
        });
        Route::bind('challenge_slug', function ($slug) {
            return Challenge::with(['quizes', 'quizes.choices'])->where('challenge_slug', $slug)
                    ->where('challenge_status', 'publish')
                    ->first() ?? abort(404);
        });
        Route::bind('quiz_slug', function ($slug) {
            return Challenge::with(['quizes', 'quizes.choices'])->where('challenge_slug', $slug)
                    ->where('challenge_status', 'publish')
                    ->first() ?? abort(404);
        });
        Route::bind('tag_slug', function ($slug) {
            return Tags::where('slug', $slug)->first() ?? abort(404);
        });
        Route::bind('todo_slug', function ($slug) {
            return Todos::with(['lists' => function ($q) {
                    $q->orderBy('created_at', 'desc');
                }])->where('slug', $slug)->first() ?? abort(404);
        });
        Route::bind('room_slug', function ($slug) {
            return Room::with(['chats.user','chats' => function ($q) {
                    $q->orderBy('created_at', 'desc');
                }])->where('slug', $slug)->first() ?? abort(404);
        });
        Route::bind('username', function ($username) {
            return User::where('username', $username)->first() ?? abort(404);
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
