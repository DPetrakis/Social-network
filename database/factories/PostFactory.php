<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\User;


$factory->define(App\Post::class, function (Faker $faker) {
    
    $users = User::pluck('id');
    
    return [
        
        'description' => $faker->name,
        'image' => $faker->text(10),
        'user_id' => $faker->randomElement($users)
         
    ];
});
