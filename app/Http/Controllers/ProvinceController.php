<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;

class ProvinceController extends Controller{
	/**
     * Display a listing of the users
     *
     * @param  \App\User  $model 
     * @return \Illuminate\View\View
     */

	public function index(){
		  
        return view("pages.province");

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
        $params['field'] = 'name;region;name_province;ID_t_md_country;ID_t_md_province';
        $params['search'] = $search;
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/province', $params);
        
        $res = json_decode($curl->response);
        return count($res->data);
    }
    
    public function data(Request $r){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        
       if(isset($r->token)){
            $token = $r->token;
        }
        
        if(isset($r->userID)){
            $userID = $r->userID;
        }
        
        $search = $r['search']['value'];
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
        $params['field'] = 'name;region;name_province;ID_t_md_country;ID_t_md_province';
        $params['search'] = $search;
        $params['page'] = $r['start'];
        $params['n_item'] = $r['length'];
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/province', $params);
        
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
                $tmp = [$i, $a->name, $a->region, $a->name_province, $a->ID_t_md_country, $a->ID_t_md_province];
                $data["data"][] = $tmp;
                $i++;
            }
        }
        
        return Response()->json($data);
    }

    public function created(){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");     

        $curl->post('http://digitasAPI.teaq.co.id/index.php/Bridge/province/user_id/'.$userID.'/access_token/'.$token.'/platform/dashboard/location/xxx', array(
            "ID_t_md_country" => "1",
            "name" => "Indonesia",
            "region" => "ASIA",
            "name_province" => "Jawa Tengah"
        ));

        // dd($curl->response);
            return view("pages.province"); 
    }      

}


 ?>