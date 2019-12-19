<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auths;

class ShowLoggedInUser extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
		dd(Auths::user());
    }
}
