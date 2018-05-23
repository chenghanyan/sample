<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionsController extends Controller
{
	/**
	 * 登录页面
	 * @DateTime 2018-05-23
	 * @return   [type]     [description]
	 */
    public function create()
    {
    	return view('sessions.create');
    }
    /**
     * 登录提交动作
     * @DateTime 2018-05-23
     * @param    Request    $request [description]
     * @return   [type]              [description]
     */
    public function store(Request $request)
    {
    	$credentials = $this->validate($request, [
    		'email' => 'required|email|max:255',
    		'password' => 'required'
    	]);
    	if (Auth::attempt($credentials, $request->has('remember'))) {
    		//登录成功
    		session()->flash('success', '欢迎回来');
    		return redirect()->route('users.show', [Auth::user()]);//Auth::user()获取当前用户信息
    	} else {
    		// 登录失败
    		session()->flash('danger', '抱歉， 你的邮箱和密码不匹配');
    		return redirect()->back();
    	}
    }
    /**
     * 退出
     */
    public function destroy()
    {
    	Auth::logout();
    	session()->flash('success', '您已成功退出');
    	return redirect('login');
    }
}
