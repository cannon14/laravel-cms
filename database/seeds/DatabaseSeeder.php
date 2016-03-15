<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
		$this->call(SchumerTypeSeeder::class);
		$this->call(CategorySeeder::class);
        $this->call(FeedsSeeder::class);
		$this->call(NodeSeeder::class);
		$this->call(TemplateTypeSeeder::class);
		$this->call(TemplateSeeder::class);
		$this->call(CardSeeder::class);
		$this->call(ContentBlockSeeder::class);
		$this->call(SeedPageTypes::class);
		$this->call(PageSeeder::class);
		$this->call(PageContentBlockMapSeeder::class);
		$this->call(IssuerSeeder::class);
		$this->call(DeviceTypesSeeder::class);
		$this->call(LinkTypesSeeder::class);
		$this->call(AclSeeder::class);
		$this->call(UserTableSeeder::class);
		$this->call(MediaTypeSeeder::class);
        Model::reguard();
    }
}
