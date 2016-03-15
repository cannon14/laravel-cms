<?php

use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('templates')->insert([
			'template_id' => 1,
			'name' => 'Card Category Page',
			'filename' => 'card-category-page.php',
			'path' => '',
			'description' => 'Standard Credit Card Category Page',
			'template_type_id' => 2,
			'type' => 'category-page',
			'version' => '1.0.0',
			'slug'=>'card-category-page',
			'orphaned_file'=>0,
			'date' => '2015-11-20',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('templates')->insert([
			'template_id' => 2,
			'name' => 'Balance Transfer Schumer Box',
			'filename' => 'balance-transfer.blade.php',
			'path' => '',
			'description' => 'Standard Credit Card Category Page',
			'template_type_id' => 2,
			'type' => 'category-page',
			'version' => '1.0.0',
			'date' => '2015-11-20',
			'slug'=>'balance-transfer',
			'orphaned_file'=>0,
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('templates')->insert([
			'template_id' => 3,
			'name' => 'Standard Schumer Box',
			'filename' => 'standard.blade.php',
			'path' => '',
			'description' => 'Standard Schumer Box',
			'template_type_id' => 2,
			'type' => 'category-page',
			'version' => '1.0.0',
			'date' => '2015-11-20',
			'slug'=>'balance-transfer',
			'orphaned_file'=>0,
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
    }
}
