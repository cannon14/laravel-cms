<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 7/25/15
 * Time: 2:48 PM
 */
namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\ReviewRepository;
use cccomus\Repositories\Admin\IssuerRepository;
use cccomus\Repositories\Admin\CardRepository;
use cccomus\Repositories\Admin\ProductIdToAltProductIdRepository;
use cccomus\Repositories\Admin\ParserRepository;
use cccomus\Traits\FileTrait;
use cccomus\Libs\Maps\ClassMap;

/**
 * Class ReviewService
 * @package cccomus\Services\Admin
 */
class ReviewService {

	use FileTrait;

	private $reviewRepo;
	private $issuerRepo;
	private $cardRepo;
	private $mapRepo;
	private $parserRepo;

	/**
	 * @param ReviewRepository $reviewRepo
	 * @param IssuerRepository $issuerRepo
	 * @param CardRepository $cardRepo
	 * @param ProductIdToAltProductIdRepository $mapRepo
	 * @param ParserRepository $parserRepo
	 */
	public function __construct(ReviewRepository $reviewRepo,
								IssuerRepository $issuerRepo,
								CardRepository $cardRepo,
								ProductIdToAltProductIdRepository $mapRepo,
								ParserRepository $parserRepo) {
		$this->reviewRepo = $reviewRepo;
		$this->issuerRepo = $issuerRepo;
		$this->cardRepo = $cardRepo;
		$this->mapRepo = $mapRepo;
		$this->parserRepo = $parserRepo;
	}

	/**
	 * Get all issuers and their reviews.
	 * @param array $attributes
	 * @return array
	 */
	public function getIssuerReviews(array $attributes) {
		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->issuerRepo->count($filters);

		$issuers = $this->issuerRepo->getObjects($count, $page, $sortBy, $dir, $filters);
		foreach($issuers as $issuer) {
			$issuer['review_count'] = $this->reviewRepo->getReviewCountByIssuer($issuer->issuer_id);
		}

		$data->issuers = $issuers;

		return $data;
	}

	/**
	 * Get reviews by issuer id
	 * @param $id
	 * @return mixed
	 */
	public function getReviewsByIssuer($id) {
		return $this->reviewRepo->getReviewsByIssuer($id);
	}

	/**
	 * Get review count by issuer
	 * @param $id
	 * @return mixed
	 */
	public function getReviewCountByIssuer($id) {
		return $this->reviewRepo->getReviewCountByIssuer($id);
	}

	/**
	 * Delete reviews by issuer
	 * @param $id
	 * @return mixed
	 */
	public function deleteReviewsByIssuer($id) {
		return $this->reviewRepo->deleteReviewsByIssuer($id);
	}

	/**
	 * Get all products and their reviews
	 * @param array $attributes
	 * @return array
	 */
	public function getProductReviews(array $attributes) {
		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->cardRepo->count($filters);

		$cards = $this->cardRepo->getObjects($count, $page, $sortBy, $dir, $filters);
		foreach ($cards as $card) {
			$map = $this->mapRepo->getMapByProductId($card->card_id);
			if(!is_null($map)) {
				$card->review_count = $this->reviewRepo->getReviewCountByProduct($map->alt_product_id);
			}
			else {
				$card->review_count = 0;
			}
		}

		$data->cards = $cards;

		return $data;
	}

	/**
	 * Get reviews by issuer id
	 * @param $id
	 * @return mixed
	 */
	public function getReviewsByIssuerId($id) {
		return $this->reviewRepo->getReviewsByIssuerId($id);
	}

	/**
	 * Get reviews by product
	 * @param $id
	 * @return mixed
	 */
	public function getReviewsByProduct($id) {
		return $this->reviewRepo->getReviewsByProduct($id);
	}

	/**
	 * Get review count by product
	 * @param $id
	 * @return mixed
	 */
	public function getReviewCountByProduct($id) {
		return $this->reviewRepo->getReviewCountByProduct($id);
	}

	/**
	 * Delete reviews by product
	 * @param $id
	 * @return mixed
	 */
	public function deleteReviewsByProduct($id) {
		return $this->reviewRepo->deleteReviewsByProduct($id);
	}

	/**
	 * Get product ID mappings
	 * @param array $attributes
	 * @return \stdClass
	 */
	public function getMappings(array $attributes) {
		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->mapRepo->count($filters);

		$data->mappings = $this->mapRepo->getObjects($count, $page, $sortBy, $dir, $filters);

		return $data;
	}

	/**
	 * Get a product mapping
	 * @param $mapId
	 * @return mixed
	 */
	public function getMapping($mapId) {
		return $this->mapRepo->getObject($mapId);
	}

	/**
	 * Create a mapping
	 * @param array $attributes
	 * @return \cccomus\Models\ProductIdToAltProductIdMap
	 */
	public function createMap(array $attributes) {
		return $this->mapRepo->updateOrCreate($attributes);
	}

	/**
	 * Update a mapping
	 * @param $id
	 * @param array $attributes
	 * @return bool
	 */
	public function updateMap($id, array $attributes) {
		return $this->mapRepo->updateOrCreate($attributes, $id);
	}

	/**
	 * Delete a map
	 * @param $id
	 * @return mixed
	 */
	public function deleteMap($id) {
		return $this->mapRepo->deleteObject($id);
	}

	public function getParsers(array $attributes) {
		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->parserRepo->count();
		$parsers = $this->parserRepo->getObjects();

		foreach($parsers as $parser) {
			$parser->issuer;
		}

		$data->parsers = $parsers;

		return $data;
	}

	/**
	 * Create a parser
	 * @param array $attributes
	 * @return bool
	 */
	public function createParser(array $attributes) {

		return $this->parserRepo->updateOrCreate($attributes);
	}

	/**
	 * Upload a file
	 * @param array $attributes
	 * @return array
	 */
	public function upload(array $attributes) {
		//Get the file to upload
		$file = array_pull($attributes, 'file');
		//Get the issuer id
		$issuerId = array_pull($attributes, 'issuer_id');
		//Get the filename
		$fileName = $file->getClientOriginalName();
		//Get the tmp path where file was uploaded
		$tmpPath = $file->getPathName();
		//Get the destination to move file.
		$destination = storage_path()."/uploads/" . $fileName;
		//Move the file.
		move_uploaded_file($tmpPath, $destination);
		//Read the reviews to an array.
		$reviews = $this->readCsvFileToArray($destination);

		$columns = json_decode($this->parserRepo->getParserByIssuerId($issuerId)->columns, true);

		$errors = 0;
		$successes = 0;

		//Loop through reviews
		foreach($reviews as $review) {
			//Check if review exists.
			if(!$this->reviewRepo->exists($review['Review ID'])) {
				//Add issuer ID to array
				$data = ['issuer_id' => $issuerId];
				//Loop through review data.
				foreach ($review as $key => $value) {
					foreach($columns as $k=>$v) {
						if($key == $v['parser_field']) {
							//Assign the data.
							$data[$v['database_field']] = $value;
							break;
						}
					}
				}
				//Add review to the database.
				if(!$this->reviewRepo->create($data)) {
					$errors++;
				}
				else {
					$successes++;
				}
			}
			else {
				$errors++;
			}
		}

		return ['errors'=>$errors, 'successes'=>$successes];
	}

	/**
	 * Get reviews by product id.
	 * @param $id
	 * @return mixed
	 */
	public function getReviewsByProductId($id) {
		return $this->reviewRepo->getReviewsByProductId($id);
	}

	/**
	 * Delete a parser.
	 * @param $parserId
	 * @return mixed
	 */
	public function deleteParser($parserId) {
		return $this->parserRepo->deleteObject($parserId);
	}

}