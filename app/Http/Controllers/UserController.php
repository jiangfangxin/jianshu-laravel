<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 用户设置页面
    public function index()
    {
        $user = \Auth::user();
        return view("user.setting", compact('user'));
    }

    // 用户设置保存
    public function settingStore()
    {
        // 验证
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);

        // 逻辑
        $name = request('name');
        $user = \Auth::user();
        if ($name != $user->name) {
            if (User::where('name', $name)->count() > 0) {
                return back()->withErrors('用户名已经注册。');
            } else {
                $user->name = $name;
            }
        }

        if (request()->file('avatar')) {
            $file = request()->file('avatar')->store('images');
            $user->avatar = '/storage/' . $file;
        }

        $user->save();

        // 渲染
        return back();
    }
}
