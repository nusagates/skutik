<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use App\Tags;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $post = Post::with(['user', 'tags'])->latest()->paginate(15);
        return view('post.index', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {

        $post = $request->user()->posts()->create($request->only("post_title", "post_content"));
        if (!empty($request->post_tags)) {
            $tags = array_unique(explode(",", $request->post_tags));
            $tagIds = array();
            foreach ($tags as $tagitem) {
                $tagIds[] = Tags::firstOrCreate(['name' => $tagitem])->id;
            }
            $post->tags()->attach($tagIds);
        }
        return redirect()->route('post.index')->with('success', trans('post.label_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->increment('post_view');
        return view('post.index', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.index', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->only("post_title", "post_content"));
        $post->tags()->detach();
        if (!empty($request->post_tags)) {
            $tags = array_unique(explode(",", $request->post_tags));
            $tagIds = array();
            foreach ($tags as $tagitem) {
                $tagIds[] = Tags::firstOrCreate(['name' => $tagitem])->id;
            }
            $post->tags()->attach($tagIds);
        }
        return redirect()->route('post.show', $post->slug)->with('success', trans('post.label_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index')->with('success', trans('post.label_delete_success'));
    }
}
