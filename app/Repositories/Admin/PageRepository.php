<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use Illuminate\Support\Facades\DB;

use cccomus\Models\Page;

/**
 * Class PageRepository
 * @package cccomus\Repositories
 */
class PageRepository extends Repository {


	public function createObject() {
		return new Page();
	}

	public function getTablesToJoin() {
		return [
			'templates'=>'template_id',
			'categories'=>'category_id'
		];
	}

	/**
	 * Get all pages
	 * @return mixed
	 */
	public function getPages() {
		return Page::where('active', 1)
			->get();
	}

	/**
	 * Create a page
	 * @param $attributes
	 * @return static
	 */
	public function create( $attributes) {

		$page = new Page();

		$page->title = array_pull($attributes, 'title');
		$page->template_id = array_pull($attributes, 'template_id');
		$page->category_id = array_pull($attributes, 'category_id');
		$page->page_type_id = array_pull($attributes, 'page_type_id');
		$page->schumer_template_id = array_pull($attributes, 'schumer_template_id');
		$page->image = array_pull($attributes, 'image');
		$page->description = array_pull($attributes, 'description');
		$page->meta_description = array_pull($attributes, 'meta_description');
		$page->meta_tags = array_pull($attributes, 'meta_tags');
		$page->slug = array_pull($attributes, 'slug');
		$page->active = array_pull($attributes, 'active', '0');
		$page->save();
		return $page;
	}

	/**
	 * Update a page.
	 * @param pageId $
	 * @param $attributes
	 * @return mixed
	 */
	public function update($pageId, $attributes) {

		$page = Page::where('page_id', $pageId)->first();

		$page->title = array_pull($attributes, 'title');
		$page->template_id = array_pull($attributes, 'template_id');
		$page->category_id = array_pull($attributes, 'category_id');
		$page->page_type_id = array_pull($attributes, 'page_type_id');
		$page->schumer_template_id = array_pull($attributes, 'schumer_template_id');
		$page->image = array_pull($attributes, 'image');
		$page->description = array_pull($attributes, 'description');
		$page->meta_description = array_pull($attributes, 'meta_description');
		$page->meta_tags = array_pull($attributes, 'meta_tags');
		$page->slug = array_pull($attributes, 'slug');
		$page->active = array_pull($attributes, 'active');

		return $page->save();
	}

	/**
	 * Set a page's status to active or inactive.
	 * @param $id
	 * @param array $attributes
	 * @return mixed
	 */
	public function setStatus($id, array $attributes) {
		$page = Page::find($id);
		$page->active = array_get($attributes, 'active');
		return $page->save();
	}

}