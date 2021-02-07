<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\User;

$factory->define(App\Profile::class, function (Faker $faker) {
    $users = User::pluck('id');
    
    return [
        
        "description" => $faker->text('25'),
        "profile_image" => $faker->text('10'),
        "user_id" => $faker->randomElement($users) 
       
    ];
});
