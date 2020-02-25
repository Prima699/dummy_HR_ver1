<?php
namespace App\Helpers;

class Constants {
	
	public static function api() {
		return config('constants.url.api');
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
	
}