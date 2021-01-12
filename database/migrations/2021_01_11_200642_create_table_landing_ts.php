<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLandingTs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_unitkerja', function (Blueprint $table) {
            $table->string('kode', 4)->primary();
            $table->string('name', 128);
            $table->string('parentkode', 4)->nullable();
            $table->smallInteger('status');
            $table->timestamps();
            $table->softDeletes();
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
                ->on('app_unitkerja')
                ->onDelete('cascade');
        });

        Schema::create('app_filearchive', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->string('name', 128);
            $table->string('path', 255);
            $table->uuid('fileType');
            $table->smallInteger('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fileType')
                ->references('id')
                ->on('app_filetype')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_unitkerja');
        Schema::dropIfExists('app_filetype');
        Schema::dropIfExists('app_filearchive');
    }
}
