<?php
namespace App\Repositories\Comment;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Exceptions\GeneralJsonException;
use App\Repositories\Comment\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getModel()
    {
        return Comment::class;
    }

    public function create($attributes = []) {
        return DB::transaction(function () use ($attributes) {
            $created = Comment::query()->create([
                'body' => data_get($attributes, 'body'),
                'user_id' => data_get($attributes, 'user_id'),
                'post_id' => data_get($attributes, 'post_id'),
            ]);

            throw_if(!$created, GeneralJsonException::class, 'Failed to create model.');

            return $created;
        });
    }

    public function update($id,array $attributes){
        return DB::transaction(function () use ($id, $attributes) {
            $comment =  Comment::find($id);
            throw_if(!$comment, GeneralJsonException::class, 'Not find Comment.');
            $update = $comment->update([
                'body' => data_get($attributes, 'body'),
            ]);
            throw_if(!$update, GeneralJsonException::class, 'Can not update Comment.');
            return $comment;
        });
    }

    public function delete($id) {
        return DB::transaction(function () use ($id) {
            $comment = Comment::find($id);
            throw_if(!$comment, GeneralJsonException::class, 'Not find Comment.');
            $delete = $comment -> forceDelete();
            throw_if(!$delete, GeneralJsonException::class, 'Can not delete Comment.');
            return $delete;
        });
    }

}