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

class CountryController extends Controller{
	/**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */


	public function index(){
        return view("master.country.index");
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
		$params['field'] = 'name;ID_t_md_country';
		$params['search'] = $search;
		$curl->get(Constants::api() . '/country', $params);
		
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
		$params['field'] = 'name;region';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/country', $params);

		
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
				$tmp = [$i, $a->name, $a->region, $a->ID_t_md_country];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}

    public function create(){
		$master = $this->master("Create country","admin.country.store","country.create","POST");
        return view("master.country.form", compact('master')); 
    }
	
	public function store(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");

		
		$params['name'] = $r->name;
		$params['region'] = $r->region;
		$curl->post(Constants::api() . "/country/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.country.create');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$status = "Success creating new country.";
			session(["status" => $status]);
			return redirect()->route('admin.country.index');
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.country.create');
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
		$params['ID_t_md_country'] = $id;
		$curl->get(Constants::api() . '/country', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('master.country.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data[0];
			$master = $this->master("Edit country","admin.country.update","country.edit","PUT",$id);
			return view('master.country.form', compact('data','master'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.country.index');
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
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['ID_t_md_country'] = $id;
		$params['name'] = $r->name;
		$params['region'] = $r->region;
		$curl->setHeader('Content-Type','application/x-www-form-urlencoded');
		$curl->put(Constants::api() . "/country/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/ID_t_md_country/$id", $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.country.edit',["id"=>$id]);
		}
		
		$res = json_decode($curl->response);

		if($res->errorcode=="0000"){
			$status = "Success updating country.";
			session(["status" => $status]);
			return redirect()->route('admin.country.index');
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.country.edit',["id"=>$id]);
		}
	}   

}


 ?>