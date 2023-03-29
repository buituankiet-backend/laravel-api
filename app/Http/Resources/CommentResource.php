<?php

namespace App\Http\Resources;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user_id' => User::find($this->user_id),
            'post_id' => Post::find($this->post_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
