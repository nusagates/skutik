<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use App\Tags;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'tag', 'author']]);
        $this->middleware('verified', ['except' => ['index', 'show', 'tag', 'author']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $post = Post::with(['user', 'tags'])
            ->where('post_type', 'post')
            ->where('post_status', 'published')
            ->latest()->paginate(15);
        return view('post.index', ['post' => $post, 'latest' => $post]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        $post = $request->user()->posts()->create($request->only("post_title", "post_content", 'post_status'));
        if (!empty($request->post_tags)) {
            $tags = array_unique(explode(",", $request->post_tags));
            $tagIds = array();
            foreach ($tags as $tagitem) {
                $tagIds[] = Tags::firstOrCreate(['name' => $tagitem])->id;
            }
            $post->tags()->attach($tagIds);
        }
        return response()->json([
            'data' => $post,
            'code' => 200,
            'message' => trans('post.label_create_success')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Post $post)
    {
        $post->increment('post_view');
        return view('post.index', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('post.index', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->only("post_title", "post_content", 'post_status'));
        $post->tags()->detach();
        if (!empty($request->post_tags)) {
            $tags = array_unique(explode(",", $request->post_tags));
            $tagIds = array();
            foreach ($tags as $tagitem) {
                $tagIds[] = Tags::firstOrCreate(['name' => $tagitem])->id;
            }
            $post->tags()->attach($tagIds);
        }
        return response()->json([
            'data' => $post,
            'code' => 200,
            'message' => trans('post.label_create_success')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('post.index')->with('success', trans('post.label_delete_success'));
    }

    public function tag(Tags $tag)
    {
        $post = Tags::find($tag->id)->tag()
            ->where('post_status', 'published')
            ->paginate(15);
        return view('post.index', ['post' => $post, "title" => $tag->name]);
    }

    public function author(User $user)
    {

        if(Auth::check() || Auth::id()!= $user->id){
            $post = Post::where('user_id', $user->id)
                ->where('post_status', 'published')
                ->paginate(15);
        }else{
            $post = Post::where('user_id', $user->id)
                ->paginate(15);
        }
        return view('post.author', ['post' => $post,"title" => trans('post.label_tag_author', ['author' => $user->name])]);
    }
}
