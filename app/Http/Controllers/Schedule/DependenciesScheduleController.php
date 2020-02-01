<?php

namespace App\Http\Controllers\Schedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Constants;

class DependenciesScheduleController extends Controller
{
	public function employee(Request $r,$id){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['pegawai_id'] = $id;
		$curl->get(Constants::api() . '/pegawai', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return FALSE;
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return FALSE;
		}
		
		if($res->data!=NULL){
			$data = $res->data[0];
			$data->variant = $this->variant($r,$data->presensi_type_id);
		}else{
			session(["error" => "Empty result of employee."]);
			$data = FALSE;
		}
		
		return $data;
	}
	
	public function type(Request $r,$id){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['presensi_type_id'] = $id;
		$curl->get(Constants::api() . '/presensiType', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return FALSE;
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return FALSE;
		}
		
		if($res->data!=NULL){
			$data = $res->data;
		}else{
			session(["error" => "Empty result of employee."]);
			$data = FALSE;
		}
		
		return $data;
	}
	
	public function variant(Request $r,$id){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/presensiVarianType', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return FALSE;
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return FALSE;
		}
		
		if($res->data!=NULL){
			$data = $res->data;
			$tmp = [];
			foreach($data as $d){
				if($d->presensi_type_id==$id){
					$tmp[] = $d;
				}
			}
			$data = $tmp;
		}else{
			session(["error" => "Empty result of employee."]);
			$data = FALSE;
		}
		
		return $data;
	}
}
