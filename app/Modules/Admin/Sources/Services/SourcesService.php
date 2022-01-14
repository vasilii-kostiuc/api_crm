<?php
/**
 * api_crm.loc - SourcesService.php
 *
 * Created by Admin
 * Created on: 14.01.2022 17:19
 */

namespace App\Modules\Admin\Sources\Services;


use App\Modules\Admin\Sources\Models\Source;
use App\Modules\Admin\Sources\Requests\SourcesRequest;

class SourcesService {

    public function getSources() {
        return Source::all();
    }

    public function save(SourcesRequest $request, Source $source) {
        $source->fill($request->only($source->getFillable()));
        $source->save();
        return $source;
    }
}
