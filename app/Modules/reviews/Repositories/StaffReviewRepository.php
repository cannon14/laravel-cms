<?php
/**
 * Created by PhpStorm.
 * User: cannon
 * Date: 3/2/2015
 * Time: 4:47 PM
 */
namespace App\Repositories;

use App\Models\StaffReview;

class StaffReviewRepository {

	public function getAll() {
		return StaffReview::all();
	}

	public function getReviewCountArray($products) {
		$review_count_array = [];

		foreach ($products as $product) {
			//Staff reviews are stored by cccom id.
			$id = $product->cccom_product_id;

			$review = StaffReview::where('cccom_product_id', '=', $id);

			$review_count_array[$id] = is_null($review) ? 'No' : 'Yes';
		}

		return $review_count_array;
	}

	public function getById($id) {
		return StaffReview::find($id);
	}

	public function createOrUpdate($id = null, array $attributes) {
		$issuer_name = array_pull($attributes, 'issuer_name');

		if (is_null($id)) {
			// create after validation
			$issuer = new Issuer;
			$issuer->issuer_name = $issuer_name;
		} else {
			// update after validation
			$issuer = Issuer::find($id);
			$issuer->issuer_name = $issuer_name;
		}
		return $issuer->save();
	}

	public function delete($id) {
		$review = StaffReview::find($id);

		return $review->delete();
	}
}