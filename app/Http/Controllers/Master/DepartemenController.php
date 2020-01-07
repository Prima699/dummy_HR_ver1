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

class DepartemenController extends Controller{
	/**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */

	public function index(){
        return view("master.departemen.index");
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
        $params['field'] = 'departemen_name';
        $params['search'] = $search;
        $curl->get(Constants::api() . '/departemen', $params);
        
        if($curl->error==TRUE){
            return -1;
        }
        
        $res = json_decode($curl->response);
        
        if($res->errorcode!="0000"){
            return -1;
        }
        
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
        
        if($start!=0){
            $start = $start / $length;
        }
        
        $params['user_id'] = $userID;
        $params['access_token'] = $token;
        $params['platform'] = 'dashboard';
        $params['location'] = 'xxx';
        $params['field'] = 'departemen_name';
        $params['search'] = $search;
        $params['page'] = $start;
        $params['n_item'] = $length;
        $curl->get(Constants::api() . '/departemen', $params);

        dd($curl);
        
        if($curl->error==TRUE){
            session(["error" => "Server Unreachable."]);
            return Response()->json($data);
        }
        
        $res = json_decode($curl->response);
        
        if($res->errorcode!="0000"){
            session(["error" => $res->errormsg]);
            return Response()->json($data);
        }
        
        if($res->data==NULL){ 
            $amount = 0;
        }else{
            $amount = $this->totalData($r);
            
            if($amount==-1){                
                session(["error" => "Server Unreachable."]);
                return Response()->json($data);
            }
        }
        
        $data["recordsTotal"] = $amount;
        $data["recordsFiltered"] = $amount;
        
        $i = ($length * $start) + 1;
        if($res->data!=NULL){
            foreach($res->data as $a){
                $tmp = [$i, $a->departemen_name, $a->departemen_id];
                $data["data"][] = $tmp;
                $i++;
            }
        }
        
        return Response()->json($data);
    }

}


 ?>