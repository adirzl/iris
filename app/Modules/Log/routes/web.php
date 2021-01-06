<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('log-aktifitas')]], function () {
    Route::get('log-aktifitas', 'LogAktifitasController')->name('log-aktifitas.index');
    Route::post('log-aktifitas/filter', 'LogAktifitasController');
    Route::get('log-aktifitas/clean', 'LogAktifitasController@clean')->name('log-aktifitas.clean');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('log-aplikasi')]], function () {
    Route::get('log-aplikasi', 'LogAplikasiController@index')->name('log-aplikasi.index');
});
