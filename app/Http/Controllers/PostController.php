<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Zan;
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
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->withCount(['comments', 'zans'])->paginate(6);
        return view("post.index", compact('posts', 'name', 'age'));
    }

    // 详情页面
    public function show(Post $post)
    {
        $post->load('comments');
        return view("post.show", compact('post'));
    }

    public function create()
    {
        return view("post.create");
    }
    
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:5',
        ]);
        $params = array_merge(request(['title', 'content']), ['user_id' => \Auth::id()]);
        Post::create($params);
        return redirect("/posts");
    }

    public function edit(Post $post)
    {
        return view("post.edit", compact('post'));
    }

    public function update(Post $post)
    {
        // 验证
        $this->authorize('update', $post);

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
        $this->authorize('delete', $post);
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

    public function comment(Post $post)
    {
        // 验证
        $this->validate(request(), [
            'content' => 'required|min:3',
        ]);

        // 逻辑
        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = request('content');
        $post->comments()->save($comment);

        // 渲染        
        return back();
    }

    public function zan(Post $post)
    {
        $params = [
            'post_id' => $post->id,
            'user_id' => \Auth::id(),
        ];
        Zan::firstOrCreate($params);
        return back();
    }

    public function unzan(Post $post)
    {
        $post->zan(\Auth::id())->delete();
        return back();
    }

    public function search()
    {
        // 验证
        $this->validate(request(), [
            'query' => 'required'
        ]);

        // 逻辑
        $query = request('query');
        $posts = Post::search($query)->paginate(6);
        
        // 渲染
        return view("post.search", compact('posts', 'query'));
    }
}
