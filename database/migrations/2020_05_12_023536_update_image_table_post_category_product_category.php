<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateImageTablePostCategoryProductCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->integer('image_id')->nullable()->default(0)->after('total_usage');
            $table->string('image_url')->nullable()->default('')->after('total_usage');
        });

        Schema::table('post_categories', function (Blueprint $table) {
            $table->integer('image_id')->nullable()->default(0)->after('total_usage');
            $table->string('image_url')->nullable()->default('')->after('total_usage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
