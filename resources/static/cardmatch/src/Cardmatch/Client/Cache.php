<?php

/**
 * Description of Cache
 *
 * @author lawrence
 */
class Cardmatch_Client_Cache {
    
    protected $_config;

    public function __construct(Zend_Config $config) {
        $this->setConfig($config);
    }
    
    public function ackDisplayed() {
		return true;
	}

	public function getProducts(){
		$results = $this->_getCookie($this->_config->name->results);
		return $results;
	}

	/**
	 * @return array
	 */
	public function getOffers(){
		$serializedOffers = $this->_getCookie($this->_config->name->offers);
		$offers = unserialize($serializedOffers);
		return $offers;
	}

	/**
	 * We're keeping this method for transnode legacy purposes. The actual data being used to display the offers
	 * is inside the offers cookie.
	 *
	 * @param array $productIds
	 *
	 * @return bool
	 */
	public function saveProducts(array $productIds){
		$config = $this->getConfig();
		$this->_setCookie($config->name->results, implode(',', $productIds), time() + $config->ttl, $config->path, $config->domain);

		//Set the encrypted values for the transnode/secure products
		$encryptedResults = array();
		foreach($productIds as $result)
		{
			$encryptedResults[] = md5("Ajz53K2ZG" . md5($result) . "7gWAJBaqDt");
		}

		$this->_setCookie( $config->name->results_encrypted, serialize($encryptedResults), time() + $config->ttl, $config->path, $config->domain );

		return $this->hasValidCache();
	}


	/**
	 * @param array $offers
	 *
	 * @return bool
	 */
	public function saveOffers(array $offers){
		$config = $this->getConfig();

		$serializedOffers = serialize($offers);
		$this->_setCookie($config->name->offers, $serializedOffers, time() + $config->ttl, $config->path, $config->domain);
		$this->_setCookie($config->name->results_time, time()+ $config->ttl, time() + $config->ttl, $config->path, $config->domain);

		return $this->hasValidCache();
	}
    
    public function clearCache(){
        $config = $this->getConfig();
        $this->_setCookie($config->name->results, '', time()-3600 + $config->ttl, $config->path, $config->domain);
        $this->_setCookie($config->name->results_time, '', time()-3600 + $config->ttl, $config->path, $config->domain);
	    $this->_setCookie($config->name->results_encrypted, '', time()-3600 + $config->ttl, $config->path, $config->domain);
	    $this->_setCookie($config->name->offers, '', time()-3600 + $config->ttl, $config->path, $config->domain);

	    return $this->hasValidCache();
    }
    
    /**
     * Checks if there is a valid cache
     *
	 * @return bool
	 */
	public function hasValidCache() {
        return $this->_hasCookie();
    }
    
    protected function _hasCookie() {
        $config = $this->getConfig();

	    // Not having results doesn't necessarily mean the cookie is not valid
        //$results = $this->_getCookie($config->name->results);

        $results_time = $this->_getCookie($config->name->results_time);

	    $hasCookie = isset($results_time) && time() < $results_time;

        return $hasCookie;
    }
    
    protected function _getCookie($cookieName){
        $value = (isset($_COOKIE[$cookieName])) ? $_COOKIE[$cookieName] : null;
        return $value;
    }
                                                            
    protected function _setCookie($cookieName, $cookieValue, $ttl, $cookiePath, $cookieDomain){
        setcookie($cookieName, $cookieValue, time() + $ttl, $cookiePath, $cookieDomain);
    }
    

    public function getConfig(){
        return $this->_config;
    }

    public function setConfig($config){
        $this->_config = ($config);
    }
}
