<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('rule-hak-akses')]], function () {
    Route::resource('rule-hak-akses', 'RuleHakAksesController')->except(['show']);
    Route::post('rule-hak-akses/filter', 'RuleHakAksesController@index');
});
