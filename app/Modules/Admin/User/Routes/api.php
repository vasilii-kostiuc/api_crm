<?php

Route::group(['prefix' => 'users', 'middleware' => ['auth:api']], function () {
    Route::get('/', 'Api\UserController@index')->name('api.users.index');
    Route::get('/create', 'UserController@create')->name('api.users.create');
    Route::post('/', 'Api\UserController@store')->name('api.users.store');
    Route::get('/{user}', 'UserController@show')->name('api.users.read');
    Route::get('/edit/{user}', 'UserController@edit')->name('api.users.edit');
    Route::put('/{user}', 'UserController@update')->name('api.users.update');
    Route::delete('/{user}', 'UserController@destroy')->name('api.users.delete');
});
