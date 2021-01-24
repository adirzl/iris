<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('evaluasi')]], function () {
    Route::resource('evaluasi', 'EvaluasiController');
});
