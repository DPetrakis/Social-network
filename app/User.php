<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function replies(){

        return $this->hasMany(Reply::class);
    
    }

    public function likes(){
        
        return $this->hasMany(Like::class);
    
    }

    public function commentlikes(){
        
        return $this->hasMany(CommentLike::class);
    
    }

    public function sex(){
        return $this->belongsTo(Sex::class);
    }


    public function scopeSearchByLetter($query,$letter)
    
    {
        
        return $query->where('name', 'LIKE','%'. $letter .'%' );
    
    }


}
