<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Like extends JsonResource
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
         
         "id"      => $this->id,
         "post_id" => $this->post_id,
         "user"    => $this->user->load('profile')
       
        ];
    }
}
