<?php

Route::group(['prefix' => 'leads', 'middleware' => ['auth:api']], function () {
    Route::get('/', 'Api\LeadController@index')->name('api.leads.index');
    Route::get('/create', 'Api\LeadController@create')->name(
        'api.leads.create'
    );
    Route::post('/', 'Api\LeadController@store')->name('api.leads.store');
    Route::get('/{lead}', 'Api\LeadController@show')->name('api.leads.read');
    Route::get('/edit/{lead}', 'Api\LeadController@edit')->name(
        'api.leads.edit'
    );
    Route::put('/{lead}', 'Api\LeadController@update')->name(
        'api.leads.update'
    );
    Route::delete('/{lead}', 'Api\LeadController@destroy')->name(
        'api.leads.delete'
    );
});
