<?php

namespace App\Http\Controllers\Schedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Constants;

class ScheduleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
		return view("schedule.index");
    }
	
	public function admin($r){
		$agenda = "waiting";
		if(isset($r->agenda) AND $r->agenda=="onGoing"){
			$agenda = "onGoing";
		}else if(isset($r->agenda) AND $r->agenda=="done"){
			$agenda = "done";
		}
		return view("agenda.".$agenda);
	}
	public function employee(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		$pegawaiID = Auths::user("pegawai.pegawai_id");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['pegawai_id'] = $pegawaiID;
		$curl->get(Constants::api() . '/pegawai_agenda', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('employee.agenda.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data;
			$master = $this->master("Agenda","admin.agenda.index","agenda","GET");
			return view('agenda.employee', compact('data','master'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('employee.agenda.index');
		}
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
		$params['field'] = 'pegawai_name';
		$params['search'] = $search;
		$curl->get(Constants::api() . '/pegawaiJadwal', $params);
		
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
		$params['sort_by'] = "pegawai_id;asc";
		$params['field'] = 'pegawai_name';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/pegawai', $params);
		
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
				session(["error" => "Server Unreachable."]);
				return Response()->json($data);
			}
		}
		
		$data["recordsTotal"] = $amount;
		$data["recordsFiltered"] = $amount;
		
		$i = ($length * $start) + 1;
		if($res->data!=NULL){
			foreach($res->data as $a){
				$tmp = [$i, $a->pegawai_name, $a->presensi_type_name, $a->pegawai_id];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}
	
	public function create(Request $r){
		$master = $this->master("Create Schedule","admin.schedule.store","schedule.create","POST");
        return view("schedule.form", compact('master')); 
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
		$i = 0;
		
		$params = [ "pegawai_id" => $r->employee ];
		$params["presensi_type_shift_id[$i]"] = $r->variant;
		$params["work_day_start[$i]"] = date("Y-m-d",strtotime($r->workStart));
		$params["work_day_end[$i]"] = date("Y-m-d",strtotime($r->workEnd));
		$params["off_day_start[$i]"] = date("Y-m-d",strtotime($r->offStart));
		$params["off_day_end[$i]"] = date("Y-m-d",strtotime($r->offEnd));
		$curl->post(Constants::api() . "/pegawaiJadwal/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$status = "Success creating new schedule.";
			session(["status" => $status]);
		}else{
			session(['error' => $res->errormsg]);
		}
		
		return redirect()->route('admin.schedule.edit',$r->employee);
	}
	
	public function storeFixed(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		$i = 0;
		
		if($r->i==-1 || $r->i=="-1"){
			session(['error' => "Please setup presence type & variant first."]);
			return redirect()->route('admin.schedule.edit',$r->e);
		}
		
		$params = [ "pegawai_id" => $r->e ];
		$params["presensi_type_shift_id[$i]"] = $r->i;
		$params["work_day_start[$i]"] = '';
		$params["work_day_end[$i]"] = '';
		$params["off_day_start[$i]"] = '';
		$params["off_day_end[$i]"] = '';
		$curl->post(Constants::api() . "/pegawaiJadwal/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$status = "Success creating new schedule.";
			session(["status" => $status]);
		}else{
			session(['error' => $res->errormsg]);
		}
		
		return redirect()->route('admin.schedule.edit',$r->e);
	}
	
	public function detail(Request $r, $id){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['agenda_id'] = $id;
		$curl->get(Constants::api() . '/agenda', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.agenda.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data[0];
			$master = $this->master("Detail Agenda","admin.agenda.index","agenda.detail","GET",$id);
			$back = route('admin.agenda.index');
			if(Auths::user("user.role")=="agt"){
				$back = route('employee.agenda.index');
			}
			return view('agenda.detail', compact('data','master','back'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.agenda.index');
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
		$params['pegawai_id'] = $id;
		$curl->get(Constants::api() . '/pegawaiJadwal', $params);
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return redirect()->route('admin.schedule.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000" || $res->errorcode=="00001"){
			$data = $res->data;
			$dep = new DependenciesScheduleController();
			$employee = $dep->employee($r,$id);
			$master = $this->master("Edit Schedule","admin.schedule.store","schedule.edit","POST",$id);
			return view('schedule.form', compact('master','employee','data'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.schedule.index');
		}
	}
	
	public function update(Request $r, $id){
		$this->validation($r);
		
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params = [ "presensi_type_shift_id" => $r->variant ];
		$params["work_day_start"] = date("Y-m-d",strtotime($r->workStart));
		$params["work_day_end"] = date("Y-m-d",strtotime($r->workEnd));
		$params["off_day_start"] = date("Y-m-d",strtotime($r->offStart));
		$params["off_day_end"] = date("Y-m-d",strtotime($r->offEnd));
		$url = Constants::api() . "/pegawaiJadwal/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/presensi_config_id/$id";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		$res = curl_exec($ch);
		
		if(!$res){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.schedule.edit',["id"=>$r->employee]);
		}
		
		$res = json_decode($res);
		
		if($res->errorcode=="0000"){
			$status = "Success updating schedule.";
			session(["status" => $status]);
			return redirect()->route('admin.schedule.edit',["id"=>$r->employee]);
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.schedule.edit',["id"=>$r->employee]);
		}
	}
}
