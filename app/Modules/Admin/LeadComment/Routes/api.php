<?php

Route::group(['prefix' => 'lead-comments', 'middleware' => []], function () {
    Route::get('/', 'LeadCommentController@index')->name('lead-comments.index');
    Route::get('/create', 'LeadCommentController@create')->name('lead-comments.create');
    Route::post('/', 'LeadCommentController@store')->name('lead-comments.store');
    Route::get('/{leadComment}', 'LeadCommentController@show')->name('lead-comments.read');
    Route::get('/edit/{leadComment}', 'LeadCommentController@edit')->name('lead-comments.edit');
    Route::put('/{leadComment}', 'LeadCommentController@update')->name('lead-comments.update');
    Route::delete('/{leadComment}', 'LeadCommentController@destroy')->name('lead-comments.delete');
});