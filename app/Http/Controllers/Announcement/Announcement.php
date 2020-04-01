<?php 

namespace App\Http\Controllers\Announcement;


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
use DateTimes;

class Announcement extends Controller{

	public function index(){
        return view("announcement.index");
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
		$params['field'] = 'broadcast_message.broadcast_message_desc;mc.message_category_name';
		$params['search'] = $search;
		$curl->get(Constants::api() . '/bcMessage', $params);
		
		$handler = Handlers::curl($curl);
		$return = -1;
		
		if($handler==true){
			$res = json_decode($curl->response);
			if($res->data!=NULL){				
				$return = count($res->data);
			}
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
		$params['field'] = 'broadcast_message.broadcast_message_desc;mc.message_category_name';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/bcMessage', $params);
		
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
				$tmp = [
					$i,
					$a->kategori,
					$a->message,
					$a->pengirim,
					DateTimes::hijfy($a->ts)
				];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}

    public function create(){
		$master = $this->master("Create Announcement","admin.announcement.store","announcement.create","POST");
        return view("announcement.form", compact('master')); 
    }
	
	public function validation(Request $r){
	}
	
	public function store(Request $r){
		$this->validation($r);
		
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['message_category_id'] = $r->category;
		$params['departemen_id'] = $r->department;
		$params['message'] = $r->message;
		$params['from'] = $userID;
		$curl->post(Constants::api() . "/bcMessage/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		$handler = Handlers::curl($curl);
		$route = "index";
		
		if($handler!=true){
			$route = "admin.announcement.create";
		}else{
			session(["status" => "Success creating new announcement."]);
			$route = "admin.announcement.index";
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
	
	public function category(){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/messageCategory', $params);
		
		$handler = Handlers::curl($curl);
		
		if($handler!=true){
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		return Response()->json($res->data);
	}
	
	public function department(){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$curl->get(Constants::api() . '/departemen', $params);
		
		$handler = Handlers::curl($curl);
		
		if($handler!=true){
			return Response()->json(FALSE);
		}
		
		$res = json_decode($curl->response);
		
		return Response()->json($res->data);
	}

}
