<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('categories')->insert([
			'category_id' => 1,
			'name' => 'N/A',
			'description' => 'No Category',
			'slug' => 'none',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('categories')->insert([
			'category_id' => 2,
			'name' => 'Balance Transfer',
			'description' => 'Balance Transfer Category',
			'slug' => 'balance-transfer',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('categories')->insert([
			'category_id' => 3,
			'name' => 'Cash Back',
			'description' => 'Cash Back Category',
			'slug' => 'cash-back',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('categories')->insert([
			'category_id' => 4,
			'name' => 'Low Interest',
			'description' => 'Low Interest Category',
			'slug' => 'low-interest',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('categories')->insert([
			'category_id' => 5,
			'name' => 'Student',
			'description' => 'Student Category',
			'slug' => 'student',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('categories')->insert([
			'category_id' => 6,
			'name' => 'Business',
			'description' => 'Business Category',
			'slug' => 'business',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('categories')->insert([
			'category_id' => 7,
			'name' => 'Travel & Airlines',
			'description' => 'Travel and Airlines Category',
			'slug' => 'trave-and-airlines',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
    }
}
