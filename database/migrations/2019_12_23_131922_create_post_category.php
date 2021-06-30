<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->default(0)->nullable();
            $table->string('title')->default('')->nullable();
            $table->string('slug')->default('')->nullable();
            $table->text('description')->nullable();
            $table->integer('total_usage')->default(0)->nullable();
            $table->string('seo_title')->default('')->nullable();
            $table->string('seo_description')->default('')->nullable();
            $table->integer('creator_id')->default(0)->nullable();
            $table->integer('editor_id')->default(0)->nullable();
            $table->timestamp('deleted_at', 0)->nullable();

            $table->index('parent_id', 'parent_id');
            $table->index('title', 'title');
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
        Schema::dropIfExists('post_categories');
    }
}
