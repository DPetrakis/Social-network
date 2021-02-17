<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $fillable = [
        'description','profile_image','user_id'
    ];
    
    public function user(){

        return $this->belongsTo(User::class);
        
    }
}
