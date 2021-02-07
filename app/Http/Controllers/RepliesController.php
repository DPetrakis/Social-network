<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Reply as ReplyResource;
use App\Reply;
use Illuminate\Support\Facades\Validator;


class RepliesController extends Controller
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
            'image' => 'nullable|sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        
        if(Auth::user()->id == $request->input('user_id')){
                
            $reply = new Reply();
            $reply->user_id = $request->get('user_id');
            $reply->comment_id = $request->get('comment_id');
            $reply->description = $request->get('description');
            
            if(request()->file('image')) {
                $image = request()->file('image');
                $imageName = $image->getClientOriginalName();
                $imageName = time() .'_'. $imageName; 
                $image->move(public_path('/images'),$imageName);
    
                $reply->image = '/' . $imageName;
            } 
            
            
            if($reply->save()) {
                return new ReplyResource($reply);
            }
        
        
        }
        
        else {
            return json_encode('You cant make replies as another user');
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
        $validator = Validator::make($request->all(), [
            
            'description' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
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
            $reply = Reply::findOrFail($id);
            
            if($reply->delete()) {

                return new ReplyResource($reply);

            }
            else {
                return json_encode("Something went wrong");
            }
        }
        else {
            return json_encode("You cant delete replies of another user");
        } 
    }
}
