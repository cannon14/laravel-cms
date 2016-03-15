<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:14 PM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Traits\GuzzleTrait;
use cccomus\Traits\SlugGenerator;
use cccomus\Models\Category;

/**
 * Class CategoryRepository
 * @package cccomus\Repositories\Admin
 */
class CategoryRepository extends Repository {

	use SlugGenerator, GuzzleTrait;

	public function createObject() {
		return new Category();
	}

	public function getTablesToJoin() {
		return [];
	}

	/**
	 * Create a category.
	 * @param int $id
	 * @param array $attributes
	 * @return bool
	 */
	public function updateOrCreate(array $attributes, $id = null) {

		$category = null;

		if(!is_null($id)) {
			$category = Category::find($id);
		}
		else if (isset($attributes['id'])) {
			$category = Category::find($attributes['id']);
		}

		if(is_null($category)) {
			$category = new Category();
		}

		$category->category_id = array_get($attributes, 'id', $category->category_id);
		$category->name = array_get($attributes, 'name', $category->name);
		$category->image = array_get($attributes, 'image', $category->image);
		$category->description = array_get($attributes, 'description', $category->description);
		$category->slug = $this->createSlug(array_get($attributes, 'name', $category->slug));
		$category->active = array_get($attributes, 'active', (isset($category->active) ? $category->active : 1));

		return $category->save();
	}

	/**
	 * Get a list of categories
	 * @return mixed
	 */
	public function getCategoriesList() {
		return Category::lists('name', 'category_id');
	}

	/**
	 * Get all Categories
	 * @param $feed
	 * @return mixed
	 */
	public function getCategoriesFromFeed($feed) {
		return $this->GET($feed);
	}

	/**
	 * Set a category's status to active or inactive.
	 * @param $id
	 * @param array $attributes
	 * @return mixed
	 */
	public function setStatus($id, array $attributes) {
		$category = Category::find($id);
		$category->active = array_get($attributes, 'active');
		return $category->save();
	}
}