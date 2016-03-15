<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('product_links', function (Blueprint $table) {
			$table->increments('link_id');
			$table->integer('product_id')->unsigned();
			$table->foreign('product_id')->references('card_id')->on('cards');
			$table->integer('link_type_id')->unsigned();
			$table->foreign('link_type_id')->references('link_type_id')->on('link_types');
			$table->integer('device_type_id')->unsigned();
			$table->foreign('device_type_id')->references('device_type_id')->on('device_types');
			$table->string('url', 255);
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
        Schema::drop('product_links');
    }
}
