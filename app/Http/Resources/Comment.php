<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Reply as ReplyResource;
use App\Http\Resources\CommentLike as CommentLikeResource;


class Comment extends JsonResource
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
            "image" => $this->image,
            "description" => $this->description,
            "created_at" => $this->created_at->diffForHumans(),
            "post_id" => $this->post_id,
            "user" => $this->user->load('profile'),
            "replies" => ReplyResource::collection($this->replies),
            "commentlikes" => CommentLikeResource::collection($this->commentlikes)
        
        ];
    }
}
