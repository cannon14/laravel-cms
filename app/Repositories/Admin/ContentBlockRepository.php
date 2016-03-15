<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:14 PM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\ContentBlock;
/**
 * Class ContentBlockRepository
 * @package cccomus\Repositories\Admin
 */
class ContentBlockRepository extends Repository {


	public function createObject() {
		return new ContentBlock();
	}

	public function getTablesToJoin() {
		return [];
	}

	/**
	 * Get all content blocks associated with a page id.
	 * @param $page_id
	 * @return mixed
	 */
	public function getContentBlocksByPageId($page_id) {
		return ContentBlock::select('content_blocks.*')
			->join('page_content_block_map', 'content_blocks.content_block_id', '=', 'page_content_block_map.content_block_id')
			->join('pages', 'pages.page_id', '=', 'page_content_block_map.page_id')
			->where('pages.page_id', $page_id)
			->get();
	}

	/**
	 * Update or Create a content block
	 * @param $id
	 * @param $attributes
	 * @return static
	 */
	public function updateOrCreate($attributes, $id = null) {

		if(!is_null($id)) {
			$contentBlock = ContentBlock::find($id);
		}
		else {
			$contentBlock = new ContentBlock();
		}

		$contentBlock->name = array_get($attributes, 'name');
		$contentBlock->description = array_get($attributes, 'description');
		$contentBlock->content = array_get($attributes, 'content');
		$contentBlock->active = array_get($attributes, 'active', 1);

		return $contentBlock->save();
	}

	/**
	 * Get a list of content blocks
	 * @return mixed
	 */
	public function getContentBlocksList() {
		return ContentBlock::lists('name', 'content_block_id');
	}
}