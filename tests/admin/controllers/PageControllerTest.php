<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PageControllerTest extends TestCase
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
	 * Test call to pages view
	 */
    public function testIndex()
    {
		$this->visit('/admin/pages')
			->see('Pages');
    }

	/**
	 * Test call to get pages route
	 */
	public function testGetPages() {

		$attributes['count'] = 10;
		$attributes['page'] = 0;
		$attributes['sorting']=['title'=>'asc'];

		$response = $this->call('GET', '/admin/pages/ajax', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test call to get pages create route
	 */
	public function testCreatePage() {
		$this->visit('/admin/pages/create')
			->see('create');
	}

	/**
	 * Test call to get pages store route
	 */
	public function testStorePage() {

		$attributes = [
			'active' => '1',
			'template_id' => '1',
			'category_id' => '1',
			'page_type_id' => '1',
			'title' => 'Test',
			'schumer_template_id' => '1',
			'slug' => 'test'
		];

		$response = $this->call('POST', '/admin/pages/store', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test call to get pages edit route
	 */
	public function testEditPage() {
		$this->visit('/admin/pages/edit/1')
			->see('Edit');
	}

	/**
	 * Test the getPageForEdit route method.
	 */
	public function testGetPageForEdit() {
		$response = $this->call('GET', '/admin/pages/edit/page/1');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test getPage route
	 */
	public function testGetPage() {
		$response = $this->call('GET', '/admin/pages/1');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test the update route method.
	 */
	public function testUpdate() {

		$attributes = [
			'active' => '1',
			'template_id' => '1',
			'category_id' => '1',
			'page_type_id' => '1',
			'title' => 'Test',
			'schumer_template_id' => '1',
			'slug' => 'test'
		];

		$response = $this->call('PUT', '/admin/pages/update/1', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test the delete route method.
	 */
	public function testDelete() {
		$response = $this->call('DELETE', '/admin/pages/1');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test cards route
	 */
	public function testShowCardAssignments() {
		$response = $this->call('GET', '/admin/pages/cards/1');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test assigned-cards route
	 */
	public function testAssignedCards() {
		$response = $this->call('GET', '/admin/pages/assigned-cards/5');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test assign-cards route
	 */
	public function testAssignCards() {

		$attributes = [
			'card_id' => '12345678'
		];

		$response = $this->call('PUT', '/admin/pages/assign-cards/5', $attributes);

		$this->assertEquals(200, $response->status());
	}

	public function testOrder() {

		$this->call('PUT', '/admin/pages/assign-cards/5', ['card_id' => '12345678']);
		$this->call('PUT', '/admin/pages/assign-cards/5', ['card_id' => '87654321']);

		$attributes = [
			'cards' => [
			'12345678',
			'87654321'
			]
		];

		$response = $this->call('PUT', '/admin/pages/assigned-cards/order/5', $attributes);

		$this->assertEquals(200, $response->status());

	}

	/**
	 * Test unassign-card route
	 */
	public function testUnAssignCards() {
		$attributes = [
			'card_id' => '12345678'
		];

		$response = $this->call('PUT', '/admin/pages/unassign-card/5', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test content-blocks route
	 */
	public function testShowContentAssignments() {

		$response = $this->call('GET', '/admin/pages/content-blocks/1');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test assignedContentBlocks route
	 */
	public function testAssignedContentBlocks() {
		$response = $this->call('GET', '/admin/pages/assigned-content-blocks/1');

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test assignContent route
	 */
	public function testAssignContent() {

		$attributes = [
			'content_block_id' => '1'
		];

		$response = $this->call('PUT', '/admin/pages/assign-content-block/1', $attributes);

		$this->assertEquals(200, $response->status());
	}

	/**
	 * Test unassignContent route
	 */
	public function testUnAssignContent() {
		$attributes = [
			'content_block_id' => '1'
		];

		$response = $this->call('PUT', '/admin/pages/unassign-content-block/1', $attributes);

		$this->assertEquals(200, $response->status());
	}
}
