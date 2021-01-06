<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('profile', 'ProfileController')->name('profile');
    Route::post('profile/update', 'ProfileController@update')->name('profile.update');
});
