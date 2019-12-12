<?php
namespace App\Helpers;

class Auth {
	
	public static function user($key=NULL) {
		if(session("auth")==NULL OR session("auth")==FALSE OR session("auth")==""){
			return NULL;
		}
        if($key!=NULL){
			if(strpos($key,".")!==FALSE){
				$tmp = explode(".", $key);
				$r = session("auth");
				foreach($tmp as $t){
					$r = $r->$t;
				}
			}else{				
				$r = session("auth")->$key;
			}
		}else{
			$r = session("auth");
		}
		return $r;
    }
	
}