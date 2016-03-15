<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{

	use WithoutMiddleware;

	public function setUp()
	{
		parent::setUp();
		parent::prepareForTests();
	}

	/**
	 * Tear down for tests
	 */
	public function tearDown()
	{
		Artisan::call('migrate:reset');
		parent::tearDown();
	}

    /**
     * Test users route.
     *
     * @return void
     */
    public function testIndex()
    {
		$this->visit('/admin/users')
			->see('Users');
    }

	/**
	 * Test users ajax route
	 */
	public function testGetUsers() {

		$attributes['count'] = 10;
		$attributes['page'] = 0;
		$attributes['sorting']=['first_name'=>'asc'];

		$response = $this->call('GET', '/admin/users/ajax', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test users create route.
	 *
	 * @return void
	 */
	public function testCreate()
	{
		$this->visit('/admin/users/create')
			->see('Create User');
	}

	/**
	 * Test both store and update routes.
	 */
	public function testStoreAndUpdate() {
		$attributes = [
			'acl_id' => 2,
			'first_name' => 'David',
			'last_name' => 'Cannon',
			'email' => 'david.cannon@creditcards.com',
			'username' => 'cannon14',
			'password' => 'Megadeth1',
			'password_confirmation' => 'Megadeth1',
			'active' => '1'
		];

		//Create the users...store
		$response = $this->call('POST', '/admin/users/', $attributes);

		$this->assertEquals(200, $response->status());

		//Update the user.
		$response = $this->call('PUT', '/admin/users/1', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test edit route
	 */
	public function testEdit() {
		$response = $this->call('GET', '/admin/users/1/edit');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test delete route.
	 */
	public function testDelete() {
		$response = $this->call('DELETE', '/admin/users/1');

		$this->assertEquals(200, $response->status());
	}

}
