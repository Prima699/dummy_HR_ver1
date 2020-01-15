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

class PerusahaanCabangController extends Controller{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model 
     * @return \Illuminate\View\View
     */

    public function index(){
          
        return view("master.perusahaan_cabang.index");

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
        $params['field'] = 'perusahaan_cabang_id;pc_address;ID_t_md_city;ID_t_md_province;ID_t_md_country;pc_long;pc_lat;pc_lat;pc_status;radius';
        $params['search'] = $search;
        $curl->get(Constants::api() . '/perusahaan_cabang', $params);
        
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
        $params['field'] = 'perusahaan_cabang_id;pc_address;ID_t_md_city;ID_t_md_province;ID_t_md_country;pc_long;pc_lat;pc_lat;pc_status;radius';
        $params['search'] = $search;
        $params['page'] = $start;
        $params['n_item'] = $length;
        $curl->get(Constants::api() . '/perusahaan_cabang', $params);
        
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
                $tmp = [$i, $a->perusahaan_id, $a->pc_address, $a->ID_t_md_city, $a->ID_t_md_province, $a->ID_t_md_country, $a->pc_lat, $a->pc_long, $a->pc_status, $a->radius, $a->perusahaan_cabang_id];
                $data["data"][] = $tmp;
                $i++;
            }
        }
        
        return Response()->json($data);
    }

    public function create(){
        $perusahaan = new Curl();
        $city           = new Curl();
        $province       = new Curl();
        $country        = new Curl();
        
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");

        $params['user_id'] = $userID;
        $params['access_token'] = $token;
        $params['platform'] = 'dashboard';
        $params['location'] = 'xxx';


        $city->get('http://digitasAPI.teaq.co.id/index.php/Bridge/city', $params);
        $citys = json_decode($city->response);

        $province->get('http://digitasAPI.teaq.co.id/index.php/Bridge/province', $params);
        $provinces = json_decode($province->response);

        $country->get('http://digitasAPI.teaq.co.id/index.php/Bridge/country', $params);
        $countrys = json_decode($country->response);

        $perusahaan->get('http://digitasAPI.teaq.co.id/index.php/Bridge/perusahaan', $params);
        $perusahaans = json_decode($perusahaan->response);


        $perusahaan_= $perusahaans->data;
        $kota = $citys->data;
        $propinsi = $provinces->data;
        $negara = $countrys->data;
        $master = $this->master("Create Perusahaan Cabang","admin.perusahaan_cabang.store","perusahaan_cabang.create","POST");
        return view("master.perusahaan_cabang.form", compact('master','perusahaan_','kota','propinsi','negara')); 
    }      

    public function store(Request $r){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        // $params['user_id'] = $userID;
        // $params['access_token'] = $token;
        // $params['platform'] = 'dashboard';
        // $params['location'] = 'xxx';
        // $params['perusahaan_name'] = $r->name;
        // $curl->post(Constants::api() . '/perusahaan', $params);
        
        $params['perusahaan_id'] = $r->perusahaan_id;
        $params['pc_address'] = $r->pc_address;
        $params['ID_t_md_city'] = $r->ID_t_md_city;
        $params['ID_t_md_province'] = $r->ID_t_md_province;
        $params['ID_t_md_country'] = $r->ID_t_md_country;
        $params['pc_lat'] = $r->pc_lat;
        $params['pc_long'] = $r->pc_long;
        $params['pc_status'] = $r->pc_status;
        $params['radius'] = $r->radius;
        $curl->post(Constants::api() . "/perusahaan_cabang/user_id/$userID/access_token/$token/platform/dashboard/location/xxx", $params);
        
        if($curl->error==TRUE){


            
            session(["error" => "Server Unreachable."]);
            return redirect()->route('admin.perusahaan_cabang.created');
        }

        $res = json_decode($curl->response);
        
        if($res->errorcode=="0000"){
            $status = "Success creating new perusahaan cabang.";
            session(["status" => $status]);
            return redirect()->route('admin.perusahaan_cabang.index');
        }else{
            session(['error' => $res->errormsg]);
            return redirect()->route('admin.perusahaan_cabang.create');
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

    public function edit(Request $r, $id){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $params['user_id'] = $userID;
        $params['access_token'] = $token;
        $params['platform'] = 'dashboard';
        $params['location'] = 'xxx';
        $params['perusahaan_cabang_id'] = $id;
        $curl->get(Constants::api() . '/perusahaan_cabang', $params);
        
        if($curl->error==TRUE){
            session(["error" => "Server Unreachable."]);
            return redirect()->route('master.perusahaan_cabang.index');
        }
        
        $res = json_decode($curl->response);
        
        if($res->errorcode=="0000"){
            $data = $res->data[0];
            $master = $this->master("Edit perusahaan cabang","admin.perusahaan_cabang.update","perusahaan_cabang.edit","PUT",$id);
            return view('master.perusahaan_cabang.form', compact('data','master'));
        }else{
            session(['error' => $res->errormsg]);
            return redirect()->route('admin.perusahaan_cabang.index');
        }
    }
    public function update(Request $r, $id){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $params['perusahaan_cabang_id'] = $id;
        $params['perusahaan_id'] = $r->perusahaan_id;
        $params['pc_address'] = $r->pc_address;
        $params['ID_t_md_city'] = $r->ID_t_md_city;
        $params['ID_t_md_province'] = $r->ID_t_md_province;
        $params['ID_t_md_country'] = $r->ID_t_md_country;
        $params['pc_lat'] = $r->pc_lat;
        $params['pc_long'] = $r->pc_long;
        $params['pc_status'] = $r->pc_status;
        $params['radius'] = $r->radius;
        $curl->setHeader('Content-Type','application/x-www-form-urlencoded');
        $curl->put(Constants::api() . "/perusahaan_cabang/user_id/$userID/access_token/$token/platform/dashboard/location/xxx/perusahaan_cabang_id/$id", $params);
        
        if($curl->error==TRUE){
            session(["error" => "Server Unreachable."]);
            return redirect()->route('admin.perusahaan_cabang.edit',["id"=>$id]);
        }
        
        $res = json_decode($curl->response);
        
        if($res->errorcode=="0000"){
            $status = "Success updating perusahaan cabang.";
            session(["status" => $status]);
            return redirect()->route('admin.perusahaan_cabang.index');
        }else{
            session(['error' => $res->errormsg]);
            return redirect()->route('admin.perusahaan_cabang.edit',["id"=>$id]);
        }
    }

}

?>