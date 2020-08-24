<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthUserAdminMiddleware
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
        // 預設不允許存取
        $is_allow_access = false;

        // 取得會員編號

        $user_id = Auth::id();
        if(!is_null($user_id)){
            $User = User::findOrFail($user_id);

            if($User->type == 'A'){
                $is_allow_access = true;
            }
        }

        if(!$is_allow_access){
            return redirect()->to('/');
        }
        return $next($request);
    }
}
