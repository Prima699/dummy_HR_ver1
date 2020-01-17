<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Response;

class AuthController extends Controller
{
	public function __construct(){
		
	}
	
    public function LogIn(Request $r){
		$curl = new curl();
		
		$curl->post('http://digitasAPI.teaq.co.id/index.php/Bridge/userlogin', array(
			'username' => $r->email,
			'password' => $r->password,
			'role' => $r->role,
			'platform' => 'dashboard',
			'location' => ''
		));
		
		if($curl->error){ // if curl error
			$err = json_decode($curl->error_code);
			$res = json_decode($curl->response);
			
			session([
				"error" => [
					"errorCode" => $err,
					"response" => $res
				]
			]);
			
			return redirect("/login");
		}else{ // curl succeed
			$res = json_decode($curl->response);
			session(["auth" => $res->data]); // restore auth to auth session
			
			return redirect("/");
		}
	}
	
	public function LogOut(Request $r){
		session(["auth" => NULL]); // forget auth session
		return redirect("login");
	}
}
