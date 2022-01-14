<?php

Route::group(['prefix' => 'sources', 'middleware' => ['auth:api']], function () {
    Route::get('/', 'Api\SourcesController@index')->name('api.sources.index');
    Route::get('/create', 'Api\SourcesController@create')->name('api.sources.create');
    Route::post('/', 'Api\SourcesController@store')->name('api.sources.store');
    Route::get('/{source}', 'Api\SourcesController@show')->name('api.sources.read');
    Route::get('/edit/{source}', 'Api\SourcesController@edit')->name('api.sources.edit');
    Route::put('/{source}', 'Api\SourcesController@update')->name('api.sources.update');
    Route::delete('/{source}', 'Api\SourcesController@destroy')->name('api.sources.delete');
});
