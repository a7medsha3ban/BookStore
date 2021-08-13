<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

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

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        //dd($user);
        // $user->token;
        $db_user=User::where('email','=',$user->email)->first();
        if($db_user == null){
           $rgisteredUser= User::create([
                'email' =>$user->email,
                'password' => Hash::make('123456'),
                'oauth_token'=>$user->token,

            ]);
            Auth::login($rgisteredUser);
        }
        else{
            Auth::login($db_user);
        }
        return redirect('books/list');
    }

}
