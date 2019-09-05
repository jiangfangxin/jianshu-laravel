<?php

namespace App\Http\Controllers;

use App\PostTopic;
use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    // 专题页面
    public function show(Topic $topic)
    {
        // 获取专题信息
        $topic = Topic::withCount('postTopic')->find($topic->id);

        // 带文章数目的专题
        $posts = $topic->posts()->with('user')->orderBy('created_at', 'desc')->get();

        // 我可以投稿这个专题的文章
        $myPosts = \Auth::user()->posts()->notTopic($topic->id)->get();
        
        return view('topic.show', compact('topic', 'posts', 'myPosts'));
    }

    public function submit(Topic $topic)
    {
        // 验证
        $this->validate(request(), [
            'post_ids' => 'required|array',
        ]);

        // 逻辑
        foreach(request('post_ids') as $post_id) {
            PostTopic::firstOrCreate([
                'post_id' => $post_id,
                'topic_id' => $topic->id,
            ]);
        }

        // 渲染
        return back();
    }
}
