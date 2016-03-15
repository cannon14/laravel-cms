<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IssuerControllerTest extends TestCase
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
	 * Test merchants route
	 */
	public function testIndex() {
		$response = $this->call('GET', '/admin/issuers');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test merchants ajax route
	 */
	public function testGetIssuers() {
		$attributes['count'] = 10;
		$attributes['page'] = 0;
		$attributes['sorting'] = ['name' => 'asc'];

		$response = $this->call('GET', '/admin/issuers/ajax', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test create route
	 */
	public function testCreate() {
		$response = $this->call('GET', '/admin/issuers/create');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test edit route
	 */
	public function testEdit() {
		$response = $this->call('GET', '/admin/issuers/1/edit');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test both store and update routes.
	 */
	public function testStoreAndUpdate() {

		$attributes = [
			'name' => 'test',
			'active' => 1
		];

		//Create the merchant...store
		$response = $this->call('POST', '/admin/issuers', $attributes);

		$this->assertEquals(200, $response->status());

		//Update the merchant.
		$response = $this->call('PUT', '/admin/issuers/1', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test get merchant ajax route
	 */
	public function testGetIssuer() {
		$response = $this->call('GET', 'admin/issuers/edit/issuer/1');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test delete route
	 */
	public function testDelete() {
		$response = $this->call('DELETE', 'admin/issuers/1');

		$this->assertEquals(200, $response->status());
	}

}
