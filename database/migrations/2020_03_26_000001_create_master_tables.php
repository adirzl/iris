<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_configuration', function (Blueprint $table) {
            $table->string('key', 100);
            $table->string('value')->nullable();
            $table->text('shortdesc')->nullable();
            $table->unsignedSmallInteger('user_config')->comment('0: System Config, 1: User Config, 2: Additional User Config');
            $table->string('component', 15);

            $table->index('key');
        });

        Schema::create('mst_module', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('label', 100);
            $table->string('uri', 150);
            $table->string('icon', 100)->nullable();
            $table->uuid('parent_module')->nullable();
            $table->boolean('visible');
            $table->string('sequence', 100);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'label', 'parent_module']);
        });

        Schema::create('mst_option_group', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'name']);
        });

        Schema::create('mst_option_value', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('option_group_id');
            $table->string('key', 150);
            $table->string('value', 150);
            $table->integer('sequence');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'option_group_id', 'key']);

            $table->foreign('option_group_id')
                ->references('id')
                ->on('mst_option_group')
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
        Schema::dropIfExists('mst_option_value');
        Schema::dropIfExists('mst_option_group');
        Schema::dropIfExists('mst_module');
        Schema::dropIfExists('mst_configuration');
    }
}
