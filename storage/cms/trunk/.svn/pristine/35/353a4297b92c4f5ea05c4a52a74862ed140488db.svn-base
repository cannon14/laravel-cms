<?php

require_once CMS_ROOT."/tests/unit/CmsDbTestCase.php";
require_once CMS_ROOT."/cms/product_links/ProductLinksController.php";

class ProductLinksControllerTest extends CmsDbTestCase {

	/**
	 * @var ProductLinksController
	 */
	protected $controller;

	const PRODUCT_LINKS_TABLE_ROW_COUNT = 12;				// should match # of rows defined in product_links.xml

	public function setup() {
		parent::setUp();
		$this->controller = new ProductLinksController();
	}

	public function getDataSet() {

		$datasets = [
			$this->createMySQLXMLDataSet(FIXTURES_PATH . '/product_links.xml'),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . '/link_types.xml'),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . '/device_types.xml'),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . '/cccomus.partner_account_types.xml'),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . '/cccomus.partner_websites.xml')
		];

		$compositeDs = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($datasets);
		return $compositeDs;
	}

	public function testCantDeleteDefaultProductLink() {

		$expectedRowCount = self::PRODUCT_LINKS_TABLE_ROW_COUNT;

		$this->assertTableRowCount('product_links', $expectedRowCount);

		$response = json_decode($this->controller->deleteProductLink(1));

		$this->assertNotEquals('success', $response->msg);

		// The record should still be there
		$this->assertTableRowCount('product_links', $expectedRowCount);


	}

	public function testCantEditDefaultProductLinkDeviceType() {

		$expectedRowCount = self::PRODUCT_LINKS_TABLE_ROW_COUNT;
		$newLinkTypeName = 'card';				// same link type
		$newDeviceTypeId = 2;					// change device type to mobile

		$request = $this->generateDefaultProductLinkRequest($newLinkTypeName, $newDeviceTypeId);

		$this->assertTableRowCount('product_links', $expectedRowCount);

		$response = json_decode($this->controller->editProductLink($request));

		$this->assertNotEquals('success', $response->msg);
	}

	public function testCantEditDefaultProductLinkLinkType() {

		$expectedRowCount = self::PRODUCT_LINKS_TABLE_ROW_COUNT;
		$newLinkTypeName = 'terms';				// change link type to terms
		$newDeviceTypeId = 1;					// same device type

		$request = $this->generateDefaultProductLinkRequest($newLinkTypeName, $newDeviceTypeId);

		$this->assertTableRowCount('product_links', $expectedRowCount);

		$response = json_decode($this->controller->editProductLink($request));

		$this->assertNotEquals('success', $response->msg);
	}

	public function testCanEditDefaultProductLinkUrl() {

		$expectedRowCount = self::PRODUCT_LINKS_TABLE_ROW_COUNT;
		$productLinkId = 1;
		$newLinkTypeName = 'card';				// same link type
		$newDeviceTypeId = 1;					// same device type
		$expectedUrl = 'http://www.default-product-link.com';

		$request = $this->generateDefaultProductLinkRequest($newLinkTypeName, $newDeviceTypeId);

		$this->assertTableRowCount('product_links', $expectedRowCount);

		$response = json_decode($this->controller->editProductLink($request));

		$this->assertEquals('success', $response->msg);

		$productLink = json_decode($this->controller->getProductLink($productLinkId));

		$this->assertEquals($productLink->url, $expectedUrl);
	}

	/**
	 * @param $productId
	 * @param $linkTypeName
	 * @param $websiteId
	 * @param $deviceTypeId
	 * @param $accountTypeId
	 * @param $url
	 * @param $username
	 *
	 * @dataProvider duplicateProductLinkProvider
	 */
	public function testCantAddDuplicateProductLink($productId,
												$linkTypeName,
												$websiteId,
												$deviceTypeId,
												$accountTypeId,
												$url,
												$username,
												$linkId) {

		$expectedRowCount = self::PRODUCT_LINKS_TABLE_ROW_COUNT;

		$this->assertTableRowCount('product_links', $expectedRowCount);

		$request['pl_productId'] = $productId;
		$request['pl_link_type'] = $linkTypeName;
		$request['pl_websiteId'] = $websiteId;
		$request['pl_device_type'] = $deviceTypeId;
		$request['pl_account_type'] = $accountTypeId;
		$request['pl_url'] = $url;
		$request['pl_username'] = $username;

		$response = json_decode($this->controller->addProductLink($request));

		$this->assertNotEquals('success', $response->msg);
	}

	public function testCanAddNewProductLink() {

		$expectedRowCount = self::PRODUCT_LINKS_TABLE_ROW_COUNT;
		$newRowCount = $expectedRowCount + 1;

		$this->assertTableRowCount('product_links', $expectedRowCount);

		$request = $this->generateNewProductLinkRequest();

		$response = json_decode($this->controller->addProductLink($request));

		$this->assertEquals('success', $response->msg);

		$this->assertTableRowCount('product_links', $newRowCount);
	}

	/**
	 * @param $productId
	 * @param $linkTypeName
	 * @param $websiteId
	 * @param $deviceTypeId
	 * @param $accountTypeId
	 * @param $url
	 * @param $username
	 * @param $linkId
	 *
	 * @dataProvider duplicateProductLinkProvider
	 */
	public function testCantEditToDuplicateProductLink($productId,
													   $linkTypeName,
													   $websiteId,
													   $deviceTypeId,
													   $accountTypeId,
													   $url,
													   $username,
													   $linkId) {

		$expectedRowCount = self::PRODUCT_LINKS_TABLE_ROW_COUNT;

		$this->assertTableRowCount('product_links', $expectedRowCount);

		$request['product_link_id'] = $linkId;
		$request['pl_productId'] = $productId;
		$request['pl_link_type'] = $linkTypeName;
		$request['pl_websiteId'] = $websiteId;
		$request['pl_device_type'] = $deviceTypeId;
		$request['pl_account_type'] = $accountTypeId;
		$request['pl_url'] = $url;
		$request['pl_username'] = $username;

		$response = json_decode($this->controller->editProductLink($request));

		$this->assertNotEquals('success', $response->msg);
	}

	public function duplicateProductLinkProvider() {

		$duplicateProductLinks = [
			// card
			[
				'productId' => 1,
				'linkTypeName' => 'card',
				'websiteId' => -1,
				'deviceTypeId' => 1,
				'accountTypeId' => -1,
				'url' => 'http://www.new-card.com',
				'username' => 'User 1',
				'linkId' => 2
			],
			// terms
			[
				'productId' => 1,
				'linkTypeName' => 'terms',
				'websiteId' => -1,
				'deviceTypeId' => 2,
				'accountTypeId' => -1,
				'url' => 'http://www.new-terms.com',
				'username' => 'User 1',
				'linkId' => 3
			],
			// account
			[
				'productId' => 1,
				'linkTypeName' => 'account',
				'websiteId' => -1,
				'deviceTypeId' => 1,
				'accountTypeId' => 2,
				'url' => 'http://www.new-account.com',
				'username' => 'User 1',
				'linkId' => 6
			],
			//website
			[
				'productId' => 1,
				'linkTypeName' => 'website',
				'websiteId' => 1,
				'deviceTypeId' => 2,
				'accountTypeId' => -1,
				'url' => 'http://www.new-website.com',
				'username' => 'User 1',
				'linkId' => 11
			],
		];

		return $duplicateProductLinks;
	}

	private function generateDefaultProductLinkRequest($linkTypeName, $deviceTypeId) {

		$request['product_link_id'] = 1;
		$request['pl_productId'] = 1;
		$request['pl_link_type'] = $linkTypeName;
		$request['pl_websiteId'] = -1;
		$request['pl_device_type'] = $deviceTypeId;
		$request['pl_url'] = 'http://www.default-product-link.com';
		$request['pl_username'] = 'User 1';

		return $request;
	}

	private function generateNewProductLinkRequest() {

		$request['product_link_id'] = 1;
		$request['pl_productId'] = 1;
		$request['pl_link_type'] = 'website';
		$request['pl_websiteId'] = 2;
		$request['pl_device_type'] = 1;
		$request['pl_url'] = 'http://www.new-product-link.com';
		$request['pl_username'] = 'User 1';

		return $request;
	}

} 
