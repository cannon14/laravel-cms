<?php

require_once(dirname(__FILE__)."/../Client/CacheHelper.php");

class Cardmatch_Channel_CacheTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Zend_Config
	 */
	protected $_config;

	public function setUp(){
        $config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', APPLICATION_ENV);
        $this->_config = $config->cache;
       
    }

    
    public function testGetOffers() {

	    $expectedOffers = array(
		    new Cardmatch_Offer(1),
		    new Cardmatch_Offer(2),
		    new Cardmatch_Offer(3),
	    );

	    $client = new Cardmatch_Client_CacheHelper($this->_config->cookie);

	    $client->saveOffers($expectedOffers);

	    $channel = new Cardmatch_Channel_Cache($this->_config);
	    $channel->setApiClient($client);


	    /**
	     * @var $cards Cardmatch_Offer[]
	     */
	    $offers = $channel->getOffers();

        //should equal cardQuery output
        $this->assertEquals($expectedOffers, $offers);
	}

    
	public function testClearCache(){
		
        //create cache channel mock that returns true if method is called
        $clientMock = $this->getMock('Cardmatch_Client_Cache',array('clearCache'),array($this->_config));
        $clientMock->expects($this->once())
                ->method('clearCache')
				->will($this->returnValue(TRUE));
		//instantiate cardmatch channel w/ test config object
        $channel = new Cardmatch_Channel_Cache($this->_config);

        //replace cache client w/ mock
        $channel->setApiClient($clientMock);



		//run the method
		$result = $channel->clearCache($this->_getTestUser());
		//method w/ mock should return true.
		$this->assertTrue($result);
	}

    private function _getTestUser(){
        $user = new Cardmatch_User($this->_config->cookie);

		$user->setFirstName('PHP');
		$user->setMiddleInitial('U');
		$user->setLastName('Testing');
		$user->setSSN('0123456789');
		$user->setStreetAddress('8920 Business Park Dr');
		$user->setCity('Austin');
		$user->setState('TX');
		$user->setZipCode('78759');

		return $user;
    }

}
