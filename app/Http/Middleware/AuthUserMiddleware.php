<?php

namespace App\Http\Middleware;

use Closure;

use App\User;
use Illuminate\Support\Facades\Auth;

class AuthUserMiddleware
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


        $is_allow_access = false;


        $user_id = Auth::id();

        // if(!is_null($user_id)){
        //     $is_allow_access = true;

        // }

        if(!is_null($user_id)){
            $User = User::findOrFail($user_id);

            if($User->type == 'G'){
                $is_allow_access = true;
            }
        }


        if(!$is_allow_access){
            return redirect()->to('/');
        }
        return $next($request);
    }
}
