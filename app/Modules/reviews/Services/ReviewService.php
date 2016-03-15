<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 7/25/15
 * Time: 2:48 PM
 */
namespace Modules\ProductReviewsModule\Services;

use Modules\ProductReviewsModule\Repositories\ReviewRepository;

class ReviewService {

	private $reviewRepo;

	/**
	 * @param ReviewRepository $reviewRepo
	 */
	public function __construct(ReviewRepository $reviewRepo) {
		$this->reviewRepo = $reviewRepo;
	}

	/**
	 * Get all reviews
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getReviews() {
		return $this->reviewRepo->getReviews();
	}

	/**
	 * Get an review by id
	 * @param $id
	 * @return mixed
	 */
	public function getReview($id) {
		return $this->reviewRepo->getReview($id);

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
	public function getReviewsByProductId($id) {
		return $this->reviewRepo->getReviewsByProductId($id);
	}

}