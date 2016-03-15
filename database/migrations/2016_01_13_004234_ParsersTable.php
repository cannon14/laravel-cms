<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('parsers', function (Blueprint $table) {
			$table->increments('parser_id');
			$table->integer('issuer_id')->unsigned();
			$table->foreign('issuer_id')->references('issuer_id')->on('issuers');
			$table->text('columns');
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
        //
    }
}
