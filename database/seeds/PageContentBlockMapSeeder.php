<?php

use Illuminate\Database\Seeder;

class PageContentBlockMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('page_content_block_map')->insert([
			'map_id' => 1,
			'page_id' => 1,
			'content_block_id' => 1,
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
    }
}
