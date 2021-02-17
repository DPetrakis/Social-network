<?php

use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login','AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/user-profile', 'AuthController@userProfile');    
});


Route::get('/sexes','SexesController@index');
Route::get('/profile/{id}','ProfileController@show');

Route::group(['middleware' => 'auth:api'],function(){
    
    Route::post('/users/search','UsersController@search');
    Route::put('/users/{user}','UsersController@update');
    Route::get('/users/{user}','UsersController@show');
    Route::post('/users/{user}','UsersController@updateProfilePic');

    Route::get('/posts','PostsController@index');
    Route::get('/posts/{id}','PostsController@show');
    Route::delete('/posts/{post}','PostsController@destroy');
    Route::post('/posts','PostsController@store');
    Route::get('/posts/{post}/likes','PostsController@getLikes');
    //Axios couldn't send form data with put request thats why i used post in order to update files..
    Route::post('/posts/{post}','PostsController@update');

    Route::post('/replies','RepliesController@store');
    Route::delete('/replies/{reply}','RepliesController@destroy');
    Route::post('replies/{reply}','RepliesController@update');
    Route::get('replies/{reply}','RepliesController@show');

    Route::post('/comments','CommentsController@store');
    Route::delete('/comments/{comment}','CommentsController@destroy');
    Route::post('/comments/{comment}','CommentsController@update');
    Route::get('/comments/{comment}','CommentsController@show');

    Route::post('/likes','LikesController@store');
    Route::delete('/likes','LikesController@destroy');
    Route::get('/likes','LikesController@index');

    Route::post('/commentlikes','CommentLikesController@store');
    Route::delete('/commentlikes','CommentLikesController@destroy');

    
    
});
