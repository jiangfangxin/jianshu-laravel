<?php

namespace App;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // 文章拥有那些评论
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    // 获取文章针对某一个用户的赞
    public function zan($user_id)
    {
        return $this->hasOne('App\Zan')->where('user_id', $user_id);
    }

    // 获取文章所有的赞
    public function zans()
    {
        return $this->hasMany('App\Zan');
    }
}
