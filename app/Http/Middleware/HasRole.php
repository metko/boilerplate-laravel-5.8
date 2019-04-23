<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $role = 'is'.ucfirst($role);
        if ( Auth::check() &&  Auth::user()->$role() ){
            return $next($request);
        }else{
            return abort(403);
        }   
    }
}
