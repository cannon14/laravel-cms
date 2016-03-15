<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErrorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('errors', function ($table) {
			$table->increments('error_id');
			$table->integer('job_id');
			$table->string('review_id', 64);
			$table->integer('error_code');
			$table->text('error_message');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('errors');
	}

}
