<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableScholarships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ps_college_scholarships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('college_id')->default(0);
            $table->integer('organization_id')->default(0);
            $table->integer('member_id')->default(0);
            $table->string('name');
            $table->string('slug');
            $table->smallInteger('condition_type')->default(0);
            $table->integer('condition_country_id')->default(0);
            $table->string('condition_country_name')->default('');
            $table->boolean('condition_gender')->default(0);
            $table->smallInteger('condition_ethnicity')->default(0);
            $table->smallInteger('condition_level_of_current_enrollment')->default(0);
            $table->smallInteger('condition_other')->default(0);
            $table->text('detail')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->timestamp('expired_at')->nullable();
            $table->smallInteger('status')->default(0);
            $table->string('seo_title')->nullable()->default('');
            $table->string('seo_keyword')->nullable()->default('');
            $table->string('seo_description')->nullable()->default('');

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
        Schema::dropIfExists('ps_college_scholarships');
    }
}
