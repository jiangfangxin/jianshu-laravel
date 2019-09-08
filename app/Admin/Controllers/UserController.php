<?php

namespace App\Admin\Controllers;

use App\AdminRole;
use App\AdminUser;

class UserController extends Controller
{
    // 管理员列表
    public function index()
    {
        $users = AdminUser::paginate(10);
        return view('admin.user.index', compact('users'));
    }
    
    // 管理员创建页面
    public function create()
    {
        return view('admin.user.add');
    }
    
    // 创建操作
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3|unique:admin_users,name',
            'password' => 'required'
        ]);

        $name = request('name');
        $password = bcrypt(request('password'));
        AdminUser::create(compact('name', 'password'));

        return redirect('/admin/users');
    }

    // 用户角色关联
    public function role(AdminUser $user)
    {
        $roles = AdminRole::all();
        $myRoles = $user->roles;
        return view('admin.user.role', compact('roles', 'myRoles', 'user'));
    }

    // 用户角色保存
    public function storeRole(AdminUser $user)
    {
        $this->validate(request(), [
            'roles' => 'required|array',
        ]);

        $roles = AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;

        // 要增加的
        $addRoles = $roles->diff($myRoles);
        foreach($addRoles as $role) {
            $user->assignRole($role);
        }
            
        // 要增加的
        $deleteRoles = $myRoles->diff($roles);
        foreach($deleteRoles as $role) {
            $user->deleteRole($role);
        }

        return back();
    }
}
