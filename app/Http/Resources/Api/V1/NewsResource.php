<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'created_by'    => $this->created_by,
            'updated_by'    => $this->updated_by,
            'comment_count' => $this->comments()->count(),
            'like_count'    => $this->likes()->count(),
            'category'      => new CategoryResource($this->category),
            'images'        => ImageResource::collection($this->images),
        ];
    }
}
