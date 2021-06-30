<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassifiedCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'classified_categories',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('parent_id')->nullable()->default(0);
                $table->string('title')->nullable()->default('');
                $table->string('slug')->nullable()->default('');
                $table->integer('image_id')->nullable()->default(0);
                $table->string('image_url')->nullable()->default('');
                $table->text('detail')->nullable();
                $table->smallInteger('level')->nullable()->default(0);
                $table->integer('order_by')->nullable()->default(0);
                $table->integer('creator_id')->nullable()->default(0);
                $table->integer('editor_id')->nullable()->default(0);
                $table->string('seo_title')->nullable()->default('');
                $table->string('seo_keyword')->nullable()->default('');
                $table->string('seo_description')->nullable()->default('');
                $table->smallInteger('status')->nullable()->default(0);

                $table->index('parent_id', 'parent_id');
                $table->index('image_id', 'image_id');
                $table->index('creator_id', 'creator_id');
                $table->index('editor_id', 'editor_id');
                $table->index('status', 'status');
                $table->index('level', 'level');

                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classified_categories');
    }
}
