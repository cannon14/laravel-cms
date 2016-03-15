<?php

class Cardmatch_Channel_Cache extends Cardmatch_Channel_Abstract {

    protected $_user;
    protected $_cardQuery;
	protected $_errors;

	/**
	 * @var Cardmatch_Client_Cache
	 */
	protected $_client;

	/**
	 * @param Cardmatch_User $user
	 * @param string $visitId
	 *
	 * @return Cardmatch_Offer[]
	 */
	public function getOffers(Cardmatch_User $user = null, $visitId = '') {
		return $this->_client->getOffers();
	}

	/**
	 * @param $offers
	 *
	 * @return bool
	 */
	public function saveOffers($offers) {
		return $this->_client->saveOffers($offers);
	}


	/**
	 * @param array $productIds
	 *
	 * @return mixed
	 */
	public function saveProductIds(array $productIds){
        return $this->_client->saveProducts($productIds);
    }
	
	public function clearCache($user){
		return $this->_client->clearCache($user);
	}
    
    public function isValid(){
        return $this->_client->hasValidCache();
    }
    
	public function ackDisplayed() {
		$response = $this->_client->ackDisplayed();
		return $response;
	}

    public function getErrors() {
        return $this->_errors;
    }
    
    public function clearErrors() {
        $this->_errors = array();
    }

	/**
	 * @param Zend_Config $config
	 *
	 * @return Cardmatch_Client_Cache
	 */
	protected function _createApiClient(Zend_Config $config) {

		$this->_client = new Cardmatch_Client_Cache($config->cookie);
		return $this->_client;
	}

	public function setApiClient($client) {
		$this->_client = $client;
	}

}

