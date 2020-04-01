<?php
namespace App\Helpers;

class Handlers {
	
	public static function curl($curl, $adds=null) {
		$defaultErrorMessage = "Unknown error occured.";
		$defaultAPIErrorMessage = "Response API is not appropriate.";
		
		if( ( is_array($curl) && isset($curl["message"]) ) || isset($curl->message) ){
			session(["error" => "Server unreachable."]);
			return false;
		}
		
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
			return false;
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
			return false;
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
			return false;
		}
		
		$res = json_decode($curl->response);
		
		if($res==false || !is_object($res)){
			$message = $defaultErrorMessage;
			session(["error" => $message]);
			return false;
		}
		
		$errorcode = $res->errorcode;
		$errormsg = $res->errormsg;
		$data = $res->data;
		
		if(!is_object($data) && !is_array($data)){
			if($errorcode!="0000" && $errorcode!="00001"){				
				$message = $defaultAPIErrorMessage;
				session(["error" => $message]);
				return false;
			}
		}
		
		$return = false;
		
		if($errorcode=="0000"){
			$return = true;
		}else if($errorcode=="00101"){
			session(["error" => $errormsg]);
		}else if($errorcode=="00102"){
			session(["error" => $errormsg]);
		}else if($errorcode=="00099"){
			session(["error" => $defaultErrorMessage]);
		}else if($errorcode=="00001"){
			$return = true;
			session(["error" => $errormsg]);
		}else if($errorcode=="00002"){
			session(["error" => $errormsg]);
		}else if($errorcode=="00003"){
			session(["error" => $errormsg]);
		}else if($errorcode=="00103"){
			session(["error" => $errormsg]);
		}else if($errorcode=="00104"){
			session(["error" => $errormsg]);
		}else if($errorcode=="00151"){
			session(["error" => $errormsg]);
		}else if($errorcode=="00161"){
			session(["error" => $errormsg]);
		}else if($errorcode=="00160"){
			session(["error" => $errormsg]);
		}else if($errorcode=="00169"){
			session(["error" => $errormsg]);
		}
		
		return $return;
    }
	
}