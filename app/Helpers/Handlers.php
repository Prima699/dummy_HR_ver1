<?php
namespace App\Helpers;

use Cookies;

class Handlers {
	
	public static function curl($r, $curl, $redirectError, $redirectSuccess, $adds=null) {
		$defaultErrorMessage = "Unknown error occured.";
		$defaultAPIErrorMessage = "Response API is not appropriate.";
		
		if($curl->error==TRUE){
			$res = $curl->response;
			if($res==false || $res==null){				
				$message = $curl->error_message;
				if($message!=null || $message!=""){
					$message = $message;
				}else{				
					$message = $defaultErrorMessage;
				}
				session(["error" => $message]);
			}else{
				$res = json_decode($res);
				if(isset($res->errormsg)){					
					$message = $res->errormsg;
				}else{
					$message = $defaultErrorMessage;
				}
				session(["error" => $res->errormsg]);
			}
			return Handlers::redirectTo($redirectError);
		}
		
		if($curl->curl_error==TRUE){
			$res = $curl->response;
			if($res==false || $res==null){				
				$message = $curl->curl_error_message;
				if($message!=null || $message!=""){
					$message = $message;
				}else{				
					$message = $defaultErrorMessage;
				}
				session(["error" => $message]);
			}else{
				$res = json_decode($res);
				session(["error" => $res->errormsg]);
			}
			return Handlers::redirectTo($redirectError);
		}
		
		if($curl->http_error==TRUE){
			$res = $curl->response;
			if($res==false || $res==null){				
				$message = $curl->http_error_message;
				if($message!=null || $message!=""){
					$message = $message;
				}else{				
					$message = $defaultErrorMessage;
				}
				session(["error" => $message]);
			}else{
				$res = json_decode($res);
				session(["error" => $res->errormsg]);
			}
			return Handlers::redirectTo($redirectError);
		}
		
		$res = json_decode($curl->response);
		
		if(!is_object($res)){
			$message = $defaultErrorMessage;
			session(["error" => $message]);
			return Handlers::redirectTo($redirectError);
		}
		
		$errorcode = $res->errorcode;
		$errormsg = $res->errormsg;
		$data = $res->data;
		
		if(!is_object($data) && !is_array($data)){
			$message = $defaultAPIErrorMessage;
			session(["error" => $message]);
			return Handlers::redirectTo($redirectError);
		}
		
		if($errorcode=="0000"){
			if($adds!=null && isset($adds["login"]) && $adds["login"]==true){				
				session(["auth" => $data]);
			}else if($adds!=null && isset($adds["token"]) && $adds["token"]==true){		
				Cookies::create($r, $data);
			}else if($adds!=null && isset($adds["data"]) && $adds["data"]=="default"){
				// https://www.php.net/manual/en/functions.anonymous.php
			}
			return Handlers::redirectTo($redirectSuccess);
		}else if($errorcode=="00101"){
			$message = $errormsg;
			session(["error" => $message]);
			return Handlers::redirectTo($redirectError);
		}else if($errorcode=="00102"){
			$message = $errormsg;
			session(["error" => $message]);
			return Handlers::redirectTo($redirectError);
		}
    }
	
	public static function redirectTo($to, $method="route"){
		if($method=="route"){
			return redirect()->route($to);
		}
	}
	
}