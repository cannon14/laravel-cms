<?php

use Illuminate\Database\Seeder;

class AclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('acl')->insert([
			'acl_id' => 1,
			'role' => 'super',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00',
		]);

		DB::table('acl')->insert([
			'acl_id' => 2,
			'role' => 'admin',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00',
		]);

		DB::table('acl')->insert([
			'acl_id' => 3,
			'role' => 'user',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00',
		]);
    }
}
