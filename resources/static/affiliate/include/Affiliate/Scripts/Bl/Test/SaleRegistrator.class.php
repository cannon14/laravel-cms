<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright ? 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: SaleRegistrator.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class Affiliate_Scripts_Bl_Test_SaleRegistrator extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------

    function testFindPaymentBySubscriptionID()
    {
        // orderid
        $this->assertTrue($this->_registrator->findPaymentBySubscriptionID('12345'), 'Payment not found');

    }

    //--------------------------------------------------------------------------

    function testSetSaleTypeAndKind()
    {
        $this->_registrator->saleType = '';
        $this->_registrator->saleKind = '';

        // transaction type, transaction kind
        $this->assertTrue($this->_registrator->setSaleTypeAndKind('1','1'),
                             'Set type and kind go trought');

        $this->assertEquals('1',$this->_registrator->saleType,'Var saleType');
        $this->assertEquals('1',$this->_registrator->saleKind,'Var saleKind');

    }

    //--------------------------------------------------------------------------

    function testInitData()
    {
        // userid, campaign
        $this->assertTrue($this->_registrator->initData('3', '1'), 'Data not inited');

    }

    //--------------------------------------------------------------------------

    function testLookupForProductCategory()
    {
        $this->_registrator->UserID = '3';

        // productid
        $this->assertTrue($this->_registrator->lookupForProductCategory('456'), 'No product category for found');

        // productid
        $this->assertFalse($this->_registrator->lookupForProductCategory('123456789'), 'Product category found');

    }

    //--------------------------------------------------------------------------

    function testSetNewProductCategory()
    {
        $this->_registrator->UserID = '3';
        $this->_registrator->settings['Aff_maxcommissionlevels'] = 10;
    
        // campaignid
        $this->assertTrue($this->_registrator->setNewProductCategory('1'),
                            'Set new product category failed');

        $this->assertEquals('1', $this->_registrator->CampaignCategoryID, 'Var CampaignCategoryID');
        $this->assertEquals('0', $this->_registrator->ClickCommission, 'Var ClickCommission');
        $this->assertEquals('20', $this->_registrator->SaleCommission, 'Var SaleCommission');
        $this->assertEquals('$', $this->_registrator->PerSaleCommType, 'Var PerSaleCommType');
        $this->assertEquals('$', $this->_registrator->STPerSaleCommType, 'Var STPerSaleCommType');
        $this->assertEquals('15', $this->_registrator->RecurringCommission, 'Var RecurringCommission');
        $this->assertEquals('$', $this->_registrator->RecurringCommType, 'Var RecurringCommType');
        $this->assertNull($this->_registrator->RecurringCommDate, 'Var RecurringCommDate');
        $this->assertEquals('1', $this->_registrator->RecurringDateType, 'Var RecurringDateType');
        $this->assertEquals('$', $this->_registrator->STRecurringCommType, 'Var STRecurringCommType');

        for($i=2; $i<=10; $i++)
        {
            $this->assertEquals(0, $this->_registrator->STClickCommission[$i], 'Var STClickCommission '.$i.' tier');
            $this->assertEquals((11-$i), $this->_registrator->STSaleCommission[$i], 'Var STSaleCommission '.$i.' tier');
            $this->assertEquals((11-$i), $this->_registrator->STRecurringCommission[$i], 'Var STRecurringCommission '.$i.' tier');
        }

        // campaignid
        $this->assertFalse($this->_registrator->setNewProductCategory('123456789'),
                            'Set new product category passed');

    }

    //--------------------------------------------------------------------------

    function testSetLanguageFile()
    {
        $this->_registrator->settings['Aff_default_lang'] = 'english';
    
        $this->assertTrue($this->_registrator->setLanguageFile(), 'Set language failed');

        $this->_registrator->settings['Aff_default_lang'] = 'aaa';

//        $this->assertFalse($this->_registrator->setLanguageFile(), 'Set language passed');

    }

    //--------------------------------------------------------------------------

    function testApplyFraudProtection()
    {
        $this->_registrator->DeclineFrequentSales = 1;
        $this->_registrator->FrequentSales = 1;
        $this->_registrator->DeclineSameOrderId = 1;
        $this->_registrator->SaleFrequency = 30;
        
        $status = '2';

        // ip, status, orderid
        $this->assertTrue($this->_registrator->applyFraudProtection('127.0.0.1', 
                            &$status, '123456789'), 'Fraud protection failed');

        $this->assertEquals('2', $status, 'Var status');

    }

    //--------------------------------------------------------------------------

    function testComputeCommission()
    {
        // totalCost, commType, saleCommission
        $this->assertEquals('5', $this->_registrator->computeCommission(
                            25, '%', 20), 'Compute commission failed');
    }

    //--------------------------------------------------------------------------

    function testSendNotificationToMerchant()
    {
        $GLOBALS['Test_mode'] = '1';
        $this->_registrator->settings['Aff_email_onsale'] = '1';
        $this->_registrator->settings['Aff_default_lang'] = 'english';
        $this->_registrator->settings['Aff_notifications_email'] = ''; // email address for test emails

        $params = array('id' => '',
                        'userid' => '2',
                        'status' => '2',
                        'commissions' => 20,
                        'totalcost' => 25,
                        'orderid' => '',
                        'productid' => '',
                        'date' => '2005-02-22',
                        'ip' => '127.0.0.1',
                        'referrer' => '127.0.0.1');

        $this->assertTrue($this->_registrator->sendNotificationToMerchant($params),
                            'Notification email to merchant not sent');
        
    }

    //--------------------------------------------------------------------------

    function testSendNotificationToUser()
    {
        $GLOBALS['Test_mode'] = '1';
        $this->_registrator->settings['Aff_email_onsale'] = '1';
        $this->_registrator->settings['Aff_default_lang'] = 'english';
        $this->_registrator->settings['Aff_notifications_email'] = ''; // email address for test emails

        $this->_registrator->UserID = '3';

        $params = array('id' => '',
                        'userid' => '3',
                        'status' => '2',
                        'commissions' => 20,
                        'totalcost' => 25,
                        'orderid' => '',
                        'productid' => '',
                        'date' => '2005-02-22',
                        'ip' => '127.0.0.1',
                        'referrer' => '127.0.0.1');

        $this->assertTrue($this->_registrator->sendNotificationToUser($params),
                            'Notification email to user not sent');
        
    }

    //--------------------------------------------------------------------------

    function testRegisterMultiTierSaleCommission()
    {
        $sql = 'delete from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->_registrator->maxCommissionLevels = '10';
        $this->_registrator->CampaignID = '1';
        $this->_registrator->AccountID = 'default1';
        $this->_registrator->CampaignCommType = '3';
        $this->_registrator->CampaignCategoryID = '1';
        $this->_registrator->SaleType = TRANSTYPE_SALE;
    
        $parentTransID = '4';
        $OrderID = '';
        $ProductID = '';
        $totalCost = '25';
        $remoteAddr = '127.0.0.1';
        $ip = '127.0.0.1';
        $status = '2';
        $parentUserID = '14';
        $tier = '2';
    
        // parentTransID, OrderID, ProductID, totalCost, remoteAddr, ip, status,
        // parentUserID, tier
        $this->_registrator->registerMultiTierSaleCommission($parentTransID, $OrderID,
             $ProductID, $totalCost, $remoteAddr, $ip, $status, $parentUserID, $tier );

        $this->assertEquals('9', $this->_registrator->multiTierSaleCommissionsCounter,
                             'Register multi tier sale commissions failed');

        $sql = 'select * from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $i = 0; 
        while(!$rs->EOF)
        {
            $i++;

            $this->assertEquals('3', $rs->fields['transtype'], 'DB transtype '.$i);
            $this->assertEquals(($i+11), $rs->fields['transkind'], 'DB transkind '.$i);
            $this->assertEquals((14-$i), $rs->fields['affiliateid'], 'DB affiliateid '.$i);
            $this->assertEquals('1', $rs->fields['campcategoryid'], 'DB campcategoryid '.$i);
            $this->assertEquals((10-$i), $rs->fields['commission'], 'DB commissions '.$i);
            
            $rs->MoveNext();
        }
    }

    //--------------------------------------------------------------------------

    function testRegisterMultiTierRecurringCommission()
    {
        $this->_registrator->maxCommissionLevels = '10';
        $this->_registrator->CampaignID = '1';
        $this->_registrator->AccountID = 'default1';
        $this->_registrator->CampaignCategoryID = '1';
        $this->_registrator->STRecurringCommType = '%';

        // parentTransID, totalCost, parentUserID, tier
        $this->_registrator->registerMultiTierRecurringCommission('1','25','14','2');

        $this->assertEquals('9', $this->_registrator->multiTierSaleRecurCommissionsCounter,
                             'Register multi tier sale recurring commissions failed');

        $sql = 'select * from wd_pa_recurringcommissions where recurringcommid=\'1\'';
        $rs = $GLOBALS['db']->execute($sql, $error);

        for($i=2; $i <= 10; $i++)
        {
            $this->assertEquals(2.25-(($i-2)*0.25), $rs->fields['st'.$i.'commission'], 'DB st'.$i.'commission');
            $this->assertEquals('%', $rs->fields['stcommtype'], 'DB stcommtype '.$i);
            $this->assertEquals((15-$i), $rs->fields['st'.$i.'affiliateid'], 'DB st'.$i.'affiliate');
        }
    }

    //--------------------------------------------------------------------------

    function testRegisterSale()
    {
        $sql = 'delete from wd_pa_recurringcommissions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $sql = 'delete from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);
    
        $GLOBALS['Test_mode'] = '1';
        $this->_registrator->settings['Aff_default_lang'] = 'english';
        $this->_registrator->settings['Aff_forcecommfromproductid'] = 'yes';
        $this->_registrator->settings['Aff_apply_from_banner'] = '';
        $this->_registrator->settings['Aff_maxcommissionlevels'] = 10;
        $this->_registrator->settings['Aff_support_recurring_commissions'] = 1;

        $this->_registrator->CampaignCommType = '3';
        $this->_registrator->CampaignID = '1';
        $this->_registrator->AccountID = 'default1';
        $this->_registrator->CampaignCategoryID = '1';
        $this->_registrator->SaleTransactionApproval = '2';
        $this->_registrator->UserID = '14';

        // totalCost, OrderID, ProductID
        $this->assertTrue($this->_registrator->registerSale('111', '12345', '456'),
                             'Register sale failed');

        $sql = 'select * from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals('3', $rs->fields['transtype'], 'DB transtype');
        $this->assertEquals('1', $rs->fields['transkind'], 'DB transkind');
        $this->assertEquals('14', $rs->fields['affiliateid'], 'DB affiliateid');
        $this->assertEquals('1', $rs->fields['campcategoryid'], 'DB campcategoryid');
        $this->assertEquals('20', $rs->fields['commission'], 'DB commissions');

        $rs->MoveNext();

        $i = 0; 
        while(!$rs->EOF)
        {
            $i++;

            $this->assertEquals('3', $rs->fields['transtype'], 'DB transtype '.$i);
            $this->assertEquals(($i+11), $rs->fields['transkind'], 'DB transkind '.$i);
            $this->assertEquals((14-$i), $rs->fields['affiliateid'], 'DB affiliateid '.$i);
            $this->assertEquals('1', $rs->fields['campcategoryid'], 'DB campcategoryid '.$i);
            $this->assertEquals((10-$i), $rs->fields['commission'], 'DB commissions '.$i);
            
            $rs->MoveNext();
        }

        $sql = 'select * from wd_pa_recurringcommissions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals('15', $rs->fields['commission'], 'DB commission');
        $this->assertEquals('2', $rs->fields['rstatus'], 'DB rstatus');
        for($i=2; $i <= 10; $i++)
        {
            $this->assertEquals((11-$i), $rs->fields['st'.$i.'commission'], 'DB st'.$i.'commission');
            $this->assertEquals('$', $rs->fields['stcommtype'], 'DB stcommtype '.$i);
            $this->assertEquals((15-$i), $rs->fields['st'.$i.'affiliateid'], 'DB st'.$i.'affiliate');
        }
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
