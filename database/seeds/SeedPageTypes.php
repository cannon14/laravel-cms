<?php

use Illuminate\Database\Seeder;

class SeedPageTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('page_types')->insert([
			'page_type_id' => 1,
			'name' => 'Home',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('page_types')->insert([
			'page_type_id' => 2,
			'name' => 'Category',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('page_types')->insert([
			'page_type_id' => 3,
			'name' => 'Product Details',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('page_types')->insert([
			'page_type_id' => 4,
			'name' => 'Top Offers',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('page_types')->insert([
			'page_type_id' => 5,
			'name' => 'Best Cards',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
    }
}
