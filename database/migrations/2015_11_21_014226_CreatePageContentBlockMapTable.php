<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageContentBlockMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('page_content_block_map', function (Blueprint $table) {
			$table->increments('map_id');
			$table->integer('page_id')->unsigned();
			$table->foreign('page_id')->references('page_id')->on('pages');
			$table->integer('content_block_id')->unsigned();
			$table->foreign('content_block_id')->references('content_block_id')->on('content_blocks');
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
		Schema::drop('page_content_block_map');
    }
}
