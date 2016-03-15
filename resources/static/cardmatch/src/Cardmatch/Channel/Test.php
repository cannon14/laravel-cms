<?php

/**
 * This channel will return a list of hardcoded products, defined in the channels.ini file.
 * It only exists for testing purposes and should not be enabled in the production configuration.
 *
 * @author Kenneth Skertchly
 *
 */
class Cardmatch_Channel_Test extends Cardmatch_Channel_Abstract {

	protected $products;

	/**
	 * @param Cardmatch_User $user
	 * @param $visitId
	 *
	 * @return Cardmatch_Offer[]
	 */
	public function getOffers(Cardmatch_User $user = null, $visitId = '') {

		$offers = array();
		foreach($this->products as $productId) {
			$offer = new Cardmatch_Offer($productId);
			$offers[] = $offer;
		}

		return $offers;
	}


	/**
	 * @return boolean
	 */
	public function ackDisplayed() {
		return true;
	}

	/**
	 * @return array Array of Cardmatch_Error objects
	 */
	public function getErrors() {
		return array();
	}

	public function clearErrors() {
		return true;
	}

	protected function _createApiClient(Zend_Config $config) {

		$this->products = explode(',', $config->products);
		return true;
	}
}

