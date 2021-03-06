<?php

use Illuminate\Database\Seeder;

class FeedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('feeds')->insert([
            'name' => 'Linkoffers Products',
            'url' => 'http://feeds.linkoffers.com/api/v1/products',
            'key' => '2136F04D-157C-47BB-A440-FF15DE00ECD8',
			'active' => 1,
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00',
        ]);

        DB::table('feeds')->insert([
            'name' => 'Linkoffers Categories',
            'url'  => 'http://feeds.linkoffers.com/api/v1/categories',
            'key'  => '2136F04D-157C-47BB-A440-FF15DE00ECD8',
            'active' => 1,
            'created_at' => '0000-00-00 00:00:00',
            'updated_at' => '0000-00-00 00:00:00'
        ]);
    }
}
