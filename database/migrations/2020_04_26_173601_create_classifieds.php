<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassifieds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classifieds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organization_id')->nullable()->default(0);
            $table->integer('member_id')->nullable()->default(0);
            $table->integer('category_id')->nullable()->default(0);
            $table->string('category_name')->nullable()->default('');
            $table->string('title')->nullable()->default('');
            $table->string('slug')->nullable()->default('');
            $table->integer('district_id')->nullable()->default(0);
            $table->string('district_name')->nullable()->default('');
            $table->integer('city_id')->nullable()->default(0);
            $table->string('city_name')->nullable()->default('');
            $table->integer('image_id')->nullable()->default(0);
            $table->string('image_url')->nullable()->default('');
            $table->string('image_url_thumb')->nullable()->default('');
            $table->text('images_multi')->nullable();
            $table->boolean('is_sale')->nullable()->default(0);
            $table->boolean('is_company')->nullable()->default(0);
            $table->decimal('price', 18, 2)->nullable()->default(0);
            $table->string('price_unit', 50)->nullable()->default('');
            $table->text('detail')->nullable();
            $table->integer('views')->nullable()->default(0);
            $table->integer('creator_id')->nullable()->default(0);
            $table->integer('editor_id')->nullable()->default(0);
            $table->timestamp('started_at', 0)->nullable();
            $table->timestamp('expired_at', 0)->nullable();
            $table->string('contact_fullname')->nullable()->default('');
            $table->string('contact_email')->nullable()->default('');
            $table->string('contact_phone')->nullable()->default('');
            $table->string('contact_address')->nullable()->default('');
            $table->string('seo_title')->nullable()->default('');
            $table->string('seo_keyword')->nullable()->default('');
            $table->string('seo_description')->nullable()->default('');
            $table->smallInteger('status')->nullable()->default(0);
            $table->string('source_id')->nullable()->default('');
            $table->tinyInteger('source')->nullable()->default(0);

            $table->index('organization_id', 'organization_id');
            $table->index('category_id', 'category_id');
            $table->index('district_id', 'district_id');
            $table->index('city_id', 'city_id');
            $table->index('is_sale', 'is_sale');
            $table->index('is_company', 'is_company');
            $table->index('creator_id', 'creator_id');
            $table->index('editor_id', 'editor_id');
            $table->index('status', 'status');

            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('classifieds');
    }
}
