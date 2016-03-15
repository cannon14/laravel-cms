<?php
namespace Modules\ProductReviewsModule\Controllers;

use App\Models\Review;
use App\Models\Product;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;

/**
 * Class ReviewController
 * @package admin
 */
class ReviewController extends Controller {

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($product_id) {

		//$page - this is done behind the scenes in laravel, so don't freak that it isn't here.
		//Get limit or use default.
		$limit = Request::get('limit', 25);
		//Order by, sort by...whatever you want to call it...default is by submission date.
		$order_by = Request::get('order_by', 'submission_date');
		//Order direction is ascending or descending...default is descending.
		$order_dir = Request::get('order_dir', 'DESC');
		//If this is populated, it means that the user is doing a search.
		$search = Request::get('search', '');

		//If a search term is present, lets do a search query in all columns.
		if ($search != '') {
			$reviews = Review::where('product_id', '=', $product_id)->where('submission_date', 'LIKE', '%' . $search . '%')->orWhere('review_id', 'LIKE', '%' . $search . '%')->orWhere('review_title', 'LIKE', '%' . $search . '%')->orWhere('review_text', 'LIKE', '%' . $search . '%')->orWhere('overall_rating', 'LIKE', '%' . $search . '%')->orderBy($order_by, $order_dir)->paginate($limit);
		} //Or let's just return the requested set of reviews.
		else {
			$reviews = Review::where('product_id', '=', $product_id)->orderBy($order_by, $order_dir)->paginate($limit);
		}

		//Get the product details.
		$product = Product::where('alternate_product_id', '=', $product_id)->distinct()->first();

		return view('reviews.show', array('search_term' => $search, 'reviews' => $reviews, 'product' => $product));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($review_id) {

		$review = Review::find($review_id);

		if ($review->delete()) {
			return Redirect::back()->with('success', 'Review Successfully Deleted!');
		} else {
			return Redirect::back()->with('error', 'Error Deleting Review! Try Again Later!');
		}
	}
}
