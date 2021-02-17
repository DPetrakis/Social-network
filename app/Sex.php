<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sex extends Model
{
    protected $fillable = [
        'description'
    ];
    
    public function users(){
        $this->hasMany(User::class);
    }
}
