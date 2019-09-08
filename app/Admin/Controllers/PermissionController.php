<?php

namespace App\Admin\Controllers;

use App\AdminPermission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = AdminPermission::paginate(10);
        return view('admin.permission.index', compact('permissions'));
    }
    
    // 创建权限页面
    public function create()
    {
        return view('admin.permission.add');
    }
    
    // 创建权限的实际行为
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required',
        ]);

        AdminPermission::create(request(['name', 'description']));

        return redirect('/admin/permissions');
    }
}
