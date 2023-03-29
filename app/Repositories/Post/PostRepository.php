<?php
namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Exceptions\GeneralJsonException;
use App\Repositories\Post\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function getModel()
    {
        return Post::class;
    }

    public function create($attributes = []) {
        return DB::transaction(function () use ($attributes) {
            $created = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body'),
            ]);

            if($userIds = data_get($attributes, 'user_ids')) {
                $created->users()->sync($userIds);
            }
            return $created;
        });
    }

    public function update($id,array $attributes){
        return DB::transaction(function () use ($id, $attributes) {
            $post =  Post::find($id);
            throw_if(!$post, GeneralJsonException::class, 'Not find Post.');
            $update = $post->update([
                'title' => data_get($attributes, 'title', $post->title),
                'body' => data_get($attributes, 'body', $post->body),
            ]);
            throw_if(!$update, GeneralJsonException::class, 'Can not update Post.');
            return $post;
        });
    }

    public function delete($id) {
        return DB::transaction(function () use ($id) {
            $post = Post::find($id);

            throw_if(!$post, GeneralJsonException::class, 'Can not find post.', 400);

            $delete = $post->delete();

            throw_if(!$delete, GeneralJsonException::class, 'Can not delete post.', 400);

            return $delete;
        });
    }

}