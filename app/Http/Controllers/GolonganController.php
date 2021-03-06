<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;
use Constants;

class GolonganController extends Controller{

	public function index(){
        return view("master.golongan.index");
    }
	
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
		$params['field'] = 'golongan_name;golongan_id';
		$params['search'] = $search;
		$curl->get(Constants::api() . '/golongan', $params);
		
		if($curl->error==TRUE){
			return -1;
		}
		
		$res = json_decode($curl->response);
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
		
		if(isset($r->token)){
			$token = $r->token;
		}
		
		if(isset($r->userID)){
			$userID = $r->userID;
		}
		
		if($search==NULL OR $search==""){
			$search = "";
		}
		
		if($r['start']!=0){
			$r['start'] = $r['start'] / $r['length'];
		}
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['field'] = 'golongan_name';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/golongan', $params);
		
		if($curl->error==TRUE){
			$data = []; // datatable format
			$data["draw"] = $draw;
			$data["recordsTotal"] = 0;
			$data["recordsFiltered"] = 0;
			$data["data"] = [[0,0,0]];
			return Response()->json($data);
		}
		
		$res = json_decode($curl->response);
		
		if($res->data==NULL){ 
			$amount = 0;
		}else{			
			// $amount = count($res->data);
			$amount = $this->totalData($r);
			
			if($amount==-1){				
				$data = []; // datatable format
				$data["draw"] = $draw;
				$data["recordsTotal"] = 0;
				$data["recordsFiltered"] = 0;
				$data["data"] = [[0,0,0]];
				return Response()->json($data);
			}
		}
		
		$recordsTotal = $amount; //count all data by
		$recordsFiltered = $amount;
		
		$data = []; // datatable format
		$data["draw"] = $draw;
		$data["recordsTotal"] = $recordsTotal;
		$data["recordsFiltered"] = $recordsFiltered;
		$data["data"] = [];
		
		$i = ($length * $start) + 1;
		if($res->data!=NULL){
			foreach($res->data as $a){
				$tmp = [$i, $a->golongan_name, $a->golongan_id];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}

    public function create(){
        return view("master.golongan.form"); 
    }
	
	public function store(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		// $params['user_id'] = $userID;
		// $params['access_token'] = $token;
		// $params['platform'] = 'dashboard';
		// $params['location'] = 'xxx';
		// $params['golongan_name'] = $r->name;
		// $curl->post(Constants::api() . '/golongan', $params);
		
		$params['golongan_name'] = $r->name;
		$curl->post(Constants::api() . "/golongan/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			$error = "Failed creating new category.";
			session(['error' => $error]);
			return redirect()->route('admin.category.create');
		}else{
			$status = "Success creating new category.";
			session(["status" => $status]);
			return redirect()->route('admin.category.index');
		}
	}

}


 ?>