<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('pages', function (Blueprint $table) {
			$table->increments('page_id');
			$table->string('title');
			$table->string('image')->nullable();
			$table->integer('page_type_id')->unsigned();
			$table->foreign('page_type_id')->references('page_type_id')->on('page_types');
			$table->integer('category_id')->unsigned()->nullable();
			$table->foreign('category_id')->references('category_id')->on('categories');
			$table->integer('template_id')->unsigned()->nullable();
			$table->foreign('template_id')->references('template_id')->on('templates');
			$table->integer('schumer_template_id')->unsigned()->nullable();
			$table->foreign('schumer_template_id')->references('template_id')->on('templates');
			$table->longText('description')->nullable();
			$table->longText('meta_description')->nullable();
			$table->string('meta_tags')->nullable();
			$table->string('slug');
			$table->tinyInteger('active')->default(0);
			$table->softDeletes();
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
		Schema::drop('pages');
	}
}
