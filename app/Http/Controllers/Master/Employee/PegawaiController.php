<?php 

namespace App\Http\Controllers\Master\Employee;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;
use Constants;
use App\Http\Controllers\Controller;

class PegawaiController extends Controller{

    public function index(){
        return view("master.pegawai.index");
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
		$curl->get(Constants::api() . '/pegawai', $params);
		
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
		$params['field'] = 'pegawai_name';
		$params['search'] = $search;
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/pegawai', $params);
		
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
				$tmp = [$i, $a->pegawai_NIK, $a->pegawai_name, $a->pegawai_telp, $a->pegawai_id];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}

    public function create(){
        $master = $this->master("Create Employee","admin.employee.store","employee.create","POST");
        return view("master.pegawai.form", compact('master'));
    }
    
    public function store(Request $r){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $params['pegawai_NIK'] = $r->pegawai_nik;
        $params['pegaawai_name'] = $r->pegawai_name;
        $params['pegawai_email'] = $r->pegawai_email;
        $params['pegawai_telp'] = $r->pegawai_telp;
        // $params['gender'] = $r->gender;
        $params['pegawai_address'] = $r->pegawai_address;
        $params['ID_t_md_country'] = $r->country;
        $params['ID_t_md_city'] = $r->city;
        $params['ID_t_md_province'] = $r->province;
        $params['departemen_id'] = $r->departement;
        $params['jabatan_id'] = $r->jabatan;
        $params['golongan_id'] = $r->golongan;
        $params['presensi_type_id'] = $r->presence;
        $params['perusahaan_cabang_id'] = $r->office;
        $params['pegawai_type'] = $r->type;
        $params['image'] = $r->image;

        $curl->post(Constants::api() . "/pegawai/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
        
        $res = json_decode($curl->response);
        
        if($res->errorcode!="0000"){
            $error = "Failed creating new employee.";
            session(['error' => $error]);
            return redirect()->route('admin.employee.create');
        }else{
            $status = "Success creating new employee.";
            session(["status" => $status]);
            return redirect()->route('admin.employee.index');
        }
    }
	
	public function getImage(Request $r){
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
		$params['pegawai_id'] = $r->id;
		$params['page'] = $r['start'];
		$params['n_item'] = $r['length'];
		$curl->get(Constants::api() . '/pegawaiimage', $params);
		
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
			$amount = $this->totalDataImage($r);
			
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
				$image = $a->path;
				$fd = $a->face_detect;
				$ts = $a->tag;
				$ft = $a->train;
				$id = $a->image_train_id;

				$tmp = [$i, $image, $fd, $ts, $ft, $id];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}
	
	private function totalDataImage($r){
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
		$params['pegawai_id'] = $r->id;
		$params['page'] = $r['start'];
		$params['n_item'] = $r['length'];
		$curl->get(Constants::api() . '/pegawaiimage', $params);
		
		if($curl->error==TRUE){
			return -1;
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode!="0000"){
			return -1;
		}
		
		return count($res->data);
	}
	
	public function face(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		$id = $r->train;
		$rst = true;
		
		if(isset($r->token)){
			$token = $r->token;
		}
		
		if(isset($r->userID)){
			$userID = $r->userID;
		}

		$params[$r->process] = $r->value;
		$url = Constants::api() . "/pegawaiimage/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/image_train_id/$id";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		$res = curl_exec($ch);
		
		if(!$res){
			session(["error" => "Server Unreachable."]);
			$rst = false;
		}else{
			$res = json_decode($res);
			if($res->errorcode!="0000"){
				session(["error" => $res->errormsg]);
				$rst = false;
			}
		}
		
		return Response()->json($rst);
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
		$curl->get(Constants::api() . '/pegawai', $params);
		
		if($curl->error==TRUE){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.employee.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data[0];
			$master = $this->master("Edit Employee","admin.employee.update","employee.edit","PUT",$id);
			return view('master.pegawai.form', compact('data','master'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.employee.index');
		}
	}
	
	public function update(Request $r, $id){
		// dd($r);
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
        $params['pegawai_NIK'] = $r->pegawai_nik;
        $params['pegaawai_name'] = $r->pegawai_name;
        $params['pegawai_email'] = $r->pegawai_email;
        $params['pegawai_telp'] = $r->pegawai_telp;
        // $params['gender'] = $r->gender;
        $params['pegawai_address'] = $r->pegawai_address;
        $params['ID_t_md_country'] = $r->country;
        $params['ID_t_md_city'] = $r->city;
        $params['ID_t_md_province'] = $r->province;
        $params['departemen_id'] = $r->departement;
        $params['jabatan_id'] = $r->jabatan;
        $params['golongan_id'] = $r->golongan;
        $params['presensi_type_id'] = $r->presence;
        $params['perusahaan_cabang_id'] = $r->office;
        $params['pegawai_type'] = $r->type;
        $params['image'] = $r->image;
		$url = Constants::api() . "/pegawai/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/pegawai_id/$id";
		// dd($params);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		$res = curl_exec($ch);
		// dd($res);
		
		if(!$res){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.employee.edit',["id"=>$id]);
		}
		
		$res = json_decode($res);
		
		if($res->errorcode=="0000"){
			$status = "Success updating employee.";
			session(["status" => $status]);
			return redirect()->route('admin.employee.index');
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.employee.edit',["id"=>$id]);
		}
	}

}


 ?>