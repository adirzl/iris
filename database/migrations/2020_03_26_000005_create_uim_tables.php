<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUimTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uim_unit_kerja', function (Blueprint $table) {
            $table->string('kode_cabang', 4)->nullable();
            $table->string('nama_cabang', 100)->nullable();
            $table->string('kode_induk', 4)->nullable();
            $table->string('nama_induk', 100)->nullable();
            $table->string('kode_kanwil', 4)->nullable();
            $table->string('nama_kanwil', 100)->nullable();
            $table->string('kode_hc', 4)->nullable();
            $table->string('alamat')->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('status', 10)->nullable();

            $table->index(['kode_cabang', 'kode_induk', 'kode_hc']);
        });

        Schema::create('uim_pegawai', function (Blueprint $table) {
            $table->string('iduid', 80)->nullable();
            $table->string('userid', 50)->nullable();
            $table->string('nama', 150)->nullable();
            $table->string('nip', 50)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('hp', 50)->nullable();
            $table->string('kode_induk', 50)->nullable();
            $table->string('kode_cabang', 50)->nullable();
            $table->string('kode_jabatan', 50)->nullable();
            $table->string('nama_jabatan', 100)->nullable();
            $table->string('kode_penempatan', 50)->nullable();
            $table->string('nama_penempatan', 150)->nullable();
            $table->string('kode_grade', 50)->nullable();
            $table->string('nama_grade', 50)->nullable();
            $table->string('admin_spv_ti', 50)->nullable();
            $table->string('hakakses', 50)->nullable();
            $table->string('status_karyawan', 50)->nullable();

            $table->index(['userid', 'nip', 'kode_induk', 'kode_cabang']);
        });

        Schema::create('uim_ubah_limit', function (Blueprint $table) {
            $table->string('tgl_pengajuan', 30)->nullable();
            $table->string('uid_aplikasi', 80)->nullable();
            $table->string('userid', 6)->nullable();
            $table->string('nama', 150)->nullable();
            $table->string('idaplikasi', 30)->nullable();
            $table->string('aplikasi', 150)->nullable();
            $table->string('kode_cabang', 30)->nullable();
            $table->string('limit_oto_kredit', 50)->nullable();
            $table->string('limit_oto_debit', 50)->nullable();
            $table->string('waktu_proses', 30)->nullable();
            $table->string('user_admin_ti', 150)->nullable();
            $table->string('tgl_berlaku_awal', 30)->nullable();
            $table->string('tgl_berlaku_akhir', 30)->nullable();
            $table->char('sementara', 1)->nullable()->comment('Y: Sementara, N: Permanen');

            $table->index(['tgl_pengajuan', 'userid', 'idaplikasi', 'kode_cabang']);
        });

        Schema::create('uim_aplikasi', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('nama', 150);
            $table->string('keterangan')->nullable();
            $table->string('alamat', 150)->nullable();
            $table->char('ada_limit', 1);
            $table->string('akses', 3);
            $table->char('muncul_di_uim', 1)->nullable();

            $table->index(['id', 'nama']);
        });

        Schema::create('uim_aplikasi_fungsi', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->bigInteger('idaplikasi');
            $table->string('nama', 150);
            $table->string('menu', 150)->nullable();
            $table->smallInteger('status');
            $table->string('limit_debit', 50)->nullable();
            $table->string('limit_kredit', 50)->nullable();
            $table->char('spv', 1);
            $table->string('akses1', 4);
            $table->string('akses2', 4);

            $table->index(['id', 'idaplikasi', 'nama']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uim_aplikasi_fungsi');
        Schema::dropIfExists('uim_aplikasi');
        Schema::dropIfExists('uim_ubah_limit');
        Schema::dropIfExists('uim_pegawai');
        Schema::dropIfExists('uim_unit_kerja');
    }
}
