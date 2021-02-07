<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;
use App\Post;
use App\Http\Resources\Like as LikeResource;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $id = Auth::user()->id;
        
        if($id == $request->input('user_id')){

            //Check if this user has already liked the post 
            //Later will be refactored
            $post = Post::findOrFail($request->get('post_id'));
            $likes_by_users = array();
            foreach($post->likes as $like ){
               array_push($likes_by_users,$like->user_id);
            }

            if(in_array($request->user_id, $likes_by_users)){
                
                //$like = Like::where('user_id',$request->user_id)->first();
                //$like->delete();
                return json_encode('This post has already been liked');
            }
            else {
                
                $like = new Like();
                $like->user_id = $request->get('user_id');
                $like->post_id = $request->get('post_id');
                if($like->save()){
                    return new LikeResource($like);
                }  
            }
        }

        else {
            return json_encode('You can make comments only with your account');
        }
       
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Auth::user()->id == $request->input('user_id')){
            $like = Like::where('user_id',$request->user_id)->firstOrFail();
            if($like->delete()){
                return new LikeResource($like);
            }
        }
        else {
            return json_encode("You can only dislike posts with your acount");
        }
    }
}
