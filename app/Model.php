<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    // 设置那些字段不能通过数组来赋值
    protected $guarded = [];
}
