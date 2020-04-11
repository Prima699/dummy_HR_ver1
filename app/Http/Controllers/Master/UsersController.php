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
use Handlers;

class UsersController extends Controller{

	public function index(){
        return view("master.user.index");
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
		$params['field'] = 'name;msisdn;email';
		$params['search'] = $search;
		$curl->get(Constants::api() . '/users', $params);
		
		$handler = Handlers::curl($curl);
		$return = -1;
		
		if($handler==true){
			$return = count(json_decode($curl->response)->data);
		}
		
		return $return;
	}
	
	public function data(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		$amount = 0;
		
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
		$params['field'] = 'name;msisdn;email';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/users', $params);
		
		$handler = Handlers::curl($curl);
		
		if($handler!=true){
			return Response()->json($data);
		}else{
			$amount = $this->totalData($r);
			if($amount==-1){
				return Response()->json($data);
			}
		}
		
		$res = json_decode($curl->response);
		
		$data["recordsTotal"] = $amount;
		$data["recordsFiltered"] = $amount;
		
		$i = ($length * $start) + 1;
		if($res->data!=NULL){
			foreach($res->data as $a){
				$tmp = [$i, $a->name, $a->msisdn, $a->user_image, $a->user_id];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}

    public function create(){
		$master = $this->master("Create User","admin.user.store","user.create","POST");
		$pegawai = $this->getPegawai();
        return view("master.user.form", compact('master','pegawai')); 
    }
	
	private function getPegawai(){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/pegawai', $params);
		
		$handler = Handlers::curl($curl);
		$return = -1;
		
		if($handler==true){
			$return = json_decode($curl->response)->data;
		}
		
		return $return;
	}
	
	public function validation(Request $r){
		// $r->validate([
			// 'name' => 'required|max:45'
		// ]);
	}
	
	public function store(Request $r){
		$this->validation($r);
		
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['name'] = $r->name;
		$params['role'] = $r->role;
		$params['password'] = $r->password;
		$params['email'] = $r->email;
		$params['msisdn'] = $r->msisdn;
		$params['related_id'] = $r->pegawai;
		
		$upload_file = (isset($_FILES['image'])) ? $_FILES['image'] : array();
		if (isset($upload_file['name'])) {
			if ($upload_file['error'] == UPLOAD_ERR_OK) {
				if (function_exists('curl_file_create')) { // For PHP 5.5+
					$params["image"] = curl_file_create(
						$upload_file['tmp_name'],
						$upload_file['type'],
						$upload_file['name']
					);
				} else {
					$params["image"] = '@' . realpath(
						$upload_file['tmp_name'],
						$upload_file['type'],
						$upload_file['name']
					);
				}
			}
		}
		
		$curl->post(Constants::api() . "/users/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params, true);
		dd($curl);
		
		$handler = Handlers::curl($curl);
		$route = "index";
		
		if($handler!=true){
			$route = "admin.user.create";
		}else{
			session(["status" => "Success creating new user."]);
			$route = "admin.user.index";
		}
		
		return redirect()->route($route);
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
		
		$handler = Handlers::curl($curl);
		
		if($handler!=true){
			return redirect()->route('admin.category.index');
		}else{
			$data = json_decode($curl->response)->data[0];
			$master = $this->master("Edit Category","admin.category.update","category.edit","PUT",$id);
			return view('master.golongan.form', compact('data','master'));
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
		$this->validation($r);
		
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		
		$curl = new Curl();
		$url = Constants::api() . "/golongan/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/golongan_id/$id";
		$params['golongan_name'] = $r->name;
		$params['golongan_id'] = $id;
		$curl->put($url, $params, true);
		
		$handler = Handlers::curl($curl);
		
		if($handler!=true){
			return redirect()->route('admin.category.edit',["id"=>$id]);
		}else{
			session(["status" => "Success updating category."]);
			return redirect()->route('admin.category.index');
		}
	}

}
