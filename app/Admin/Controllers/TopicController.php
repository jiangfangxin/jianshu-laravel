<?php

namespace App\Admin\Controllers;

use App\Topic;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        return view('admin.topic.index', compact('topics'));
    }
    
    // 创建权限页面
    public function create()
    {
        return view('admin.topic.create');
    }
    
    // 创建权限的实际行为
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|string',
        ]);

        Topic::create(request(['name']));

        return redirect('/admin/topics');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return [
            'error' => 0,
            'msg' => '',
        ];
    }
}
