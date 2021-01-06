<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHcsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcs_unit_kerja', function (Blueprint $table) {
            $table->string('kode', 4)->nullable();
            $table->string('treecode', 100)->nullable();
            $table->string('parentcode', 4)->nullable();
            $table->string('nama', 100)->nullable();
            $table->string('alamat', 200)->nullable();
            $table->string('kota', 50)->nullable();
            $table->unsignedTinyInteger('status')->nullable();

            $table->index(['kode']);
        });

        Schema::create('hcs_grade', function (Blueprint $table) {
            $table->string('kode', 4)->nullable();
            $table->string('nama', 20)->nullable();
            $table->unsignedSmallInteger('status')->nullable();

            $table->index(['kode', 'nama']);
        });

        Schema::create('hcs_jabatan', function (Blueprint $table) {
            $table->string('kode', 6)->nullable();
            $table->string('nama', 100)->nullable();
            $table->unsignedSmallInteger('status')->nullable();

            $table->index(['kode', 'nama']);
        });

        Schema::create('hcs_pegawai', function (Blueprint $table) {
            $table->string('userid', 6)->nullable();
            $table->string('nama', 150)->nullable();
            $table->string('nip', 15)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('hp', 30)->nullable();
            $table->string('kode_unit_kerja', 4)->nullable();
            $table->string('kode_jabatan', 5)->nullable();
            $table->string('kode_penempatan', 4);
            $table->string('kode_grade', 4)->nullable();
            $table->string('status_karyawan', 50)->nullable();

            $table->index(['userid', 'nip', 'kode_unit_kerja', 'status_karyawan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hcs_pegawai');
        Schema::dropIfExists('hcs_jabatan');
        Schema::dropIfExists('hcs_grade');
        Schema::dropIfExists('hcs_unit_kerja');
    }
}
