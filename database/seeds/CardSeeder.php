<?php

use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('cards')->insert([
			'card_id' => 12345678,
			'last_updated_on_feed' => '0000-00-00 00:00:00',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00',
		]);

		DB::table('cards')->insert([
			'card_id' => 87654321,
			'last_updated_on_feed' => '0000-00-00 00:00:00',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00',
		]);
    }
}
