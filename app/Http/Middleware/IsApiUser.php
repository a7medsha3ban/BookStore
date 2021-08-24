<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class IsApiUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if($request->has('access_token')){
            $token=$request->access_token;
            if($token!=null){
                $user=User::where('access_token','=',$token)->first();
                if($user){
                    return $next($request);
                }
                else{
                    $error='access token is not correct';
                    return response()->json($error);
                }
            }
            else{
                $error='access token is empty';
                return response()->json($error);
            }
        }
        else{
            $error='there is no access token';
            return response()->json($error);
        }
    }
}
