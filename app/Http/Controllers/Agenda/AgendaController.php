<?php

namespace App\Http\Controllers\Agenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Constants;
use Handlers;
use DateTimes;
use DB;

class AgendaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
		if(Auths::user("user.role")=="adm"){
			return $this->admin($r);
		}else{
			return $this->employee($r);
		}
    }
	
	public function admin($r){
		$agenda = "onGoing";
		$module = "Agenda";
		$route = "agenda";
		if(isset($r->agenda) AND $r->agenda=="upComing"){
			$agenda = "upComing";
		}else if(isset($r->agenda) AND $r->agenda=="done"){
			$agenda = "done";
		}
		return view("agenda.".$agenda, compact("module","route"));
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
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
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
		
		date_default_timezone_set("Asia/Jakarta");
		if($r->agenda=="upComing"){
			$params['agenda_status'] = 1;
			$params['before_date'] = date("Y-m-d");
		}else if($r->agenda=="onGoing"){
			$params['agenda_status'] = 1;
			$params['due_date'] = date("Y-m-d");
		}else if($r->agenda=="done"){
			$params['agenda_status'] = 2;
		}
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['field'] = 'agenda_title;category_agenda_name';
		$params['search'] = $search;
		$curl->get(Constants::api() . '/agenda', $params);
		
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
		date_default_timezone_set("Asia/Jakarta");
		if($r->agenda=="upComing"){
			$params['agenda_status'] = 1;
			$params['before_date'] = date("Y-m-d");
		}else if($r->agenda=="onGoing"){
			$params['agenda_status'] = 1;
			$params['due_date'] = date("Y-m-d");
		}else if($r->agenda=="done"){
			$params['agenda_status'] = 2;
		}
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['sort_by'] = "agenda_date;asc";
		$params['field'] = 'agenda_title;category_agenda_name';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/agenda', $params);
		
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
		
		// dd($res->data[0]);
		
		$i = ($length * $start) + 1;
		if($res->data!=NULL){
			foreach($res->data as $a){
				$tmp = [$i, $a->category_agenda_name, $a->agenda_title, $a->agenda_date, $a->agenda_date_end, $a->nama_city, $a->agenda_id];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}
	
	public function create(Request $r){
		$master = $this->master("Create Agenda","admin.agenda.store","agenda.create","POST");
        return view("agenda.form", compact('master')); 
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
		
		$params = [
			"category_agenda_id" => $r->category,
			"agenda_title" => $r->title,
			"agenda_desc" => $r->description,
			"ID_t_md_province" => $r->province,
			"ID_t_md_city" => $r->city,
			"hari" => [],
			"anggota" => []
		];
		for($i=0; $i<count($r->date); $i++){
			$tmp = new \stdClass;
			$tmp->agenda_detail_date = DateTimes::ymd($r->date[$i]);
			$tmp->agenda_detail_address = $r->address[$i];
			$tmp->agenda_detail_time_start = $r->start[$i];
			$tmp->agenda_detail_time_end = $r->end[$i];
			$tmp->agenda_detail_long = $r->lng[$i];
			$tmp->agenda_detail_lat = $r->lat[$i];
			$params["hari"][] = $tmp;
		}
		for($i=0; $i<count($r->employee); $i++){
			$tmp = new \stdClass;
			$tmp->pegawai_id = $r->employee[$i];
			$params["anggota"][] = $tmp;
		}
		$curl->post(Constants::api() . "/agenda/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
		
		$redirect = "admin.agenda";
		$red = session("redirect.route");
		$module = "agenda";
		if($red!=NULL && $red!=""){
			$redirect = $red;
			$module = "surat tugas";
			$this->stInsert($r, $curl);
			session(["redirect.route" => NULL]);
		}
		
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			
			return redirect()->route($redirect . ".create");
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$status = "Success creating new " . $module . ".";
			session(["status" => $status]);
			return redirect()->route($redirect . ".index");
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route($redirect . ".create");
		}
	}
	
	private function stInsert($r, $agenda){
		$agenda_id = json_decode($agenda->response)->data->agenda_id;
		
		$curl = new Curl();
		$curl->get("https://www.uuidgenerator.net/api/version4");
		$uuid = $curl->response;
		
		$now = DateTimes::ymdhis();
		
		DB::table("st_surattugas")
			->insert([
				"id" => $uuid,
				"agenda_id" => $agenda_id,
				"agenda_title" => $r->title,
				"created_at" => $now,
				"updated_at" => $now
			]);
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
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return redirect()->route('admin.agenda.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data[0];
			$button = false;
			$master = $this->master("Detail Agenda","admin.agenda.verify","agenda.detail","PUT",$id);
			$back = route('admin.agenda.index');
			if(Auths::user("user.role")=="agt"){
				$back = route('employee.agenda.index');
			}
			if(
				($data->agenda_status==1 OR $data->agenda_status=="1")
				AND $data->agenda_date_end >= date("Y-m-d")
				AND $data->agenda_date <= date("Y-m-d") 
			){
				$button = true;
			}
			return view('agenda.detail', compact('data','master','back','button'));
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
		$params['agenda_id'] = $id;
		$curl->get(Constants::api() . '/agenda', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
		}
		if($curl->error==TRUE){
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return redirect()->route('admin.agenda.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data[0];
			$master = $this->master("Edit Agenda","admin.agenda.update","agenda.edit","PUT",$id);
			return view('agenda.form', compact('data','master'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.agenda.index');
		}
	}
	
	public function update(Request $r, $id){
		$this->validation($r);
		
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$params = [
			"category_agenda_id" => $r->category,
			"agenda_title" => $r->title,
			"agenda_desc" => $r->description,
			"ID_t_md_province" => $r->province,
			"ID_t_md_city" => $r->city,
			"hari" => [],
			"anggota" => []
		];
		for($i=0; $i<count($r->date); $i++){
			$tmp = new \stdClass;
			$tmp->agenda_detail_date = $r->date[$i];
			$tmp->agenda_detail_address = $r->address[$i];
			$tmp->agenda_detail_time_start = $r->start[$i];
			$tmp->agenda_detail_time_end = $r->end[$i];
			$tmp->agenda_detail_long = 107.6570477;
			$tmp->agenda_detail_lat = -6.895538;
			
			if($r->agenda_detail_id[$i]!=-1){
				$tmp->agenda_detail_id = $r->agenda_detail_id[$i];
			}
			
			$params["hari"][] = $tmp;
		}
		for($i=0; $i<count($r->employee); $i++){
			$tmp = new \stdClass;
			$tmp->pegawai_id = $r->employee[$i];
			
			if($r->id_attendance[$i]!=-1){
				$tmp->id_attendance = $r->id_attendance[$i];
			}
			
			$params["anggota"][] = $tmp;
		}
		$url = Constants::api() . "/agenda/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/agenda_id/$id";
		// dd([$params,$id]);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		$res = curl_exec($ch);
		
		$redirect = "admin.agenda";
		$red = session("redirect.route");
		$module = "agenda";
		if($red!=NULL && $red!=""){
			$redirect = $red;
			$module = "surat tugas";
			$this->stUpdate($r,$id);
			session(["redirect.route" => NULL]);
		}
		
		if(!$res){
			session(["error" => "Server Unreachable."]);
			return redirect()->route($redirect . '.edit',["id"=>$id]);
		}
		
		$res = json_decode($res);
		
		if($res->errorcode=="0000"){
			$status = "Success updating " . $module . ".";
			session(["status" => $status]);
			return redirect()->route($redirect . '.index');
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route($redirect . '.edit',["id"=>$id]);
		}
	}
	
	private function stUpdate($r, $agenda){
		$now = DateTimes::ymdhis();
		
		DB::table("st_surattugas")
			->where("agenda_id",$agenda)
			->update([
				"agenda_title" => $r->title,
				"updated_at" => $now
			]);
	}
	
	public function verify(Request $r){
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$curl = new Curl();
		$url = Constants::api() . "/verifikasiagenda/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/agenda_id/" . $r->id;
		$params['agenda_id'] = $r->id;
		$curl->put($url, $params, true);
		
		$handler = Handlers::curl($curl);
		
		if($handler!=true){
			return redirect()->route('admin.agenda.edit',["id"=>$r->id]);
		}else{
			session(["status" => "Success updating agenda."]);
			return redirect()->route('admin.agenda.index');
		}
	}
	
	public function fcManual(Request $r){
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		$curl = new Curl();
		
		$url = Constants::api() . "/verifikasiMember/user_id/$userID/access_token/$token/platform/dashboard/location/xxx";
		$url .= "/attendance_id/" . $r->id;
		// $url .= "/attendance_status/" . $r->status;
		
		$params['attendance_status'] = $r->status;
		$curl->put($url, $params, true);
		
		$handler = Handlers::curl($curl);
		
		return Response()->json($handler);
	}
}
