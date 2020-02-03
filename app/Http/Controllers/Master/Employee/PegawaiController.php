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
        $ch = curl_init();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		$url = Constants::api() . "/pegawai/user_id/$userID/access_token/$token/platform/dashboard/location/xxx";
		
		$params = array(
			"pegawai_NIK" => $r->pegawai_NIK,
			"pegawai_name" => $r->pegawai_name,
			"pegawai_email" => $r->pegawai_email,
			"pegawai_telp" => $r->pegawai_telp,
			"pegawai_address" => $r->pegawai_address,
			"ID_t_md_country" => $r->ID_t_md_country,
			"ID_t_md_city" => $r->ID_t_md_city,
			"ID_t_md_province" => $r->ID_t_md_province,
			"departemen_id" => $r->departemen_id,
			"jabatan_id" => $r->jabatan_id,
			"golongan_id" => $r->golongan_id,
			"presensi_type_id" => $r->presensi_type_id,
			"perusahaan_cabang_id" => $r->perusahaan_cabang_id,
			"pegawai_type" => $r->pegawai_type
		);
    
		$postfields = array();
		$upload_file = (isset($_FILES['image'])) ? $_FILES['image'] : array();
		
		if (isset($upload_file['name'])) {
			foreach ($upload_file["error"] as $key => $error) {
				if ($error == UPLOAD_ERR_OK) {
					if (function_exists('curl_file_create')) { // For PHP 5.5+
						$params["image[$key]"] = curl_file_create(
							$upload_file['tmp_name'][$key],
							$upload_file['type'][$key],
							$upload_file['name'][$key]
						);
					} else {
						$params["image[$key]"] = '@' . realpath(
							$upload_file['tmp_name'][$key],
							$upload_file['type'][$key],
							$upload_file['name'][$key]
						);
					}
				}
			}
		}
		
		curl_setopt_array($ch, array(
			CURLOPT_POST => 1,
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => 1,
			CURLINFO_HEADER_OUT => 1,
			CURLOPT_HTTPHEADER => array("Content-Type:multipart/form-data"),
			CURLOPT_POSTFIELDS => $params,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
		));

		$res = curl_exec($ch);

		if(!$res){
			session(["error" => "Server Unreachable."]);
			return redirect()->route('admin.employee.create');
		}
		
		$res = json_decode($res);
		
		if($res->errorcode=="0000"){
			$status = "Success creating employee.";
			session(["status" => $status]);
			return redirect()->route('admin.employee.index');
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.employee.create');
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
		$params['page'] = $start;
		$params['n_item'] = $length;
		$curl->get(Constants::api() . '/pegawaiimage', $params);
		
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

				$tmp = [$i, $image, $fd, $ts, $ft];
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
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
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
	
	public function update(Request $r,$id){
		$ch = curl_init();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		$url = Constants::api() . "/pegawaiEdit/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/pegawai_id/$id";
		
		$params = array(
			"pegawai_NIK" => $r->pegawai_NIK,
			"pegawai_name" => $r->pegawai_name,
			"pegawai_email" => $r->pegawai_email,
			"pegawai_telp" => $r->pegawai_telp,
			"pegawai_address" => $r->pegawai_address,
			"ID_t_md_country" => $r->ID_t_md_country,
			"ID_t_md_city" => $r->ID_t_md_city,
			"ID_t_md_province" => $r->ID_t_md_province,
			"departemen_id" => $r->departemen_id,
			"jabatan_id" => $r->jabatan_id,
			"golongan_id" => $r->golongan_id,
			"presensi_type_id" => $r->presensi_type_id,
			"perusahaan_cabang_id" => $r->perusahaan_cabang_id,
			"pegawai_type" => $r->pegawai_type
		);
		
		if($r->has("eks_image")){
			$i = 0;
			foreach($r->eks_image as $e){
				$params["eks_image[$i]"] = $e;
				$i++;
			}
		}else{
			$params["eks_image[]"] = 0;
		}
		
		$postfields = array();
		$upload_file = (isset($_FILES['image'])) ? $_FILES['image'] : array();
		
		if (isset($upload_file['name'])) {
			foreach ($upload_file["error"] as $key => $error) {
				if ($error == UPLOAD_ERR_OK) {
					if (function_exists('curl_file_create')) { // For PHP 5.5+
						$params["image[$key]"] = curl_file_create(
							$upload_file['tmp_name'][$key],
							$upload_file['type'][$key],
							$upload_file['name'][$key]
						);
					} else {
						$params["image[$key]"] = '@' . realpath(
							$upload_file['tmp_name'][$key],
							$upload_file['type'][$key],
							$upload_file['name'][$key]
						);
					}
				}
			}
		}
		
		curl_setopt_array($ch, array(
			CURLOPT_POST => 1,
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => 1,
			CURLINFO_HEADER_OUT => 1,
			CURLOPT_HTTPHEADER => array("Content-Type:multipart/form-data"),
			CURLOPT_POSTFIELDS => $params,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
		));

		$res = curl_exec($ch);

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
	
	public function detail(Request $r, $id){
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
			if($curl->response==false){				
				session(["error" => "Server Unreachable."]);
			}else{
				$res = json_decode($curl->response);
				session(["error" => $res->errormsg]);
			}
			return redirect()->route('admin.employee.index');
		}
		
		$res = json_decode($curl->response);
		
		if($res->errorcode=="0000"){
			$data = $res->data[0];
			$master = $this->master("Detail Employee","admin.employee.index","employee.detail","GET",$id);
			$back = route('admin.employee.index');
			if(Auths::user("user.role")=="agt"){
				$back = route('employee.employee.index');
			}
			return view('master.pegawai.detail', compact('data','master','back'));
		}else{
			session(['error' => $res->errormsg]);
			return redirect()->route('admin.employee.index');
		}
	}

}

