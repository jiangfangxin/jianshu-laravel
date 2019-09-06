<?php

namespace App\Admin\Controllers;

class LoginController extends Controller
{
    // 登录页面
    public function index()
    {
        return view('admin.login.index');
    }
    
    // 登录行为
    public function login()
    {
        // 验证
        $this->validate(request(), [
            'name' => 'required|min:2',
            'password' => 'required|min:6',
        ]);

        // 逻辑
        $is_login = \Auth::guard('admin')->attempt(request(['name', 'password']));

        // 渲染
        if ($is_login) {
            return redirect("/admin/home");
        } else {
            return back()->withErrors('用户名密码不匹配。');
        }
    }
    
    // 登出行为
    public function logout()
    {
        \Auth::guard('admin')->logout();
        return redirect("/admin/login");
    }
}
