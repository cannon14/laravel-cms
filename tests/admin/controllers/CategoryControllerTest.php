<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryControllerTest extends TestCase {
	use WithoutMiddleware;

	public function setUp() {
		parent::setUp();
		parent::prepareForTests();
	}

	/**
	 * Tear down for tests
	 */
	public function tearDown() {
		Artisan::call('migrate:reset');
		parent::tearDown();
	}

	/**
	 * Test users route.
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->visit('/admin/categories')
			->see('Categories');
	}

	/**
	 * Test users ajax route
	 */
	public function testGetCategories() {

		$attributes['count'] = 10;
		$attributes['page'] = 0;
		$attributes['sorting'] = ['name' => 'asc'];

		$response = $this->call('GET', '/admin/categories/ajax', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test users create route.
	 *
	 * @return void
	 */
	public function testCreate() {

		$this->visit('/admin/categories/create')
			->see('Create Category');
	}

	/**
	 * Test both store and update routes.
	 */
	public function testStoreAndUpdate() {

		$attributes = [
			'active' => 1,
			'name' => 'Secured',
			'description' => 'Secured Category',
			'slug' => 'secured',
		];

		//Create the category...store
		$response = $this->call('POST', '/admin/categories', $attributes);

		$this->assertEquals(200, $response->status());

		//Update a category.
		$response = $this->call('PUT', '/admin/categories/1', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test edit route
	 */
	public function testEdit() {

		$response = $this->call('GET', '/admin/categories/1/edit');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test delete route.
	 */
	public function testDelete() {

		$response = $this->call('DELETE', '/admin/categories/1');

		$this->assertEquals(200, $response->status());
	}
}

