<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Response;
use Constants;

class AuthController extends Controller
{
	public function __construct(){
		
	}
	
    public function LogIn(Request $r){
		$curl = new curl();
		
		$curl->post(Constants::api() . '/userlogin', array(
			'username' => $r->email,
			'password' => $r->password,
			'role' => $r->role,
			'platform' => 'dashboard',
			'location' => ''
		));
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return redirect("/login");
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			session(["auth" => $res->data]); // restore auth to auth session
			return redirect("/");
		}else{
			session(['error' => $res->errormsg]);
			return redirect("/login");
		}
	}
	
	public function LogOut(Request $r){
		session(["auth" => NULL]); // forget auth session
		return redirect("login");
	}
}
