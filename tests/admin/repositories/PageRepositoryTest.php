<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use cccomus\Repositories\Admin\PageRepository;

class PageRepositoryTest extends TestCase
{

	use WithoutMiddleware;

	private $repo;

	public function setUp()
	{
		parent::setUp();
		parent::prepareForTests();
		$this->repo = new PageRepository();
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

		$this->assertInstanceOf('cccomus\Models\Page', $object);
    }

	/**
	 * Test geting table joins
	 */
	public function testGetTablesToJoin() {
		$tables = $this->repo->getTablesToJoin();

		$this->assertEquals(2, count($tables));

	}

	/**
	 * Test getting all objects
	 */
	public function testGetObjects() {
		$objects = $this->repo->getObjects($count = 10, $page = null, $sortBy = 'title', $dir = 'asc', []);

		$this->assertGreaterThan(0, $objects->count());

		foreach ($objects as $object) {
			$this->assertInstanceOf('cccomus\Models\Page', $object);
			break;
		}
	}

	/**
	 * Test getting a single object
	 */
	public function testGetObject() {
		$object = $this->repo->getObject('1');

		$this->assertInstanceOf('cccomus\Models\Page', $object);

	}

	/**
	 * Test object count
	 */
	public function testCount() {
		$count = $this->repo->count();

		$this->assertEquals(3, $count);
	}

	/**
	 * Test updating and creating object.
	 */
	public function testUpdateOrCreate() {
		$attributes = [
			'title' => 'Test Page',
			'category_id' => 2,
			'template_id' => 1,
			'page_type_id' => 1,
			'schumer_template_id' => 3,
			'active' => 1,
			'slug' => 'test-page',
		];

		$object = $this->repo->create($attributes);

		$this->assertInstanceOf('cccomus\Models\Page', $object);

		//Now lets get the object and check values.  Should be id of 8 based on seeder already adding 7.
		$this->assertEquals('Test Page', $object->title);
		$this->assertEquals(2, $object->category_id);
		$this->assertEquals(1, $object->template_id);
		$this->assertEquals(3, $object->schumer_template_id);
		$this->assertEquals(1, $object->active);
		$this->assertEquals('test-page', $object->slug);

		//Run this so we get a failure if we add or subtract database columns
		$this->assertEquals(14, count($object->getAttributes()));

		//Update the first user with the above user's attributes.
		$status = $this->repo->update(1, $attributes);

		$this->assertTrue($status);

		$object = $this->repo->getObject(1);

		$this->assertEquals('Test Page', $object->title);
		$this->assertEquals(2, $object->category_id);
		$this->assertEquals(1, $object->template_id);
		$this->assertEquals(3, $object->schumer_template_id);
		$this->assertEquals(1, $object->active);
		$this->assertEquals('test-page', $object->slug);

	}

	/**
	 * Test deleting an object
	 */
	public function testDeleteObject() {
		$status = $this->repo->deleteObject(1);

		$this->assertEquals(1, $status);
	}

}
