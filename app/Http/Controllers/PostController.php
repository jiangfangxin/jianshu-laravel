<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function phpinfo()
    {
        phpinfo();
    }

    // 列表
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(6);
        return view("post/index", compact('posts', 'name', 'age'));
    }

    // 详情页面
    public function show(Post $post)
    {
        return view("post/show", compact('post'));
    }

    public function create()
    {
        return view("post/create");
    }
    
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:5',
        ]);
        Post::create(request(['title', 'content']));
        return redirect("/posts");
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
