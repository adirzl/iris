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
            $table->string('hp', 16);

            $table->index(['user_id', 'nip']);

            $table->foreign('user_id')
                ->references('id')
                ->on('app_user')
                ->onDelete('cascade');
        });

        Schema::create('app_hak_akses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('grade')->nullable();
            $table->boolean('pegawai_ti');
            $table->boolean('as_admin_spv');
            $table->boolean('as_admin');
            $table->unsignedSmallInteger('primary_level');
            $table->unsignedSmallInteger('secondary_level')->nullable();
            $table->unsignedInteger('sequence');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'primary_level']);
        });

        Schema::create('app_limit_oto', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode', 10);
            $table->json('jabatan');
            $table->decimal('limit_kredit', 18, 2);
            $table->decimal('limit_debit', 18, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'kode']);
        });

        Schema::create('app_sync_pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('iduid', 80);
            $table->string('userid', 50);
            $table->string('nama', 150);
            $table->string('nip', 10);
            $table->string('email', 80);
            $table->string('hp', 15);
            $table->string('kode_induk', 4);
            $table->string('nama_induk', 150)->nullable();
            $table->string('kode_cabang', 4);
            $table->string('nama_cabang', 150)->nullable();
            $table->string('kode_jabatan', 50);
            $table->string('nama_jabatan');
            $table->string('kode_penempatan', 4);
            $table->string('nama_penempatan', 150);
            $table->string('kode_grade', 4);
            $table->string('nama_grade', 50);
            $table->string('admin_spv_ti', 4);
            $table->unsignedSmallInteger('hakakses');
            $table->string('status_karyawan', 50);
            $table->date('tgl_sinkronisasi');
            $table->boolean('sinkronisasi')->default(0);

            $table->index(['id', 'userid', 'nip', 'kode_cabang', 'tgl_sinkronisasi']);
        });

        Schema::create('app_sync_ubah_limit', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('tgl_perubahan');
            $table->string('uid_aplikasi', 100);
            $table->string('userid', 6);
            $table->string('nama', 150);
            $table->string('idaplikasi', 30);
            $table->string('aplikasi', 150);
            $table->string('kode_cabang', 4);
            $table->decimal('limit_oto_kredit', 18, 2);
            $table->decimal('limit_oto_debit', 18, 2);
            $table->string('grup_limit', 10);
            $table->decimal('limit_oto_kredit_default', 18, 2);
            $table->decimal('limit_oto_debit_default', 18, 2);
            $table->date('tgl_sinkronisasi');
            $table->boolean('sinkronisasi')->default(0);
            $table->string('rc')->nullable();

            $table->index(['id', 'userid', 'tgl_perubahan', 'aplikasi', 'kode_cabang', 'tgl_sinkronisasi']);
        });

        Schema::create('app_reg_aplikasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('idaplikasi')->unique()->nullable();
            $table->string('nama', 150);
            $table->string('keterangan')->nullable();
            $table->string('alamat', 150)->nullable();
            $table->char('ada_limit', 1);
            $table->string('akses', 3);
            $table->char('muncul_di_uim', 1)->nullable();
            $table->smallInteger('otentikasi_user')->nullable()->comment('1:Manajemen User di Aplikasi; 2:UIM bandung10; 3:LDAP+UIM; 4:UIM API');
            $table->boolean('sinkronisasi')->default(0);
            $table->timestamps();

            $table->index(['id', 'idaplikasi', 'nama']);
        });

        Schema::create('app_reg_aplikasi_fungsi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('reg_aplikasi_id');
            $table->bigInteger('idfungsi')->unique()->nullable();
            $table->string('nama', 150);
            $table->string('menu', 150)->nullable();
            $table->smallInteger('status');
            $table->string('limit_debit', 50)->nullable();
            $table->string('limit_kredit', 50)->nullable();
            $table->char('spv', 1);
            $table->string('akses1', 4);
            $table->string('akses2', 4);
            $table->boolean('sinkronisasi')->default(0);
            $table->timestamps();

            $table->index(['id', 'reg_aplikasi_id', 'idfungsi', 'nama']);

            $table->foreign('reg_aplikasi_id')
                ->references('id')
                ->on('app_reg_aplikasi')
                ->onDelete('cascade');
        });

        Schema::create('app_reg_server', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->ipAddress('ip_address')->unique();
            $table->string('nama', 150);
            $table->string('hash_key')->nullable();
            $table->enum('environment', ['development', 'testing', 'production']);
            $table->boolean('blacklist');
            $table->enum('koneksi', ['development', 'testing', 'production']);
            $table->timestamps();

            $table->index(['id', 'ip_address', 'nama']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_reg_server');
        Schema::dropIfExists('app_reg_aplikasi_fungsi');
        Schema::dropIfExists('app_reg_aplikasi');
        Schema::dropIfExists('app_sync_ubah_limit');
        Schema::dropIfExists('app_sync_pegawai');
        Schema::dropIfExists('app_limit_oto');
        Schema::dropIfExists('app_hak_akses');
        Schema::dropIfExists('app_profile');
        Schema::dropIfExists('app_user');
    }
}
