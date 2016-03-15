<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardCategoryMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('card_category_map', function (Blueprint $table) {
			$table->increments('map_id');
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('category_id')->on('categories');
			$table->integer('card_id')->unsigned();
			$table->foreign('card_id')->references('card_id')->on('cards');
			$table->string('position_link');
			$table->integer('rank')->nullable();
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
        Schema::drop('card_category_map');
    }
}
