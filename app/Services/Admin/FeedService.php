<?php
namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\FeedRepository;
use cccomus\Repositories\Admin\CardRepository;
use cccomus\Repositories\Admin\CategoryRepository;
use cccomus\Repositories\Admin\CardCategoryMapRepository;
use cccomus\Repositories\Admin\IssuerRepository;

use Exception;

/**
 * Class FeedService
 * @package cccomus\Services
 */
class FeedService {

    private $feedRepo;
    private $cardRepo;
	private $categoryRepo;
	private $cardCategoryMapRepo;
	private $issuerRepo;

	/**
	 * @param FeedRepository $feedRepo
	 * @param CardRepository $cardRepo
	 * @param CategoryRepository $categoryRepo
	 * @param IssuerRepository $issuerRepo
	 * @param CardCategoryMapRepository $cardCategoryMapRepo
	 */
    function __construct(FeedRepository $feedRepo,
						 CardRepository $cardRepo,
						 CategoryRepository $categoryRepo,
						IssuerRepository $issuerRepo,
						 CardCategoryMapRepository $cardCategoryMapRepo) {
        $this->feedRepo = $feedRepo;
        $this->cardRepo = $cardRepo;
		$this->categoryRepo = $categoryRepo;
		$this->issuerRepo = $issuerRepo;
		$this->cardCategoryMapRepo = $cardCategoryMapRepo;
    }

    /**
     * Get all feeds
     * @param array $attributes
     * @return \stdClass
     */
    public function getFeeds(array $attributes) {
		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

        $data = new \stdClass();
        $data->totalRecords = $this->feedRepo->count($filters);
        $data->feeds = $this->feedRepo->getObjects($count, $page, $sortBy, $dir, $filters);

        return $data;
    }

    /**
     * Get a feed by id.
     * @param $id
     * @return mixed
     */
    public function getFeed($id) {
        return $this->feedRepo->getObject($id);
    }

    /**
     * Create a feed
     * @param $attributes
     * @param null $id
     * @return bool
     */
    public function updateOrCreate($attributes, $id = null) {

        $status = $this->feedRepo->updateOrCreate($attributes, $id);

        return $status;
    }

    /**
     * Delete a feed.
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->feedRepo->deleteObject($id);
    }

    /**
     * Get all cards from feed and create
     * @param int $id
     * @return bool
     */
    public function updateCards($id) {

		$errors = [];

        $feed = $this->feedRepo->getObject($id);

        //Get all the cards
        $data = $this->cardRepo->getCardsFromFeed($feed);

		$cards = $data['data']['products'];

		//Loop through all the cards.
        foreach($cards as $card) {
			try {
				$this->cardRepo->createFromFeed($card);
			}
			catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
        }

        return $errors;
    }

	/**
	 * Update or create all issuers (from card feed)
	 * @param $id
	 * @return bool
	 */
	public function updateIssuers($id) {

		$errors = [];

		$feed = $this->feedRepo->getObject($id);

		//Get all the cards
		$data = $this->cardRepo->getCardsFromFeed($feed);

		$cards = $data['data']['products'];

		//Loop through all the cards.
		foreach($cards as $card) {
			try {
			$this->issuerRepo->updateOrCreateFromFeed($card);
			}
			catch (Exception $e) {
				$errors[] = $e->getMessage();
			}
		}

		return $errors;
	}

	/**
	 * Update or Create all categories from feed.
	 * @param $id
	 * @return bool
	 */
	public function updateCategories($id) {

		$errors = [];

		//Get the feed
		$feed = $this->feedRepo->getObject($id);
		//Get the data from feed call.
		$data = $this->categoryRepo->getCategoriesFromFeed($feed);

		//Get all categories
		$categories = $data['data']['categories'];

		foreach($categories as $category) {
			//Create or update category.
			try {
				$this->categoryRepo->updateOrCreate($category);
				//Create or update the map with the ranking(order)
				foreach($category['rankings'] as $ranking) {
					try {
						$this->cardCategoryMapRepo->createOrUpdateMapping($category['id'], $ranking);
					}
					catch (Exception $e) {
						$errors[] = $e->getMessage();
					}
				}
			}
			catch (Exception $e) {
				$errors[] = $e->getMessage();
			}

		}

		return $errors;
	}
}