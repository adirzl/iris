<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('dmtl-audit')]], function () {
    Route::resource('dmtl-audit', 'DmtlController');
    Route::post('dmtl-audit/filter', 'DmtlController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('rkat-audit')]], function () {
    Route::resource('rkat-audit', 'RkatController');
    Route::post('rkat-audit/filter', 'RkatController@index');
});
