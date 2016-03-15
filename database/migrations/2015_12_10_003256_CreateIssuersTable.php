<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('issuers', function (Blueprint $table) {
			$table->increments('issuer_id');
			$table->string('name');
			$table->string('logo', 255)->nullable();
			$table->string('slug')->nullable();
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
        Schema::drop('issuers');
    }
}
