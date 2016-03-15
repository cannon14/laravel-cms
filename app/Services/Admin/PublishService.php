<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\PageRepository;
use cccomus\Repositories\Admin\PageTypeRepository;
use cccomus\Repositories\Admin\CategoryRepository;
use cccomus\Repositories\Admin\TemplateRepository;
use cccomus\Repositories\Admin\CardRepository;
use cccomus\Repositories\Admin\CardPageMapRepository;
use cccomus\Repositories\Admin\ContentBlockRepository;
use cccomus\Repositories\Admin\PageContentBlockMapRepository;
use cccomus\Repositories\Admin\ReviewRepository;
use cccomus\Repositories\Admin\ProductIdToAltProductIdRepository;
use cccomus\Repositories\WordpressRepository;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Exception;

/**
 * Class PublishService
 * @package cccomus\Services
 */
class PublishService {

	private $pageRepo;
	private $pageTypeRepo;
	private $categoryRepo;
	private $templateRepo;
	private $cardRepo;
	private $cardPageMapRepo;
	private $contentBlockRepo;
	private $pageContentBlockMapRepo;
	private $reviewRepo;
	private $mapRepo;
	private $wordpressRepo;

	/**
	 * @param PageRepository $pageRepo
	 * @param PageTypeRepository $pabeTypeRepo
	 * @param CategoryRepository $categoryRepo
	 * @param TemplateRepository $templateRepo
	 * @param CardRepository $cardRepo
	 * @param CardPageMapRepository $cardPageMapRepo
	 * @param ContentBlockRepository $contentBlockRepo
	 * @param PageContentBlockMapRepository $pageContentBlockMapRepo
	 * @param ReviewRepository $reviewRepo
	 * @param ProductIdToAltProductIdRepository $mapRepo
	 */
	function __construct(PageRepository $pageRepo,
						 PageTypeRepository $pabeTypeRepo,
						 CategoryRepository $categoryRepo,
						 TemplateRepository $templateRepo,
						 CardRepository $cardRepo,
						 CardPageMapRepository $cardPageMapRepo,
						 ContentBlockRepository $contentBlockRepo,
						 PageContentBlockMapRepository $pageContentBlockMapRepo,
						 ReviewRepository $reviewRepo,
						 ProductIdToAltProductIdRepository $mapRepo,
						 WordpressRepository $wordpressRepo) {
		$this->pageRepo = $pageRepo;
		$this->pageTypeRepo = $pabeTypeRepo;
		$this->categoryRepo = $categoryRepo;
		$this->templateRepo = $templateRepo;
		$this->cardRepo = $cardRepo;
		$this->cardPageMapRepo = $cardPageMapRepo;
		$this->contentBlockRepo = $contentBlockRepo;
		$this->pageContentBlockMapRepo = $pageContentBlockMapRepo;
		$this->reviewRepo = $reviewRepo;
		$this->mapRepo = $mapRepo;
		$this->wordpressRepo = $wordpressRepo;
	}

	public function publishToProduction() {
		return File::copyDirectory(public_path('/cccomus-staging'), public_path('/cccomus-production'));
	}

	/**
	 * Publish to staging.
	 * @return \stdClass
	 */
	public function publishToStaging() {

		File::deleteDirectory(public_path('cccomus-staging'));
		File::makeDirectory(public_path('cccomus-staging'), 0775);

		$this->publishAssets();
		$this->publishStaticContent();

		$errors = [];
		array_merge($errors, $this->publishWordpressPages());
		array_merge($errors, $this->publishHeaderAndFooter());
		array_merge($errors, $this->publishPages());
		array_merge($errors, $this->publishSpecialPages());
		array_merge($errors, $categoryPageErrors = $this->publishCategoryPages());
		array_merge($errors, $cardErrors = $this->publishCardPages());

		return $errors;
	}

	/**
	 * Publish asset directories and files
	 */
	public function publishAssets() {

		File::copyDirectory(public_path('cccomus-admin/cccomus-assets'), public_path('cccomus-staging'));
	}

	/**
	 * Publish static content.
	 */
	public function publishStaticContent() {
		File::copyDirectory(base_path('resources/static'), public_path('cccomus-staging'));
	}

	/**
	 * Publish the header and footer so it can be used throughout the site and by other sites.
	 * @return array
	 */
	public function publishHeaderAndFooter() {
		//Create a Filesystem object
		$fs = new Filesystem();

		//Collect any errors.
		$errors = [];

		$includes = [
			'header' => [
				'path' => public_path('cccomus-staging/inc/header.php'),
				'view' => public_path('cccomus.templates.partials.includes.header')
			],
			'footer' => [
				'path' => public_path('cccomus-staging/inc/footer.php'),
				'view' => public_path('cccomus.templates.partials.includes.header')
			]
		];

		//Loop through pages and write to file system.
		foreach ($includes as $include) {
			try {
				$fs->put($include['path'], view($include['view']));
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
		}

		return $errors;
	}

	/**
	 * Publish Wordpress Pages;
	 */
	public function publishWordPressPages() {
		//Create a Filesystem object
		$fs = new Filesystem();

		//Collect any errors.
		$errors = [];

		//Get all active pages
		$pages = $this->wordpressRepo->getPages();

		//Loop through pages and write to file system.
		foreach ($pages as $page) {

			$parentSlug = '';
			if($page->post_parent != 0) {
				$parentSlug = $this->wordpressRepo->getParentPageSlug($page->ID);
			}

			$parentDir = !empty($parentSlug) ? $parentSlug.'/' : '';

			$directoryPath = public_path('cccomus-staging/'.$parentDir);

			if(!File::exists($directoryPath)) {
				File::makeDirectory($directoryPath, 0775);
			}

			$filepath = $directoryPath.$page->post_name . '.php';
			$view = 'cccomus.templates.pages.basic';
			try {
				$fs->put($filepath, view($view, ['page' => $page]));
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
		}

		return $errors;
	}

	/**
	 * Publish pages
	 * @return array
	 */
	public function publishPages() {
		//Create a Filesystem object
		$fs = new Filesystem();

		//Collect any errors.
		$errors = [];

		//Get all active pages
		$pages = $this->pageRepo->getObjects(null, null, null, null, ['pages' => '{"active":"1", "page_type_id":"1"}']);

		//Loop through pages and write to file system.
		foreach ($pages as $page) {
			$cards = $this->cardRepo->getAssignedCards($page->page_id);
			$contentBlocks = $this->contentBlockRepo->getContentBlocksByPageId($page->page_id);

			$filepath = public_path('cccomus-staging/' . $page->slug . '.php');
			$view = $page->template->path;
			try {
				$fs->put($filepath, view()->file($view, ['page' => $page, 'content-blocks' => $contentBlocks, 'cards' => $cards]));
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
		}

		return $errors;
	}

	public function publishSpecialPages() {
		//Create a Filesystem object
		$fs = new Filesystem();

		//Collect any errors.
		$errors = [];

		//Get all active pages
		$pages = $this->pageRepo->getObjects(null, null, null, null, ['pages' => '{"active":"1", "page_type_id":"1"}']);

		//Loop through pages and write to file system.
		foreach ($pages as $page) {
			$filepath = public_path('cccomus-staging/' . $page->slug . '.php');
			$view = $page->template->path;

			try {
				$fs->put($filepath, view()->file($view, ['page' => $page]));
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
		}

		return $errors;
	}

	/**
	 * Publish category pages
	 * @return array
	 */
	public function publishCategoryPages() {
		//Create a Filesystem object
		$fs = new Filesystem();

		//Collect any errors.
		$errors = [];

		//Get all active pages
		$pages = $this->pageRepo->getObjects(null, null, null, null, ['pages' => '{"active":"1", "page_type_id":"2"}']);

		//Loop through pages and write to file system.
		foreach ($pages as $page) {
			$cards = $this->categoryRepo->getObject($page->category_id)->cards;

			//Get the reviews for a card
			foreach ($cards as $card) {
				//Get map so that we can get the alt_product_id.
				$map = $this->mapRepo->getMapByProductId($card->card_id);
				if (!is_null($map)) {
					//Get some states based on alt_product_id
					$card->overall_rating = 0; //$this->reviewRepo->getOverallReviewRating($map->alt_product_id);
					$card->review_count = 0; //$this->reviewRepo->getReviewCountByProduct($map->alt_product_id);
				} else {
					$card->overall_rating = 0;
					$card->review_count = 0;
				}
			}

			$filepath = public_path('/cccomus-staging/' . $page->slug . '.php');
			$view = $page->template->path;

			try {
				$fs->put($filepath, view()->file($view, ['page' => $page, 'cards' => $cards]));
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
		}

		return $errors;
	}

	/**
	 * Publish cards.
	 * @return array
	 */
	public function publishCardPages() {
		//Create a Filesystem object
		$fs = new Filesystem();

		File::makeDirectory(public_path('cccomus-staging/credit-cards'), 0775, true);

		//Collect any errors.
		$errors = [];

		//Get all active cards
		$cards = $this->cardRepo->getObjects(null, null, null, null, ['cards' => '{"active":"1"}']);

		//Loop through pages and write to file system.
		foreach ($cards as $card) {
			//Get the reviews for a card
			$map = $this->mapRepo->getMapByProductId($card->card_id);
			if (!is_null($map)) {
				$card->overall_rating = 0;//$this->reviewRepo->getOverallReviewRating($card->card_id);
				$card->review_count = 0;//$this->reviewRepo->getReviewCountByProduct($map->alt_product_id);
			} else {
				$card->overall_rating = 0;
				$card->review_count = 0;
			}

			$filepath = public_path('cccomus-staging/credit-cards/' . $card->slug . '.php');

			$view = 'cccomus.templates.pages.credit-cards.card';
			try {
				$fs->put($filepath, view($view, ['card' => $card]));
			} catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
		}
		return $errors;
	}

}