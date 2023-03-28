<?php
namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
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

}