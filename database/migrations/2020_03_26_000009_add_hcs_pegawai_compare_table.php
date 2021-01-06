<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHcsPegawaiCompareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hcs_pegawai_compare', function (Blueprint $table) {
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
        Schema::dropIfExists('hcs_pegawai_compare');
    }
}
