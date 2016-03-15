<?php

require_once "../SearchCache.php";

class SearchCacheTest extends PHPUnit_Framework_TestCase {


	/**
	 * @dataProvider getPages
	 */
	public function testGetUnique($pages, $expectedUnique) {

		$hits = [];
		foreach($pages as $page) {
			$hits[] = [
				'_source' => [
					'title' => $page['title'],
					'url' => "http://www.creditcards.com/{$page['url']}.php"
				]
			];
		}

		$searchCache = new SearchCache(null, null);

		$method = new ReflectionMethod($searchCache, 'getUnique');
		$method->setAccessible(true);

		$unique = $method->invoke($searchCache, $hits);

		$this->assertCount($expectedUnique, $unique);

	}

	public function getPages() {


		$pages = [
			['url' => 'low-interest', 'title' => 'Low Interest'],
			['url' => 'business', 'title' => 'Business'],
			['url' => 'travel', 'title' => 'Travel'],
			['url' => 'low-interest-page-2', 'title' => 'Low Interest'],
			['url' => 'travel-page-2', 'title' => 'Travel'],
			['url' => 'travel-page-3', 'title' => 'Travel'],
			['url' => 'hotels', 'title' => 'Hotels'],

			// Need to account for possible duplicate elements in the index
			['url' => 'payday-loans', 'title' => 'Payday Loans'],
			['url' => 'payday-loans', 'title' => 'Payday Loans'],
		];

		$unique = 5;

		return [[$pages, $unique]];

	}


}
