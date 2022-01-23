<?php

namespace App\Modules\Admin\Sources\Controllers\Api;

use App\Modules\Admin\Sources\Models\Source;
use App\Modules\Admin\Sources\Requests\SourcesRequest;
use App\Modules\Admin\Sources\Services\SourcesService;
use App\Modules\Admin\User\Models\User;
use App\Modules\Admin\User\Serices\UserService;
use App\Services\Response\ResponseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SourcesController extends Controller
{


    private SourcesService $service;

    public function __construct(SourcesService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Source::class);


        return ResponseService::sendJsonResponse(true, 200, [], [
            'items' => $this->service->getSources(),
        ]);
    }

    /**
     * Create of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * @param SourcesRequest $request
     */
    public function store(SourcesRequest $request)
    {
        $item = $this->service->save($request, new Source());

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $item->toArray(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $source->toArray(),
        ]);
    }

    /**
     * Edit resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SourcesRequest $request
     * @param Source         $source
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SourcesRequest $request, Source $source)
    {
        $item = $this->service->save($request, $source);

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $item->toArray(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        $source->delete();

        return ResponseService::sendJsonResponse(true, 200, [], [
            'item' => $source->toArray(),
        ]);
    }
}
