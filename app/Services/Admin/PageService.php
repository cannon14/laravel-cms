<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\PageRepository;
use cccomus\Repositories\Admin\CategoryRepository;
use cccomus\Repositories\Admin\TemplateRepository;
use cccomus\Repositories\Admin\CardRepository;
use cccomus\Repositories\Admin\CardPageMapRepository;
use cccomus\Repositories\Admin\ContentBlockRepository;
use cccomus\Repositories\Admin\PageContentBlockMapRepository;
use cccomus\Repositories\Admin\PageTypeRepository;

use Illuminate\Support\Facades\File;

/**
 * Class PageService
 * @package cccomus\Services
 */
class PageService {

	private $pageRepo;
	private $categoryRepo;
	private $templateRepo;
	private $cardRepo;
	private $cardPageMapRepo;
	private $contentBlockRepo;
	private $pageContentBlockMapRepo;
	private $pageTypeRepo;

	/**
	 * @param PageRepository $pageRepo
	 * @param CategoryRepository $categoryRepo
	 * @param TemplateRepository $templateRepo
	 * @param CardRepository $cardRepo
	 * @param CardPageMapRepository $cardPageMapRepo
	 * @param ContentBlockRepository $contentBlockRepo
	 * @param PageContentBlockMapRepository $pageContentBlockMapRepo
	 * @param PageTypeRepository $pageTypeRepo
	 */
	function __construct(PageRepository $pageRepo,
						 CategoryRepository $categoryRepo,
						 TemplateRepository $templateRepo,
						 CardRepository $cardRepo,
						 CardPageMapRepository $cardPageMapRepo,
						 ContentBlockRepository $contentBlockRepo,
						 PageContentBlockMapRepository $pageContentBlockMapRepo,
						 PageTypeRepository $pageTypeRepo) {
		$this->pageRepo = $pageRepo;
		$this->categoryRepo = $categoryRepo;
		$this->templateRepo = $templateRepo;
		$this->cardRepo = $cardRepo;
		$this->cardPageMapRepo = $cardPageMapRepo;
		$this->contentBlockRepo = $contentBlockRepo;
		$this->pageContentBlockMapRepo = $pageContentBlockMapRepo;
		$this->pageTypeRepo = $pageTypeRepo;
	}

	/**
	 * Get all pages
	 * @param $attributes
	 * @return \stdClass
	 */
	public function getPages($attributes) {

		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->pageRepo->count($filters);

		$pages = $this->pageRepo->getObjects($count, $page, $sortBy, $dir, $filters);

		foreach($pages as $page) {
			$page->category->cards;
			$page->template;
			$page->schumer;
		}

		$data->pages = $pages;

		return $data;
	}

	/**
	 * Get all static pages
	 * @return mixed
	 */
	public function getStaticPages() {
		$pages = File::allFiles(base_path('resources/static'));

		$data = new \stdClass();
		$data->pages = [];

		foreach($pages as $page) {
			$data->pages[] = ['filename'=>$page->getFilename(), 'path'=>$page->getPathname(), 'extension'=>$page->getExtension()];
		}

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
	 * Get a list of Categories
	 * @return mixed
	 */
	public function getCategoriesList() {
		return $this->categoryRepo->getCategoriesList();
	}

	/**
	 * Get a list of templates
	 * @return mixed
	 */
	public function getPageTemplatesList() {
		return $this->templateRepo->getTemplateList('Pages');
	}

	/**
	 * Get a list of page types
	 * @return mixed
	 */
	public function getPageTypesList() {
		return $this->pageTypeRepo->getPageTypesList();
	}

	/**
	 * Get a list of template types
	 * @return mixed
	 */
	public function getSchumerTemplatesList() {
		return $this->templateRepo->getTemplateList('Schumers');
	}


	/**
	 * Get all cards assigned to a page.
	 * @param $page_id
	 * @return array
	 */
	public function getAssignedCards($page_id) {
		$data = new \stdClass();
		$data->cards = $this->cardRepo->getAssignedCards($page_id);
		return $data;
	}

	/**
	 * Assign a card and page to mapping.
	 * @param $page_id
	 * @param array $attributes
	 * @return mixed
	 */
	public function createMapping($page_id, array $attributes) {

		$card_id = array_get($attributes, 'card_id');

		return $this->cardPageMapRepo->createMapping($page_id, $card_id);
	}

	/**
	 * Delete a card and page mapping
	 * @param $page_id
	 * @param array $attributes
	 * @return mixed
	 */
	public function deleteMapping($page_id, array $attributes) {

		$card_id = array_get($attributes, 'card_id');

		return $this->cardPageMapRepo->deleteMapping($page_id, $card_id);
	}

	/**
	 * Order Cards
	 * @param $pageId
	 * @param array $attributes
	 * @return bool
	 */
	public function order($pageId, array $attributes) {
		$cards = array_get($attributes, 'cards');

		$status = true;
		$order = 1;
		foreach ($cards as $cardId) {
			$status = $this->cardPageMapRepo->order($pageId, $cardId, $order);
			$order++;
		}

		return $status;
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

	/**
	 * Get all content assigned to a page.
	 * @param $page_id
	 * @return array
	 */
	public function getAssignedContent($page_id) {
		return $this->contentBlockRepo->getContentBlocksByPageId($page_id);
	}

	/**
	 * Assign a card and page to mapping.
	 * @param $page_id
	 * @param array $attributes
	 * @return mixed
	 */
	public function createContentMapping($page_id, array $attributes) {

		$content_block_id = array_get($attributes, 'content_block_id');

		return $this->pageContentBlockMapRepo->createMapping($page_id, $content_block_id);
	}

	/**
	 * Delete a content block and page mapping
	 * @param $page_id
	 * @param array $attributes
	 * @return mixed
	 */
	public function deleteContentMapping($page_id, array $attributes) {

		$content_block_id = array_get($attributes, 'content_block_id');

		return $this->pageContentBlockMapRepo->deleteMapping($page_id, $content_block_id);
	}


}