<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateProductToProductMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_id_to_alt_product_id_map', function (Blueprint $table) {
            $table->increments('map_id');
			$table->string('product_name');
			$table->string('product_id');
            $table->string('alt_product_id');
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
        Schema::drop('product_id_to_alt_product_id_map');
    }
}
