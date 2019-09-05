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

    public function show(User $user)
    {
        // 用户的信息
        $user = User::withCount(['posts', 'stars', 'fans'])->find($user->id);

        // 用户的文章列表
        $posts = $user->posts()->take(6)->get();

        // 关注明星的列表
        $susers = User::withCount(['posts', 'stars', 'fans'])->find($user->stars()->pluck('star_id'));

        // 粉丝的列表
        $fusers = User::withCount(['posts', 'stars', 'fans'])->find($user->fans()->pluck('fan_id'));

        return view("user.show", compact('user', 'posts', 'susers', 'fusers'));
    }
    
    public function fan(User $user)
    {
        \Auth::user()->doFan($user->id);
        return [
            'err' => 0,
            'msg' => '',
        ];
    }
    
    public function unfan(User $user)
    {
        \Auth::user()->doUnFan($user->id);
        return [
            'err' => 0,
            'msg' => '',
        ];
    }
}
