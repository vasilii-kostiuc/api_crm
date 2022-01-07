<?php

namespace App\Modules\Admin\Menu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\User\Models\User;

class Menu extends Model
{
    use HasFactory;

    const MENU_TYPE_FRONT = "front";
    const MENU_TYPE_BACKENND = "admin";

    public static  function scopeFrontMenu($query, User $user){
        return $query->where('type', self::MENU_TYPE_FRONT)//->
//            whereHas('perms', function ($q) use($user){
//
//
//        })
        ;
    }

    public static function scopeMenuByType($query, $type){
        return $query->where('type', $type)->orderBy('sort_order');
    }

}
