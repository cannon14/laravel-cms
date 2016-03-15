<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
			'user_id'=>1,
			'first_name'=> 'John',
			'last_name'=> 'Doe',
			'email' => 'john.doe@creditcards.com',
			'username' => 'john.doe',
			'password'=>'$2y$10$ZHEJTTrnBLNwZzyo3ArNDOqgHfZ5IdVLkztyzkgglGLU.iEvcsXxS',
			'acl_id' => 2,
			'active' => 1,
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
    }
}
