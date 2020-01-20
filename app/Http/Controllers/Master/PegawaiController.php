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

class PegawaiController extends Controller{

    public function index(){$curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/pegawai', array(
            'user_id' => $userID,
            'access_token' => $token,
            'platform' => 'dashboard',
            'location' => 'xxx'
        ));
        $res = json_decode($curl->response);
        // dd($res);
        // if($curl->error){ // if curl error
            // $res = NULL;
        // }else{ // curl succeed
            // $res = json_decode($curl->response);
        // }
        // $r["data"] = $res->data;
        // dd(json_encode($r));
        return view("pages.pegawai");
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
        $params['field'] = 'pegawai_name;pegawai_address;pegawai_telp;pegawai_id';
        $params['search'] = $search;
        $curl->get(Constants::api() . '/pegawai', $params);
        
        if($curl->error==TRUE){
            return -1;
        }
        
        $res = json_decode($curl->response);
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
        
        if(isset($r->token)){
            $token = $r->token;
        }
        
        if(isset($r->userID)){
            $userID = $r->userID;
        }
        
        if($search==NULL OR $search==""){
            $search = "";
        }
        
        if($r['start']!=0){
            $r['start'] = $r['start'] / $r['length'];
        }
        
        $params['user_id'] = $userID;
        $params['access_token'] = $token;
        $params['platform'] = 'dashboard';
        $params['location'] = 'xxx';
        $params['field'] = 'pegawai_id';
        $params['search'] = $search;
        $params['page'] = $start;
        $params['n_item'] = $length;
        $curl->get(Constants::api() . '/pegawai', $params);
        
        if($curl->error==TRUE){
            $data = []; // datatable format
            $data["draw"] = $draw;
            $data["recordsTotal"] = 0;
            $data["recordsFiltered"] = 0;
            $data["data"] = [[0,0,0]];
            return Response()->json($data);
        }
        
        $res = json_decode($curl->response);
        
        if($res->data==NULL){ 
            $amount = 0;
        }else{          
            // $amount = count($res->data);
            $amount = $this->totalData($r);
            
            if($amount==-1){                
                $data = []; // datatable format
                $data["draw"] = $draw;
                $data["recordsTotal"] = 0;
                $data["recordsFiltered"] = 0;
                $data["data"] = [[0,0,0]];
                return Response()->json($data);
            }
        }
        
        $recordsTotal = $amount; //count all data by
        $recordsFiltered = $amount;
        
        $data = []; // datatable format
        $data["draw"] = $draw;
        $data["recordsTotal"] = $recordsTotal;
        $data["recordsFiltered"] = $recordsFiltered;
        $data["data"] = [];
        
        $i = 1;
        foreach($res->data as $a){
            $tmp = [$i, $a->pegawai_name, $a->pegawai_address, $a->pegawai_telp, $a->pegawai_id];
            $data["data"][] = $tmp;
            $i++;
        }

        return Response()->json($data);
    }

    public function create(){
        $city           = new Curl();
        $province       = new Curl();
        $country        = new Curl();
        $departement    = new Curl();
        $jabatan        = new Curl();
        $golongan       = new Curl();
        $presensi       = new Curl();
        $perusahaan     = new Curl();

        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");

        $params['user_id'] = $userID;
        $params['access_token'] = $token;
        $params['platform'] = 'dashboard';
        $params['location'] = 'xxx';

        $city->get('http://digitasAPI.teaq.co.id/index.php/Bridge/city', $params);
        $citys = json_decode($city->response);

        $province->get('http://digitasAPI.teaq.co.id/index.php/Bridge/province', $params);
        $provinces = json_decode($province->response);

        $country->get('http://digitasAPI.teaq.co.id/index.php/Bridge/country', $params);
        $countrys = json_decode($country->response);

        $departement->get('http://digitasAPI.teaq.co.id/index.php/Bridge/departemen', $params);
        $departements = json_decode($departement->response);

        $jabatan->get('http://digitasAPI.teaq.co.id/index.php/Bridge/jabatan', $params);
        $jabatans = json_decode($jabatan->response);

        $golongan->get('http://digitasAPI.teaq.co.id/index.php/Bridge/golongan', $params);
        $golongans = json_decode($golongan->response);

        $presensi->get('http://digitasAPI.teaq.co.id/index.php/Bridge/presensiType', $params);
        $presensis = json_decode($presensi->response);

        $perusahaan->get('http://digitasAPI.teaq.co.id/index.php/Bridge/perusahaan', $params);
        $perusahaans = json_decode($perusahaan->response);

        
        $kota = $citys->data;
        $propinsi = $provinces->data;
        $negara = $countrys->data;
        $departemen = $departements->data;
        $jabatan_= $jabatans->data;
        $golongan_= $golongans->data;
        $presensi_= $presensis->data;
        $perusahaan_= $perusahaans->data;
        $master = $this->master("Create Pegawai","admin.pegawai.store","pegawai.create","POST");

        return view("pegawai.form", compact('master','kota','propinsi','negara','departemen','jabatan_','golongan_','presensi_','perusahaan_'));
    }
    
    public function store(Request $r){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        // $params['user_id'] = $userID;
        // $params['access_token'] = $token;
        // $params['platform'] = 'dashboard';
        // $params['location'] = 'xxx';
        // $params['golongan_name'] = $r->name;
        // $curl->post(Constants::api() . '/golongan', $params);
        
        $params['pegaawai_name'] = $r->pegawai_name;
        $params['pegawai_address'] = $r->pegawai_address;
        $params['pegawai_NIK'] = $r->pegawai_nik;
        $params['pegawai_telp'] = $r->pegawai_telp;
        $params['pegawai_email'] = $r->pegawai_email;
        $params['ID_t_md_country'] = $r->country;
        $params['ID_t_md_province'] = $r->propinsi;
        $params['ID_t_md_city'] = $r->city;
        $params['departemen_id'] = $r->departemen;
        $params['jabatan_id'] = $r->jabatan;
        $params['golongan_id'] = $r->golongan;
        $params['presensi_type_id'] = $r->presensi;
        $params['perusahaan_cabang_id'] = $r->perusahaan;
        $params['image'] = $r->image;

        $curl->post(Constants::api() . "/pegawai/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
        
        $res = json_decode($curl->response);
        
        if($res->errorcode!="0000"){
            $error = "Failed creating new pegawai.";
            session(['error' => $error]);
            return redirect()->route('admin.pegawai.create');
        }else{
            $status = "Success creating new pegawai.";
            session(["status" => $status]);
            return redirect()->route('admin.pegawai.index');
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

}


 ?>