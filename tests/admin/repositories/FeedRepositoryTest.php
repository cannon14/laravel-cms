<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use cccomus\Repositories\Admin\FeedRepository;

class FeedRepositoryTest extends TestCase
{

	use WithoutMiddleware;

	private $repo;

	public function setUp()
	{
		parent::setUp();
		parent::prepareForTests();
		$this->repo = new FeedRepository();
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

		$this->assertInstanceOf('cccomus\Models\Feed', $object);
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
			$this->assertInstanceOf('cccomus\Models\Feed', $object);
			break;
		}
	}

	/**
	 * Test getting a single object
	 */
	public function testGetObject() {
		$object = $this->repo->getObject('1');

		$this->assertInstanceOf('cccomus\Models\Feed', $object);

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
			'name' => 'test',
			'url' => 'test.test.com/api/v1',
			'key' => '12345678',
			'active' => 1
		];

		$status = $this->repo->updateOrCreate($attributes, null);

		$this->assertTrue($status);

		//Now lets get the object and check values.  Should be id of 2 based on seeder already adding 1.
		$object = $this->repo->getObject(3);

		$this->assertEquals('test', $object->name);
		$this->assertEquals('test.test.com/api/v1', $object->url);
		$this->assertEquals('12345678', $object->key);
		$this->assertEquals(1, $object->active);

		//Run this so we get a failure if we add or subtract database columns
		$this->assertEquals(8, count($object->getAttributes()));

		//Update the first user with the above user's attributes.
		$status = $this->repo->updateOrCreate($attributes, 1);

		$this->assertTrue($status);

		$object = $this->repo->getObject(1);

		$this->assertEquals('test', $object->name);
		$this->assertEquals('test.test.com/api/v1', $object->url);
		$this->assertEquals('12345678', $object->key);
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
