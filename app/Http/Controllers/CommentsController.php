<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Support\Facades\Validator;


class CommentsController extends Controller
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
        
        $validator = Validator::make($request->all(), [
            
            'description' => 'required',
            'image' => 'nullable|sometimes|mimes:jpeg,png,jpg,gif,svg|max:2000'
        
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       

        if(Auth::user()->id == $request->input('user_id')){
                
                $comment = new Comment();
                $comment->user_id = $request->get('user_id');
                $comment->post_id = $request->get('post_id');
                $comment->description = $request->get('description');
                
                if(request()->file('image')) {
                    $image = request()->file('image');
                    $imageName = $image->getClientOriginalName();
                    $imageName = time() .'_'. $imageName; 
                    $image->move(public_path('/images'),$imageName);
        
                    $comment->image = '/' . $imageName;
                } 
                
                if($comment->save()) {
                    return new CommentResource($comment);
                }
        }
        else {
            return json_encode('You cant make comments as another user');
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
        $comment = Comment::findOrFail($id);

        return new CommentResource($comment);
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

        $validator = Validator::make($request->all(), [
            
            'description' => 'required',
            'image' => 'nullable|sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048'
          
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if(Auth::user()->id == $request->input('user_id')){

            $comment = Comment::findOrFail($id);
            $comment->description = $request->get('description');
            $comment->user_id = $request->get('user_id');
            $comment->post_id = $request->get('post_id');
            
            if(request()->file('image')) {
                
                $image = request()->file('image');
                $imageName = $image->getClientOriginalName();
                $imageName = time() .'_'. $imageName; 
                $image->move(public_path('/images'),$imageName);

                $comment->image = '/' . $imageName;
            } 
       
            if($comment->save()){
                return new CommentResource($comment);
            }       
        }
        
        else {
            return json_encode('You can edit only your Comments');
        }   
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {   
      
        if(Auth::user()->id == $request->get('user_id')){
            $comment = Comment::findOrFail($id);
            
            if($comment->delete()) {

                return new CommentResource($comment);

            }
            else {
                return json_encode("Something went wrong");
            }
        }
        else {
            return json_encode("You cant delete posts of another user");
        } 
    
    }
}
