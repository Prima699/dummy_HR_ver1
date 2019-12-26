<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Route;

class isSessionEnd extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
		$r = 1;
        if(session("auth")==NULL OR session("auth")==FALSE OR session("auth")==""){
			$route = $request->c;
			if(
				$route=='login' OR $route=='/login'
				OR $route=='index' OR $route=='/index'
				OR $route=='home' OR $route=='/home'
				OR $route=='' OR $route=='/'
			){
				$r = 1;
			}else{
				$r = 0;
			}
		}
		return $r;
    }
}
