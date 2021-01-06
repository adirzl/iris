<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('hak-akses')]], function () {
    Route::resource('hak-akses', 'HakAksesController')->except(['show']);
    Route::post('hak-akses/filter', 'HakAksesController@index');
});
