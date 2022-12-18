<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){

            if(Auth::user()->isUser() || Auth::user()->isAdmin() || Auth::user()->isSuperAdmin()){
                    
                return $next($request); 
            }

            return redirect('/');
        }
        return redirect('/login'); 
    }
}
