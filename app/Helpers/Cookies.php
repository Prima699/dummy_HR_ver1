<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Constants;

class Cookies {
	
	public static function create($r, $value){
		$name = Constants::tokenName();
		$expire = time() + (86400*30);
		$path = "/";
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		$secure = false;
		$httponly = true;
		
		if(is_object($value)){
			$value = json_encode($value);
		}
		
		if(is_array($value)){
			$value = implode(Constants::separator(),$value);
		}
		
		// $response = new Response('DIGITAS');
		
		// return $response->withCookie(cookie($name, $value, $expire, $path, $domain, $secure, $httponly));
		
		setCookie($name, $value, $expire, $path, $domain, $secure, $httponly);
		
		// cookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}
	
	public static function retrieve($value){
		$cookie = NULL;
		
		if(isset($_COOKIE[$value])){
			$cookie = $_COOKIE[$value];
		}
		
		return $cookie;
	}
	
}