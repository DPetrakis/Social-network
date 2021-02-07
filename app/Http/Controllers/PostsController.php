<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\Like as LikeResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(5);

        return PostResource::collection($posts);
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
            'image' => 'nullable|sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       
        $id = Auth::user()->id;
        
        if($id == $request->input('user_id')){

            $post = new Post();
            $post->description = $request->get('description');
            $post->user_id = $request->get('user_id');
          
            
            if(request()->file('image')) {
                
                $image = request()->file('image');
                $imageName = $image->getClientOriginalName();
                $imageName = time() .'_'. $imageName; 
                $image->move(public_path('/images'),$imageName);
                $post->image = '/' . $imageName;
            }
         
       
            if($post->save()){
                return new PostResource($post);
            }       
        }
        else {
            return json_encode('You cant create posts with another account');
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
        $post = Post::findOrFail($id);

        return new PostResource($post);
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
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
       
        
        if(Auth::user()->id == $request->input('user_id')){

            $post = Post::findOrFail($id);
            $post->description = $request->get('description');
            $post->user_id = $request->get('user_id');
          
            if(request()->file('image')) {
               
                $image = request()->file('image');
                $imageName = $image->getClientOriginalName();
                $imageName = time() .'_'. $imageName; 
                $image->move(public_path('/images'),$imageName);

                $post->image = '/' . $imageName;
                
            } 
       
            if($post->save()){
                return new PostResource($post);
            }       
        }
        
        else {
            return json_encode('You can edit only your Posts');
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
            $post = Post::findOrFail($id);
            
            if($post->delete()) {

                return new PostResource($post);

            }
            else {
                return json_encode("Something went wrong");
            }
        }
        else {
            return json_encode("You cant delete posts of another user");
        } 
    }


    public function getLikes($id)
    {

        $post = Post::findOrFail($id);

        $likes = $post->likes;

        return LikeResource::collection($likes);

    }
}
