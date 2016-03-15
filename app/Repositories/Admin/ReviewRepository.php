<?php
/**
 * Created by PhpStorm.
 * User: cannon
 * Date: 3/2/2015
 * Time: 4:47 PM
 */
namespace cccomus\Repositories\Admin;

use cccomus\Models\Review;

use Illuminate\Support\Facades\DB;

/**
 * Class ReviewRepository
 * @package Modules\ProductReviewsModule\Repositories
 */
class ReviewRepository {

	/**
	 * Get reviews by issuer
	 * @param $id
	 * @return mixed
	 */
	public function getReviewsByIssuer($id) {
		return Review::where('issuer_id', (string) $id)->get();
	}

	/**
	 * Get review count by issuer
	 * @param $id
	 * @return mixed
	 */
	public function getReviewCountByIssuer($id) {
		return Review::where('issuer_id', (string) $id)->count();
	}

	/**
	 * Delete reviews by issuer.
	 * @param $id
	 * @return mixed
	 */
	public function deleteReviewsByIssuer($id) {
		return Review::where('issuer_id', (string) $id)->delete();
	}

	/**
	 * Get reviews by product
	 * @param $id
	 * @return mixed
	 */
	public function getReviewsByProduct($id) {
		return Review::where('product_id', (string) $id)->get();
	}

	/**
	 * Get review count by product
	 * @param $id
	 * @return mixed
	 */
	public function getReviewCountByProduct($id) {
		return Review::where('product_id', $id)->count();
	}

	/**
	 * Delete reviews by product
	 * @param $id
	 * @return mixed
	 */
	public function deleteReviewsByProduct($id) {
		return Review::where('product_id', (string) $id)->delete();
	}

	/**
	 * Create a review with mass assignment
	 * @param $data
	 * @return static
	 */
	public function create($data) {
		return Review::create($data);
	}

	/**
	 * Check if review exists.
	 * @param $reviewId
	 * @return mixed
	 */
	public function exists($reviewId) {
		return Review::where('review_id', (string) $reviewId)->exists();
	}

	/**
	 * Get the overall rating for a product
	 * @param $id
	 * @return mixed
	 */
	public function getOverallReviewRating($id) {
		return Review::where('product_id', (string) $id)
			->avg('overall_rating');
	}

	public function getReviewsByIssuerId($id) {
		return Review::where('issuer_id', (string) $id)->get();
	}

	public function getReviewCountByIssuerId($id) {
		return Review::where('issuer_id', (string) $id)->count();
	}

	public function getReviewsByProductId($id) {
		return Review::where('product_id', (string) $id)->get();
	}

	public function getReviewCountByProductId($id) {
		return Review::where('product_id', (string) $id)->count();
	}
}