<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;

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
		
		if(isset($r->token)){
			$token = $r->token;
		}
		
		if(isset($r->userID)){
			$userID = $r->userID;
		}
		
		if($r['start']!=0){
			$r['start'] = $r['start'] / $r['length'];
		}
		
		$params['user_id'] = $userID;
		$params['access_token'] = $token;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['pegawai_id'] = $r->id;
		$params['page'] = $r['start'];
		$params['n_item'] = $r['length'];
		$curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/pegawaiimage', $params);
		
		$res = json_decode($curl->response);
		
		if($res->data==NULL){
			$amount = 0;
		}else{			
			// $amount = count($res->data);
			$amount = $this->totalData($r);
		}
		
		$search = $r['search']['value']; //filter keyword
		$start = $r['start']; //offset data
		$draw = $r['draw'];
		
		$recordsTotal = $amount; //count all data by
		$recordsFiltered = $amount;
		
		$data = []; // datatable format
		$data["draw"] = $draw;
		$data["recordsTotal"] = $recordsTotal;
		$data["recordsFiltered"] = $recordsFiltered;
		$data["data"] = [];
		
		$i = ($r['length'] * $start) + 1;
		if($res->data!=NULL){
			foreach($res->data as $a){
				$image = asset("public/" . $a->path);
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

	private function totalData($r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
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
		$curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/pegawaiimage', $params);
		
		$res = json_decode($curl->response);
		return count($res->data);
	}
	
	public function faceDetect(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
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
		$params['image_train_id'] = $r->id;
		$curl->put('http://digitasAPI.teaq.co.id/index.php/Bridge/pegawaiimage', $params);
		
		$res = json_decode($curl->response);
		return count($res->data);
	}

}


 ?>