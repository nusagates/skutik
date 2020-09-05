<?php

namespace App\Http\Controllers;

use App\Notifications\NewComment;
use App\Post;
use App\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Post $post, Request $request)
    {
        $request->validate([
            "comment_content" => 'required'
        ]);
        $comment = $post->comments()->create(["comment_content" => $request->comment_content, "user_id" => $request->user()->id]);
        if ($post->user_id != Auth::id()) {
            $comment->post->user->notify(new NewComment($comment));
        }
        return redirect()->route('post.show', $post->slug)->with('success', trans('post.comment_create_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\PostComment $postComment
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(PostComment $postComment, $comment, $post)
    {
        $postComment = PostComment::find($post);
        return view('comment.edit', compact('postComment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\PostComment $postComment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $post, $comment)
    {

        $postComment = PostComment::find($comment);
        $postComment->update($request->only('comment_content'));
        return response()->json([
            'message' => trans('post.comment_update_success'),
            'comment_content' => $postComment->comment_content
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PostComment $postComment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PostComment $postComment, $comment, $post)
    {
        PostComment::find($post)->delete();
        return back()->with('success', trans('post.comment_delete_success'));
    }
}
