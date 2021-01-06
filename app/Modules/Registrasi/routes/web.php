<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('registrasi-aplikasi')]], function () {
    Route::resource('registrasi-aplikasi', 'AplikasiController')->except(['show', 'destroy']);
    Route::post('registrasi-aplikasi/filter', 'AplikasiController@index');
    Route::post('registrasi-aplikasi/{registrasi_aplikasi}/sinkronisasi', 'AplikasiController@sinkronisasi')->name('registrasi-aplikasi.sinkronisasi');
    Route::post('registrasi-aplikasi/{registrasi_aplikasi}/matriks', 'AplikasiController@matriks')->name('registrasi-aplikasi.matriks');
    Route::post('registrasi-aplikasi/export', 'AplikasiController@export');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('registrasi-aplikasi-fungsi')]], function () {
    Route::resource('registrasi-aplikasi-fungsi', 'FungsiController')->except(['show', 'destroy']);
    Route::post('registrasi-aplikasi-fungsi/filter', 'FungsiController@index');
    Route::post('registrasi-aplikasi-fungsi/{registrasi_aplikasi_fungsi}/sinkronisasi', 'FungsiController@sinkronisasi')->name('registrasi-aplikasi-fungsi.sinkronisasi');
    Route::post('registrasi-aplikasi-fungsi/export', 'FungsiController@export');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('registrasi-server')]], function () {
    Route::resource('registrasi-server', 'ServerController')->except(['show']);
    Route::post('registrasi-server/filter', 'ServerController@index');
    Route::post('registrasi-server/export', 'ServerController@export');
});
