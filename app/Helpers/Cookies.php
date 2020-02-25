<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Constants;

class Cookies {
	
	public static function create($r, $value){
		$name = str_replace(" ","",preg_replace("/[^a-zA-Z0-9\s]/", "", $_SERVER['HTTP_USER_AGENT']));
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
	
	public static function retrieve($r, $value){
		$value = $r->cookie($value);
		return $value;
	}
	
}