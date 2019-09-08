<?php

namespace App;

class AdminPermission extends Model
{
    // 拥有这个权限的角色有哪些
    public function roles()
    {
        return $this->belongsToMany(\App\AdminRole::class, 'admin_permission_role', 'permission_id', 'role_id');
    }
}
