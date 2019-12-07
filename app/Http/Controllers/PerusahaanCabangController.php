<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;

class PerusahaanCabangController extends Controller{
	/**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */

	public function index(){
		$curl = new Curl();
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/perusahaan_cabang/user_id/3/access_token/ApmzLXaiIQKwEHr2BFvC3SjtT5DudgUGNfYe1ZO80khcqPlys6/platform/dashboard/location/xxx');
        
        // Convert JSON string to Array
		  $someArray = json_decode($curl->response, true);
		  $data = $someArray['data'];
		  // dd($data);
		  
        return view("pages.perusahaancabang",compact('data'));

    }

}


 ?>