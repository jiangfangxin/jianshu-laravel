<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // 登录页面
    public function index() {
        if (\Auth::check()) {
            return redirect('/posts');
        } else {
            return view("login.index");
        }
    }

    // 登录行为
    public function login() {
        // 验证
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 逻辑
        $is_login = app('auth')->attempt(request(['email', 'password']), request('is_remember'));

        // 渲染
        if ($is_login) {
            return redirect("/posts");
        } else {
            return back()->withErrors('用户名密码不匹配。');
        }
    }
    
    // 登出行为
    public function logout() {
        app('auth')->logout();
        return redirect("/login");
    }
}
