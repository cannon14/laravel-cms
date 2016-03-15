<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use cccomus\Repositories\Admin\UserRepository;

class UserRepositoryTest extends TestCase
{

	use WithoutMiddleware;

	private $repo;

	public function setUp()
	{
		parent::setUp();
		parent::prepareForTests();
		$this->repo = new UserRepository();
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
	 * Test creating object
	 */
    public function testCreateObject()
    {
		$object = $this->repo->createObject();

		$this->assertInstanceOf('cccomus\Models\User', $object);
    }

	/**
	 * Test geting table joins
	 */
	public function testGetTablesToJoin() {
		$tables = $this->repo->getTablesToJoin();

		$this->assertArrayHasKey('acl', $tables);

	}

	/**
	 * Test getting all objects
	 */
	public function testGetObjects() {
		$objects = $this->repo->getObjects($count = 10, $page = 0, $sortBy = 'last_name', $dir = 'asc', []);

		$this->assertGreaterThan(0, $objects->count());

		foreach ($objects as $object) {
			$this->assertInstanceOf('cccomus\Models\User', $object);
			break;
		}
	}

	/**
	 * Test getting a single object
	 */
	public function testGetObject() {
		$object = $this->repo->getObject('1');

		$this->assertInstanceOf('cccomus\Models\User', $object);

	}

	/**
	 * Test object count
	 */
	public function testCount() {
		$count = $this->repo->count();

		$this->assertGreaterThan(0, $count);
	}

	/**
	 * Test updating and creating object.
	 */
	public function testUpdateOrCreate() {
		$attributes = [
			'acl_id' => 2,
			'first_name' => 'Jane',
			'last_name' => 'Doe',
			'email' => 'jane.doe@creditcards.com',
			'username' => 'jane.doe',
			'password' => 'password',
			'active' => 1
		];

		$status = $this->repo->updateOrCreate($attributes, null);

		$this->assertTrue($status);

		//Now lets get the user and check values.  Should be id of 2 based on seeder already adding 1.
		$user = $this->repo->getObject(2);

		$this->assertEquals(2, $user->acl_id);
		$this->assertEquals('Jane', $user->first_name);
		$this->assertEquals('Doe', $user->last_name);
		$this->assertEquals('jane.doe@creditcards.com', $user->email);
		$this->assertEquals('jane.doe', $user->username);
		$this->assertEquals(1, $user->active);

		//Run this so we get a failure if we add or subtract database columns
		$this->assertEquals(12, count($user->getAttributes()));

		//Update the first user with the above user's attributes.
		$status = $this->repo->updateOrCreate($attributes, 1);

		$this->assertTrue($status);

		$user = $this->repo->getObject(1);

		$this->assertEquals(2, $user->acl_id);
		$this->assertEquals('Jane', $user->first_name);
		$this->assertEquals('Doe', $user->last_name);
		$this->assertEquals('jane.doe@creditcards.com', $user->email);
		$this->assertEquals('jane.doe', $user->username);
		$this->assertEquals(1, $user->active);


	}

	/**
	 * Test deleting an object
	 */
	public function testDeleteObject() {
		$status = $this->repo->deleteObject(1);

		$this->assertEquals(1, $status);
	}

}
