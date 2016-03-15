<?php

use Illuminate\Database\Seeder;

class MediaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('media_types')->insert([
			'media_type_id' => 1,
			'name' => 'image',
		]);

		DB::table('media_types')->insert([
			'media_type_id' => 2,
			'name' => 'video',
		]);
    }
}
