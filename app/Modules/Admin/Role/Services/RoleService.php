<?php
/**
 * api_crm.loc - RoleService.php
 *
 * Created by Admin
 * Created on: 08.01.2022 22:11
 */

namespace App\Modules\Admin\Role\Services;

use App\Modules\Admin\Role\Requests\RoleRequest;
use Illuminate\Database\Eloquent\Model;

class RoleService {

    public function save(RoleRequest $request, Model $model) {
        $model->fill($request->only($model->getFillable()));
        return $model->save();
    }

}
