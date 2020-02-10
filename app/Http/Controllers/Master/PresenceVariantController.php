<?php 

namespace App\Http\Controllers\Master;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;
use Constants;
use App\Http\Controllers\Controller;

class PresenceVariantController extends Controller{
	
	private function totalData($r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$search = $r['search']['value'];
		if($search==NULL OR $search==""){
			$search = "";
		}
		
		if(isset($r->token)){
			$token = $r->token;
		}
		
		if(isset($r->userID)){
			$userID = $r->userID;
		}
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['field'] = 'shift_name';
		$params['search'] = $search;
		$curl->get(Constants::api() . '/presensiVarianType', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return -1;
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			return -1;
		}
		
		return count($res->data);
	}
	
	public function data(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$search = $r['search']['value']; //filter keyword
		$start = $r['start']; //offset
		$length = $r['length']; //limit
		$draw = $r['draw'];
		$search = $r['search']['value'];
				
		$data = []; // datatable format
		$data["draw"] = $draw;
		$data["recordsTotal"] = 0;
		$data["recordsFiltered"] = 0;
		$data["data"] = [];
		
		if(isset($r->token)){
			$token = $r->token;
		}
		
		if(isset($r->userID)){
			$userID = $r->userID;
		}
		
		if($search==NULL OR $search==""){
			$search = "";
		}
		
		if($start!=0){
			$start = $start / $length;
		}
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['field'] = 'shift_name';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/presensiVarianType', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return Response()->json($data);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			session(["error" => $res->errormsg]);
			return Response()->json($data);
		}
		
		if($res->data==NULL){ 
			$amount = 0;
		}else{
			$amount = $this->totalData($r);
			
			if($amount==-1){
				return Response()->json($data);
			}
		}
		
		$data["recordsTotal"] = $amount;
		$data["recordsFiltered"] = $amount;
		
		$i = ($length * $start) + 1;
		if($res->data!=NULL){
			foreach($res->data as $a){
				if($a->presensi_type_id==$r->type){					
					$tmp = [$i, $a->shift_name, json_encode($a)];
					$data["data"][] = $tmp;
					$i++;
				}
			}
		}
		
		return Response()->json($data);
	}
	
	public function store(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['presensi_type_id'] = $r->type;
		$params['start_day'] = $r->startDay;
		$params['end_day'] = $r->endDay;
		$params['start_work'] = $r->startWork;
		$params['end_work'] = $r->endWork;
		$params['start_break'] = $r->startBreak;
		$params['end_break'] = $r->endBreak;
		$params['shift_name'] = $r->name;
		$curl->post(Constants::api() . "/presensiVarianType/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return redirect()->route('admin.presence.type.detail',["id"=>$r->type]);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$status = "Success creating new presence variant.";
			session(["status" => $status]);
			return redirect()->route('admin.presence.type.detail',["id"=>$r->type]);
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.presence.type.detail',["id"=>$r->type]);
		}
	}
	
	private function master($t,$a,$b,$m,$p=NULL){
		$data = new \stdClass;
		
		if($p!=NULL){
			$a = route($a,["id"=>$p]);
		}else{
			$a = route($a);
		}
		
		$data->title = $t;
		$data->action = $a;
		$data->breadcrumb = $b;
		$data->method = $m;
		
		return $data;
	}
	
	public function update(Request $r, $id){
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['start_day'] = $r->startDay;
		$params['end_day'] = $r->endDay;
		$params['start_work'] = $r->startWork;
		$params['end_work'] = $r->endWork;
		$params['start_break'] = $r->startBreak;
		$params['end_break'] = $r->endBreak;
		$params['shift_name'] = $r->name;
		$url = Constants::api() . "/presensiVarianType/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/presensi_type_shift_id/$r->presensi_type_shift_id";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		$res = curl_exec($ch);
		
		if(!$res){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.presence.type.detail',["id"=>$id]);
		}
		
		$res = json_decode($res);
		
		if($res->errorcode=="0000"){
			$status = "Success updating presence variant.";
			session(["status" => $status]);
			return redirect()->route('admin.presence.type.detail',["id"=>$id]);
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.presence.type.detail',["id"=>$id]);
		}
	}
	
	public function amount($id){
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
			return -1;
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = 0;
			
			foreach($res->data as $d){
				if($id==$d->presensi_type_id){
					$data += 1;
				}
			}
			
			return $data;
		}else{
			session(['error' => $res->errormsg]);
			return -1;
		}
	}

}


 ?>