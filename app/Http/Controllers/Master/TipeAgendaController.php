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

class TipeAgendaController extends Controller{
	/**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */


	public function index(){
        return view("master.tipeAgenda.index");
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
		$params['field'] = 'category_agenda_id';
		$params['search'] = $search;
		$curl->get(Constants::api() . '/category_agenda', $params);
		
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
		$params['field'] = 'category_agenda_id';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/category_agenda', $params);
		
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
				$tmp = [$i, $a->category_agenda_name, $a->category_agenda_id];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}

    public function create(){
		$master = $this->master("Create Tipe Agenda","admin.TipeAgenda.store","TipeAgenda.create","POST");
        return view("master.TipeAgenda.form", compact('master')); 
    }
	
	public function store(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['category_agenda_name'] = $r->agendaname;
		$params['category_agenda_color'] = $r->agendacolor;
		$curl->post(Constants::api() . "/category_agenda/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.TipeAgenda.create');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$status = "Success creating new AgendaTipe.";
			session(["status" => $status]);
			return redirect()->route('admin.TipeAgenda.index');
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.TipeAgenda.create');
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
		$params['category_agenda_id'] = $id;
		$curl->get(Constants::api() . '/category_agenda', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('master.TipeAgenda.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data[0];
			$master = $this->master("Edit Tipe Agenda","admin.TipeAgenda.update","TipeAgenda.edit","PUT",$id);
			return view('master.TipeAgenda.form', compact('data','master'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.TipeAgenda.index');
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
		
		$params['category_agenda_id'] = $id;
		$params['category_agenda_name'] = $r->agendaname;
		$params['category_agenda_color'] = $r->agendacolor;
		$curl->setHeader('Content-Type','application/x-www-form-urlencoded');
		$curl->put(Constants::api() . "/category_agenda/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/category_agenda_id/$id", $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.TipeAgenda.edit',["id"=>$id]);
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$status = "Success updating tipe Agenda.";
			session(["status" => $status]);
			return redirect()->route('admin.TipeAgenda.index');
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.TipeAgenda.edit',["id"=>$id]);
		}
	}   

}


 ?>