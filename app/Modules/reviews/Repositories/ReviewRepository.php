<?php
/**
 * Created by PhpStorm.
 * User: cannon
 * Date: 3/2/2015
 * Time: 4:47 PM
 */
namespace Modules\ProductReviewsModule\Repositories;

use Modules\ProductReviewsModule\Models\Review;

/**
 * Class ReviewRepository
 * @package Modules\ProductReviewsModule\Repositories
 */
class ReviewRepository {

	public function getReviews() {
		return Review::all();
	}

	public function getReview($id) {
		return Review::find($id);
	}

	public function getReviewsByIssuerId($id) {
		return Review::where('issuer_id', $id)->get();
	}

	public function getReviewCountByIssuerId($id) {
		return Review::where('issuer_id', $id)->count();
	}

	public function getReviewsByProductId($id) {
		return Review::where('product_id', $id)->get();
	}

	public function getReviewCountByProductId($id) {
		return Review::where('product_id', $id)->count();
	}
}