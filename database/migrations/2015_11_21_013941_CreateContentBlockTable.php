<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('content_blocks', function (Blueprint $table) {
			$table->increments('content_block_id');
			$table->string('name');
			$table->text('description')->nullable();
			$table->longText('content')->nullable();
			$table->tinyInteger('active');
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
        Schema::drop('content_blocks');
    }
}
