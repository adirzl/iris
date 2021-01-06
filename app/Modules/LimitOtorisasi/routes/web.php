<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('limit-otorisasi')]], function () {
    Route::resource('limit-otorisasi', 'LimitOtorisasiController')->except(['show']);
    Route::post('limit-otorisasi/filter', 'LimitOtorisasiController@index');
});
