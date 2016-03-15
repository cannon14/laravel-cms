<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use cccomus\Repositories\Admin\IssuerRepository;

class IssuerRepositoryTest extends TestCase
{

	use WithoutMiddleware;

	private $repo;

	public function setUp()
	{
		parent::setUp();
		parent::prepareForTests();
		$this->repo = new IssuerRepository();
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

		$this->assertInstanceOf('cccomus\Models\Issuer', $object);
    }

	/**
	 * Test geting table joins
	 */
	public function testGetTablesToJoin() {
		$tables = $this->repo->getTablesToJoin();

		$this->assertEmpty($tables);

	}

	/**
	 * Test getting all objects
	 */
	public function testGetObjects() {
		$objects = $this->repo->getObjects($count = 10, $page = 0, $sortBy = 'name', $dir = 'asc', []);

		$this->assertGreaterThan(0, $objects->count());

		foreach ($objects as $object) {
			$this->assertInstanceOf('cccomus\Models\Issuer', $object);
			break;
		}
	}

	/**
	 * Test getting a single object
	 */
	public function testGetObject() {
		$object = $this->repo->getObject('1');

		$this->assertInstanceOf('cccomus\Models\Issuer', $object);

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
			'name' => 'Test Issuer',
			'slug' => 'test-merchant',
			'active' => 1
		];

		$status = $this->repo->create($attributes);

		$this->assertTrue($status);

		//Now lets get the object and check values.  Should be id of 8 based on seeder already adding 7.
		$object = $this->repo->getObject(7);

		$this->assertEquals('Test Issuer', $object->name);
		$this->assertEquals('test-merchant', $object->slug);
		$this->assertEquals(1, $object->active);

		//Run this so we get a failure if we add or subtract database columns
		$this->assertEquals(8, count($object->getAttributes()));

		//Update the first user with the above user's attributes.
		$status = $this->repo->update(1, $attributes);

		$this->assertTrue($status);

		$object = $this->repo->getObject(1);

		$this->assertEquals('Test Issuer', $object->name);
		$this->assertEquals('test-merchant', $object->slug);
		$this->assertEquals(1, $object->active);

	}

	/**
	 * Test deleting an object
	 */
	public function testDeleteObject() {
		$status = $this->repo->deleteObject(1);

		$this->assertEquals(1, $status);
	}

}
