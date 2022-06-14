<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAccessUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('_token');
        if(!empty($token))
        {
            $cek = User::where(['remember_token' => $token,'level_id' => 2])->first();
            if($cek)
            {
                Auth::login($cek);
                return $next($request);
            }
            // Cookie::queue(Cookie::forget('_token'));
        }
        return abort(404);
    }
}
