<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'id'        => $this->id,
            'filename'  => $this->filename,
            'image_url' => $this->image_url,
        ];
    }
}
