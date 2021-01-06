<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('unit-kerja-uim')]], function () {
    Route::get('unit-kerja-uim', 'UnitKerjaController')->name('unit-kerja-uim.index');
    Route::post('unit-kerja-uim/filter', 'UnitKerjaController');
    Route::post('unit-kerja-uim/export', 'UnitKerjaController@export');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('pegawai-uim')]], function () {
    Route::get('pegawai-uim', 'PegawaiController')->name('pegawai-uim.index');
    Route::post('pegawai-uim/filter', 'PegawaiController');
    Route::post('pegawai-uim/export', 'PegawaiController@export');
});
