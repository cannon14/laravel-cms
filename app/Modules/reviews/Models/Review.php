<?php
namespace Modules\ProductReviewsModule\Models;

use Jenssegers\Mongodb\Model as Meloquent;

class Review extends Meloquent {

	protected $connection = 'mongodb';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $collection = 'reviews';

    protected $primaryKey = 'review_id';

    /**
     * Get the total number of reviews for a product.
     * @param $id
     * @return mixed
     */
    public static function getTotalReviews($id) {
        $reviews = Review::where('product_id','=',$id)->count();

        return $reviews;
    }


    public static function deleteReviews($attributes) {
        $issuer_id = array_pull($attributes, 'issuer_id');
        $product_id = array_pull($attributes, 'product_id');
        $start_dtg = array_pull($attributes, 'start_dtg');
        $end_dtg = array_pull($attributes, 'end_dtg');

        //If issuer_id is -1...delete ALL reviews.
        if ($issuer_id == -1) {
            $success = Review::where('review_id','>=',0)->delete();
        }
        //Else if $product_id is -1...delete all reviews for all that issuer's products.
        else {
            if ($product_id == -1) {
                $success = Review::where('issuer_id', '=', $issuer_id)->delete();
            }
            //Else delete all reviews by issuer, product, and date range.
            else {
                $success = Review::where('product_id', '=', $product_id)
                    ->where('issuer_id', '=', $issuer_id)
                    ->where('submission_date', '>=', $start_dtg)
                    ->where('submission_date', '<=', $end_dtg)
                    ->delete();
            }
        }

        return $success;
    }
}
