<?php 

namespace App\Http\Controllers;


use App\User;
use App\Http\Requests\UserRequest; 
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Illuminate\Http\Request;
use Auths;
use Response;

class JabatanController extends Controller{
	/**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View 
     */

	public function index(){

		  
        return view("pages.jabatan");

    }

    private function totalData($r){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/jabatan', array(
            'user_id' => $userID,
            'access_token' => $token,
            'platform' => 'dashboard',
            'location' => 'xxx',
            'field' => 'jabatan_name;jabatan_id;jabatan_parent',
            'search' => $r['search']['value']
        ));
        
        $res = json_decode($curl->response);
        return count($res->data);
    }
    
    public function data(Request $r){
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");
        
        $curl->get('http://digitasAPI.teaq.co.id/index.php/Bridge/jabatan', array(
            'user_id' => $userID,
            'access_token' => $token,
            'platform' => 'dashboard',
            'location' => 'xxx',
            'field' => 'jabatan_name;jabatan_id;jabatan_parent',
            'search' => $r['search']['value'],
            'page' => $r['start'],
            'n_item' => $r['length']
        ));

        $length = $r['length']; //limit data per page
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
        
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $recordsTotal;
        $data["recordsFiltered"] = $recordsFiltered;
        $data["data"] = [];
        
        $i = 1;
        if($res->data!=NULL){
            foreach($res->data as $a){
                $tmp = [$i, $a->jabatan_name, $a->jabatan_parent, $a->jabatan_id];
                $data["data"][] = $tmp;
                $i++;
            }
        }
        
        return Response()->json($data);
    }

    public function created(Request $request){
        $res = $request->request->all();
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");     

        $curl->post('http://digitasAPI.teaq.co.id/index.php/Bridge/jabatan/user_id/'.$userID.'/access_token/'.$token.'/platform/dashboard/location/xxx', array(
            "jabatan_name" => $res['name_jabatan'],
            "jabatan_parent" => "1"
        ));

        // dd($curl->response);
            $res = json_decode($curl->response);
        
        if($res->errorcode!="0000"){
            $error = "Failed created";
            session(['error' => $error]);
            return redirect()->route('admin.jabatan.index');
        }else{
            $status = "Success created";
            session(["status" => $status]);
            return redirect()->route('admin.jabatan.index');
        }
    }

    public function edited(Request $request){
        $res = $request->request->all();
        $curl = new Curl();
        $userID = Auths::user('user.user_id');
        $token = Auths::user("access_token");     

        $curl->post('http://digitasAPI.teaq.co.id/index.php/Bridge/jabatan/user_id/'.$userID.'/access_token/'.$token.'/platform/dashboard/location/xxx', array(
            "jabatan_name" => $res['name_jabatan'],
            "jabatan_parent" => "1"
        ));

        $res = json_decode($curl->response);
        
        if($res->errorcode!="0000"){
            $error = "Failed created";
            session(['error' => $error]);
            return redirect()->route('admin.jabatan.index');
        }else{
            $status = "Success created";
            session(["status" => $status]);
            return redirect()->route('admin.jabatan.index');
        }

        // dd($curl->response);
             
    }      

}


 ?>