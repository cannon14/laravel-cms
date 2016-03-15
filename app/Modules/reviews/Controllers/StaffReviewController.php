<?php
namespace App\Http\Controllers\Admin;

use App\Models\StaffReview;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

use App\Http\Controllers\Controller;

/**
 * Class StaffReviewController
 * @package admin
 */
class StaffReviewController extends Controller {

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($product_id) {

		$review = StaffReview::where('cccom_product_id', '=', $product_id)->first();

		return view('staff_reviews.show', array('review' => $review, 'product_id' => $product_id));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$cccom_product_id = Request::get('cccom_product_id', '');
		return view('staff_reviews.create', array('cccom_product_id' => $cccom_product_id));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$rules = array('member_name' => 'required', 'review' => 'required');

		$validator = Validator::make(Request::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$review = new StaffReview();
		$review->cccom_product_id = Request::get('cccom_product_id', '');
		$review->member_name = Request::get('member_name', '');
		$review->member_title = Request::get('member_title', '');
		$review->member_image_path = Request::get('member_image_path', '');
		$review->member_url = Request::get('member_url', '');
		$review->review_title = Request::get('review_title', '');
		$review->review = Request::get('review', '');

		if ($review->save()) {
			return Redirect::back()->with('success', 'Staff Review Successfully Created!');
		} else {
			return Redirect::back()->with('error', 'Error Creating Staff Review! Try Again Later!');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($product_id) {
		$review = StaffReview::where('cccom_product_id', '=', $product_id)->first();

		return view('staff_reviews.edit', array('review' => $review));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update($product_id) {

		$rules = array('member_name' => 'required', 'review' => 'required');

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$review = StaffReview::where('cccom_product_id', '=', $product_id)->first();
		$review->member_name = Request::get('member_name', '');
		$review->member_title = Request::get('member_title', '');
		$review->member_image_path = Request::get('member_image_path', '');
		$review->member_url = Request::get('member_url', '');
		$review->review_title = Request::get('review_title', '');
		$review->review = Request::get('review', '');

		if ($review->save()) {
			return Redirect::back()->with('success', 'Staff Review Successfully Updated!');
		} else {
			return Redirect::back()->with('error', 'Error Updating Staff Review! Try Again Later!');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($product_id) {

		$review = StaffReview::where('cccom_product_id', '=', $product_id);

		if ($review->delete()) {
			return Redirect::back()->with('success', 'Review Successfully Deleted!');
		} else {
			return Redirect::back()->with('error', 'Error Deleting Review! Try Again Later!');
		}
	}

	private function processImage($variable_name) {
		//Process the member's image file if there is one.
		$file = Request::file($variable_name);
		//Default image is a black and white silhouette.
		$filename = 'silhouette.png';
		//Start by assuming the upload will be unsuccessful.
		$uploadSuccess = false;
		//If there is no file, skip this code.
		if (isset($file)) {
			$destination = public_path() . '/images/';
			$filename = $file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension();
			$allowed = array('png', 'gif', 'jpg', 'jpeg');
			if (in_array(strtolower($extension), $allowed)) {
				$uploadSuccess = Input::file($variable_name)->move($destination, $filename);
			} else {
				return Redirect::back()->withInput()->with('error', 'Image file must be .png, .gif, .jpg');
			}
		}

		//If the file passed validation and was uploaded, give it the proper file name.
		if ($uploadSuccess) {
			$filename = $file->getClientOriginalName();
		}

		return $filename;
	}
}

