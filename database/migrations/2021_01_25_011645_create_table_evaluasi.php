<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEvaluasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_evaluasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('risettitle', 255);
            $table->string('unitkerja_kode', 4);
            $table->string('risetquality', 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('app_evaluasi_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('evaluasi_id');
            $table->string('aspect', 255);
            $table->string('description', 255);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('evaluasi_id')
                ->references('id')
                ->on('app_evaluasi')
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
        Schema::dropIfExists('app_evaluasi');
        Schema::dropIfExists('app_evaluasi_detail');
    }
}
