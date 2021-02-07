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


Route::get('/posts','PostsController@index');
Route::get('/posts/{id}','PostsController@show');
Route::get('/users/{id}', 'UserController@show'); 
Route::get('/profile/{id}','ProfileController@show');

Route::middleware('auth:api')->post('/likes','LikesController@store');
Route::middleware('auth:api')->delete('/likes','LikesController@destroy');
Route::middleware('auth:api')->get('/likes','LikesController@index');

Route::middleware('auth:api')->post('/commentlikes','CommentLikesController@store');
Route::middleware('auth:api')->delete('/commentlikes','CommentLikesController@destroy');

Route::middleware('auth:api')->post('/comments','CommentsController@store');
Route::middleware('auth:api')->delete('/comments/{comment}','CommentsController@destroy');
Route::middleware('auth:api')->post('/comments/{comment}','CommentsController@update');

Route::middleware('auth:api')->post('/replies','RepliesController@store');
Route::middleware('auth:api')->delete('/replies/{reply}','RepliesController@destroy');
Route::middleware('auth:api')->post('replies/{reply}','RepliesController@update');



Route::middleware('auth:api')->post('/posts/{post}','PostsController@update');
Route::middleware('auth:api')->delete('/posts/{post}','PostsController@destroy');
Route::middleware('auth:api')->post('/posts','PostsController@store');
Route::middleware('auth:api')->get('/posts/{post}/likes','PostsController@getLikes');