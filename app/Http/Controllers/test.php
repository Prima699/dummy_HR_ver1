<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class test extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
		session(["test" => "testing purpose only!"]); // store
		session(["test" => null]); // forget
        dump(session("test")); // retrieve
    }
}
