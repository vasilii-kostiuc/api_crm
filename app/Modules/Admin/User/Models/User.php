<?php

namespace App\Modules\Admin\User\Models;

use App\Modules\Admin\Lead\Models\Traits\UserLeadsTrait;
use App\Modules\Admin\Role\Traits\UserRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthUser;
use Laravel\Passport\HasApiTokens;

class User extends AuthUser
{
    use HasFactory, HasApiTokens, UserRoles, UserLeadsTrait;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'status'
    ];

    protected $hidden = [
        'password'
    ];
}
