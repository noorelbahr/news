<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!$this->resource) {
            return ['data' => null];
        }

        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'body'          => $this->body,
            'tags'          => $this->tags,
            'hr_created_at' => $this->hr_created_at,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'created_by'    => $this->created_by,
            'updated_by'    => $this->updated_by,
            'comment_count' => $this->comments()->count(),
            'like_count'    => $this->likes()->count(),
            'author'        => new UserResource($this->author),
            'category'      => new CategoryResource($this->category),
            'images'        => ImageResource::collection($this->images),
            'comments'      => CommentResource::collection($this->comments()->latest()->simplePaginate(3)),
            'is_liked'      => (bool) ($this->likes()->where('user_id', Auth::id())->count() > 0)
        ];
    }
}
