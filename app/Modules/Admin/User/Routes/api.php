<?php

Route::group(['prefix' => 'users', 'middleware' => ['auth:api']], function () {
    Route::get('/', 'Api\UserController@index')->name('api.users.index');
    Route::get('/create', 'Api\UserController@create')->name(
        'api.users.create'
    );
    Route::post('/', 'Api\UserController@store')->name('api.users.store');
    Route::get('/{user}', 'Api\UserController@show')->name('api.users.read');
    Route::get('/edit/{user}', 'Api\UserController@edit')->name(
        'api.users.edit'
    );
    Route::put('/{user}', 'Api\UserController@update')->name(
        'api.users.update'
    );
    Route::delete('/{user}', 'Api\UserController@destroy')->name(
        'api.users.delete'
    );
});
