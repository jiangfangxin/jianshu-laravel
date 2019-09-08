<?php

namespace App\Admin\Controllers;

use App\Jobs\SendMessage;
use App\Notice;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();
        return view('admin.notice.index', compact('notices'));
    }
    
    // 创建权限页面
    public function create()
    {
        return view('admin.notice.add');
    }
    
    // 创建权限的实际行为
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|min:3',
            'content' => 'required|min:3',
        ]);

        $notice = Notice::create(request(['title', 'content']));

        dispatch(new SendMessage($notice));

        return redirect('/admin/notices');
    }
}
