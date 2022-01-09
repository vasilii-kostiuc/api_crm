<?php
/**
 * api_crm.loc - UserRoles.php
 *
 * Created by Admin
 * Created on: 09.01.2022 19:04
 */

namespace App\Modules\Admin\Role\Traits;

use App\Modules\Admin\Role\Models\Role;
use Illuminate\Support\Str;

trait UserRoles {

    public function roles() {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function canDo($alias, $require = false) {
        if(is_array($alias)){
            foreach ($alias as $permAlias) {
                $result = $this->canDo($permAlias);
                if($result && !$require){
                    return true;
                }elseif (!$result && $require){
                    return false;
                }
            }
        }else{
            foreach ($this->roles as $role){


                foreach ($role->permissions as $permission){
                    if(Str::is( $alias, $permission->alias)){
                        return true;
                    }
                }
            }
        }
        return $require;
    }

    public function hasRole($alias, $require = false) {
        if (is_array($alias)) {
            foreach ($alias as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if ($hasRole && !$require) {
                    return true;
                } elseif (!$hasRole && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->roles as $role) {
                if ($role->alias == $alias) {
                    return true;
                }
            }
        }

        return $require;
    }

    public function getMergedPermissions() {
        $result = [];
        foreach ($this->roles as $role) {
            $result = array_merge($result, $role->permissions->toArray());
        }

        return $result;
    }

    public function getRoles() {
        if($this->roles) {
            return $this->roles;
        }

        return [];
    }
}
