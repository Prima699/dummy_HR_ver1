<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Response;
use Constants;
use Handlers;

class AuthController extends Controller
{
	public function __construct(){
		
	}
	
    public function LogIn(Request $r){
		$curl = new curl();
		
		$curl->post(Constants::api() . '/userlogin', array(
			'username' => $r->email,
			'password' => $r->password,
			'role' => 'adm',
			'platform' => 'dashboard',
			'location' => ''
		));
		
		return Handlers::curl($curl,"home","index",[
			"login" => true
		]);
	}
	
	public function LogOut(Request $r){
		session(["auth" => NULL]); // forget auth session
		return redirect("/");
	}
}
