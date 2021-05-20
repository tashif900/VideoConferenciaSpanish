<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminValidate
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
        //dd(Auth::guard('api')->check());
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (! auth()->user()->hasRole('Administrador')) {
            Auth::logout();
            return redirect()->route('login');
        }

        return $next($request);
    }
}
