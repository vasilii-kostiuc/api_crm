<?php
/**
 * api_crm.loc - UserService.php
 *
 * Created by Admin
 * Created on: 11.01.2022 23:05
 */

namespace App\Modules\Admin\User\Serices;

use App\Modules\Admin\Role\Models\Role;
use App\Modules\Admin\User\Models\User;
use App\Modules\Admin\User\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserService {

    public function getUsers($status = false) {
        $usersBuilder = User::with('roles')->get();
        if($status){
            $usersBuilder->where('status', (string)$status);
        }
        $users =$usersBuilder->get();
        $users->transform(function ($item) {
            $item->rolename = '';
            if (isset($item->roles)) {
                $item->rolename = isset($item->roles->first()->title) ? $item->roles->first()->title : '';
            }

            return $item;
        });

        return $users;
    }

    public function save(UserRequest $request, User $user) {
        $user->fill($request->only($user->getFillable()));
        $user->password = Hash::make($request->password);
        $user->status = 1;
        $user->save();
        $role = Role::findOrFail($request->role_id);
        $user->roles()->sync($role->id);
        $user->rolename = $role->title;
        return $user;
    }
}
