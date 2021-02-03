<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('landing');
});

Auth::routes(['reset' => false, 'verify' => false]);

Route::get('/login_iris', 'LandingController@login_iris');
Route::get('/login_admin', 'LandingController@login_iris');
Route::get('/home', 'HomeController@index')->name('home');

// Landing Routes
Route::get('/landing', 'LandingController@index')->name('landing');
Route::get('/{id}/detail', 'LandingController@detail')->name('landingdetail');
Route::get('/tugas_wew_kk', 'LandingController@tugas_wew_kk');
Route::get('/perencanaan_bisnis_bank', 'LandingController@perencanaan_bisnis_bank');
Route::get('/pengembangan_organisasi', 'LandingController@pengembangan_organisasi');
Route::get('/profil', 'LandingController@profil');
Route::get('/visi_misi', 'LandingController@visi_misi');
Route::get('/sekapur_sirih', 'LandingController@sekapur_sirih');
Route::get('/arsip_dokumen', 'LandingController@arsip_dokumen');

Route::get('/tentang_kk', 'LandingController@tentang_kk');
Route::get('/sekilas_kk', 'LandingController@sekilas_kk');
Route::get('/struktur_kk', 'LandingController@struktur_kk');
Route::get('/comp_prof_kk', 'LandingController@comp_prof_kk');
Route::get('/comp_prof_kk_detail/{id}', 'LandingController@comp_prof_kk_detail');
Route::get('/report_sumber', 'LandingController@report_sumber');
Route::get('/kajian_kinke', 'LandingController@kajian_kinke');
Route::get('/regulasi', 'LandingController@regulasi');
Route::get('/berita', 'LandingController@berita');
Route::get('/regulasi_content/{id}', 'LandingController@regulasi_content');
Route::get('/berita_content/{id}', 'LandingController@berita_content');
Route::get('/tentang_tatakelola', 'LandingController@tentang_tatakelola');
Route::get('/tentang_manrisk', 'LandingController@tentang_manrisk');
Route::get('/tentang_kepatuhan', 'LandingController@tentang_kepatuhan');
Route::get('/tentang_audit', 'LandingController@tentang_audit');
Route::get('/rencana_kerja_manrisk', 'LandingController@rencana_kerja_manrisk');
Route::get('/rencana_kerja_kepatuhan', 'LandingController@rencana_kerja_kepatuhan');
Route::get('/rencana_kerja_audit', 'LandingController@rencana_kerja_audit');
Route::get('/report_kuisioner_manrisk', 'LandingController@report_kuisioner_manrisk');
Route::get('/report_kuisioner_manrisk/export/{id}', 'LandingController@export');
Route::get('/report_kuisioner_kepatuhan', 'LandingController@report_kuisioner_kepatuhan');
Route::get('/report_kuisioner_kepatuhan/export/{id}', 'LandingController@export');
Route::get('/report_kuisioner_audit', 'LandingController@report_kuisioner_audit');
Route::post('/ceklogin', 'LandingController@cekLogin')->name('ceklogin');
