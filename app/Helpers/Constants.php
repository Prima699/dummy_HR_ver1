<?php
namespace App\Helpers;

class Constants {
	
	public static function api() {
		return config('constants.url.api');
    }
	
	public static function assetApi() {
		return config('constants.url.assetApi');
    }
	
}