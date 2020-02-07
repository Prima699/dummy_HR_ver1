<?php
namespace App\Helpers;

class Constants {
	
	public static function api() {
		return config('constants.url.api');
    }
	
	public static function assetApi() {
		return config('constants.url.assetApi');
    }
	
	public static function days3() {
		return config('constants.datetime.days3');
    }
	
}