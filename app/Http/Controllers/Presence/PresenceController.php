<?php

namespace App\Http\Controllers\Presence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Constants;

class PresenceController extends Controller
{
    public function index(){
		return view("presence.index");
	}
	
	public function status(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		$pegawaiID = Auths::user("pegawai.pegawai_id");
		$status = $r->v;
		
		date_default_timezone_set("Asia/Jakarta");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['pegawai_id'] = $pegawaiID;
		$params['date'] = date("Y-m-d");
		$curl->get(Constants::api() . '/attendanceStatus', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			$return = NULL;
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			$return = NULL;
		}
		
		// return Response()->json($res);
		if(is_array($res->data->$status)){
			session(["error" => "Error occured. Please contact Administrator or our support center."]);
			$return = NULL;
		}else if($res->data->$status->status=="off"){
			session(["error" => "There is no $status today."]);
			$return = NULL;
		}else if($res->data->$status->work_status=="waiting"){
			$return = $res->data->$status;
		}else{
			session(["error" => "You have made a presence today."]);
			$return = NULL;
		}
		return Response()->json($return);
	}
}
