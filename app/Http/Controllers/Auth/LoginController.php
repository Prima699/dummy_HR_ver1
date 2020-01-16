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
		if(session("error") AND session("error")!=NULL){
			if(session("error")['response']==NULL){
				$res = "Unknown Error";
			}else{				
				$res = session("error")['response']->errormsg;
			}
			session(["error"=>$res]);
		}
		
		if(session("auth")!=NULL){
			return redirect("/");
		}
		
		return view("auth.login");
	}
}
