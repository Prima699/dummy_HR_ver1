<?php

namespace App\Http\Controllers\Agenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Constants;

class DependeciesAgendaController extends Controller
{
	public function category(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/category_agenda', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
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
			session(["error" => "Empty result of category agenda."]);
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
		$curl->get(Constants::api() . '/province', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
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
		$curl->get(Constants::api() . '/city', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
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
			session(["error" => "Empty result of city."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
	
	public function employee(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/pegawai', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
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
			session(["error" => "Empty result of employee."]);
			$data = FALSE;
		}
		
		return Response()->json($data);
	}
}
