<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (BluePrint $table) {
            $table->string('review_id', 64);
            $table->primary('review_id');
            $table->integer('issuer_id')->unsigned();
            $table->foreign('issuer_id')->references('issuer_id')->on('issuers');
            $table->string('review_title', 64)->nullable();
            $table->date('submission_date')->nullable();
            $table->string('product_id', 64);
            $table->string('product_name', 255)->nullable();
            $table->string('user_nickname', 64)->nullable();
            $table->string('age', 64)->nullable();
            $table->string('member_since', 45)->nullable();
            $table->string('recommend_to_a_friend', 3)->nullable();
            $table->string('user_location', 64)->nullable();
            $table->text('review_text')->nullable();
            $table->smallInteger('overall_rating')->nullable();
            $table->smallInteger('account_benefits')->nullable();
            $table->smallInteger('online_experience')->nullable();
            $table->smallInteger('customer_service')->nullable();
            $table->smallInteger('rewards_program')->nullable();
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
        Schema::drop('reviews');
    }
}
