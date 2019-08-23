<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // 用户设置页面
    public function index() {
        return view("user.setting");
    }

    // 用户设置保存
    public function settingStore() {

    }
}
