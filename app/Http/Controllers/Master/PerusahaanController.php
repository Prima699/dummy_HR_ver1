<?php 

namespace App\Http\Controllers\Master;

 
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;
use Constants;
use App\Http\Controllers\Controller;

class PerusahaanController extends Controller{
	/**
     * Display a listing of the users
     *
     * @param  \App\User  $model 
     * @return \Illuminate\View\View
     */

	public function index(){
		  
        return view("master.perusahaan.perusahaan");

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
        $params['field'] = 'perusahaan_name;perusahaan_logo;perusahaan_id';
        $params['search'] = $search;
        $curl->get(Constants::api() . '/perusahaan', $params);
        
        if($curl->error==TRUE){
            return -1;
        }
        
        $res = json_decode($curl->response);
        return count($res->data);
    }
    
    public function data(Request $r){
       $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $search = $r['search']['value']; //filter keyword
        $start = $r['start']; //offset
        $length = $r['length']; //limit
        $draw = $r['draw'];
        $search = $r['search']['value'];
        
        if(isset($r->token)){
            $token = $r->token;
        }
        
        if(isset($r->userID)){
            $userID = $r->userID;
        }
        
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
        $params['field'] = 'perusahaan_name;perusahaan_logo';
        $params['search'] = $search;
        $params['page'] = $start;
        $params['n_item'] = $length;
        $curl->get(Constants::api() . '/perusahaan', $params);
        
        if($curl->error==TRUE){
            $data = []; // datatable format
            $data["draw"] = $draw;
            $data["recordsTotal"] = 0;
            $data["recordsFiltered"] = 0;
            $data["data"] = [[0,0,0]];
            return Response()->json($data);
        }
        
        $res = json_decode($curl->response);
        
        if($res->data==NULL){ 
            $amount = 0;
        }else{          
            // $amount = count($res->data);
            $amount = $this->totalData($r);
            
            if($amount==-1){                
                $data = []; // datatable format
                $data["draw"] = $draw;
                $data["recordsTotal"] = 0;
                $data["recordsFiltered"] = 0;
                $data["data"] = [[0,0,0]];
                return Response()->json($data);
            }
        }
        
        $recordsTotal = $amount; //count all data by
        $recordsFiltered = $amount;
        
        $data = []; // datatable format
        $data["draw"] = $draw;
        $data["recordsTotal"] = $recordsTotal;
        $data["recordsFiltered"] = $recordsFiltered;
        $data["data"] = [];
        
        $i = ($length * $start) + 1;
        if($res->data!=NULL){
            foreach($res->data as $a){
                $tmp = [$i, $a->perusahaan_name, $a->perusahaan_logo, $a->perusahaan_id];
                $data["data"][] = $tmp;
                $i++;
            }
        }
        
        return Response()->json($data);
    }

    public function created(){
        $master = $this->master("Create Perusahaan","admin.perusahaan.store","perusahaan.created","POST");
        return view("master.perusahaan.form", compact('master')); 
    }      

    public function store(Request $r){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        // $params['user_id'] = $userID;
        // $params['access_token'] = $token;
        // $params['platform'] = 'dashboard';
        // $params['location'] = 'xxx';
        // $params['golongan_name'] = $r->name;
        // $curl->post(Constants::api() . '/golongan', $params);
        
        $params['perusahaan_name'] = $r->name;
        $curl->post(Constants::api() . "/perusahaan/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
        
        if($curl->error==TRUE){


            
            session(["error" => "Server Unreachable."]);
            return redirect()->route('admin.perusahaan.created');
        }

        $res = json_decode($curl->response);
        
        if($res->errorcode=="0000"){
            $status = "Success creating new perusahaan.";
            session(["status" => $status]);
            return redirect()->route('admin.perusahaan.index');
        }else{
            session(['error' => $res->errormsg]);
            return redirect()->route('admin.perusahaan.create');
        }
    }

    private function master($t,$a,$b,$m,$p=NULL){
        $data = new \stdClass;
        
        if($p!=NULL){
            $a = route($a,["id"=>$p]);
        }else{
            $a = route($a);
        }
        
        $data->title = $t;
        $data->action = $a;
        $data->breadcrumb = $b;
        $data->method = $m;
        
        return $data;
    }

}


 ?>