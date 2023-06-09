<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\Post\PostRepositoryInterface;

class PostController extends Controller
{


        /**
     * @var PostRepositoryInterface|\App\Repositories\Repository
     */
    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $posts = $this->postRepo->getAll($pageSize);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $created = $this->postRepo->create($request->only([
        'title',
        'body',
        'user_ids',
       ]));

       throw_if(!$created, GeneralJsonException::class, 'Failed creating resource');

        return new PostResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post =  $this->postRepo->find($id);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $updated = $this->postRepo->update($id, $request->only([
            'title',
            'body',
        ]));

        throw_if(!$updated, GeneralJsonException::class, 'Can not update');

        return new PostResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = $this->postRepo->delete($id);
        return new PostResource($delete);
    }
}