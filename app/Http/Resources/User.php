<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Post as PostResource;

class User extends JsonResource
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
           "name" => $this->name,
           "email" => $this->email,
           "posts" => PostResource::collection($this->posts),
           "profile" => $this->profile,
           "sex" => $this->sex
         
       ];
    }
}
