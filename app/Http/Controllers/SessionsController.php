<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionsController extends Controller
{
    //

	public function create(){
		return view('sessions.create');
	}

	public function store(Request $request){
		$validator = $this->validate($request,[
			'email' => 'required|email|max:255',
			'password' => 'required'
		]);

		if(Auth::attempt($validator, $request->has('remember'))){
			session()->flash('success','熊孩子，欢迎回家！');
			return redirect()->route('users.show',[Auth::user()]);
		}else{
			session()->flash('danger','哈哈！你的密码跟邮箱不匹配，懵逼了吧！');
			return redirect()->back();
		}
	

	}

	public function destroy(){
		Auth::logout();
		session()->flash('success','好了，你已经退出成功了，赶紧走吧！');
		return redirect('login');
	}
}
