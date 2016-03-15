<?php

use Illuminate\Database\Seeder;

class TemplateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('template_types')->insert([
            'template_type_id' => 1,
            'type' => 'Layouts',
			'path' => '/templates/layouts/',
            'created_at' => '0000-00-00 00:00:00',
            'updated_at' => '0000-00-00 00:00:00'
        ]);

        DB::table('template_types')->insert([
            'template_type_id' => 2,
            'type' => 'Pages',
			'path' => '/templates/pages/',
            'created_at' => '0000-00-00 00:00:00',
            'updated_at' => '0000-00-00 00:00:00'
        ]);

        DB::table('template_types')->insert([
            'template_type_id' => 3,
            'type' => 'Includes',
			'path' => '/templates/partials/includes/',
            'created_at' => '0000-00-00 00:00:00',
            'updated_at' => '0000-00-00 00:00:00'
        ]);

		DB::table('template_types')->insert([
			'template_type_id' => 4,
			'type' => 'Gutters',
			'path' => '/templates/partials/gutters/',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);

		DB::table('template_types')->insert([
			'template_type_id' => 5,
			'type' => 'Schumers',
			'path' => '/templates/partials/schumers/',
			'created_at' => '0000-00-00 00:00:00',
			'updated_at' => '0000-00-00 00:00:00'
		]);
    }
}
