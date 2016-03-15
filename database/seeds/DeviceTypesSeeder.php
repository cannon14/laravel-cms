<?php

use Illuminate\Database\Seeder;

class DeviceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('device_types')->insert([
			'name' => 'desktop',
			'description' => 'Default',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('device_types')->insert([
			'name' => 'mobile',
			'description' => 'Mobile Devices',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

	}
}
