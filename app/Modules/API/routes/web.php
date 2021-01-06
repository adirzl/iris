<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('datasource')]], function () {
    Route::resource('datasource', 'DatasourceController')->except(['show']);
    Route::post('datasource/filter', 'DatasourceController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('log-transaksi')]], function () {
    Route::get('log-transaksi', 'LogTransaksiController')->name('log-transaksi.index');
    Route::post('log-transaksi/filter', 'LogTransaksiController');
});
