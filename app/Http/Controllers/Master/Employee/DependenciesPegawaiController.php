<?php 

namespace App\Http\Controllers\Master\Employee;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;
use Constants;
use App\Http\Controllers\Controller;

class DependenciesPegawaiController extends Controller{
	public function country(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/country', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return Response()->json(FALSE);
		}
		
		if($res->data!=NULL){
			$data = $res->data;
		}else{
			session(["error" => "Empty result of country."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
	
	public function province(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['ID_t_md_country'] = $r->country;
		$curl->get(Constants::api() . '/province', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return Response()->json(FALSE);
		}
		
		if($res->data!=NULL){
			$data = $res->data;
		}else{
			session(["error" => "Empty result of province."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
	
	public function city(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['ID_t_md_province'] = $r->province;
		$curl->get(Constants::api() . '/city', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return Response()->json(FALSE);
		}
		
		if($res->data!=NULL){
			$data = $res->data;
		}else{
			session(["error" => "Empty result of province."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
	
	public function departement(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/departemen', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return Response()->json(FALSE);
		}
		
		if($res->data!=NULL){
			$data = $res->data;
		}else{
			session(["error" => "Empty result of departement."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
	
	public function jabatan(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/jabatan', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return Response()->json(FALSE);
		}
		
		if($res->data!=NULL){
			$data = $this->setJabatan($res->data,0);
		}else{
			session(["error" => "Empty result of jabatan."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
	
	private function setJabatan($data,$parent){
		$r = [];
		foreach($data as $d){
			if($d->jabatan_parent==$parent){
				$r[] = [
					"main" => $d,
					"child" => $this->setJabatan($data,$d->jabatan_id)
				];
			}
		}
		return $r;
	}
	
	public function golongan(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/golongan', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return Response()->json(FALSE);
		}
		
		if($res->data!=NULL){
			$data = $res->data;
		}else{
			session(["error" => "Empty result of golongan."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
	
	public function presence(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/presensiType', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return Response()->json(FALSE);
		}
		
		if($res->data!=NULL){
			$data = $res->data;
		}else{
			session(["error" => "Empty result of presence."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
	
	public function office(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/perusahaan_cabang', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return Response()->json(FALSE);
		}
		
		if($res->data!=NULL){
			$data = $res->data;
		}else{
			session(["error" => "Empty result of office."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
	
	public function type(Request $r){
		$r = [];
		
		$tmp = new \stdClass();
		$tmp->id = 1;
		$tmp->name = "Tetap";
		$r[] = $tmp;
		
		$tmp = new \stdClass();
		$tmp->id = 2;
		$tmp->name = "Kontrak";
		$r[] = $tmp;
		
		$tmp = new \stdClass();
		$tmp->id = 3;
		$tmp->name = "Percobaan";
		$r[] = $tmp;
		
		$tmp = new \stdClass();
		$tmp->id = 4;
		$tmp->name = "Freelance";
		$r[] = $tmp;
		
		return Response()->json($r);
	}
}

