<?php

use Illuminate\Database\Seeder;

class IssuerSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('issuers')->insert([
			'issuer_id' => 1,
			'name' => 'Discover',
			'slug' => 'discover',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('issuers')->insert([
			'issuer_id' => 2,
			'name' => 'American Express',
			'slug' => 'american-express',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('issuers')->insert([
			'issuer_id' => 3,
			'name' => 'Capitalone',
			'slug' => 'capitalone',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('issuers')->insert([
			'issuer_id' => 4,
			'name' => 'Chase',
			'slug' => 'chase',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('issuers')->insert([
			'issuer_id' => 5,
			'name' => 'Citi',
			'slug' => 'citi',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('issuers')->insert([
			'issuer_id' => 6,
			'name' => 'Usaa',
			'slug' => 'usaa',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
	}
}
