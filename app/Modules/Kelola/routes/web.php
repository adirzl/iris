<?php
Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-banner')]], function () {
    Route::resource('kelola-banner', 'BannerController');
    Route::post('kelola-banner/filter', 'BannerController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-konten')]], function () {
    Route::resource('kelola-konten', 'KontenController');
});