<?php
/**
 * api_crm.loc - UserLeadsTrait.php
 *
 * Created by Admin
 * Created on: 15.01.2022 11:35
 */

namespace App\Modules\Admin\Lead\Models\Traits;


use App\Modules\Admin\Lead\Models\Lead;
use App\Modules\Admin\LeadComment\Models\LeadComment;

trait UserLeadsTrait {
    public function leads(){
        return $this->hasMany(Lead::class);
    }

    public function tasks(){

    }

    public function responsibleTasks(){

    }

    public function comments(){
        return $this->hasMany(LeadComment::class);
    }

}
