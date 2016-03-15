<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchumerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('schumer_types', function (Blueprint $table) {
			$table->increments('schumer_type_id');
			$table->string('type');
			$table->longText('description')->nullable();
			$table->string('slug')->nullable();
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
		Schema::drop('schumer_types');
	}
}
