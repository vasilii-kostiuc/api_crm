<?php

Route::group(['prefix' => 'menus', 'middleware' => ['auth:api']], function () {
    Route::get('/', 'Api\MenuController@index')->name('menus.index');
});
