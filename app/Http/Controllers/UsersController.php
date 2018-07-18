<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    //
	public function __construct(){
		$this->middleware('auth',[
			'except' => ['show','create','store','index','confirmEmail']
		]);

		$this->middleware('guest',[
			'only' => ['create']
		]);
	}

	public function index(){
		$users = User::paginate(10);
		return view('users.index',compact('users'));
	}

	public function create(Request $request){
		return view('users.create');
	}

	public function show(User $user){
		return view('users.show',compact('user'));
	}

	public function store(Request $request){
		$this -> validate($request,[
			'name' => 'required|max:50',
			'email' => 'required|email|unique:users|max:255',
			'password' => 'required|confirmed|min:6'
		]);

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
		]);

		$this->sendEmailConfirmationTo($user);
		
		//Auth::login($user);
		session()->flash('success','哎呦，不错呦！可惜。你还没有真正注册成功。为了确认一下眼神，我们给你发了一封验证邮件，赶紧去查收一下。');
		return redirect('/');
	}

	public function edit(User $user){
		$this->authorize('update',$user);
		return view('users.edit',compact('user'));
	}

	public function update(User $user, Request $request){
		$this->validate($request,[
			'name' => 'required|max:50',
			'password' => 'required|confirmed|min:6'
		]);

		$this->authorize('update',$user);
		$data = [];
		$data['name'] = $request->name;
		if($request->password){
			$data['password'] = bcrypt($request->password);
		}
		$user->update($data);
	
		session()->flash('success','恭喜啊，你的个人资料更改成功了→_→');

		return redirect()->route('users.show',$user->id);
	}

	public function destroy(User $user){
		$this->authorize('destroy',$user);
		$user->delete();
		session()->flash('success','你成功的干掉了这个玩家！(o゜▽゜)o☆ 	'.$user->name);
		return back();
	}

	public function sendEmailConfirmationTo($user){
		$view = 'emails.confirm';
		$data = compact('user');
		$to = $user->email;
		$subject = '呦吼，我们又见面了。';

		Mail::send($view,$data,function($message) use ($to ,$subject){
			$message->to($to)->subject($subject);
		});
	}

	public function confirmEmail($token){
		$user = User::where('activation_token',$token)->firstOrFail();

		$user->activated = true;
        	$user->activation_token = null;
        	$user->save();

       		Auth::login($user);
        	session()->flash('success', '哇偶，你终于成功打败打怪兽了，不对，你终于注册成功了，有没有很激动很兴奋，开心的快要跳起来了？恩这是个肯定句，你不用回答。');
        	return redirect()->route('users.show', [$user]);
	}
}
