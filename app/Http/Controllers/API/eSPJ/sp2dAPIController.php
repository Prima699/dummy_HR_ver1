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

class sp2dAPIController extends Controller{

	public function data(Request $r){
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		$amount = 0;
		$approve = 0;

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

		if($r["a"]=="active"){
			$approve = 1;
		}

		$search = strtolower($search);
		$where = "WHERE approved = '$approve'";

		if($search!=""){
			$where .= " AND (LOWER(kegiatan) LIKE '%$search%' OR LOWER(code) LIKE '%$search%')";
		}

		$records = DB::select("SELECT id, code, kegiatan FROM pd_sp2d $where ORDER BY created_at ASC LIMIT $length OFFSET $start");

		$data["recordsFiltered"] = DB::select("SELECT COUNT(id) AS amount FROM pd_sp2d $where")[0]->amount;
		$data["recordsTotal"] = count($records);

		$i = $start + 1;
		if(count($records)>0){
			foreach($records as $a){
				$tmp = [$i, $a->code, $a->kegiatan, $a->id];
				$data["data"][] = $tmp;
				$i++;
			}
		}

		return Response()->json($data);
	}

}
