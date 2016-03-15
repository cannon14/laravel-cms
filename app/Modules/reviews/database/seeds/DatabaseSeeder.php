<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $this->call('AclTableSeeder');
		$this->call('UsersTableSeeder');
        $this->call('IssuersTableSeeder');
	}

}

class AclTableSeeder extends Seeder {

    public function run() {

        DB::table('acl')->delete();

        Acl::create(array('acl_id'=>1, 'acl_value'=>'user'));
        Acl::create(array('acl_id'=>2, 'acl_value'=>'admin'));
        Acl::create(array('acl_id'=>3, 'acl_value'=>'master'));
    }
}

class UsersTableSeeder extends Seeder {

    public function run() {

        DB::table('users')->delete();

        User::create(array('acl_id'=>1, 'username'=>'cccom', 'password'=>'$2y$10$xbsB49V5b9YM1SkZFEdwNernztahyaM19WtfPq2XGRjgZTZoEfrba'));
    }
}

class IssuersTableSeeder extends Seeder {

    public function run() {

        DB::table('issuers')->delete();

        Issuer::create(array('issuer_id'=>1, 'issuer_name'=>'Discover'));
        Issuer::create(array('issuer_id'=>2, 'issuer_name'=>'Capital One'));
        Issuer::create(array('issuer_id'=>3, 'issuer_name'=>'Chase'));
    }
}

class MapsTableSeeder extends Seeder {

    public function run() {

        DB::table('cccom_product_id_map')->delete();

        Map::create(array('cccom_product_map_id'=>1, 'product_name'=>'Capital One® Quicksilver® Cash Rewards Credit', 'cccom_product_id'=>'22100504', 'alternate_product_id'=>'QUICKSILVER'));
        Map::create(array('cccom_product_map_id'=>2, 'product_name'=>'Discover it®', 'cccom_product_id'=>'22189517', 'alternate_product_id'=>'DCIT'));
        Map::create(array('cccom_product_map_id'=>3, 'product_name'=>'Capital One® Spark® Cash Select for Business', 'cccom_product_id'=>'22105983', 'alternate_product_id'=>'sparkcash'));
    }
}