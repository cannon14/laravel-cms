<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright � 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: RecurringCommissions.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class Affiliate_Scripts_Bl_Test_RecurringCommissions extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_RecurringCommissions');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------

    function testGenerateTransactions()
    {
        $GLOBALS['Test_mode'] = '1';

        $this->_registrator->test_date = '2005-3-14';

        // userid
        $this->assertEquals('1',$this->_registrator->generateTransactions(),'Transaction not generated');

        $sql = 'select * from wd_pa_transactions where transid like \'____%\'';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals('4', $rs->fields['transtype'], 'DB transtype');
        $this->assertEquals('3', $rs->fields['transkind'], 'DB transkind');
        $this->assertEquals('3', $rs->fields['affiliateid'], 'DB affiliateid');
        $this->assertEquals('1', $rs->fields['campcategoryid'], 'DB campcategoryid');
        $this->assertEquals('10', $rs->fields['commission'], 'DB commissions');

        $rs->MoveNext();

        $i = 0; 
        while(!$rs->EOF)
        {
            $i++;

            $this->assertEquals('4', $rs->fields['transtype'], 'DB transtype '.$i);
            $this->assertEquals(($i+11), $rs->fields['transkind'], 'DB transkind '.$i);
            $this->assertEquals((14-$i), $rs->fields['affiliateid'], 'DB affiliateid '.$i);
            $this->assertEquals('1', $rs->fields['campcategoryid'], 'DB campcategoryid '.$i);
            $this->assertEquals((10-$i), $rs->fields['commission'], 'DB commissions '.$i);

            $rs->MoveNext();
        }
    }

    //--------------------------------------------------------------------------

    function testGetDataForRecurringTransaction()
    {
        // current date
        $rs = $this->_registrator->getDataForRecurringTransaction('2005-3-14', 'default1');
        
        $this->assertEquals('1', $rs->fields['recurringcommid'], 'DB recurringcommid 1 failed');
        $rs->MoveNext();
        $this->assertEquals('2', $rs->fields['recurringcommid'], 'DB recurringcommid 2 failed');
    }
    
    //--------------------------------------------------------------------------

    function testGetCurrentPaymentDate()
    {
        $dayofmonth = '1';
        $dayofweek = '3';
        $month = '2';
        $week = '5';
        $year = '2005';

        $datetype = RECURRINGTYPE_MONTHLY;
    
        // dayofmonth, dayofweek, month, week, year, datetype
        $this->assertEquals('2005-'.date("n").'-1',$this->_registrator->getCurrentPaymentDate(
        $dayofmonth,$dayofweek,$month,$week,$year,$datetype),'Can not get current monthy payment date');

        $dayofmonth = '1';
        $dayofweek = '3';
        $month = '2';
        $week = '5';
        $year = '2005';
        $datetype = RECURRINGTYPE_WEEKLY;

        $days = computeDateToDays(date('j'), date("n"), date("Y"));
        $days--;
        $dayofweek2 = date('w') - 1;
        if($dayofweek2 < 0)
            $dayofweek2 = 6;
        $dayofweek2++;
        if(3 > $dayofweek2)
            computeDaysToDate($days + (3 - $dayofweek2), $nextDay, $nextMonth, $nextYear);
        else
            computeDaysToDate($days + 7 - ($dayofweek2 - 3), $nextDay, $nextMonth, $nextYear);

        // dayofmonth, dayofweek, month, week, year, datetype
        $this->assertEquals($nextYear.'-'.$nextMonth.'-'.$nextDay,$this->_registrator->getCurrentPaymentDate(
        $dayofmonth,$dayofweek,$month,$week,$year,$datetype),'Can not get current weekly payment date');

        $dayofmonth = '1';
        $dayofweek = '3';
        $month = '2';
        $week = '5';
        $year = '2005';
        $datetype = RECURRINGTYPE_QUARTERLY;

        // dayofmonth, dayofweek, month, week, year, datetype
        $this->assertEquals('2005-5-3',$this->_registrator->getCurrentPaymentDate(
        $dayofmonth,$dayofweek,$month,$week,$year,$datetype),'Can not get current quarterly payment date');

        $dayofmonth = '1';
        $dayofweek = '3';
        $month = '2';
        $week = '5';
        $year = '2005';
        $datetype = RECURRINGTYPE_BIANNUALLY;

        // dayofmonth, dayofweek, month, week, year, datetype
        $this->assertEquals('2005-8-2',$this->_registrator->getCurrentPaymentDate(
        $dayofmonth,$dayofweek,$month,$week,$year,$datetype),'Can not get current biannually payment date');

        $dayofmonth = '1';
        $dayofweek = '3';
        $month = '2';
        $week = '5';
        $year = '2005';
        $datetype = RECURRINGTYPE_YEARLY;

        // dayofmonth, dayofweek, month, week, year, datetype
        $this->assertEquals('2006-2-1',$this->_registrator->getCurrentPaymentDate(
        $dayofmonth,$dayofweek,$month,$week,$year,$datetype),'Can not get current yearly payment date');

        $dayofmonth = '1';
        $dayofweek = '3';
        $month = '2';
        $week = '5';
        $year = '2005';
        $datetype = '';

        // dayofmonth, dayofweek, month, week, year, datetype
        $this->assertEquals('undefined',$this->_registrator->getCurrentPaymentDate(
        $dayofmonth,$dayofweek,$month,$week,$year,$datetype),'Can not get current payment date');

    }

    //--------------------------------------------------------------------------

    function testCheckTodaysRecordExist()
    {
        $currentDate = '2005-3-1';
        $params = array('recurringcommid' => '1', 'accountid' => 'default1');

        // params, current date
        $this->assertFalse($this->_registrator->checkTodaysRecordExist($params,$currentDate),
                            'Todays record not exist');

        $currentDate = '2005-2-22';
        $params = array('recurringcommid' => '1', 'accountid' => 'default1');

        // params, current date
        $this->assertTrue($this->_registrator->checkTodaysRecordExist($params,$currentDate),
                           'Todays record exist');

    }

    //--------------------------------------------------------------------------

    function testInsertRecurringTransaction()
    {
        $sql = 'delete from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);
    
        $GLOBALS['Test_mode'] = '1';
        $this->_registrator->account_settings = array(
                          'Aff_recurringrealcommissions' => '1',
                          'Aff_email_recurringtrangenerated' => '1',
                          'Aff_default_lang' => 'english',
                          'Aff_notifications_email' => ''// email address for test emails
                         );


        $this->_registrator->maxCommissionLevels = 10;

        $params = array('totalcost' => '',
                        'productid' => '',
                        'commission' => '10',
                        'commtype' => '$',
                        'campcategoryid' => '1',
                        'recurringcommid' => '2',
                        'saleapproval' => '2',
                        'affiliateid' => '3',
                        'st2affiliateid' => '13',
                        'st2commission' => '9',
                        'st3affiliateid' => '12',
                        'st3commission' => '8',
                        'st4affiliateid' => '11',
                        'st4commission' => '7',
                        'st5affiliateid' => '10',
                        'st5commission' => '6',
                        'st6affiliateid' => '9',
                        'st6commission' => '5',
                        'st7affiliateid' => '8',
                        'st7commission' => '4',
                        'st8affiliateid' => '7',
                        'st8commission' => '3',
                        'st9affiliateid' => '6',
                        'st9commission' => '2',
                        'st10affiliateid' => '5',
                        'st10commission' => '1',
                        'campcategoryid' => '1',
                        'orderid' => '12345',
                        'recurringcommid' => '2'
                       );

        // params
        $this->assertTrue($this->_registrator->insertRecurringTransaction($params),
                            'Recurring transaction not inserted');

        $sql = 'select * from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals('4', $rs->fields['transtype'], 'DB transtype');
        $this->assertEquals('3', $rs->fields['transkind'], 'DB transkind');
        $this->assertEquals('3', $rs->fields['affiliateid'], 'DB affiliateid');
        $this->assertEquals('1', $rs->fields['campcategoryid'], 'DB campcategoryid');
        $this->assertEquals('15', $rs->fields['commission'], 'DB commissions');

        $rs->MoveNext();

        $i = 0; 
        while(!$rs->EOF)
        {
            $i++;

            $this->assertEquals('4', $rs->fields['transtype'], 'DB transtype '.$i);
            $this->assertEquals(($i+11), $rs->fields['transkind'], 'DB transkind '.$i);
            $this->assertEquals((14-$i), $rs->fields['affiliateid'], 'DB affiliateid '.$i);
            $this->assertEquals('1', $rs->fields['campcategoryid'], 'DB campcategoryid '.$i);
            $this->assertEquals((10-$i), $rs->fields['commission'], 'DB commissions '.$i);

            $rs->MoveNext();
        }
    }

    //--------------------------------------------------------------------------

    function testGetSaleCommission()
    {
        $this->_registrator->account_settings = array('Aff_recurringrealcommissions' => '1');
        
        $params = array('affiliateid' => '3',
                        'campcategoryid' => '1',
                        'commtype' => '',
                        'commission' => '10'
                       );

        $this->assertTrue($this->_registrator->getSaleCommission($params),'Get sale commission failed');

        $this->assertEquals('1',$this->_registrator->CampaignID,'Var CampaignID error');
        $this->assertEquals('3',$this->_registrator->UserID,'Var UserID error');
        $this->assertEquals('$',$this->_registrator->PerSaleCommType,'Var PerSaleCommType error');
        $this->assertEquals(15,$this->_registrator->SaleCommission,'Var SaleCommission error');

        $params = array('affiliateid' => '3',
                        'campcategoryid' => '1',
                        'commtype' => '$',
                        'commission' => '10'
                       );

        $this->assertTrue($this->_registrator->getSaleCommission($params),'Get sale commission failed');

        $this->assertEquals('1',$this->_registrator->CampaignID,'Var CampaignID error');
        $this->assertEquals('3',$this->_registrator->UserID,'Var UserID error');
        $this->assertEquals('$',$this->_registrator->PerSaleCommType,'Var PerSaleCommType error');
        $this->assertEquals(15,$this->_registrator->SaleCommission,'Var SaleCommission error');

    }

    //--------------------------------------------------------------------------

    function testGetRecurringSaleCommission()
    {
        // test without tier
        $this->_registrator->CampaignID = '1';
        $this->_registrator->UserID = '3';
        $this->_registrator->CampaignCategoryID = '2';

        $this->assertTrue($this->_registrator->getRecurringSaleCommission(),
                            'Get recurring sale commission without tier failed');

        $this->assertEquals('15',$this->_registrator->SaleCommission,'Var SaleCommission error');
        $this->assertEquals('$',$this->_registrator->PerSaleCommType,'Var PerSaleCommType error');

        // test tier
        $this->_registrator->CampaignID = '1';
        $this->_registrator->UserID = '3';
        $this->_registrator->CampaignCategoryID = '2';

        $this->assertEquals(array('STRecurringCommType' => '$', 'recurringCommission' => '9'),
                            $this->_registrator->getRecurringSaleCommission('2'),
                            'Get recurring sale commission with tier failed');

    }

    //--------------------------------------------------------------------------

    function testCancelRecurring()
    {
        // order id
        $this->assertTrue($this->_registrator->cancelRecurring('12345'),'Cancel recurring failed');

        $sql = 'select rstatus from wd_pa_recurringcommissions where recurringcommid=\'2\'';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals(AFFSTATUS_SUPPRESSED,$rs->fields['rstatus'],'Var status error');

        // order id
        $this->assertFalse($this->_registrator->cancelRecurring('25686794'),'Cancel recurring passed');
    }

    //--------------------------------------------------------------------------

    function testSendNotificationToMerchant()
    {
        $GLOBALS['Test_mode'] = '1';
        
        $this->_registrator->account_settings = array(
                            'Aff_email_recurringtrangenerated' => '1',
                            'Aff_default_lang' => 'english',
                            'Aff_notifications_email' => ''// email address for test emails
                        );

        $TransID = '3';
        $params = array();
        $params['id'] = '3';
        $params['commission'] = '10';
        $params['orderid'] = '';
        $params['userid'] = '2';
        $params['status'] = '2';
        $params['recurringcommid'] = '1';
    
        // trans id, params
        $this->assertTrue($this->_registrator->sendNotificationToMerchant($TransID, $params),
                            'Notification email send failed');
    }

    //--------------------------------------------------------------------------

    function testRegisterMultiTierRecurringCommission()
    {
        $sql = 'delete from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->_registrator->account_settings = array(
                                    'Aff_recurringrealcommissions' => '1',
                                    'Aff_maxcommissionlevels' => '10');

        $this->_registrator->CampaignID = '1';
        $this->_registrator->UserID = '3';
        $this->_registrator->maxCommissionLevels = 10;
        $this->_registrator->$recurringCommissionsCounter = 0;

        $params = array('totalcost' => '',
                        'st2affiliateid' => '13',
                        'st2commission' => '9',
                        'st3affiliateid' => '12',
                        'st3commission' => '8',
                        'st4affiliateid' => '11',
                        'st4commission' => '7',
                        'st5affiliateid' => '10',
                        'st5commission' => '6',
                        'st6affiliateid' => '9',
                        'st6commission' => '5',
                        'st7affiliateid' => '8',
                        'st7commission' => '4',
                        'st8affiliateid' => '7',
                        'st8commission' => '3',
                        'st9affiliateid' => '6',
                        'st9commission' => '2',
                        'st10affiliateid' => '5',
                        'st10commission' => '1',
                        'campcategoryid' => '1',
                        'orderid' => '12345',
                        'recurringcommid' => '2'
                       );

        // params, insert transaction status, tier
        $this->_registrator->registerMultiTierRecurringCommission($params, 2, 2);

        $this->assertEquals('9',$this->_registrator->$recurringCommissionsCounter,
                            'Register multi tier commission failed');

        $sql = 'select * from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $i = 0; 
        while(!$rs->EOF)
        {
            $i++;

            $this->assertEquals('4', $rs->fields['transtype'], 'DB transtype '.$i);
            $this->assertEquals(($i+11), $rs->fields['transkind'], 'DB transkind '.$i);
            $this->assertEquals((14-$i), $rs->fields['affiliateid'], 'DB affiliateid '.$i);
            $this->assertEquals('1', $rs->fields['campcategoryid'], 'DB campcategoryid '.$i);
            $this->assertEquals((10-$i), $rs->fields['commission'], 'DB commissions '.$i);
            
            $rs->MoveNext();
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