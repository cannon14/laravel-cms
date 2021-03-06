<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('user_id');
			$table->integer('acl_id')->unsigned();
			$table->foreign('acl_id')->references('acl_id')->on('acl');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('username');
			$table->string('password');
			$table->tinyInteger('active');
			$table->string('remember_token', 255)->nullable();
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
        Schema::drop('users');
    }
}
