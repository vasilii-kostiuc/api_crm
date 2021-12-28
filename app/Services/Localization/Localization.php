<?php
/**
 * api_crm.loc - Localization.php
 *
 * Created by Admin
 * Created on: 26.12.2021 20:44
 */

namespace App\Services\Localization;

use Illuminate\Support\Facades\App;

class Localization {

    public static function locale() {
        $locale = request()->segment(1);
        if ($locale && in_array($locale, config('app.locales'))) {
            App::setLocale($locale);
            return $locale;
        }
    }
}
