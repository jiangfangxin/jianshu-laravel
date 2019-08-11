<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // 列表
    public function index()
    {
        $posts = [
            [
                'title' => 'this is title1',
            ],
            [
                'title' => 'this is title2',
            ],
            [
                'title' => 'this is title3',
            ],
        ];
        $topics = [];
        return view("post/index", compact('posts', 'topics'));
    }

    // 详情页面
    public function show()
    {
        return view("post/show", ['title' => 'This is title', 'isShow' => true]);
    }

    public function create()
    {
        return view("post/create");
    }
    
    public function store()
    {
    }

    public function edit()
    {
        return view("post/edit");
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
