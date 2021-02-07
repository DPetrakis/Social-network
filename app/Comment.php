<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function replies(){

        return $this->hasMany(Reply::class);
    
    }

    public function commentlikes(){
        return $this->hasMany(CommentLike::class);
    }


    
}
