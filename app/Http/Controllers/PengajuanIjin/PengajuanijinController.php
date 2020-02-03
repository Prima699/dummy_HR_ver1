<?php 

namespace App\Http\Controllers\PengajuanIjin;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;
use Constants;
use App\Http\Controllers\Controller;

class PengajuanIjinController extends Controller{

    public function index(){
        return view("PengajuanIjin.index");
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
        $params['field'] = 'name';
        $params['search'] = $search;
        $curl->get(Constants::api() . '/pengajuanIjin', $params);
        
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
        $params['field'] = 'name';
        $params['search'] = $search;
        $params['page'] = $start;
        $params['n_item'] = $length;
        $curl->get(Constants::api() . '/pengajuanIjin', $params);
        
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
                $tmp = [$i, $a->pengajuan_from.' - '.$a->pengajuan_to, $a->pengajuan_keterangan, $a->tipe_ijin_name, $a->response_comment];
                $data["data"][] = $tmp;
                $i++;
            }
        }
        
        return Response()->json($data);
    }

    public function create(){

        $master = $this->master("Create country","admin.country.store","country.create","POST");
        return view("master.country.form", compact('master')); 
    }
    
    public function validation(Request $r){
        $r->validate([
            'name_country' => 'required|max:45'
        ]);
    }
    
    public function store(Request $r){
        $this->validation($r);
        
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $params['name'] = $r->name_country;
        $params['region'] = $r->region;
        $curl->post(Constants::api() . "/country/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
        
        if($curl->error==TRUE){
            session(["error" => "Server Unreachable."]);
            return redirect()->route('admin.country.create');
        }
        
        $res = json_decode($curl->response);
        
        if($res->errorcode=="0000"){
            $status = "Success creating new country.";
            session(["status" => $status]);
            return redirect()->route('admin.country.index');
        }else{
            session(['error' => $res->errormsg]);
            return redirect()->route('admin.country.create');
        }
    }
    
    public function edit(Request $r, $id){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $params['user_id'] = $userID;
        $params['access_token'] = $token;
        $params['platform'] = 'dashboard';
        $params['location'] = 'xxx';
        $params['ID_t_md_country'] = $id;
        $curl->get(Constants::api() . '/country', $params);
        
        if($curl->error==TRUE){
            session(["error" => "Server Unreachable."]);
            return redirect()->route('admin.country.index');
        }
        
        $res = json_decode($curl->response);
        
        if($res->errorcode=="0000"){
            $data = $res->data[0];
            $master = $this->master("Edit country","admin.country.update","country.edit","PUT",$id);
            return view('master.country.form', compact('data','master'));
        }else{
            session(['error' => $res->errormsg]);
            return redirect()->route('admin.country.index');
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
    
    public function update(Request $r, $id){
        $this->validation($r);
        
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $params['ID_t_md_country'] = $id;
        $params['name'] = $r->name_country;
        $params['region'] = $r->region;
        $url = Constants::api() . "/country/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/ID_t_md_country/$id";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        $res = curl_exec($ch);
        
        if(!$res){
            session(["error" => "Server Unreachable."]);
            return redirect()->route('admin.country.edit',["id"=>$id]);
        }
        
        $res = json_decode($res);
        
        if($res->errorcode=="0000"){
            $status = "Success updating country.";
            session(["status" => $status]);
            return redirect()->route('admin.country.index');
        }else{
            session(['error' => $res->errormsg]);
            return redirect()->route('admin.country.edit',["id"=>$id]);
        }
    }

}


 ?>