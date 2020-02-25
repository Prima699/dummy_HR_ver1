<?php
namespace App\Helpers;

class Digitas {
	
	public static function signature($action, $string) {
		$output = false;
		$encrypt_method = "AES-128-CBC";
		$secret_key = 'D161T45!W1NN3R!!';
		$secret_iv = 'digitasahura2020';
		$key = ($secret_key);

		$iv = $secret_iv;
		if ( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = ($output);
		}
		
		return $output;
    }
	
}