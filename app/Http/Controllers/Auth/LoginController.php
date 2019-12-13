<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	public function showLoginForm(){
		$message = NULL;
		
		if(session("error")!=NULL AND session("error")['response']!=NULL){
			$res = session("error")['response'];
			$message = "Error Code : ".$res->errorcode ."<br>".$res->errormsg;
		}
		
		if(session("auth")!=NULL){
			return redirect("/");
		}
		
		session(["error"=>NULL]);
		return view("auth.login", compact("message"));
	}
}
