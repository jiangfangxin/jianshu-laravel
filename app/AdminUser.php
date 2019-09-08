<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable 
{
    protected $guarded = [];

    // 用户有那些角色
    public function roles()
    {
        return $this->belongsToMany(\App\AdminRole::class, 'admin_role_user', 'user_id', 'role_id')->withPivot(['user_id', 'role_id']);
    }

    // 判断是否有某一个角色，或者某些角色
    public function isInRoles(Collection $roles)
    {
        return !!$roles->intersect($this->roles)->count();
    }

    // 给用户分配角色
    public function assignRole(AdminRole $role)
    {
        return $this->roles()->save($role);
    }

    // 取消用户分配的角色
    public function deleteRole(AdminRole $role)
    {
        return $this->roles()->detach($role);
    }

    // 用户是否有权限
    public function hasPermission(AdminPermission $permission)
    {
        return $this->isInRoles($permission->roles);
    }
}
