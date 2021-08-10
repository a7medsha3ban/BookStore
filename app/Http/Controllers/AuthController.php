<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class AuthController extends Controller
{
    public function register(){
        return view('auth.register');
    }

    public function handleRegister(Request $request){
        $validated=Validator::make($request->all(),[
            'email'=>'required|email|max:100',
            'pass'=>'required|string|max:50|min:5',
        ]);

        if($validated->fails()){
            return redirect('/register')
                ->withErrors($validated)
                ->withInput();
        }
        $user = new User();
        $user->email=$request->email;
        $user->password=Hash::make($request->pass);
        $user->save();
        return redirect('books/list');
    }

    public function login(){
        return view('auth.login');
    }

    public function handleLogin(Request $request){
        $validated=Validator::make($request->all(),[
            'email'=>'required|email|max:100',
            'pass'=>'required|string|max:50|min:5',
        ]);

        if($validated->fails()){
            return redirect('/login')
                ->withErrors($validated)
                ->withInput();
        }
        $cred=Auth::attempt(['email' => $request->email, 'password' => $request->pass]);
        if($cred){
            return redirect('books/list');
        }
        else{
            return back();
        }

}

    public function logout(){
        Auth::logout();
        return back();
    }

}
