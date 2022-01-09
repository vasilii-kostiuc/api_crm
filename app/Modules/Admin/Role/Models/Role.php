<?php

namespace App\Modules\Admin\Role\Models;

use App\Modules\Admin\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    use HasFactory;

    protected $fillable = [
        'alias',
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function savePermissions(array $permissions) {
        if (!empty($permissions)) {
            $this->permissions()->sync($permissions);
        } else {
            $this->permissions()->detach();
        }
    }

    public function hasPermission($alias, $require = false): bool {
        if(is_array($alias)){
            foreach ($alias as $permAlias) {
                $hasPermissions = $this->hasPermission($permAlias);
                if($hasPermissions && !$require){
                    return true;
                }else if (!$hasPermissions && $require){
                    return false;
                }
            }
        }else{
            foreach ($this->permissions as $permission){
                if($permission->alias == $alias){
                    return true;
                }
            }
        }

        return $require;
    }
}
