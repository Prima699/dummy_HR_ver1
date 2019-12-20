<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Auths;
use Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;

class PerusahaanCabangController extends Controller{
	/**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */

public function index(){$curl = new Curl();

        return view("pages.perusahaancabang");
  
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
        $params['field'] = 'perusahaan_id;pc_address;ID_t_md_city;ID_t_md_province;ID_t_md_country;pc_lat;pc_long;pc_status;perusahaan_cabang_id';
        $params['search'] = $search;
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/perusahaan_cabang', $params);
        
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
        $params['field'] = 'perusahaan_id;pc_address;ID_t_md_city;ID_t_md_province;ID_t_md_country;pc_lat;pc_long;pc_status;perusahaan_cabang_id';
        $params['search'] = $search;
        $params['page'] = $r['start'];
        $params['n_item'] = $r['length'];
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/perusahaan_cabang', $params);
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
                $tmp = [$i, $a->perusahaan_id, $a->pc_address, $a->ID_t_md_city, $a->ID_t_md_province, $a->ID_t_md_country, $a->pc_lat, $a->pc_long, $a->pc_status, $a->perusahaan_cabang_id];
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

        $curl->post('http://digitasAPI.teaq.co.id/index.php/Bridge/perusahaan_cabang/user_id/'.$userID.'/access_token/'.$token.'/platform/dashboard/location/xxx', array(
            "golongan_name" => "Golongan2",
        ));

        // dd($curl->response);
            return view("pages.golongan"); 
    }       

}


 ?>