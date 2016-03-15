<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		DB::table('pages')->insert([
			'page_id' => 1,
			'title' => 'Balance Transfer',
			'page_type_id' => 2,
			'category_id' => 2,
			'template_id' => 1,
			'schumer_template_id' => 2,
			'active' => 1,
			'slug' => 'balance-transfer',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('pages')->insert([
			'page_id' => 2,
			'title' => 'Cash Back',
			'page_type_id' => 2,
			'category_id' => 3,
			'template_id' => 1,
			'schumer_template_id' => 3,
			'slug' => 'cash-back',
			'active' => 1,
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('pages')->insert([
			'page_id' => 3,
			'title' => 'Low Interest',
			'page_type_id' => 2,
			'category_id' => 4,
			'template_id' => 1,
			'schumer_template_id' => 3,
			'slug' => 'cash-back',
			'active' => 1,
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
    }
}
