<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('setting')]], function () {
    Route::get('setting', 'SettingController')->name('setting.index');
    Route::post('setting/update', 'SettingController@update')->name('setting.update');
});
