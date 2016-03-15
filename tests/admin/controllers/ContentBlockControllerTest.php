<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContentBlockControllerTest extends TestCase
{

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
	 * Test content-blocks route
	 */
	public function testIndex() {
		$this->visit('/admin/content-blocks')
			->see('Content Blocks');
	}

	/**
	 * Test content blocks list route.
	 */
	public function testContentBlocksList() {
		$response = $this->call('GET', '/admin/content-blocks/lists');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test content blocks ajax route.
	 */
	public function testContentBlocksAjax() {

		$attributes['count'] = 10;
		$attributes['page'] = 0;
		$attributes['sorting']=['name'=>'asc'];

		$response = $this->call('GET', '/admin/content-blocks/ajax', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test create route
	 */
	public function testCreate() {
		$response = $this->call('GET', '/admin/content-blocks/create');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test content-block store route
	 */
	public function testStoreAndUpdate() {
		$attributes = [
			'name' => 'Test Block'
		];

		//Store
		$response = $this->call('POST', '/admin/content-blocks/store', $attributes);

		$this->assertEquals(200, $response->status());

		//Update
		$response = $this->call('PUT', '/admin/content-blocks/update/1', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test edit route
	 */
	public function testEdit() {
		$response = $this->call('GET', '/admin/content-blocks/1');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test delete route
	 */
	public function testDelete() {
		$response = $this->call('DELETE', '/admin/content-blocks/1');

		$this->assertEquals(200, $response->status());
	}

}
