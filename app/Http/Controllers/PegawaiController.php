<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;
use Constants;

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
    
    public function data(Request $r){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/pegawai', array(
            'user_id' => $userID,
            'access_token' => $token,
            'platform' => 'dashboard',
            'location' => 'xxx'
        ));
        
        $res = json_decode($curl->response);
        // dump(count($res->data));
        // dd($res->data);
        
        $length = $r['length']; //limit data per page
        $search = $r['search']['value']; //filter keyword
        $start = $r['start']; //offset data
        $draw = $r['draw'];
        
        $recordsTotal = count($res->data); //count all data by
        $recordsFiltered = $recordsTotal;
        
        $data = [];
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