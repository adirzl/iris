<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('requestfile')]], function () {
    Route::resource('requestfile', 'RequestfileController');
});
