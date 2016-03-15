<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\PageContentBlockMap;
/**
 * Class PageContentBlockMapRepository
 * @package cccomus\Repositories
 */
class PageContentBlockMapRepository extends Repository {

	public function createObject() {
		return new PageContentBlockMap();
	}

	public function getTablesToJoin() {
		return [];
	}

	/**
	 * Get all mappings by page id
	 * @param $page_id
	 * @return mixed
	 */
	public function getMapings($page_id) {
		return PageContentBlockMap::where('page_id', $page_id)
			->get();
	}

	/**
	 * Create a mapping
	 * @param $page_id
	 * @param $content_block_id
	 * @return bool
	 */
	public function createMapping($page_id, $content_block_id) {
		$mapping = new PageContentBlockMap();

		$mapping->page_id = $page_id;
		$mapping->content_block_id = $content_block_id;

		return $mapping->save();
	}

	/**
	 * Delete a mapping
	 * @param $page_id
	 * @param $content_block_id
	 * @return bool
	 */
	public function deleteMapping($page_id, $content_block_id) {

		return PageContentBlockMap::where('page_id', $page_id)
			->where('content_block_id', $content_block_id)
			->delete();
	}

}