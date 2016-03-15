<?php
/**
 * Class IssuerController
 * @author David Cannon
 * @date 20 Oct 14
 */
namespace Modules\ProductReviewsModule\Controllers;

use Modules\ProductReviewsModule\Services\IssuerService;

/**
 * Class IssuerController
 * @package Modules\ProductReviewsModule\Controllers
 */
class IssuerController extends Controller {

	private $issuerService;

	/**
	 * Issuer Constructor.
	 * @param IssuerService $issuerService
	 */
	public function __construct(IssuerService $issuerService) {
		$this->issuerService = $issuerService;
	}

	/**
	 * Show page with all issuers.
	 * @return \Illuminate\View\View
	 */
	public function index() {
		$issuers = $this->issuerService->getIssuers();

		return view('cccomus-admin.modules.reviews.issuers.index', array('issuers' => $issuers));
	}
}
