<?php

namespace App\Http\Middleware;

use Closure;
use Cookies;
use Route;
use Auths;
use Constants;
use Request;

class middlewareToken
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
		$value = str_replace(" ","",preg_replace("/[^a-zA-Z0-9\s]/", "", $_SERVER['HTTP_USER_AGENT']));
		$value = Cookies::retrieve($request, $value);
				
		$exception = Constants::routeException("token");
		$match = false;
		foreach($exception as $exc){
			if(Route($exc)==$request->fullUrl()){
				$match = true;
				break;
			}
		}
		
		if($value==NULL){
			if($match==false){
				return redirect()->route("auth.token");
			}
		}
		
        return $next($request);
    }
}
