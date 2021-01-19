<?php
Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('FileType')]], function () {
    Route::resource('FileType', 'FileTypeController');
    Route::post('FileType/filter', 'FileTypeController@index');
});


Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('FileArchive')]], function () {
    Route::resource('FileArchive', 'FileArchiveController');
    Route::post('FileArchive/filter', 'FileArchiveController@index');
});
