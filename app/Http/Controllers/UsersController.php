<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class UsersController extends Controller
{
    //
	public function create(Requset $request){
		return view('users.create');
	}
}
