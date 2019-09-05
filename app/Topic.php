<?php

namespace App;

class Topic extends Model
{
    public function posts()
    {
        return $this->belongsToMany(\App\Post::class);
    }

    // 专题的文章数，用于withCount
    public function postTopic()
    {
        return $this->hasMany(\App\PostTopic::class);
    }
}
