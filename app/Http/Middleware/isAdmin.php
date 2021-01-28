<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class IsAdmin
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
        if (Auth::user() &&  Auth::user()->name == 'administrator') {
             return $next($request);
        }

        return redirect('/errorPage')->with('error','Only the administrator has rights!');
    }
}
