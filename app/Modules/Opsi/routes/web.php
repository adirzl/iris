<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('opsi')]], function () {
    Route::resource('opsi', 'OpsiController')->except(['show']);
    Route::post('opsi/filter', 'OpsiController@index');
});
