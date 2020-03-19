<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use Constants;

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
		Constants::api();
		return view("test");
    }
}
