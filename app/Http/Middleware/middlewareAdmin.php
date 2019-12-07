<?php

namespace App\Http\Middleware;

use Closure;

class middlewareAdmin
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
		// check if auth is admin
		if(session("auth")==NULL OR session("auth")==FALSE OR session("auth")=="" OR session("auth")->user->role!="adm"){
			return redirect("/");
		}
		
        return $next($request);
    }
}
