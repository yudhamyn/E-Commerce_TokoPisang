<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAccess
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
        $token = $request->bearerToken();
        if(empty($token))
        {
            Auth::logout();
            return response()->json([
                'status' => false,
                'message' => 'Unauthentication.'
            ]);
        }

        $cek = User::where(['remember_token' => $token])->first();
        if($cek)
        {
            Auth::login($cek);
            return $next($request);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthentication.'
        ]);
    }
}
