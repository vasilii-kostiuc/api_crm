<?php
/**
 * api_crm.loc - LocalizationService.php
 *
 * Created by Admin
 * Created on: 26.12.2021 20:36
 */

namespace app\Services\Localization;

use Illuminate\Support\Facades\Facade;

class LocalizationService extends Facade {
    protected static function  getFacadeAccessor() {
        return 'Localization';
    }



}
