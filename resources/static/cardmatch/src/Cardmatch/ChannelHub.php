<?php

/**
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_ChannelHub {
        
    /**
     * Zend Configuration object
     * 
     * @var Zend_Config
     */
    protected $_config;
    protected $_user;
    protected $_visitId;
	protected $_channels;
	protected $_cache;
	protected $_logger;

	public function __construct(Zend_Config $config = NULL, Cardmatch_User $user = NULL, $visitId = 1) {
        $this->setConfig($config);
        $this->setUser($user);
        $this->setVisitId($visitId);

		$this->_logger = Cardmatch_Logger::getInstance();
	}


	/**
	 * Returns channel objects
	 * @return Cardmatch_Channel_Abstract[]
	 */
	public function getChannels() {

		if(empty($this->_channels)) {
			$this->_channels = $this->_createChannels();
		}

		return $this->_channels;
	}
    
    /**
     * Creates channel objects
     *
	 * @param string $prefix
	 *
	 * @return array
	 * @throws UnexpectedValueException
	 * @throws InvalidArgumentException
	 */
	protected function _createChannels($prefix="Cardmatch_Channel_") {
        $config = $this->getConfig();

        if(!is_a($config, 'Zend_Config') || !$config->channels){
	        throw new InvalidArgumentException('Channel configuration error');
        }

        //Now populate the channel object array
		$channels = array();
        foreach($config->channels as $channelConfig){
	        if($channelConfig->active) {
	            $channel = $this->_createChannelObject($channelConfig,$prefix);
		        $channels[] = $channel;
	        }
        }

		if(empty($channels)) {
			throw new UnexpectedValueException('No channels found');
		}

	    return $channels;
    }


	/**
	 * @return Cardmatch_Offer[]
	 */
	public function getOffers() {

		if($this->hasValidCache()) {
			$cache = $this->getCache();
			return $cache->getOffers($this->getUser(), $this->getVisitId());
		}

		$channels = $this->getChannels();

        $offers = array();

		foreach($channels as $channel){

			$this->_logger->debug('Sending request to '. $channel->getName() . ' - Session ID: '. session_id());
			$channelOffers = $this->_getChannelOffers($channel);
			$this->_logger->debug('Received response from '. $channel->getName() . ' - Session ID: '. session_id());
			$offers = array_merge($offers, $channelOffers);
        }

		/*
		 * The transnode expects the card ids to exist in a specific
		 * cookie, so we need to save them there. The idea is to eventually
		 * refactor the transnode to use the cookie with the offer objects
		 * instead.
		 */
		$this->saveCardIds($offers);

		$disclosure = new Cardmatch_Disclosure();
		$disclosure->saveConsentLog($this->getUser(), $this->_getDisclosureVersion());

        return $offers;
	}


	/**
	 * @param Cardmatch_Offer[] $offers
	 *
	 * @return mixed
	 */
	public function saveCardIds($offers) {

	    $cardIds = array();

	    foreach($offers as $offer) {
		    $cardIds[] = $offer->getCardId();
	    }

	    $cardIds = array_unique($cardIds);


		$cache = $this->getCache();

		return $cache->saveProductIds($cardIds);

    }

	public function saveOffers($offers) {

		$cache = $this->getCache();
		return $cache->saveOffers($offers);

	}

	/**
	 * Send an ack response to each channel
	 * when products are shown to the user
	 *
	 * @return bool
	 */
	public function ackDisplayed() {
		$channels = $this->getChannels();
		$ack = true;
		foreach($channels as $channel){
			$ack = $ack && $channel->ackDisplayed();
        }

		return $ack;
	}


	/**
	 * Checks all the channels for errors
	 *
	 * @returns boolean
	 */
	public function hasErrors() {
		/**
		 * @var $channel Cardmatch_Channel_Abstract
		 */
		foreach($this->getChannels() as $channel) {
			if($channel->hasErrors()) return true;
		}
		return false;
	}

	/**
	 * Get errors from all channels
	 *
	 * @return Cardmatch_Error[]
	 */
	public function getErrors() {

		$hubErrors = array();

		/**
		 * @var $channel Cardmatch_Channel_Abstract
		 */
		foreach($this->getChannels() as $channel) {
			$channelErrors = $channel->getErrors();
			$hubErrors = array_merge($hubErrors, $channelErrors);
		}

		return $hubErrors;
	}


	/**
	 * @return boolean
	 */
	public function hasValidCache(){
		$cache = $this->getCache();
		return $cache->isValid();
	}

	public function clearCache(){
		$cache = $this->getCache();
		return $cache->clearCache($this->getUser());
	}

    
    /*****************************
     * Setters                   *
     *****************************/
    
    public function setConfig($config){
        $this->_config = $config;
    }
    
    public function setUser($user){
        $this->_user = $user;
    }
      
    public function setVisitId($visitId){
        $this->_visitId = $visitId;
    }
	
	public function setCache(Cardmatch_Channel_Cache $cache){
		$this->_cache = $cache;
	}
    
    /***********
     * Getters *
     ***********/
    
    public function getConfig(){
        return $this->_config;
    }

	/**
	 * @return Cardmatch_User
	 */
    public function getUser(){
        return $this->_user;
    }
        
    public function getVisitId(){
        return $this->_visitId;
    }
	
	public function getCache(){
	
		if(!isset($this->_cache)||!$this->_cache instanceof Cardmatch_Channel_Cache){
			$cacheConfig = $this->_config->cache;
			$cacheObject = new Cardmatch_Channel_Cache($cacheConfig);
			$this->setCache($cacheObject);
		}

		return $this->_cache;
	}
    
    /*****************************
     * Private/Protected Methods *
     *****************************/
    
    /**
     * Checks for existence of class and instantiates object
     *
	 * @param Zend_Config $config
	 * @param $prefix
	 *
	 * @return Cardmatch_Channel_Abstract
	 * @throws RuntimeException
	 */
	protected function _createChannelObject(Zend_Config $config, $prefix){

        $channelName = (!empty($config->class_name)) ? $config->class_name : '';
        $className = (!empty($channelName)) ? $prefix.$channelName: '';

        if(empty($className) && !class_exists($className)){
            throw new RuntimeException('Channel '.$className.' does not exist');
        }

		/**
		 * @var Cardmatch_Channel_Abstract $channelObject
		 */
		$channelObject = new $className($config->params);
		$channelObject->setName($channelName);

	    return $channelObject;
    }
    
  
    /**
     * Get Product list from channel object
     * 
     * @param Cardmatch_Channel_Abstract $channel
     * @return array
     */
    protected function _getChannelOffers(Cardmatch_Channel_Abstract $channel){


	    $user = $this->getUser();

	    if(!$user->isValid()) {
		    $this->_logger->err('Sending invalid user! Session ID: '. session_id());
		    $this->_logger->insane(json_encode($_SERVER));
	    }

	    $offers = array();
	    try {
		    $offers = $channel->getOffers($user, $this->getVisitId());
	    } catch(Exception $e) {
		    $this->_logger->err($channel->getName(). ' - Could not get offers - Session ID: '. session_id());
		    $this->_logger->err($e->getMessage());
	    }

	    return $offers;
    }

	protected function _getDisclosureVersion() {

		$config = $this->getConfig();
		$version = $config->disclosure->version;

		return $version;
	}



}
