<?php

use Illuminate\Database\Seeder;

class SchumerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('schumer_types')->insert([
			'schumer_type_id' => 1,
			'type' => 'None',
			'description' => 'No Schumer Box',
			'slug' => 'none',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('schumer_types')->insert([
			'schumer_type_id' => 2,
			'type' => 'Standard',
			'description' => 'Standard Schumer Box',
			'slug' => 'basic',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('schumer_types')->insert([
			'schumer_type_id' => 3,
			'type' => 'Balance Transfer',
			'description' => 'Balance Transfer Schumer Box',
			'slug' => 'home',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

	}
}
