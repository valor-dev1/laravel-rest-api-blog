<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query();
        $user = auth()->user();

        if (optional($user)->isEditor()) {
            $posts->where(['user_id' => $user->id]);
        } else if (! optional($user)->isAdmin()) {
            $posts->published();
        }

        return PostResource::collection($posts->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        Gate::authorize('create', Post::class); // Authorize the current user
        
        $post = auth()->user()->posts()->create($request->validated());

        return response()->json([
            'success'   => true,
            'message'   => __('messages.posts.created_successfully', ['title' => $post->title]),
            'post'      => PostResource::make($post)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
