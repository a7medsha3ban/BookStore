<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class ApiAuthController extends Controller
{
    public function handleRegister(Request $request){
        $validated=Validator::make($request->all(),[
            'email'=>'required|email|max:100',
            'pass'=>'required|string|max:50|min:5',
        ]);

        if($validated->fails()){
            $errors=$validated->errors();
            return response()->json($errors);
        }

        $user = new User();
        $user->email=$request->email;
        $user->password=Hash::make($request->pass);
        $user->access_token=Str::random(64);
        $user->save();
        return response()->json($user->access_token);
    }


    public function handleLogin(Request $request){
        $validated=Validator::make($request->all(),[
            'email'=>'required|email|max:100',
            'pass'=>'required|string|max:50|min:5',
        ]);

        if($validated->fails()){
            $errors=$validated->errors();
            return response()->json($errors);
        }
        $cred=Auth::attempt(['email' => $request->email, 'password' => $request->pass]);
        if(!$cred){
            $errors='credentials are not correct';
            return response()->json($errors);
        }
        else{
            $user=User::where('email','=',$request->email)->first();
            $new_access_token=Str::random(64);
            $user->access_token=$new_access_token;
            $user->save();
            return response()->json($user->access_token);
        }

    }


    public function logout(Request $request){
        $access_token=$request->access_token;
        $user=user::where('access_token','=',$access_token)->first();
        if($user!=null){
            $user->access_token=null;
            $user->save();
            $success_message='Logged out successfully';
            return response()->json($success_message);

        }
        else{
            $errors='Token not correct';
            return response()->json($errors);
        }

    }


}
