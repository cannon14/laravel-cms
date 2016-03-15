<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright � 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: DailyReports.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class Affiliate_Scripts_Bl_Test_DailyReports extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_DailyReports');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------

    function testSendDailyReports()
    {
        $GLOBALS['Test_mode'] = '1';
    
        // nothing
        $this->assertEquals('1',$this->_registrator->sendDailyReports(),'Daily report not sent');
    }

    //--------------------------------------------------------------------------

    function testSendDailyReportToMerchant()
    {
        QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');

        $this->assertTrue(false); // prerobit !!!
        // getTimerangeStats() je teraz v triede Affiliate_Scripts_Bl_TimerangeStatistics
        // a ma o parameter viac (prvy parameter AffiliateID)
        
        //$data = Affiliate_Scripts_Bl_SaleStatistics::getTimerangeStats(
        //                            '', $d, $m, $y, $d, $m, $y, 'default1', '1');
    
        // timerange data, lang, email
        //$this->assertTrue($this->_registrator->sendDailyReportToMerchant(
        //                        $data, 'english', 'ladislav.tamas@qualityunit.com')
        //                        , 'Daily report not sent to merchant');
    }

    //--------------------------------------------------------------------------

    function testSendDailyReportToUser()
    {
        $userID = '3';
        $email = '';
    
        $this->assertTrue(false); // prerobit !!!
        // getTimerangeStats() je teraz v triede Affiliate_Scripts_Bl_TimerangeStatistics
        // a ma o parameter viac (prvy parameter AffiliateID)

        //QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');

        //$data = Affiliate_Scripts_Bl_SaleStatistics::getTimerangeStats(
        //                            '', $d, $m, $y, $d, $m, $y, 'default1', '1');
    
        // userid, email address, timerange data, accountid
        //$this->assertTrue($this->_registrator->sendDailyReportToUser(
        //        $userID, $email, $data, 'english'), 'Daily report not sent to user');
    }
}
?>