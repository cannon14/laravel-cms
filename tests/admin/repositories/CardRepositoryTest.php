<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use cccomus\Repositories\Admin\CardRepository;

class CardRepositoryTest extends TestCase
{

	use WithoutMiddleware;

	private $repo;

	public function setUp()
	{
		parent::setUp();
		parent::prepareForTests();
		$this->repo = new CardRepository();
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

		$this->assertInstanceOf('cccomus\Models\Card', $object);
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
			$this->assertInstanceOf('cccomus\Models\Card', $object);
			break;
		}
	}

	/**
	 * Test getting a single object
	 */
	public function testGetObject() {
		$object = $this->repo->getObject('12345678');

		$this->assertInstanceOf('cccomus\Models\Card', $object);

	}

	/**
	 * Test object count
	 */
	public function testCount() {
		$count = $this->repo->count([]);

		$this->assertEquals(2, $count);
	}

	/**
	 * Test updating and creating object.
	 */
	public function testUpdateOrCreate() {
		$attributes = [
			'id' => '5011',
			'active' => 1
		];

		$status = $this->repo->createFromFeed($attributes);

		$this->assertTrue($status);

		//Now lets get the object and check values.
		$object = $this->repo->getObject('5011');

		$this->assertEquals('5011', $object->card_id);
		$this->assertEquals(1, $object->active);

		//Run this so we get a failure if we add or subtract database columns
		$this->assertEquals(56, count($object->getAttributes()));

		//Update the first user with the above user's attributes.
		$status = $this->repo->update( '12345678', $attributes);

		$this->assertTrue($status);

		$object = $this->repo->getObject('12345678');

		$this->assertEquals(1, $object->active);

	}

	/**
	 * Test deleting an object
	 */
	public function testDeleteObject() {
		$status = $this->repo->deleteObject('12345678');

		$this->assertEquals(1, $status);
	}

}
