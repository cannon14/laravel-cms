<?php

use Illuminate\Database\Seeder;

class ContentBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('content_blocks')->insert([
			'content_block_id' => 1,
			'name' => 'Advertiser Disclosure',
			'description' => 'Advertiser Disclosure',
			'content' => 'Advertiser Disclosure',
			'active' => 1,
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
    }
}
