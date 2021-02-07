<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
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
            "profile_image" => $this->profile_image,
            "user" => $this->user->load('posts')
            
        ];
    }
}
