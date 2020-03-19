<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Response;
use Constants;
use Handlers;
use Digitas;
use Cookies;

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
		
		$handler = Handlers::curl($curl,[
			"login" => true
		]);
		
		if($handler==true){
			session(["auth" => json_decode($curl->response)->data]);
		}
		
		return redirect()->route("dashboard");
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
		
		$handler = Handlers::curl($curl);
		
		if($handler==true){
			Cookies::create($r, json_decode($curl->response)->data);
		}else{
			session(["error" => "Invalid token."]);
			return redirect()->route("auth.token");
		}
		
		return redirect()->route("login");
	}
}
