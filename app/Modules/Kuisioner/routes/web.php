<?php
Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kuisioner-pertanyaan')]], function () {
    Route::resource('kuisioner-pertanyaan', 'PertanyaanController');
    Route::post('kuisioner-pertanyaan/filter', 'PertanyaanController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kuisioner-penilaian')]], function () {
    Route::resource('kuisioner-penilaian', 'PenilaianController')->except(['edit']);
    Route::post('kuisioner-penilaian/filter', 'PenilaianController@index');
    Route::post('kuisioner-penilaian/export/{id}', 'PenilaianController@export');
    Route::get('kuisioner-penilaian/approve/{id}', 'PenilaianController@approve');
    Route::get('kuisioner-penilaian/reject/{id}', 'PenilaianController@reject');
});
