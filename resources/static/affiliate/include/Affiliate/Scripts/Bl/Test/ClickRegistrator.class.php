<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright ? 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: ClickRegistrator.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class Affiliate_Scripts_Bl_Test_ClickRegistrator extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_ClickRegistrator');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------

    function testSaveClick()
    {
        $sql = 'delete from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->_registrator->AccountID = 'default1';
        $this->_registrator->CampaignCategoryID = '2';
        $this->_registrator->BannerID = '1';
        $this->_registrator->ClickTransactionApproval = '2';
        $this->_registrator->DeclineFrequentClicks = '0';
        $this->_registrator->FrequentClicks = '1';
        $this->_registrator->CampaignCommType = '1';
        $this->_registrator->CampaignID = '2';
        $this->_registrator->ClickCommission = '10';
        $this->_registrator->UserID = '14';
        $this->_registrator->cookieSetReturn = '';
        $this->_registrator->maxCommissionLevels = '10';
        $referrer = '127.0.0.1';
        
        // referrer
        $this->assertTrue($this->_registrator->saveClick($referrer), 'Save click failed');

        $sql = 'select * from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals('1', $rs->fields['transtype'], 'DB transtype');
        $this->assertEquals('1', $rs->fields['transkind'], 'DB transkind');
        $this->assertEquals('14', $rs->fields['affiliateid'], 'DB affiliateid');
        $this->assertEquals('2', $rs->fields['campcategoryid'], 'DB campcategoryid');
        $this->assertEquals('10', $rs->fields['commission'], 'DB commissions');

        $rs->MoveNext();

        $i = 0;
        while(!$rs->EOF)
        {
            $i++;

            $this->assertEquals('1', $rs->fields['transtype'], 'DB transtype '.$i);
            $this->assertEquals(($i+11), $rs->fields['transkind'], 'DB transkind '.$i);
            $this->assertEquals((14-$i), $rs->fields['affiliateid'], 'DB affiliateid '.$i);
            $this->assertEquals('2', $rs->fields['campcategoryid'], 'DB campcategoryid '.$i);
            $this->assertEquals((10-$i), $rs->fields['commission'], 'DB commissions '.$i);
            
            $rs->MoveNext();
        }
    }

    //--------------------------------------------------------------------------

    function testRegisterMultiTierClickCommission()
    {
        $sql = 'delete from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);
    
        $this->_registrator->AccountID = 'default1';
        $this->_registrator->CampaignCategoryID = '2';
        $this->_registrator->BannerID = '1';
        $this->_registrator->CampaignCommType = '1';
        $this->_registrator->CampaignID = '2';
        $this->_registrator->cookieSetReturn = '99';
        $this->_registrator->maxCommissionLevels = '10';
        $TransID = '2';
        $remoteAddr = $_SERVER['HTTP_REFERER'];
        $ip = '127.0.0.1';
        $status = AFFSTATUS_APPROVED;
        $this->_registrator->UserID = '14';
        $this->_registrator->multiTierCommissionsCounter = 0;

        $this->_registrator->STClickCommission[2] = 9;
        $this->_registrator->STClickCommission[3] = 8;
        $this->_registrator->STClickCommission[4] = 7;
        $this->_registrator->STClickCommission[5] = 6;
        $this->_registrator->STClickCommission[6] = 5;
        $this->_registrator->STClickCommission[7] = 4;
        $this->_registrator->STClickCommission[8] = 3;
        $this->_registrator->STClickCommission[9] = 2;
        $this->_registrator->STClickCommission[10] = 1;

        // this is tested
        $this->_registrator->registerMultiTierClickCommission($TransID, $remoteAddr,
                             $ip, $status, $this->_registrator->UserID, 2);

        $this->assertEquals('9',$this->_registrator->multiTierCommissionsCounter,
                            'Save multitier commission failed');

        $sql = 'select * from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $i = 0; 
        while(!$rs->EOF)
        {
            $i++;

            $this->assertEquals('1', $rs->fields['transtype'], 'DB transtype '.$i);
            $this->assertEquals(($i+11), $rs->fields['transkind'], 'DB transkind '.$i);
            $this->assertEquals((14-$i), $rs->fields['affiliateid'], 'DB affiliateid '.$i);
            $this->assertEquals('2', $rs->fields['campcategoryid'], 'DB campcategoryid '.$i);
            $this->assertEquals((10-$i), $rs->fields['commission'], 'DB commissions '.$i);
            
            $rs->MoveNext();
        }
    }

    //--------------------------------------------------------------------------

    function testCheckBeforeSaveClick()
    {
        $this->_registrator->CampaignCategoryID = 'something';
        $this->_registrator->BannerID = 'something';

        // referer
        $this->assertEquals(array('status' => AFFSTATUS_APPROVED,
                                  'ip' => $_SERVER['REMOTE_ADDR'],
                                  'remoteAddr' => 'myReferer'
                                 ),
                            $this->_registrator->checkBeforeSaveClick('myReferer'),
                            'Check before save click failed');
    }

    //--------------------------------------------------------------------------

    function testGetCommission()
    {
        $this->_registrator->CampaignCommType = TRANSTYPE_CLICK;
        $this->_registrator->ClickCommission = '20';

        $this->assertEquals('20',$this->_registrator->getCommission(),
                            'Get commission failed');

        // 

        $this->_registrator->CampaignCommType = -1;
        $this->_registrator->ClickCommission = '20';

        $this->assertEquals('0',$this->_registrator->getCommission(),
                            'Get commission passed');

    }
    
    //--------------------------------------------------------------------------
    
    function testgetCommissionMultiTier()
    {
        $this->_registrator->CampaignCommType = TRANSTYPE_CLICK;
        $this->_registrator->STClickCommission[2] = '9';

        $params = array('tier' => '2');
        
        $this->assertEquals('9',$this->_registrator->getCommissionMultiTier($params),
                            'Get commission multi tier failed');

        // 

        $this->_registrator->CampaignCommType = -1;
        $this->_registrator->STClickCommission[2] = '9';

        $params = array('tier' => '2');

        $this->assertFalse($this->_registrator->getCommissionMultiTier($params),
                            'Get commission multi tier passed');

    }

    //--------------------------------------------------------------------------

    function testGetParentUser()
    {
        $this->_registrator->AccountID = 'default1';
        // check parent that not exist
        $params = array('parentUserID' => '756',
                        'status' => '2');
    
        $this->assertFalse($this->_registrator->getParentUser($params),'Get parent found');        

        // check parent that exist
        $params = array('parentUserID' => '3',
                        'status' => '2',
                        'accountid' => 'default1');
    
        $this->assertEquals(array('userID' => '4','status' => '2'),
                    $this->_registrator->getParentUser($params),'Get parent failed');        
    }

    //--------------------------------------------------------------------------

    function testCheckSpecialCommission()
    {
        $this->_registrator->CampaignID = '2';
        $this->_registrator->CampaignCategoryID = '2';
        
        $params = array('userID' => '3',
                        'tier' => '2');

        // userid and tier as params
        $this->assertTrue($this->_registrator->checkSpecialCommission($params),'Check special commission failed');
        
        $this->assertEquals('9',$this->_registrator->STClickCommission[$params['tier']],
                            'Var STClickCommission '.$params['tier'].' tier');
    }  

    //--------------------------------------------------------------------------

    function testApplyFraudProtection()
    {
        $status = 2;
        $this->_registrator->ClickFrequency = '10';
    
        // ip, click transaction approval status
        $this->assertTrue($this->_registrator->applyFraudProtection('127.0.0.1', $status),
                          'Fraud protection failed');
        
        $this->assertEquals(2, $status, 'Status suppressed');
    }

    //--------------------------------------------------------------------------    
    // Other functions
    //--------------------------------------------------------------------------
/*
    function testSetRegVariables() 
    {
        $this->fail('abdc');
    }
*/
}
?>
