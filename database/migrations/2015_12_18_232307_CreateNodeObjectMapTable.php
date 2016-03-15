<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodeObjectMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('node_object_map', function (Blueprint $table) {
			$table->increments('map_id');
			$table->integer('node_id')->unsigned();
			$table->foreign('node_id')->references('node_id')->on('nodes');
			$table->integer('object_id');
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
        Schema::drop('node_object_map');
    }
}
