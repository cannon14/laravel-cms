<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\StaticPageRepository;

use Illuminate\Support\Facades\File;

/**
 * Class StaticPageService
 * @package cccomus\Services
 */
class StaticPageService {

	private $pageRepo;
	private $categoryRepo;
	private $templateRepo;
	private $cardRepo;
	private $cardPageMapRepo;
	private $contentBlockRepo;
	private $pageContentBlockMapRepo;
	private $pageTypeRepo;

	/**
	 * @param StaticPageRepository $pageRepo
	 */
	function __construct(StaticPageRepository $pageRepo) {
		$this->pageRepo = $pageRepo;
	}

	/**
	 * Get all pages
	 * @param array $attributes
	 * @return \stdClass
	 */
	public function getPages(array $attributes) {

		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->pageRepo->count($filters);
		$data->pages = $this->pageRepo->getObjects($count, $page, $sortBy, $dir, $filters);

		return $data;
	}

	/**
	 * Get a page by id.
	 * @param $id
	 * @return mixed
	 */
	public function getPage($id) {
		return $this->pageRepo->getObject($id);
	}

	/**
	 * Create a page.
	 * @param $attributes
	 * @return mixed
	 */
	public function create ($attributes) {

		return $this->pageRepo->create($attributes);

	}

	/**
	 * Update a page.
	 * @param $id
	 * @param $attributes
	 * @return mixed
	 */
	public function update($id, $attributes) {
		return $this->pageRepo->update($id, $attributes);
	}

	/**
	 * Delete a page.
	 * @param $id
	 * @return mixed
	 */
	public function delete($id) {
		return $this->pageRepo->deleteObject($id);
	}


	/**
	 * Update a page's status to active or inactive.
	 * @param $id
	 * @param $attributes
	 * @return mixed
	 */
	public function updateStatus($id, $attributes) {
		return $this->pageRepo->setStatus($id, $attributes);
	}

}