<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassifiedImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classified_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('classified_id')->default(0)->nullable();
            $table->integer('image_id')->default(0)->nullable();
            $table->string('image_url')->nullable();
            $table->integer('creator_id')->default(0)->nullable();
            $table->integer('editor_id')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('classified_id', 'classified_id');
            $table->index('image_id', 'image_id');

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
        Schema::dropIfExists('classified_images');
    }
}
