<?php

use Illuminate\Database\Seeder;

class NodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('nodes')->insert([
			'node_id' => 1,
			'parent_id' => 0,
			'title' => '/',
			'type' => 'directory',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('nodes')->insert([
			'node_id' => 2,
			'parent_id' => 1,
			'title' => 'Pages',
			'type' => 'directory',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('nodes')->insert([
			'node_id' => 7,
			'parent_id' => 2,
			'title' => 'Balance Transfer',
			'type' => 'file',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('nodes')->insert([
			'node_id' => 8,
			'parent_id' => 2,
			'title' => 'Cash Back',
			'type' => 'file',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
	}
}
