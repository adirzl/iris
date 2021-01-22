<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('dokumen-filetype')]], function () {
    Route::resource('dokumen-filetype', 'FileTypeController');
    Route::post('dokumen-filetype/filter', 'FileTypeController@index');
    Route::get('dokumen-filetype-list/{unitkerja_kode}', 'FileTypeController@list_filetype');
});


Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('dokumen-filearchive')]], function () {
    Route::resource('dokumen-filearchive', 'FileArchiveController');
    Route::post('dokumen-filearchive/filter', 'FileArchiveController@index');
});