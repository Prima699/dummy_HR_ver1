<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;

class JabatanController extends Controller{
	/**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */

	public function index(){
		$curl = new Curl();
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/jabatan/user_id/3/access_token/GCOpsFiZzNnB4y2ghrRv8taVPLkJX6AHqM0xEdfSojD5ewuY3U/dashboard/location/xxx');
        
        // Convert JSON string to Array
		  $someArray = json_decode($curl->response, true);
		  $data = $someArray['data'];
		  // dd($data);
		  
        return view("pages.jabatan",compact('data'));

    }

}


 ?>