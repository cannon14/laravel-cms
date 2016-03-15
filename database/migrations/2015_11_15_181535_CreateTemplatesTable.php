<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('templates', function (Blueprint $table) {
			$table->increments('template_id');
			$table->string('name');
			$table->string('filename');
			$table->string('path');
			$table->string('type');
			$table->integer('template_type_id');
			$table->longText('description')->nullable();
			$table->string('version')->nullable();
			$table->date('date');
			$table->string('slug');
			$table->boolean('orphaned_file')->default(0);
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
		Schema::drop('templates');
	}
}
