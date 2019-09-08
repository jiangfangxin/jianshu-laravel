<?php

namespace App;

class AdminRole extends Model
{
    // 当前角色的所有权限
    public function permissions()
    {
        return $this->belongsToMany(\App\AdminPermission::class, 'admin_permission_role', 'role_id', 'permission_id')->withPivot(['permission_id', 'role_id']);
    }

    // 给角色赋予权限
    public function grantPermission(AdminPermission $permission)
    {
        return $this->permissions()->save($permission);
    }

    // 取消给角色赋予的权限
    public function deletePermission(AdminPermission $permission)
    {
        return $this->permissions()->detach($permission);
    }

    // 判断角色是否有权限
    public function hasPermission(AdminPermission $permission)
    {
        return $this->permissions()->contains($permission);
    }
}
