<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\Like as LikeResource;

class Post extends JsonResource
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
          "description" => $this->description,
          "image" => $this->image,
          "created_at" => $this->created_at->diffForHumans(),
          "comments" => CommentResource::collection($this->comments),
          "likes" => LikeResource::collection($this->likes),
          "user" => $this->user->load('profile')
        
        ];  
    }
}
