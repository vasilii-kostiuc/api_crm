<?php

namespace App\Modules\Admin\Role\Policies;

use App\Modules\Admin\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view():bool{
        return true;
    }

    public function create():bool{
        return true;
    }

    public function edit():bool{
        return true;
    }

    public function delete():bool{
        return true;
    }
}
