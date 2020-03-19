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
use DateTimes;

class CalendarController extends Controller{

	public function index(){
        return view("master.calendar.index");
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
		$params['field'] = 'calendar_date;calendar_desc';
		$params['search'] = $search;
		$curl->get(Constants::api() . '/calendar', $params);
		
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
		$params['field'] = 'calendar_date;calendar_desc';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/calendar', $params);
		
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
				$tmp = [$i, $a->calendar_desc, DateTimes::jfy($a->calendar_date), $a->calendar_id];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}

    public function create(){
		$master = $this->master("Create Calendar","admin.calendar.store","calendar.create","POST");
        return view("master.calendar.form", compact('master')); 
    }
	
	public function validation(Request $r){
		$r->validate([
			'name' => 'required|max:45'
		]);
	}
	
	public function store(Request $r){
		$this->validation($r);
		
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['desc'] = $r->name;
		$params['from'] = $r->from;
		$params['to'] = $r->to;
		$curl->post(Constants::api() . "/calendar/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		$handler = Handlers::curl($curl);
		$route = "index";
		
		if($handler!=true){
			$route = "admin.calendar.create";
		}else{
			session(["status" => "Success creating new calendar."]);
			$route = "admin.calendar.index";
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
		$params['calendar_id'] = $id;
		$curl->get(Constants::api() . '/calendar', $params);
		
		$handler = Handlers::curl($curl);
		
		if($handler!=true){
			return redirect()->route('admin.calendar.index');
		}else{
			$data = json_decode($curl->response)->data[0];
			$master = $this->master("Edit Calendar","admin.calendar.update","calendar.edit","PUT",$id);
			return view('master.calendar.form', compact('data','master'));
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
		$url = Constants::api() . "/calendar/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/calendar_id/$id";
		$params['desc'] = $r->name;
		$params['date'] = $r->date;
		$params['calendar_id'] = $id;
		$curl->put($url, $params, true);
		
		$handler = Handlers::curl($curl);
		$route = "index";
		
		if($handler!=true){
			return redirect()->route('admin.calendar.edit',["id"=>$id]);
		}else{
			session(["status" => "Success updating calendar."]);
			return redirect()->route('admin.calendar.index');
		}
	}

}
