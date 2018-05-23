<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UsersController extends Controller
{
    public function create()
    {
    	return view('users.create');
    }
    public function show(User $user)
    {
    	return view('users.show', compact('user'));
    }
    /**
     * 提交注册信息
     * @DateTime 2018-05-23
     * @param    Request    $request [description]
     * @return   [type]              [description]
     */
    public function store(Request $request)
    {
    	$this->validate($request,[
    		'name' => 'required|max:50',
    		'email' => 'required|email|unique:users|max:255',
    		'password' => 'required|confirmed|min:6'
    	]);
    	$user = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    	]);
    	Auth::login($user);//注册后登录
    	session()->flash('success', '欢饮，您将在这里开始一个新的旅程');
    	return redirect()->route('users.show', [$user]);//route会自动获取$user的的主键
    }
}
