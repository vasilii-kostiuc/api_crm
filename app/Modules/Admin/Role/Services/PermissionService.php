<?php
/**
 * api_crm.loc - PermissionService.php
 *
 * Created by Admin
 * Created on: 08.01.2022 22:56
 */

namespace App\Modules\Admin\Role\Services;

use App\Modules\Admin\Role\Models\Role;
use Illuminate\Http\Request;

class PermissionService
{

    public function save(Request $request)
    {
        $data = $request->except('_token');

        $roles = Role::all();

        foreach ($roles as $role) {
            if (isset($data[$role->id])) {
                $role->savePermissions($data[$role->id]);
            } else {
                $role->savePermissions([]);
            }
        }
    }
}
