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

class spjController extends Controller{

	public function index(Request $r){
		$afalse = "active";
		$atrue = "";

		if(isset($r->a) && $r->a=="true"){
			$afalse = "";
			$atrue = "active";
		}

		return view("eSPJ.spj.index", compact("atrue","afalse"));
    }

	public function create(){
        $master = $this->master("Create SPJ","admin.spj.store","spj.create","POST");
        $jenis = DB::table("pd_pengeluaran_jenis")->get();

        return view("eSPJ.spj.form", compact('master','jenis'));
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

		DB::table("pd_spj")
			->insert([
                "id" => $uuid,
                "code" => $r->nomor,
                "sp2d" => $r->sp2d,
                "approved" => "0",
                "created_at" => DateTimes::ymdhis(),
                "updated_at" => DateTimes::ymdhis()
            ]);

        for($i=0; $i<count($r->pengeluaranJenis); $i++){
			$name = "";
			if(isset($r->file('pengeluaranFile')[$i]) && $r->file('pengeluaranFile')[$i]!="" && $r->file('pengeluaranFile')[$i]!=NULL){
                $file = $r->file('pengeluaranFile')[$i];
                $ext = $file->getClientOriginalExtension();
                $name = rand(100000,1001238912) . date("YmdHis") . "." . $ext;
                $file->move('public/upload/espj',$name);
			}elseif(isset($r->pengeluaranOldFile[$i]) && $r->pengeluaranOldFile[$i]!=false){
                $name = $r->pengeluaranOldFile[$i];
            }
            DB::table("pd_pengeluaran")
                ->insert([
                    "spj_id" => $uuid,
                    "pegawai_id" => Auths::user('user.user_id'),
                    "jenis" => $r->pengeluaranJenis[$i],
                    "bukti" => $name,
                    "keterangan" => $r->pengeluaranDesc[$i],
                    "created_at" => DateTimes::ymdhis(),
                    "updated_at" => DateTimes::ymdhis()
                ]);
        }

		return redirect()->route("admin.spj.index");
	}

	public function detail(Request $r, $id){
		$r->uid = Auths::user('user.user_id');
		$r->at = Auths::user('access_token');
		$r->ov = true;

		$spj = DB::table("pd_spj")
			->where("id",$id)
			->first();
		if($spj==null){
			session(["error"=>"SPJ is broken"]);
			return redirect()->route("admin.spj.index");
		}

		$sp2d = DB::table("pd_sp2d")
			->where("id",$spj->sp2d)
			->first();
		if($sp2d==null){
			session(["error"=>"SPJ is broken"]);
			return redirect()->route("admin.spj.index");
		}

        $tmp = [];
        $pengeluaran = DB::table("pd_pengeluaran as p")
            ->join("pd_pengeluaran_jenis as j","j.id","=","p.jenis")
            ->select("p.*","j.name as jenis","j.id as fk_jenis")
            ->where("p.spj_id",$id)
            ->get();
        foreach($pengeluaran as $p){
            $tmp[$p->fk_jenis][] = $p;
        }
        $pengeluaran = $tmp;

        $master = $this->master("Detail SPJ","admin.spj.index","spj.detail","GET");
        return view("eSPJ.spj.detail", compact('master','pengeluaran','spj','sp2d'));
	}

	public function destroy(Request $r, $id){
		$this->delete($id);
		session(["status"=>"an SPJ successfully deleted"]);
		return redirect()->route("admin.spj.index");
    }

    private function delete($id){
        DB::table("pd_pengeluaran")
			->where("spj_id",$id)
			->delete();
        DB::table("pd_spj")
            ->where("id",$id)
            ->delete();
    }

	public function sign(Request $r, $id){
		DB::table("pd_spj")
			->where("id",$id)
			->update([
				"approved" => 1
			]);
		session(["status"=>"an SPJ successfully approved"]);
		return redirect()->route("admin.spj.index");
	}

	public function edit(Request $r, $id){
		$r->uid = Auths::user('user.user_id');
		$r->at = Auths::user('access_token');
		$r->ov = true;

		$spj = DB::table("pd_spj")
			->where("id",$id)
			->first();
		if($spj==null){
			session(["error"=>"SPJ is broken"]);
			return redirect()->route("admin.spj.index");
		}

		$sp2d = DB::table("pd_sp2d")
			->where("id",$spj->sp2d)
			->first();
		if($sp2d==null){
			session(["error"=>"SPJ is broken"]);
			return redirect()->route("admin.spj.index");
		}

        $pengeluaran = DB::table("pd_pengeluaran as p")
            ->join("pd_pengeluaran_jenis as j","j.id","=","p.jenis")
            ->select("p.*","j.name as jenis","j.id as fk_jenis")
            ->where("p.spj_id",$id)
            ->get();

        $jenis = DB::table("pd_pengeluaran_jenis")->get();

        $master = $this->master("Edit SPJ","admin.spj.update","spj.edit","GET");
        // dd(compact('master','pengeluaran','spj','sp2d','jenis'));
        return view("eSPJ.spj.form", compact('master','pengeluaran','spj','sp2d','jenis'));
    }

    public function update(Request $r){
        $this->delete($r->_spj);
        return $this->store($r);
    }

}
