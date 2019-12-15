<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;

class GolonganController extends Controller{

	public function index(){$curl = new Curl();
		// $userID = Auths::user('user.user_id');
		// $token = Auths::user("access_token");
		
		// $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/golongan', array(
			// 'user_id' => $userID,
			// 'access_token' => $token,
			// 'platform' => 'dashboard',
			// 'location' => 'xxx'
		// ));
		
		// if($curl->error){ // if curl error
			// $res = NULL;
		// }else{ // curl succeed
			// $res = json_decode($curl->response);
		// }
		// $r["data"] = $res->data;
		// dd(json_encode($r));
        return view("pages.golongan");
    }
	
	public function data(Request $r){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/golongan', array(
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
			$tmp = [$i, $a->golongan_name, $a->golongan_id];
			$data["data"][] = $tmp;
			$i++;
		}
		
		return Response()->json($data);
	}

    public function created(){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");     

        $curl->post('http://digitasAPI.teaq.co.id/index.php/Bridge/golongan/user_id/'.$userID.'/access_token/'.$token.'/platform/dashboard/location/xxx', array(
            "golongan_name" => "Golongan1",
        ));

        // dd($curl->response);
            return view("pages.golongan"); 
    }       

}


 ?>