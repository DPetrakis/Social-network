<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class Reply extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            
            "id" => $this->id,
            "created_at" => $this->created_at->diffForHumans(),
            "user" => $this->user->load('profile'),
            "description" => $this->description,
            "comment_id" => $this->comment_id,
            "image", $this->image
        ];
    }
}
