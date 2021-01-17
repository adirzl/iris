<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('requestfile')]], function () {
    Route::resource('requestfile', 'RequestfileController');
    Route::get('requestfile/{id}/approval', 'RequestfileController@approval')->name('requestfile.approval');
    Route::post('requestfile/{requestfile}/storeapproval', 'RequestfileController@storeapproval')->name('requestfile.storeapproval');
});
