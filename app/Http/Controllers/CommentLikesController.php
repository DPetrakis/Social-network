<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CommentLike;
use App\Comment;
use App\Http\Resources\CommentLike as CommentLikeResource;

class CommentLikescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $comment = Comment::findOrFail($request->get('comment_id'));
            $likes_by_users = array();
            foreach($comment->commentlikes as $like ){
               array_push($likes_by_users,$like->user_id);
            }

            if(in_array($request->user_id, $likes_by_users)){
                
               
                return json_encode('This comment has already been liked');
            }
            else {
                
                $commentlike = new CommentLike();
                $commentlike->user_id = $request->get('user_id');
                $commentlike->comment_id = $request->get('comment_id');
                if($commentlike->save()){
                    return new CommentLikeResource($commentlike);
                }  
            }
        }

        else {
            return json_encode('You can like comments only with your account');
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
            $commentlike = CommentLike::where('user_id',$request->user_id)->firstOrFail();
            if($commentlike->delete()){
                return new CommentLikeResource($commentlike);
            }
        }
        else {
            return json_encode("You can only dislike comments with your acount");
        }
    }
}
