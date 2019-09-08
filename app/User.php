<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    protected $fillable = [
        'name', 'email', 'password'
    ];

    // 所有文章
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // 所有粉丝
    public function fans()
    {
        return $this->hasMany(Fan::class, 'star_id');
    }

    // 关注的明星
    public function stars()
    {
        return $this->hasMany(Fan::class, 'fan_id');
    }

    // 我要关注明星
    public function doFan($uid)
    {
        $star = new Fan();
        $star->star_id = $uid;
        return $this->stars()->save($star);
    }

    // 取消关注
    public function doUnFan($uid)
    {
        $star = new Fan();
        $star->star_id = $uid;
        return $this->stars()->delete($star);
    }

    // 是否有某一个粉丝
    public function hasFan($uid)
    {
        return $this->fans()->where('fan_id', $uid)->count();
    }

    // 是否关注了某一个明星
    public function hasStar($uid)
    {
        return $this->stars()->where('star_id', $uid)->count();
    }

    // 用户收到的消息
    public function notices()
    {
        return $this->belongsToMany(Notice::class, 'user_notice', 'user_id', 'notice_id')->withPivot(['user_id', 'notice_id']);
    }

    // 给用户增加通知
    public function addNotice(Notice $notice)
    {
        return $this->notices()->attach($notice->id);
    }
}
