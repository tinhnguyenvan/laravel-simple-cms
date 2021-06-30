<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePsCollegeImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ps_college_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('college_id')->default(0)->nullable();
            $table->integer('image_id')->default(0)->nullable();
            $table->string('image_url')->nullable();
            $table->integer('creator_id')->default(0)->nullable();
            $table->integer('editor_id')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('college_id', 'college_id');
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
        Schema::dropIfExists('ps_college_images');
    }
}
