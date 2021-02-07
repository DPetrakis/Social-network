<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Post;
use App\User;

$factory->define(App\Comment::class, function (Faker $faker) {
    $users = User::pluck('id');
    $posts = Post::pluck('id');
    
    return [
        'user_id' => $faker->randomElement($users),
        'post_id' => $faker->randomElement($posts),
        'description' => $faker->text(15)        
    ];



});
