<?php

namespace App;

class Fan extends Model
{
    // 某一个粉丝对应的用户模型
    public function fuser()
    {
        return $this->hasOne(User::class, 'id', 'fan_id');
    }
    
    // 某一个明星对应的用户模型
    public function suser()
    {
        return $this->hasOne(User::class, 'id', 'star_id');
    }
}
