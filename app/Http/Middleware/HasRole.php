<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Access\AuthorizationException;

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
            throw new AuthorizationException('AuthorizationException');
        }   
    }
}
