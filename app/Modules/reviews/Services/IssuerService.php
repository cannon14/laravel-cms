<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 7/25/15
 * Time: 2:48 PM
 */
namespace Modules\ProductReviewsModule\Services;

use Modules\ProductReviewsModule\Repositories\IssuerRepository;

class IssuerService {

	private $issuerRepo;

	/**
	 * Issuer Constructor.
	 * @param IssuerRepository $issuerRepo
	 */
	public function __construct(IssuerRepository $issuerRepo) {
		$this->issuerRepo = $issuerRepo;
	}

	/**
	 * Get all issuers
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getIssuers() {
		return $this->issuerRepo->getIssuers();
	}


	/**
	 * Get an issuer by id
	 * @param $id
	 * @return mixed
	 */
	public function getIssuer($id) {
		return $this->issuerRepo->getIssuer($id);

	}

	public function getReviewCount($id) {

	}

	public function getIssuerList() {
		return $this->issuerRepo->getIssuerList();
	}

	/**
	 * Enable or disable an issuer
	 * @param $id
	 * @return string

	public function changeStatus($id) {
		//Get the issuer.
		$issuer = $this->issuer->getById($id);
		//Get all the products associated with the issuer.
		$products = $this->product->getAllByIssuer($id);
		//Get the current status;
		$status = $issuer->disabled;
		$message = "";
		$attributes = [];

		//If current status is 0, change it to 1 (Enabled)
		if ($status == 0) {
			$status = 1;
			$attributes['disabled'] = $status;
			$message = "All reviews for " . $issuer->issuer_name . " have been disabled!";
		} //Else change it to 0 (Disabled)
		else {
			$status = 0;
			$attributes['disabled'] = $status;
			$message = "All reviews for " . $issuer->issuer_name . " have been enabled!";
		}

		$success = $this->issuer->update($id, $attributes);

		if ($success) {
			//Since the new status of the issuer was successfully saved, change the status of all it's associated
			// products.
			foreach ($products as $product) {
				$this->product->changeStatus($product);
			}
		} else {
			$message = "";
		}

		return $message;
	}
	 * */
}