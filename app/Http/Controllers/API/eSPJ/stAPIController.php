<?php 

namespace App\Http\Controllers\API\eSPJ;


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
use DB;

class stAPIController extends Controller{

	public function data(Request $r){
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
		
		$search = strtolower($search);
		$where = "";
		
		if($search!=""){
			$where = "
				WHERE
					LOWER(agenda_title) LIKE '%$search%'
			";
		}
		
		$records = DB::select("SELECT agenda_title, id FROM st_surattugas $where ORDER BY created_at ASC LIMIT $length OFFSET $start");
		
		$data["recordsFiltered"] = DB::select("SELECT COUNT(id) AS amount FROM st_surattugas $where")[0]->amount;
		$data["recordsTotal"] = count($records);
		
		$i = $start + 1;
		if(count($records)>0){
			foreach($records as $a){
				$tmp = [$i, $a->agenda_title, $a->id];
				$data["data"][] = $tmp;
				$i++;
			}
		}
		
		return Response()->json($data);
	}
	
	public function detail(Request $r, $id){
		$id = DB::select("SELECT * FROM st_surattugas WHERE id = '$id'")[0]->agenda_id;
		
		$curl = new Curl();
		
		$params['user_id'] = $r->uid;
		$params['access_token'] = $r->at;
		$params['platform'] = 'dashboard';
		$params['location'] = 'xxx';
		$params['agenda_id'] = $id;
		$curl->get(Constants::api() . '/agenda', $params);
		
		$handler = Handlers::curl($curl);
		
		if($handler!=true){
			return response()->json(false);
		}
		
		$res = json_decode($curl->response);
		$data = $res->data[0];
		
		if(isset($r->ov) && $r->ov==true){
			return $data;
		}
		
		return response()->json($data);
	}
	
}
