<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 30);
            $table->string('password');
            $table->rememberToken();
            $table->string('session_id', 100)->nullable();
            $table->dateTime('last_activity')->nullable();
            $table->string('email', 80);
            $table->timestamps();

            $table->index(['id', 'username', 'email']);
        });

        Schema::create('app_profile', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->string('nama', 80);
            $table->string('nip', 20)->nullable();
            $table->string('hp', 16)->nullable();
            $table->string('unit_kerja_kode', 4);
            $table->string('unit_kerja_parent', 4);
            $table->index(['user_id', 'nip']);
            $table->foreign('user_id')
                ->references('id')
                ->on('app_user')
                ->onDelete('cascade');
        });

        Schema::create('app_unit_kerja', function (Blueprint $table) {
            $table->string('kode',4)->primary();
            $table->string('nama', 100);
            $table->string('kode_induk',4);
            $table->string('kode_kanwil',4);
            $table->string('nama_kanwil',100);
            $table->string('status',1);
            $table->timestamps();
        });

        Schema::create('app_filetype', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('name', 128);
            $table->string('unitkerja_kode', 4);
            $table->smallInteger('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('unitkerja_kode')
                ->references('kode')
                ->on('app_unit_kerja')
                ->onDelete('cascade');
        });

        Schema::create('app_filearchive', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('unitkerja_kode', 4);
            $table->uuid('filetype_id');
            $table->string('version', 5);
            $table->string('path', 255);
            $table->smallInteger('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('filetype_id')
                ->references('id')
                ->on('app_filetype')
                ->onDelete('cascade');
        });

        Schema::create('app_artikel', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('title',255)->nullable();
            $table->text('description')->nullable();
            $table->string('image',255)->nullable();
            $table->string('file',255)->nullable();
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('app_banner', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('title',255)->nullable();
            $table->text('description')->nullable();
            $table->string('image',255)->nullable();
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('app_company_prof', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('company_name',255)->nullable();
            $table->text('description')->nullable();
            $table->string('image',255)->nullable();
            $table->integer('status');
            $table->integer('status_progress');
            $table->timestamps();
        });

        Schema::create('app_laporan', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('title',255)->nullable();
            $table->text('description')->nullable();
            $table->string('image',255)->nullable();
            $table->string('file',255)->nullable();
            $table->integer('status');
            $table->integer('status_progres');
            $table->uuid('company_name');
            $table->string('periode',100)->nullable();
            $table->integer('tahun')->nullable();
            $table->timestamps();
        });

        Schema::create('app_local_user', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('username',255)->nullable();
            $table->string('password',255)->nullable();
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('app_penilaian', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('user',255)->nullable();
            $table->string('nama_peruasahaan',100)->nullable();
            $table->string('modal_inti',100)->nullable();
            $table->string('periode',16)->nullable();
            $table->integer('status');
            $table->string('status_kuisioner',100)->nullable();
            $table->timestamps();
        });

        Schema::create('app_penilaian_detail', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('id_induk');
            $table->uuid('id_pertanyaan');
            $table->uuid('id_pertanyaan_detail');
            $table->integer('jawaban');
            $table->string('file',255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('app_pertanyaan', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->text('description')->nullable();
            $table->integer('status');
            $table->integer('status_user');
            $table->timestamps();
        });

        Schema::create('app_pertanyaan_detail', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('id_induk');
            $table->string('no_pertanyaan',255)->nullable();
            $table->string('pertanyaan',255)->nullable();
            $table->timestamps();
        });

        Schema::create('app_profil', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('title',255)->nullable();
            $table->string('description',255)->nullable();
            $table->string('image',255)->nullable();
            $table->integer('status');
            $table->timestamps();
        });


        Schema::create('app_regulasi', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('title',255)->nullable();
            $table->text('description')->nullable();
            $table->string('image',255)->nullable();
            $table->string('file',255)->nullable();
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('app_struktur', function(Blueprint $table){
            $table->string('key',100)->nullable();
            $table->string('value',255)->nullable();
            $table->text('shortdesc',255)->nullable();
            $table->timestamps();
        });

        Schema::create('app_tugas_wewenang', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('title',255)->nullable();
            $table->text('description')->nullable();
            $table->integer('status');
            $table->integer('status_data');
            $table->timestamps();
        });


















    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_unit_kerja');
        Schema::dropIfExists('app_profile');
        Schema::dropIfExists('app_user');
    }
}
