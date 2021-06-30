<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNavPosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nav_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->default('')->nullable();
            $table->string('slug')->default('')->nullable();
            $table->integer('creator_id')->default(0)->nullable();
            $table->integer('editor_id')->default(0)->nullable();
            $table->timestamp('deleted_at', 0)->nullable();

            $table->index('creator_id', 'creator_id');
            $table->index('deleted_at', 'deleted_at');

            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nav_positions');
    }
}