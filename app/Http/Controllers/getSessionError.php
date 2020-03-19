<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class getSessionError extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
		$r = FALSE;
        if((session("error") AND session("error")!=NULL)){
			$r = session("error");
		}
		
		if($r=="Access token not granted"){
			session(["auth" => NULL]);			
		}
		
		session(["error" => NULL]);
		
		return Response()->json($r);
    }
}
