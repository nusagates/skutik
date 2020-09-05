<?php

namespace App\Http\Controllers;

use App\Notifications\NewComment;
use App\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function comment(){
        $comment = PostComment::find(10);


        return (new NewComment($comment))
            ->toMail($comment->user, $comment);
    }
}
