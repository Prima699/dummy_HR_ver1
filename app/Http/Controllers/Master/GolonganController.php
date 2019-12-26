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
		$params['field'] = 'golongan_name';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/golongan', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
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
				session(["error" => "Server Unreachable."]);
				return Response()->json($data);
			}
		}
		
		$data["recordsTotal"] = $amount;
		$data["recordsFiltered"] = $amount;
		
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
		$master = $this->master("Create Category","admin.category.store","category.create","POST");
        return view("master.golongan.form", compact('master')); 
    }
	
	public function store(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['golongan_name'] = $r->name;
		$curl->post(Constants::api() . "/golongan/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.category.create');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$status = "Success creating new category.";
			session(["status" => $status]);
			return redirect()->route('admin.category.index');
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.category.create');
		}
	}
	
	public function edit(Request $r, $id){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['golongan_id'] = $id;
		$curl->get(Constants::api() . '/golongan', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.category.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data[0];
			$master = $this->master("Edit Category","admin.category.update","category.edit","PUT",$id);
			return view('master.golongan.form', compact('data','master'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.category.index');
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
		
		$params['golongan_id'] = $id;
		$params['golongan_name'] = $r->name;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,Constants::api() . "/golongan/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/golongan_id/$id");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		$res = curl_exec($ch);
		
		if(!$res){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.category.edit',["id"=>$id]);
		}
		
		$res = json_decode($res);
		
		if($res->errorcode=="0000"){
			$status = "Success updating category.";
			session(["status" => $status]);
			return redirect()->route('admin.category.index');
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.category.edit',["id"=>$id]);
		}
	}

}


 ?>