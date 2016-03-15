<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('media', function (Blueprint $table) {
			$table->increments('media_id');
			$table->integer('media_type_id')->unsigned();
			$table->foreign('media_type_id')->references('media_type_id')->on('media_types');
			$table->string('name');
			$table->string('path');
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
        Schema::drop('media');
    }
}
