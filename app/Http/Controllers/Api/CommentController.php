<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        return CommentResource::collection($post->comment);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = $post->comment()->create($request->validated());

        return response()->json([
            'success'   => true,
            'message'   => __('messages.comments.created_successfully'),
            'comment'      => new CommentResource($comment)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $comment->update($request->validated());

        return response()->json([
            'success'   => true,
            'message'   => __('messages.comments.updated_successfully'),
            'comment'      => new CommentResource($comment)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return response()->json([
            'success'   => true,
            'message'   => __('messages.comments.deleted_successfully'),
        ]);
    }
}
