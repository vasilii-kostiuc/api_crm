<?php
/**
 * api_crm.loc - UserPolicy.php
 *
 * Created by Admin
 * Created on: 11.01.2022 23:18
 */

namespace App\Modules\Admin\User\Policies;


use App\Modules\Admin\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
    use HandlesAuthorization;

    public function view(User $user){
        return $user->canDo(['SUPER_ADMINISTRATOR','USER_ACCESS']);
    }

    public function create(User $user){
        return $user->canDo(['SUPER_ADMINISTRATOR','USER_ACCESS']);
    }

    public function edit(User $user){
        return $user->canDo(['SUPER_ADMINISTRATOR','USER_ACCESS']);
    }

    public function delete(User $user){
        return $user->canDo(['SUPER_ADMINISTRATOR','USER_ACCESS']);
    }

}
