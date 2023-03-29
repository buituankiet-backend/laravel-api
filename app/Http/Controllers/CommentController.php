<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Repositories\Comment\CommentRepositoryInterface;

class CommentController extends Controller
{

    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $comments = $this->commentRepository->getAll($pageSize);
        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created = $this->commentRepository->create($request-> only([
            'body',
            'user_id',
            'post_id',
        ]));
        return new CommentResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $comment = $this->commentRepository->find($id);
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $comment = $this->commentRepository->update($id, $request->only([
        'body'
        ]));
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = $this->commentRepository->delete($id);
        return new CommentResource($comment);
    }
}