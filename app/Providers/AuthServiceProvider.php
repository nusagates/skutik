<?php

namespace App\Providers;

use App\Challenge;
use App\ChallengeQuiz;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use App\Policies\QuizPolicy;
use App\Post;
use App\PostComment;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
        PostComment::class => CommentPolicy::class,
        Challenge::class => QuizPolicy::class,
        ChallengeQuiz::class => QuizPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
