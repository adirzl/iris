<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('target-rbb')]], function () {
    Route::resource('target-rbb', 'TargetRBBController');
    Route::post('target-rbb/filter', 'TargetRBBController@index');
    Route::post('target-rbb/upload_excel', 'TargetRBBController@upload_excel')->name('target-rbb.upload');
    Route::get('target-rbb/aktivasi/{id}', 'ActivasiTargetRBBController@activated');
    Route::get('target-rbb/inaktif/{id}', 'ActivasiTargetRBBController@not_activated');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('realisasi-rbb')]], function () {
    Route::resource('realisasi-rbb', 'RealisasiRBBController');
    Route::post('realisasi-rbb/filter', 'RealisasiRBBController@index');
    Route::post('realisasi-rbb/upload/{id}', 'RealisasiRBBController@upload_txt')->name('realisasi-rbb.upload');
    Route::get('realisasi-rbb/kategori/{id}', 'RealisasiRBBController@detail_kategori')->name('realisasi-rbb.detail_kategori');
    Route::get('realisasi-rbb/hapusKategori/{id}', 'RealisasiRBBController@hapusKategori')->name('realisasi-rbb.hapusKategori');
    Route::get('realisasi-rbb/export/{id}', 'RealisasiRBBController@export');
});

// Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kajian-kinerja')]], function () {
//     Route::resource('kajian-kinerja', 'KajiankinerjaController');
//     Route::post('kajian-kinerja/filter', 'KajiankinerjaController@index');
// });
