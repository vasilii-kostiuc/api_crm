<?php

Route::group(['prefix' => 'dashboards', 'middleware' => []], function () {
    Route::get('/', 'DashboardController@index')->name('dashboards.index');
    Route::get('/create', 'DashboardController@create')->name('dashboards.create');
    Route::post('/', 'DashboardController@store')->name('dashboards.store');
    Route::get('/{dashboard}', 'DashboardController@show')->name('dashboards.read');
    Route::get('/edit/{dashboard}', 'DashboardController@edit')->name('dashboards.edit');
    Route::put('/{dashboard}', 'DashboardController@update')->name('dashboards.update');
    Route::delete('/{dashboard}', 'DashboardController@destroy')->name('dashboards.delete');
});