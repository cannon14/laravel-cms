<?php
namespace Modules\ProductReviewsModule\Controllers;

use Modules\ProductReviewsModule\Services\FileService;

use Illuminate\Support\Facades\Request;

class FileController extends Controller {

	/**
	 * @var FileService
	 */
	private $service;

	/**
	 * File Constructor
	 * @param FileService $service
	 */
	public function __construct(FileService $service) {

		$this->service = $service;
	}

	protected function index() {
		//Get all the issuers so user can select the one they want to upload reviews for.
		$issuers = $this->service->getIssuerList();

		return view('cccomus-admin.modules.reviews.index.index', array('issuers' => $issuers));
	}

	/**
	 * Upload file to server then to database.
	 * @param Request $request
	 * @return mixed
	 */
	protected function uploadFile(Request $request) {

		$attributes = $request->all();

		$rules = array('issuer_id' => 'required', 'csv_file' => 'required',);

		$validator = Validator::make($attributes, $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		}

		$message = $this->service->process($attributes);

		//If there were any errors, send back to user.
		if ($message[0] == 'error') {
			return Redirect::back()->with('error', $message[1]);
		}

		//Let the user know that the file has been uploaded and is being processed..
		return Redirect::back()->with('success', $message[1]);

	}
}


