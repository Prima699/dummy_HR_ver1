<?php

namespace App\Http\Controllers\Presence;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PresenceController extends Controller
{
    public function index(){
		return view("presence.index");
	}
}
