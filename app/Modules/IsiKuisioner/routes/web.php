<?php
Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('isikuisioner-manrisk')]], function () {
    Route::resource('isikuisioner-manrisk', 'IsiKuisionerManriskController');
    Route::post('isikuisioner-manrisk/filter', 'IsiKuisionerManriskController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('isikuisioner-kepatuhan')]], function () {
    Route::resource('isikuisioner-kepatuhan', 'IsiKuisionerKepatuhanController');
    Route::post('isikuisioner-kepatuhan/filter', 'IsiKuisionerKepatuhanController@index');
});
