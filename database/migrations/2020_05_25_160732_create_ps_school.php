<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsSchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ps_colleges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organization_id')->nullable()->default(0);
            $table->integer('member_id')->nullable()->default(0);
            $table->string('name');
            $table->string('slug');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->integer('district_id')->nullable()->default(0);
            $table->string('district_name')->nullable()->default('');
            $table->integer('city_id')->nullable()->default(0);
            $table->string('city_name')->nullable()->default('');
            $table->integer('country_id')->nullable()->default(0);
            $table->string('country_name')->nullable()->default('');
            $table->integer('student_statistics_tuition')->nullable()->default(0);
            $table->integer('student_statistics_dorm_fee')->nullable()->default(0);
            $table->integer('student_statistics_total_student')->nullable()->default(0);
            $table->integer('student_statistics_international_student')->nullable()->default(0);
            $table->integer('image_id')->nullable()->default(0);
            $table->string('image_url')->nullable()->default('');
            $table->integer('cover_id')->nullable()->default(0);
            $table->string('cover_url')->nullable()->default('');
            $table->integer('views')->nullable()->default(0);
            $table->text('summary')->nullable();
            $table->text('detail_general')->nullable();
            $table->text('detail_applicant_eligibility')->nullable();
            $table->text('detail_admission')->nullable();
            $table->string('seo_title')->nullable()->default('');
            $table->string('seo_keyword')->nullable()->default('');
            $table->string('seo_description')->nullable()->default('');
            $table->smallInteger('status')->nullable()->default(0);
            $table->integer('creator_id')->nullable()->default(0);
            $table->integer('editor_id')->nullable()->default(0);

            $table->index('deleted_at', 'deleted_at');
            $table->index('status', 'status');
            $table->index('organization_id', 'organization_id');
            $table->index('member_id', 'member_id');
            $table->index('country_id', 'country_id');
            $table->index('city_id', 'city_id');
            $table->index('district_id', 'district_id');

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
        Schema::dropIfExists('ps_colleges');
    }
}
