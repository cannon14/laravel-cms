<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\CategoryRepository;

/**
 * Class CategoryService
 * @package cccomus\Services
 */
class CategoryService {

	private $categoryRepo;

	/**
	 * @param CategoryRepository $categoryRepo
	 */
	function __construct(CategoryRepository $categoryRepo) {
		$this->categoryRepo = $categoryRepo;
	}

	/**
	 * Get categories
	 * @param array $attributes
	 * @return mixed
	 */
	public function getCategories(array $attributes) {
		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->categoryRepo->count($filters);
		$categories = $this->categoryRepo->getObjects($count, $page, $sortBy, $dir, $filters);

		foreach($categories as $category) {
			$category->cards;
		}

		$data->categories = $categories;

		return $data;
	}

	/**
	 * Get a category.
	 * @param $id
	 * @return mixed
	 */
	public function getCategory($id) {
		return $this->categoryRepo->getObject($id);
	}

	/**
	 * Create a category
	 * @param array $attributes
	 * @param int $id
	 * @return mixed
	 */
	public function updateOrCreate(array $attributes, $id = null) {
		return $this->categoryRepo->updateOrCreate($attributes, $id);
	}

	/**
	 * Delete a category
	 * @param $id
	 * @return mixed
	 */
	public function delete($id) {
		return $this->categoryRepo->deleteObject($id);
	}

	/**
	 * Update a category's status to active or inactive.
	 * @param $id
	 * @param $attributes
	 * @return mixed
	 */
	public function updateStatus($id, $attributes) {
		return $this->categoryRepo->setStatus($id, $attributes);
	}

}