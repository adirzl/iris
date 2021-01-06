<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('sinkronisasi-pegawai')]], function () {
    Route::get('sinkronisasi-pegawai', 'PegawaiController@index')->name('sinkronisasi-pegawai.index');
    Route::post('sinkronisasi-pegawai/filter', 'PegawaiController@index');
    Route::post('sinkronisasi-pegawai/send', 'PegawaiController@send')->name('sinkronisasi-pegawai.send');
    Route::post('sinkronisasi-pegawai/export', 'PegawaiController@export');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('sinkronisasi-limit')]], function () {
    Route::get('sinkronisasi-limit', 'UbahLimitController@index')->name('sinkronisasi-limit.index');
    Route::post('sinkronisasi-limit/filter', 'UbahLimitController@index');
    Route::post('sinkronisasi-limit/send', 'UbahLimitController@send')->name('sinkronisasi-limit.send');
    Route::post('sinkronisasi-limit/export', 'UbahLimitController@export');
});
