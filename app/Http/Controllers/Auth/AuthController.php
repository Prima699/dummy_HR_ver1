<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Response;
use Constants;
use Handlers;
use Digitas;

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
		
		return Handlers::curl($r, $curl,"home","index",[
			"login" => true
		]);
	}
	
	public function LogOut(Request $r){
		session(["auth" => NULL]); // forget auth session
		return redirect("/");
	}
	
	public function token(Request $r){
		session(["auth" => NULL]); // forget auth session
		return view("auth.token");
	}
	
	public function submit(Request $r){
		$curl = new Curl();
		$signature = Digitas::signature('encrypt', 'DGT_'.$r->company.'_ML');
		
		$params['signature'] = $signature;
		$curl->get(Constants::client() . "/companyCode", $params);
		
		return Handlers::curl($r, $curl,"auth.token","login",[
			"token" => true
		]);
	}
}
