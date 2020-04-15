<?php 

namespace App\Http\Controllers\eSPJ;


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

class stController extends Controller{

	public function index(Request $r){
		$agenda = "onGoing";
		$module = "Surat Tugas";
		$route = "st";
		if(isset($r->agenda) AND $r->agenda=="upComing"){
			$agenda = "upComing";
		}else if(isset($r->agenda) AND $r->agenda=="done"){
			$agenda = "done";
		}
		return view("agenda.".$agenda, compact("module","route"));
    }
	
	public function create(){
		$master = $this->master("Create Surat Tugas","admin.agenda.store","st.create","POST");
		session(["redirect.route" => "admin.st"]);
        return view("agenda.form", compact('master')); 
    }
	
	public function validation(Request $r){
		$r->validate([
			'name' => 'required|max:45'
		]);
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
			$master = $this->master("Edit Surat Tugas","admin.agenda.update","st.edit","PUT",$id);
			session(["redirect.route" => "admin.st"]);
			return view('agenda.form', compact('data','master'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.agenda.index');
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
			return redirect()->route('admin.st.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data[0];
			$button = false;
			$master = $this->master("Detail Surat Tugas","admin.st.verify","st.detail","PUT",$id);
			$back = route('admin.st.index');
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
			return redirect()->route('admin.st.index');
		}
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
			return redirect()->route('admin.st.detail',["id"=>$r->id]);
		}else{
			session(["status" => "Success updating surat tugas."]);
			return redirect()->route('admin.st.index');
		}
	}

}
