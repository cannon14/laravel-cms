<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardPageMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('card_page_map', function (Blueprint $table) {
			$table->increments('map_id');
			$table->integer('page_id')->unsigned();
			$table->foreign('page_id')->references('page_id')->on('pages');
			$table->integer('card_id')->unsigned();
			$table->foreign('card_id')->references('card_id')->on('cards');
			$table->integer('order')->nullable();
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
		Schema::drop('card_page_map');
	}
}
