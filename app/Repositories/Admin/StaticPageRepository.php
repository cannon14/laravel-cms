<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\StaticPage;

/**
 * Class StaticPageRepository
 * @package cccomus\Repositories
 */
class StaticPageRepository extends Repository {


	public function createObject() {
		return new StaticPage();
	}

	public function getTablesToJoin() {
		return [];
	}


	/**
	 * Create a page
	 * @param $attributes
	 * @return static
	 */
	public function create( $attributes) {

		$page = new StaticPage();

		$page->title = array_get($attributes, 'title');
		$page->description = array_get($attributes, 'description');
		$page->content = array_get($attributes, 'content');
		$page->meta_description = array_get($attributes, 'meta_description');
		$page->meta_tags = array_get($attributes, 'meta_tags');
		$page->slug = array_get($attributes, 'slug');
		$page->active = array_get($attributes, 'active', 1);

		return $page->save();
	}

	/**
	 * Update a page.
	 * @param pageId $
	 * @param $attributes
	 * @return mixed
	 */
	public function update($pageId, $attributes) {

		$page = StaticPage::where('page_id', $pageId)->first();

		$page->title = array_get($attributes, 'title', $page->title);
		$page->description = array_get($attributes, 'description', $page->description);
		$page->content = array_get($attributes, 'content', $page->content);
		$page->meta_description = array_get($attributes, 'meta_description', $page->meta_description);
		$page->meta_tags = array_get($attributes, 'meta_keywords', $page->meta_keywords);
		$page->slug = array_get($attributes, 'slug', $page->slug);
		$page->active = array_get($attributes, 'active', $page->active);

		return $page->save();
	}

	/**
	 * Set a page's status to active or inactive.
	 * @param $id
	 * @param array $attributes
	 * @return mixed
	 */
	public function setStatus($id, array $attributes) {
		$page = StaticPage::find($id);
		$page->active = array_get($attributes, 'active');
		return $page->save();
	}

}