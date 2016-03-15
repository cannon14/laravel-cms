<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_reviews', function (Blueprint $table) {
            $table->increments('review_id');
            $table->integer('cccom_product_id');
            $table->string('member_name', 64);
            $table->string('member_title', 64);
            $table->string('member_image_name', 255);
            $table->string('member_url', 255)->nullable();
            $table->string('review_title', 255)->nullable();
            $table->text('review');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('staff_reviews');
    }
}
