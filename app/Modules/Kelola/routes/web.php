<?php
Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-banner')]], function () {
    Route::resource('kelola-banner', 'BannerController');
    Route::post('kelola-banner/filter', 'BannerController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-profilkonglomerasi')]], function () {
    Route::resource('kelola-profilkonglomerasi', 'ProfilKonglomerasiController');
    // Route::post('kelola-profilkonglomerasi/filter', 'ProfilKonglomerasiController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-comprof')]], function () {
    Route::resource('kelola-comprof', 'ComprofController');
    Route::post('kelola-comprof/filter', 'ComprofController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-struktur')]], function () {
    Route::get('kelola-struktur', 'StrukturController')->name('kelola-struktur.index');
    Route::post('kelola-struktur/update', 'StrukturController@update')->name('kelola-struktur.update');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-artikel')]], function () {
    Route::resource('kelola-artikel', 'ArtikelController');
    Route::post('kelola-artikel/filter', 'ArtikelController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-laporan')]], function () {
    Route::resource('kelola-laporan', 'LaporanController');
    Route::post('kelola-laporan/filter', 'LaporanController@index');
    Route::get('kelola-laporan/approve/{id}', 'ApproveLaporanController@approveLaporan');
    Route::get('kelola-laporan/reject/{id}', 'ApproveLaporanController@rejectLaporan');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-regulasi')]], function () {
    Route::resource('kelola-regulasi', 'RegulasiController');
    Route::post('kelola-regulasi/filter', 'RegulasiController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kelola-tugaswewenang')]], function () {
    Route::resource('kelola-tugaswewenang', 'TugasWewenangController');
    Route::post('kelola-tugaswewenang/filter', 'TugasWewenangController@index');
});