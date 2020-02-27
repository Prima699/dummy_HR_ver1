<?php
namespace App\Helpers;

use Cookies;

class Constants {
	
	public static function api() {
		// return config('constants.url.api');
		
		$name = Constants::tokenName();
		$res = Cookies::retrieve($name);
		$res = json_decode($res);
		return $res->config->url;
    }
	
	public static function assetApi() {
		return config('constants.url.assetApi');
    }
	
	public static function client() {
		return config('constants.url.client');
    }
	
	public static function days3() {
		return config('constants.datetime.days3');
    }
	
	public static function separator($p=NULL){
		if($p==NULL){
			$r = config('constants.separator.default');
		}else{
			$r = config('constants.separator.' + $p);
		}
		return $r;
	}
	
	public static function routeException($p){
		$v = config('constants.route.exception');
		return $v[$p];
	}
	
	public static function tokenName(){
		return str_replace(" ","",preg_replace("/[^a-zA-Z0-9\s]/", "", $_SERVER['HTTP_USER_AGENT']));
	}
	
}