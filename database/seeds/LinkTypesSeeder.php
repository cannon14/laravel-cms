<?php

use Illuminate\Database\Seeder;

class LinkTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('link_types')->insert([
			'name' => 'card',
			'description' => 'Default - Card Link',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('link_types')->insert([
			'name' => 'account',
			'description' => 'Account type link',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('link_types')->insert([
			'name' => 'website',
			'description' => 'Match card and website',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('link_types')->insert([
			'name' => 'terms',
			'description' => '"See terms and conditions" link',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
    }
}
