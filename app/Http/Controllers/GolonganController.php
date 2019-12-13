<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;

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
	
	public function data(){
		$curl = new Curl();
		$userID = Auths::user('user.user_id');
		$token = Auths::user("access_token");
		
		$curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/golongan', array(
			'user_id' => $userID,
			'access_token' => $token,
			'platform' => 'dashboard',
			'location' => 'xxx'
		));
		
		if($curl->error){ // if curl error
			$res = NULL;
		}else{ // curl succeed
			$res = json_decode($curl->response);
		}
		
		$tmp = [];
		$i = 1;
		foreach($res->data as $a){
			$tmp[] = [$i, $a->golongan_name, $a->golongan_id];
			$i++;
		}
		
		$r["data"] = $tmp;
		return Response()->json($r);
	}

}


 ?>