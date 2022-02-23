<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'body'          => $this->body,
            'created_at'    => $this->created_at,
            'user'          => new UserResource($this->user),
        ];
    }
}
