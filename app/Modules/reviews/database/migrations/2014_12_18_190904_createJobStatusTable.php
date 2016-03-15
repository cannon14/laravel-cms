<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('jobs', function ($table) {
			$table->increments('job_id');
			$table->integer('issuer_id')->unsigned();
			$table->foreign('issuer_id')->references('issuer_id')->on('issuers');
			$table->string('file_name', 64);
			$table->integer('total_records');
			$table->integer('processed')->default(0);
			$table->integer('successful')->default(0);
			$table->integer('errors')->default(0);
			$table->tinyInteger('isComplete')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('jobs');
	}

}
