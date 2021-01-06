<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('unit-kerja-hcs')]], function () {
    Route::get('unit-kerja-hcs', 'UnitKerjaController')->name('unit-kerja-hcs.index');
    Route::post('unit-kerja-hcs/filter', 'UnitKerjaController');
    Route::post('unit-kerja-hcs/export', 'UnitKerjaController@export');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('grade-hcs')]], function () {
    Route::get('grade-hcs', 'GradeController')->name('grade-hcs.index');
    Route::post('grade-hcs/filter', 'GradeController');
    Route::post('grade-hcs/export', 'GradeController@export');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('jabatan-hcs')]], function () {
    Route::get('jabatan-hcs', 'JabatanController')->name('jabatan-hcs.index');
    Route::post('jabatan-hcs/filter', 'JabatanController');
    Route::post('jabatan-hcs/export', 'JabatanController@export');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('pegawai-hcs')]], function () {
    Route::get('pegawai-hcs', 'PegawaiController')->name('pegawai-hcs.index');
    Route::post('pegawai-hcs/filter', 'PegawaiController');
    Route::post('pegawai-hcs/export', 'PegawaiController@export');
});
