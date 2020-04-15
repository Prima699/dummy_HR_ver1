<?php 

namespace App\Http\Controllers\eSPJ;


use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Curl;
use Auths;
use Response;
use Illuminate\Http\Request;
use Constants;
use App\Http\Controllers\Controller;
use Handlers;
use DateTimes;
use DB;
use App\Http\Controllers\API\eSPJ\stAPIController;

class sp2dController extends Controller{

	public function index(Request $r){
		$afalse = "active";
		$atrue = "";
		
		if(isset($r->a) && $r->a=="true"){
			$afalse = "";
			$atrue = "active";
		}
		
		return view("eSPJ.sp2d.index", compact("atrue","afalse"));
    }
	
	public function create(){
		$master = $this->master("Create SP2D","admin.sp2d.store","sp2d.create","POST");
        return view("espj.sp2d.form", compact('master')); 
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
	
	public function store(Request $r){
		$curl = new Curl();
		$curl->get("https://www.uuidgenerator.net/api/version4");
		$uuid = $curl->response;
		
		$code = $r->nomor;
		$jenis = 0;
		$st = $r->st;
		$kegiatan = $r->kegiatan;
		$by = 0;
		$anggaran = Handlers::removeCurrency($r->anggaran);
		$tujuan = 0;
		$instansi = 0;
		$berangkat = DateTimes::ymdhis($r->berangkat);
		$kembali = DateTimes::ymdhis($r->kembali);
		$ntpn = $r->ntpn;
		$mak = $r->mak;
		$approved = 0;
		$created_at = DateTimes::ymdhis();
		$updated_at = DateTimes::ymdhis();
		$tanggal = DateTimes::ymdhis($r->tanggal);
		
		DB::select("
			INSERT INTO pd_sp2d (
				id, code, jenis,
				surat_tugas, kegiatan, created_by,
				anggaran, tujuan, instansi,
				berangkat, kembali, ntpn,
				mak, approved, created_at,
				updated_at, tanggal
			) VALUES (
				'$uuid', '$code', '$jenis',
				'$st', '$kegiatan', '$by',
				'$anggaran', '$tujuan', '$instansi',
				'$berangkat', '$kembali', '$ntpn',
				'$mak', '$approved', '$created_at',
				'$updated_at', '$tanggal'
			)
		");
		
		return redirect()->route("admin.sp2d.index");
	}
	
	public function detail(Request $r, $id){
		$r->uid = Auths::user('user.user_id');
		$r->at = Auths::user('access_token');
		$r->ov = true;
		
		$sp2d = DB::select("SELECT * FROM pd_sp2d WHERE id = '$id'");
		if(!isset($sp2d[0]) || $sp2d[0]==null){
			session(["error"=>"Unknown Error"]);
			return redirect()->route("admin.sp2d.index");
		}
		$sp2d = $sp2d[0];
		
		$api = new stAPIController();
		$api = $api->detail($r, $sp2d->surat_tugas);
		
		if($api==null || $api=="null"){
			session(["error"=>"Unknown Error"]);
			return redirect()->route("admin.sp2d.index");
		}
		
		$detail = $api;
		$master = $this->master("Detail SP2D","admin.sp2d.index","sp2d.detail","GET");
        return view("espj.sp2d.detail", compact('master','detail','sp2d')); 
	}
	
	public function destroy(Request $r, $id){
		DB::select("DELETE FROM pd_sp2d WHERE id = '$id'");
		session(["status"=>"an SP2D successfully deleted"]);
		return redirect()->route("admin.sp2d.index");
	}
	
	public function sign(Request $r, $id){
		DB::select("UPDATE pd_sp2d SET approved = 1 WHERE id = '$id'");
		session(["status"=>"an SP2D successfully approved"]);
		return redirect()->route("admin.sp2d.index");
	}

}
