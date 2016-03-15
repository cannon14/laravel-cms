<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->increments('category_id');
			$table->string('name');
			$table->string('image')->nullable();
			$table->longText('description')->nullable();
			$table->string('slug');
			$table->tinyInteger('active')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('categories');
	}
}
