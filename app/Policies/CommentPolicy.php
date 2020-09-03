<?php

namespace App\Policies;

use App\PostComment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

     /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\PostComment  $postComment
     * @return mixed
     */
    public function update(User $user, PostComment $postComment)
    {
        return $user->id === $postComment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\PostComment  $postComment
     * @return mixed
     */
    public function delete(User $user, PostComment $postComment)
    {
        return $user->id === $postComment->user_id;
    }


}
