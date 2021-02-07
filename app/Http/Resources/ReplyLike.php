<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyLike extends JsonResource
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
            "reply_id" => $this->reply_id,
            "user_id" => $this->user_id
        
        ];
    
    }
}
