<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;

class Post extends Model
{

    use Searchable;

    public function searchableAs()
    {
        return 'post';
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

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

    public function topics()
    {
        return $this->belongsToMany(\App\Topic::class);
    }

    public function scopeNotTopic(Builder $query, $topic_id)
    {
        return $query->doesntHave('topics', 'and', function ($query) use ($topic_id) {
            $query->where('topic_id', $topic_id);
        });
    }
}
