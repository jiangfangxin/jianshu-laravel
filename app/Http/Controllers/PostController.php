<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;

class PostController extends Controller
{
    public function phpinfo()
    {
        app('log')->debug('phpinfo()');
        phpinfo();
    }

    // 列表
    public function index(LogManager $log1)
    {
        // 直接获取容器中的服务，然后使用
        $log = app()->make('log');
        $log->info('Get provider from container directly.');

        // 通过依赖注入
        $log1->notice('Get provider from container through IOC.');

        // 通过门脸模式
        \Log::info('Get provider from container through Facade.');

        $posts = Post::orderBy('created_at', 'desc')->paginate(6);
        return view("post.index", compact('posts', 'name', 'age'));
    }

    // 详情页面
    public function show(Post $post)
    {
        return view("post.show", compact('post'));
    }

    public function create()
    {
        $name = 'jiangfangxin';
        return view("post.create");
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

    public function edit(Post $post)
    {
        return view("post.edit", compact('post'));
    }

    public function update(Post $post)
    {
        // 验证
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:5',
        ]);

        // 逻辑
        $post->title = request('title');
        $post->content = request('content');
        $post->save();

        // 跳转
        return redirect("posts/{$post->id}");
    }

    public function delete(Post $post)
    {
        // TODO：用户权限的验证
        $post->delete();
        
        return redirect("posts");
    }

    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorFile')->store('images');
        return response()->json([
            'errno' => 0,
            'data' => [asset('/storage/' . $path)]
        ]);
    }
}
