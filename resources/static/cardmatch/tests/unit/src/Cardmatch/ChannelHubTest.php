<?php

require_once "Client/CacheHelper.php";

class Cardmatch_ChannelHubTest extends PHPUnit_Framework_TestCase {

    protected $_config;
	protected $_userTest;

	/**
	 * @var Cardmatch_ChannelHub
	 */
	protected $_hub;


    public function setUp(){
        $this->_config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', APPLICATION_ENV);
        $this->_hub = new Cardmatch_ChannelHub($this->getConfig(),$this->getTestUser(),1);
    }

    /*********
     * Tests *
     *********/
    
    public function testCreateChannelObjects(){

        $channelObjects = $this->_hub->getChannels();
        $channelCount = count($channelObjects);
		$this->assertEquals(4, $channelCount);
		$this->assertEquals(
					'Cardmatch_Channel_Barclay', 
					get_class($channelObjects[0]), 
					'Third element of the channelObjects should be of type Cardmatch_Channel_Barclay.  channelObjects[0] class = ' . get_class($channelObjects[0]));
		$this->assertEquals(
					'Cardmatch_Channel_TransUnion', 
					get_class($channelObjects[1]), 
					'First element of the channelObjects should be of type Cardmatch_Channel_TransUnion.  channelObjects[1] class = ' . get_class($channelObjects[1])
		);
		$this->assertEquals(
					'Cardmatch_Channel_Amex', 
					get_class($channelObjects[2]), 
					'Second element of the channelObjects should be of type Cardmatch_Channel_Amex.  channelObjects[2] class = ' . get_class($channelObjects[2]));
    }

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNoChannelsThrowsException() {
		$hub = new Cardmatch_ChannelHub();
		$channels = $hub->getChannels();
	}


	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testAllChannelsInactiveThrowsException() {

		$path = TEST_DATA_PATH . '/channels-disabled.ini';
		$config = new Zend_Config_Ini($path, 'development');

		$hub = new Cardmatch_ChannelHub($config);
		$channels = $hub->getChannels();
	}
    
    public function testGetProducts() {


		$channelHubMock = $this->getMock('Cardmatch_ChannelHub', array(
				'_getProductsFromChannel',
				'_removeDuplicateCards',
				'_getChannelOffers',
				'getChannels',
				'hasValidCache',
				'saveCardIds',
				'getUser'
			),
			array($this->getConfig())

		);


	    $channelOffers = array(
		    array(new Cardmatch_Offer(123)),
		    array(new Cardmatch_Offer(345)),
	    );


	    $channelHubMock->expects($this->any())
		    ->method('getUser')
		    ->will($this->returnValue($this->getTestUser()));

	    $channelHubMock->expects($this->exactly(2))
					->method('_getChannelOffers')
					->will($this->onConsecutiveCalls($channelOffers[0], $channelOffers[1]));


	    # mock of parameter to ensure 2 channels are run
	    $channelObjectsArray = array(
		    new Cardmatch_Channel_Amex($this->_config),
		    new Cardmatch_Channel_Amex($this->_config),
	    );

	    $channelHubMock->expects($this->any())
		    ->method('getChannels')
		    ->will($this->returnValue($channelObjectsArray));

	    $channelHubMock->expects($this->any())
			    ->method('hasValidCache')
			    ->will($this->returnValue(false));

	    $channelHubMock->expects($this->any())
			    ->method('saveCardIds')
			    ->will($this->returnValue(true));

		$offers = $channelHubMock->getOffers();

	    foreach($channelOffers as $key => $channelOffer) {
		    $expectedOffer = $channelOffer[0];
		    $this->assertEquals($expectedOffer->getCardId(), $offers[$key]->getCardId());
	    }
	}    

    public function testClearCache(){
        //load the test config object into the channel hub
        $config = $this->getConfig();
        $this->_hub->setConfig($config);
        //create cache channel mock that returns true if method is called
        $cacheMock = $this->getMock('Cardmatch_Channel_Cache',array('clearCache'),array($this->_hub->getConfig()->cache));
        $cacheMock->expects($this->once())
                ->method('clearCache')
				->will($this->returnValue(TRUE));
		//replace cache channel w/ mock
		$this->_hub->setCache($cacheMock);
		//run the method
		$result = $this->_hub->clearCache();
		//method w/ mock should return true.
		$this->assertTrue($result);
	}

	public function testGetOffersFromCache() {

		$path = TEST_DATA_PATH . '/channels-disabled.ini';
		$config = new Zend_Config_Ini($path, 'development');
		$cache = new Cardmatch_Channel_Cache($config->cache);

		$client = new Cardmatch_Client_CacheHelper($config->cache->cookie);

		$cache->setApiClient($client);

		$expectedOffers = array(
			new Cardmatch_Offer(123),
			new Cardmatch_Offer(345)
		);

		$user = new Cardmatch_User();
		$cache->saveOffers($expectedOffers);

		$hub = new Cardmatch_ChannelHub($config, $user);
		$hub->setCache($cache);

		$actualOffers = $hub->getOffers();

		$this->assertEquals($expectedOffers, $actualOffers);
	}


	public function testAckDisplayed() {
		# mock the Channel classes to get ackDisplayed for them both
		$channelMock = $this->getMockBuilder('Cardmatch_Channel_Amex')
						->setMethods(array('ackDisplayed'))
						->disableOriginalConstructor()
						->getMock();
		$channelMock->expects($this->any())
			->method('ackDisplayed')
			->will($this->returnValue(true));

		# mock the ChannelHub to substitute out getChannels to return Channel mocks
		$CHMock = $this->getMockBuilder('Cardmatch_ChannelHub')
			->setMethods(array('getChannels'))
			->disableOriginalConstructor()
			->getMock();
		$CHMock->expects($this->any())
			->method('getChannels')
			->will($this->returnValue(array($channelMock)));

		# test that ackDisplayed is being called

		$this->assertTrue($CHMock->ackDisplayed());

	}
    
    /***********
     * Getters *
     ***********/
    
    public function getConfig(){
        return $this->_config;
    }
    
    public function getHub(){
        return $this->_hub;
    }
        
    public function getTestUser(){
        $user = new Cardmatch_User();

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
    
    public function getTestChannelValues(){
        $valueArray = array(1,2,3,4,5);
        return $valueArray;
    }
    
    private function _getTuObjectArray(){
        $cardObjArr = array();
        $rows = array(
            array(
                'cardId'=>1,
                'default_commission'=>10,
                'commission_label'=>'Commission Label 1',
                'status'=>'Status 1',
                'cardTitle'=>'Card Title 1',
                'cardDescription'=>'Description 1',
                'cardDetailText'=>'Card Detail Text 1',
                'imagePath'=>'http://domain1.com/imagePath.jpg',
                'url'=>'http://issuer.com/url1',
                'cardLink'=>'Card link 1',
                'introApr'=>'Intro APR string 1',
                'q_introApr'=>1,
                'regularApr'=>'Regular APR string 1',
                'q_regularApr'=>10,
                'introAprPeriod'=>'Intro APR period string 1',
                'q_introAprPeriod'=>10,
                'annualFee'=>'Annual Fee string 1',
                'q_annualFee'=>10,
                'monthlyFee'=>'Monthly fee string 1',
                'q_monthlyFee'=>1,
                'balanceTransfers'=>'Balance Transfer String 1',
                'q_balanceTransfers'=>1,
                'balanceTransferFee'=>'Balance Transfer String 2',
                'q_balanceTransferFee'=>10,
                'creditNeeded'=>'Credit needed string',
                'q_creditNeeded'=>100,
                'cardIntroDetail'=>'Card intro detail 1',
                'merchant'=>'Merchant name 1',
                'dateCreated'=>'2001-01-01',
                'applyByPhoneNumber'=>'Apply by Number',
                'intro_balance_transfer_apr'=>'Intro balance Transfer APR string 1',
                'intro_balance_transfer_apr_period'=>'',
            ),
            array(
                'cardId'=>2,
                'default_commission'=>20,
                'commission_label'=>'Commission Label 2',
                'status'=>'Status 2',
                'cardTitle'=>'Card Title 2',
                'cardDescription'=>'Description 2',
                'cardDetailText'=>'Card Detail Text 2',
                'imagePath'=>'http://domain2.com/imagePath.jpg',
                'url'=>'http://issuer.com/url2',
                'cardLink'=>'Card link 2',
                'introApr'=>'Intro APR string 2',
                'q_introApr'=>2,
                'regularApr'=>'Regular APR string 2',
                'q_regularApr'=>20,
                'introAprPeriod'=>'Intro APR period string 2',
                'q_introAprPeriod'=>20,
                'annualFee'=>'Annual Fee string 2',
                'q_annualFee'=>20,
                'monthlyFee'=>'Monthly fee string 2',
                'q_monthlyFee'=>2,
                'balanceTransfers'=>'Balance Transfer String 2',
                'q_balanceTransfers'=>2,
                'balanceTransferFee'=>'Balance Transfer String 2',
                'q_balanceTransferFee'=>20,
                'creditNeeded'=>'Credit needed string',
                'q_creditNeeded'=>200,
                'cardIntroDetail'=>'Card intro detail 2',
                'merchant'=>'Merchant name 2',
                'dateCreated'=>'2002-02-02',
                'applyByPhoneNumber'=>'Apply by Number',
                'intro_balance_transfer_apr'=>'Intro balance Transfer APR string 2',
                'intro_balance_transfer_apr_period'=>'',
            ),
            array(
                'cardId'=>3,
                'default_commission'=>30,
                'commission_label'=>'Commission Label 3',
                'status'=>'Status 3',
                'cardTitle'=>'Card Title 3',
                'cardDescription'=>'Description 3',
                'cardDetailText'=>'Card Detail Text 3',
                'imagePath'=>'http://domain3.com/imagePath.jpg',
                'url'=>'http://issuer.com/url3',
                'cardLink'=>'Card link 3',
                'introApr'=>'Intro APR string 3',
                'q_introApr'=>3,
                'regularApr'=>'Regular APR string 3',
                'q_regularApr'=>30,
                'introAprPeriod'=>'Intro APR period string 3',
                'q_introAprPeriod'=>30,
                'annualFee'=>'Annual Fee string 3',
                'q_annualFee'=>30,
                'monthlyFee'=>'Monthly fee string 3',
                'q_monthlyFee'=>3,
                'balanceTransfers'=>'Balance Transfer String 3',
                'q_balanceTransfers'=>3,
                'balanceTransferFee'=>'Balance Transfer String 2',
                'q_balanceTransferFee'=>30,
                'creditNeeded'=>'Credit needed string',
                'q_creditNeeded'=>300,
                'cardIntroDetail'=>'Card intro detail 3',
                'merchant'=>'Merchant name 3',
                'dateCreated'=>'2003-03-03',
                'applyByPhoneNumber'=>'Apply by Number',
                'intro_balance_transfer_apr'=>'Intro balance Transfer APR string 3',
                'intro_balance_transfer_apr_period'=>'',
            ),
            
        );

        foreach($rows as $row){
	        $cardDao = new Cardmatch_CardDao();
	        $card = $cardDao->buildFromRow($row);
	        $cardObjArr[] = $card;
        }

        return $cardObjArr;
    }
    
    private function _getAmexObjectArray(){
        $cardObjArr = array();
        $rows = array(
            array(
                'cardId'=>5,
                'default_commission'=>50,
                'commission_label'=>'Commission Label 5',
                'status'=>'Status 5',
                'cardTitle'=>'Card Title 5',
                'cardDescription'=>'Description 5',
                'cardDetailText'=>'Card Detail Text 5',
                'imagePath'=>'http://domain5.com/imagePath.jpg',
                'url'=>'http://issuer.com/url5',
                'cardLink'=>'Card link 5',
                'introApr'=>'Intro APR string 5',
                'q_introApr'=>5,
                'regularApr'=>'Regular APR string 5',
                'q_regularApr'=>50,
                'introAprPeriod'=>'Intro APR period string 5',
                'q_introAprPeriod'=>50,
                'annualFee'=>'Annual Fee string 5',
                'q_annualFee'=>50,
                'monthlyFee'=>'Monthly fee string 5',
                'q_monthlyFee'=>5,
                'balanceTransfers'=>'Balance Transfer String 5',
                'q_balanceTransfers'=>5,
                'balanceTransferFee'=>'Balance Transfer String 5',
                'q_balanceTransferFee'=>50,
                'creditNeeded'=>'Credit needed string',
                'q_creditNeeded'=>500,
                'cardIntroDetail'=>'Card intro detail 5',
                'merchant'=>'Merchant name 5',
                'dateCreated'=>'2005-05-05',
                'applyByPhoneNumber'=>'Apply by Number',
                'intro_balance_transfer_apr'=>'Intro balance Transfer APR string 5',
                'intro_balance_transfer_apr_period'=>'',
            ),
            //Card id 2 exists in transunion. Duplicate handling test.
            array(
                'cardId'=>2,
                'default_commission'=>20,
                'commission_label'=>'Commission Label 2',
                'status'=>'Status 2',
                'cardTitle'=>'Card Title 2',
                'cardDescription'=>'Description 2',
                'cardDetailText'=>'Card Detail Text 2',
                'imagePath'=>'http://domain2.com/imagePath.jpg',
                'url'=>'http://issuer.com/url2',
                'cardLink'=>'Card link 2',
                'introApr'=>'Intro APR string 2',
                'q_introApr'=>2,
                'regularApr'=>'Regular APR string 2',
                'q_regularApr'=>20,
                'introAprPeriod'=>'Intro APR period string 2',
                'q_introAprPeriod'=>20,
                'annualFee'=>'Annual Fee string 2',
                'q_annualFee'=>20,
                'monthlyFee'=>'Monthly fee string 2',
                'q_monthlyFee'=>2,
                'balanceTransfers'=>'Balance Transfer String 2',
                'q_balanceTransfers'=>2,
                'balanceTransferFee'=>'Balance Transfer String 5',
                'q_balanceTransferFee'=>20,
                'creditNeeded'=>'Credit needed string',
                'q_creditNeeded'=>200,
                'cardIntroDetail'=>'Card intro detail 2',
                'merchant'=>'Merchant name 2',
                'dateCreated'=>'2002-02-02',
                'applyByPhoneNumber'=>'Apply by Number',
                'intro_balance_transfer_apr'=>'Intro balance Transfer APR string 2',
                'intro_balance_transfer_apr_period'=>'',
            ),
            array(
                'cardId'=>6,
                'default_commission'=>60,
                'commission_label'=>'Commission Label 6',
                'status'=>'Status 6',
                'cardTitle'=>'Card Title 6',
                'cardDescription'=>'Description 6',
                'cardDetailText'=>'Card Detail Text 6',
                'imagePath'=>'http://domain6.com/imagePath.jpg',
                'url'=>'http://issuer.com/url6',
                'cardLink'=>'Card link 6',
                'introApr'=>'Intro APR string 6',
                'q_introApr'=>6,
                'regularApr'=>'Regular APR string 6',
                'q_regularApr'=>60,
                'introAprPeriod'=>'Intro APR period string 6',
                'q_introAprPeriod'=>60,
                'annualFee'=>'Annual Fee string 6',
                'q_annualFee'=>60,
                'monthlyFee'=>'Monthly fee string 6',
                'q_monthlyFee'=>6,
                'balanceTransfers'=>'Balance Transfer String 6',
                'q_balanceTransfers'=>6,
                'balanceTransferFee'=>'Balance Transfer String 5',
                'q_balanceTransferFee'=>60,
                'creditNeeded'=>'Credit needed string',
                'q_creditNeeded'=>600,
                'cardIntroDetail'=>'Card intro detail 6',
                'merchant'=>'Merchant name 6',
                'dateCreated'=>'2006-06-06',
                'applyByPhoneNumber'=>'Apply by Number',
                'intro_balance_transfer_apr'=>'Intro balance Transfer APR string 6',
                'intro_balance_transfer_apr_period'=>'',
            ),  
        );
        foreach($rows as $row){
	        $cardDao = new Cardmatch_CardDao();
	        $card = $cardDao->buildFromRow($row);
	        $cardObjArr[] = $card;
        }
        return $cardObjArr;
    }
    
    private function _getCacheObjectArray(){
        $cardObjArr = array();
        $rows = array(
            array(
                'cardId'=>1,
                'default_commission'=>10,
                'commission_label'=>'Commission Label 1',
                'status'=>'Status 1',
                'cardTitle'=>'Card Title 1',
                'cardDescription'=>'Description 1',
                'cardDetailText'=>'Card Detail Text 1',
                'imagePath'=>'http://domain1.com/imagePath.jpg',
                'url'=>'http://issuer.com/url1',
                'cardLink'=>'Card link 1',
                'introApr'=>'Intro APR string 1',
                'q_introApr'=>1,
                'regularApr'=>'Regular APR string 1',
                'q_regularApr'=>10,
                'introAprPeriod'=>'Intro APR period string 1',
                'q_introAprPeriod'=>10,
                'annualFee'=>'Annual Fee string 1',
                'q_annualFee'=>10,
                'monthlyFee'=>'Monthly fee string 1',
                'q_monthlyFee'=>1,
                'balanceTransfers'=>'Balance Transfer String 1',
                'q_balanceTransfers'=>1,
                'balanceTransferFee'=>'Balance Transfer String 2',
                'q_balanceTransferFee'=>10,
                'creditNeeded'=>'Credit needed string',
                'q_creditNeeded'=>100,
                'cardIntroDetail'=>'Card intro detail 1',
                'merchant'=>'Merchant name 1',
                'dateCreated'=>'2001-01-01',
                'applyByPhoneNumber'=>'Apply by Number',
                'intro_balance_transfer_apr'=>'Intro balance Transfer APR string 1',
                'intro_balance_transfer_apr_period'=>'',
            ),
            array(
                'cardId'=>2,
                'default_commission'=>20,
                'commission_label'=>'Commission Label 2',
                'status'=>'Status 2',
                'cardTitle'=>'Card Title 2',
                'cardDescription'=>'Description 2',
                'cardDetailText'=>'Card Detail Text 2',
                'imagePath'=>'http://domain2.com/imagePath.jpg',
                'url'=>'http://issuer.com/url2',
                'cardLink'=>'Card link 2',
                'introApr'=>'Intro APR string 2',
                'q_introApr'=>2,
                'regularApr'=>'Regular APR string 2',
                'q_regularApr'=>20,
                'introAprPeriod'=>'Intro APR period string 2',
                'q_introAprPeriod'=>20,
                'annualFee'=>'Annual Fee string 2',
                'q_annualFee'=>20,
                'monthlyFee'=>'Monthly fee string 2',
                'q_monthlyFee'=>2,
                'balanceTransfers'=>'Balance Transfer String 2',
                'q_balanceTransfers'=>2,
                'balanceTransferFee'=>'Balance Transfer String 2',
                'q_balanceTransferFee'=>20,
                'creditNeeded'=>'Credit needed string',
                'q_creditNeeded'=>200,
                'cardIntroDetail'=>'Card intro detail 2',
                'merchant'=>'Merchant name 2',
                'dateCreated'=>'2002-02-02',
                'applyByPhoneNumber'=>'Apply by Number',
                'intro_balance_transfer_apr'=>'Intro balance Transfer APR string 2',
                'intro_balance_transfer_apr_period'=>'',
            ),
            array(
                'cardId'=>3,
                'default_commission'=>30,
                'commission_label'=>'Commission Label 3',
                'status'=>'Status 3',
                'cardTitle'=>'Card Title 3',
                'cardDescription'=>'Description 3',
                'cardDetailText'=>'Card Detail Text 3',
                'imagePath'=>'http://domain3.com/imagePath.jpg',
                'url'=>'http://issuer.com/url3',
                'cardLink'=>'Card link 3',
                'introApr'=>'Intro APR string 3',
                'q_introApr'=>3,
                'regularApr'=>'Regular APR string 3',
                'q_regularApr'=>30,
                'introAprPeriod'=>'Intro APR period string 3',
                'q_introAprPeriod'=>30,
                'annualFee'=>'Annual Fee string 3',
                'q_annualFee'=>30,
                'monthlyFee'=>'Monthly fee string 3',
                'q_monthlyFee'=>3,
                'balanceTransfers'=>'Balance Transfer String 3',
                'q_balanceTransfers'=>3,
                'balanceTransferFee'=>'Balance Transfer String 2',
                'q_balanceTransferFee'=>30,
                'creditNeeded'=>'Credit needed string',
                'q_creditNeeded'=>300,
                'cardIntroDetail'=>'Card intro detail 3',
                'merchant'=>'Merchant name 3',
                'dateCreated'=>'2003-03-03',
                'applyByPhoneNumber'=>'Apply by Number',
                'intro_balance_transfer_apr'=>'Intro balance Transfer APR string 3',
                'intro_balance_transfer_apr_period'=>'',
            ),
            
        );
        foreach($rows as $row){
	        $cardDao = new Cardmatch_CardDao();
	        $card = $cardDao->buildFromRow($row);
	        $cardObjArr[] = $card;
        }
        return $cardObjArr;
	}
}
