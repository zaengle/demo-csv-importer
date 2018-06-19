<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'csv-uploads',
    'as' => 'csv-uploads.'
], function() {
    Route::get('/', 'CSVUploadController@index')->name('index');
    Route::get('create', 'CSVUploadController@create')->name('create');
    Route::post('/', 'CSVUploadController@store')->name('store');

    Route::group([
        'prefix' => '{csvUpload}'
    ], function() {
        Route::get('map-columns', 'MapColumnsController@show')->name('map-columns.show');
        Route::post('map-columns', 'MapColumnsController@store')->name('map-columns.store');
    });
});