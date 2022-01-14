<?php
/**
 * api_crm.loc - SourcesSeeds.php
 *
 * Created by Admin
 * Created on: 14.01.2022 17:52
 */

namespace App\Modules\Admin\Sources\Seeds;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourcesSeeds  extends Seeder {

    public function run(){
        DB::table('sources')->insert([
            [
                'title' => 'Instagram'
            ],
            [
                'title' => 'Viber'
            ],
            [
                'Site'
            ],
            [
                'Phone'
            ]
        ]);
    }
}
