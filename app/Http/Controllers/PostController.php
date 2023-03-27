<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index()
    {
        $posts = Post::query()->get()->paginate(5);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $created =  DB::transaction(function () use ($request) {
            $created = Post::query()->create([
                'title' => $request->title,
                'body' => $request->body,
            ]);

            $created->users()->sync($request->user_ids);

            return $created;
        });

        return new PostResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $updated = $post->update([
            'title' => $request->title ?? $post->title,
            'body' => $request->body ?? $post->body,
        ]);

        if (!$updated){
            return new JsonResponse([
                'errors' => [
                    'Failed to update model. '
                ]
            ], 400);
        }

        return new PostResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $delete = $post->forceDelete();

        if (!$delete) {
            return new JsonResponse([
                'errors' => [
                    'Could not delete resource.'
                ]
            ], 400);
        }
        return new PostResource($delete);
    }
}