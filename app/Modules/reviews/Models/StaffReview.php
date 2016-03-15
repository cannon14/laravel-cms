<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffReview extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'staff_reviews';

    protected $primaryKey = 'review_id';

	public function product() {
		return $this->hasOne('Product', 'cccom_product_id', 'cccom_product_id');
	}

	/**
	 * Get the total number of reviews for a product.
	 * @param $id
	 * @return mixed
	 */
	public static function hasStaffReview($id) {
		$review = StaffReview::where('cccom_product_id','=',$id)->first();

		$hasReview = is_null($review) ? 'No' : 'Yes';

		return $hasReview;
	}
}
