<?php
namespace cccomus\Http\Controllers\Admin;

use cccomus\Services\Admin\ReviewService;

use cccomus\Services\Admin\IssuerService;

use cccomus\Http\Controllers\Controller;

use Illuminate\Http\Request;


/**
 * Class ReviewController
 * @package admin
 */
class ReviewController extends Controller {

	private $reviewService;
	private $issuerService;

	/**
	 * @param ReviewService $reviewService
	 * @param IssuerService $issuerService
	 */
	function __construct(ReviewService $reviewService, IssuerService $issuerService) {
		$this->reviewService = $reviewService;
		$this->issuerService = $issuerService;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function issuerReviews() {
		return view('cccomus-admin.reviews.issuers');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function productReviews() {
		return view('cccomus-admin.reviews.products');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function map() {
		return view('cccomus-admin.reviews.maps');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function createMap() {
		return view('cccomus-admin.reviews.create-map');
	}

	/**
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function editMap($id) {

		return view('cccomus-admin.reviews.edit-map');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function parsers() {
		return view('cccomus-admin.reviews.parsers');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function createParser() {
		return view('cccomus-admin.reviews.create-parser', ['issuers'=>$this->issuerService->getIssuersList()]);
	}

	/**
	 * Upload reviews
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function upload() {
		return view('cccomus-admin.reviews.upload', ['issuers'=>$this->issuerService->getIssuersList()]);
	}

	/**
	 * Get product ID mappings
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getMappings(Request $request) {
		return response()->json($this->reviewService->getMappings($request->all()));
	}

	/**
	 * Get product ID map
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getMap($id) {
		return response()->json($this->reviewService->getMapping($id));
	}

	/**
	 * Get all issuers and their reviews.
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getIssuerReviews(Request $request) {
		return response()->json($this->reviewService->getIssuerReviews($request->all()));
	}

	/**
	 * Get reviews by issuer id
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getReviewsByIssuer($id) {
		return response()->json(['reviews'=>$this->reviewService->getReviewsByIssuer($id)]);
	}

	/**
	 * Get review count by issuer
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getReviewCountByIssuer($id) {
		return response()->json(['count'=>$this->reviewService->getReviewCountByIssuer($id)]);
	}

	/**
	 * Delete reviews by issuer
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteReviewsByIssuer($id) {
		return response()->json(['message'=>$this->reviewService->deleteReviewsByIssuer($id)]);
	}

	/**
	 * Get all products and their reviews
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getProductReviews(Request $request) {
		return response()->json($this->reviewService->getProductReviews($request->all()));
	}
	/**
	 * Get reviews by product
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getReviewsByProduct($id) {
		return response()->json(['reviews'=>$this->reviewService->getReviewsByProduct($id)]);
	}

	/**
	 * Get review count by product
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getReviewCountByProduct($id) {
		return response()->json(['count'=>$this->reviewService->getReviewCountByProduct($id)]);
	}

	/**
	 * Delete reviews by issuer
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteReviewsByProduct($id) {
		return response()->json(['message'=>$this->reviewService->deleteReviewsByProduct($id)]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function storeMap(Request $request) {
		$rules = [
			'product_id' => 'required',
			'alt_product_id' => 'required'
		];

		$messages = [
			'product_id.required' => 'Product ID is Required',
			'alt_product_id.required' => 'Alt Product ID is Required'
		];

		$this->validate($request, $rules, [], $messages);

		$message = $this->reviewService->createMap($request->all());

		return response()->json(['message'=>$message]);
	}

	/**
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateMap($id, Request $request) {
		$rules = [
			'product_id' => 'required',
			'alt_product_id' => 'required'
		];

		$messages = [
			'product_id.required' => 'Product ID is Required',
			'alt_product_id.required' => 'Alt Product ID is Required'
		];

		$this->validate($request, $rules, $messages);

		$message = $this->reviewService->updateMap($id, $request->all());

		return response()->json(['message'=>$message]);
	}

	/**
	 * Delete a map
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteMap($id) {
		$message = $this->reviewService->deleteMap($id);

		return response()->json(['message' => $message]);
	}

	/**
	 * Get all parsers.
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getParsers(Request $request) {
		return response()->json($this->reviewService->getParsers($request->all()));
	}

	/**
	 * Store parser
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function storeParser(Request $request) {

		$rules = [
			'issuer_id' => 'required',
			'data' => 'required'
		];

		$messages = [
			'issuer_id.required' => 'Issuer is Required',
			'data.required' => 'Parser Data is Required'
		];

		$this->validate($request, $rules, $messages);

		$message = $this->reviewService->createParser($request->all());

		return response()->json(['message'=>$message]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function processUpload(Request $request) {

		$rules = [
			'issuer_id' => 'required',
			'file' => 'required'
		];

		$messages = [
			'issuer_id.required' => 'Issuer is Required',
			'file.required' => 'File is Required',
			'file.mimes' => 'File must be of type .csv'
		];

		$this->validate($request, $rules, $messages);

		$attributes = $request->all();

		$stats = $this->reviewService->upload($attributes);

		return response()->json(['stats' => $stats]);
	}

	public function deleteParser($id) {
		return response()->json(['message'=>$this->reviewService->deleteParser($id)]);
	}

}
