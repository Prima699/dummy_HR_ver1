<?php

namespace App\Http\Middleware;

use Closure;

class middlewareEmployee
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
		// check if auth is employee / anggota
		if(session("auth")==NULL OR session("auth")==FALSE OR session("auth")=="" OR session("auth")->user->role!="agt"){
			return redirect("/");
		}
		
        return $next($request);
    }
}
