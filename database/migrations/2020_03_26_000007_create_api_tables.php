<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_datasource', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 15);
            $table->enum('environment', ['development', 'testing', 'production']);
            $table->enum('dialect', ['pgsql', 'mssql']);
            $table->json('properties');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'nama', 'environment', 'dialect']);
        });
 
        Schema::create('api_transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('tgl_transaksi');
            $table->ipAddress('ipaddress');
            $table->enum('jobtype', ['API', 'JOB']);
            $table->string('jobname', 80);
            $table->json('reqdata');
            $table->json('resdata');
            $table->enum('status', ['success', 'failed']);

            $table->index(['id', 'tgl_transaksi', 'ipaddress', 'jobtype', 'jobname']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_transaksi');
        Schema::dropIfExists('api_datasource');
    }
}
