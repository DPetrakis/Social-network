<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
   
    public function updateProfilePic(Request $request,$id){

        if(Auth::user()->id == $id){
                
            $validator = Validator::make($request->all(), [
                
                'image' => 'required|max:2048',
               
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
           
            $user = User::findOrFail($id);
            
            if(request()->file('image')) {
                
                $image = request()->file('image');
                $imageName = $image->getClientOriginalName();
                $imageName = time() .'_'. $imageName; 
                $image->move(public_path('/images'),$imageName);
                $profile_image = '/' . $imageName;
            }


            $user->profile->update([
                    
                'profile_image' => $profile_image,

            ]);

            
            return json_encode($profile_image);


        }

        else {
            return json_encode('You cant change the profile pic of another user');
        }

        
    }
    



    public function search(Request $request){
        
        $users = User::searchbyletter($request->input('letter'))->get();
      
        return UserResource::collection($users);
    }

   
    public function show($id)
    {
        $user = User::findOrFail($id);

        return new UserResource($user);
    }


    public function update(Request $request, $id)
    {


            if(Auth::user()->id == $id){
                
                $validator = Validator::make($request->all(), [
                    
                    'name' => 'required|max:10',
                    'profile_description' => 'required|string|max:50',
                    'sex' => 'required',
                  
                
                ]);
        
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }
               
                $user = User::findOrFail($id);
                $user->name = $request->get('name');
                $user->sex_id = $request->get('sex');

                if($user->save()){
                    
                    $user->profile->update([
                        
                        'description' => $request->get('profile_description'),
                    ]);

                }

                return new UserResource($user);


            }

            else {
                return json_encode('You cant edit this profile');
            }

    }

  

   
    public function destroy($id)
    {
        
    }

   
}
