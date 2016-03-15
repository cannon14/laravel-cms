<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright ? 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: Registrator.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class Affiliate_Scripts_Bl_Test_Registrator extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_Registrator');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------

    function testCheckUserExists()
    {
        // user id
        $this->assertTrue($this->_registrator->checkUserExists('3'), 'User not exist');

        // parent user id
        $this->assertEquals('4',$this->_registrator->ParentUserID,'Get parent user id failed');
    }

    //--------------------------------------------------------------------------

    function testCheckCampaignExists()
    {
        $this->_registrator->settings['Aff_camp_cookielifetime'] = '0';
        $this->_registrator->settings['Aff_camp_clickapproval'] = '2';
        $this->_registrator->settings['Aff_camp_saleapproval'] = '2';
        $this->_registrator->settings['Aff_declinefrequentclicks'] = '0';
        $this->_registrator->settings['Aff_declinefrequentsales'] = '0';
        $this->_registrator->settings['Aff_frequentclicks'] = '1';
        $this->_registrator->settings['Aff_frequentsales'] = '1';
        $this->_registrator->settings['Aff_declinesameorderid'] = '0';
        $this->_registrator->settings['Aff_clickfrequency'] = '0';
        $this->_registrator->settings['Aff_salefrequency'] = '0';
    
        // campaign id
        $this->assertTrue($this->_registrator->checkCampaignExists('1'), 'Campaign not exist');

        $this->assertEquals('1',$this->_registrator->CampaignID,'Var CampaignID error');
        $this->assertEquals('3',$this->_registrator->CampaignCommType,'Var CampaignCommType error');
        $this->assertEquals('0',$this->_registrator->cookieLifetime,'Var cookieLifetime error');
        $this->assertEquals('2',$this->_registrator->ClickTransactionApproval,'Var ClickTransactionApproval error');
        $this->assertEquals('2',$this->_registrator->SaleTransactionApproval,'Var SaleTransactionApproval error');
        $this->assertEquals('0',$this->_registrator->DeclineFrequentClicks,'Var DeclineFrequentClicks error');
        $this->assertEquals('0',$this->_registrator->DeclineFrequentSales,'Var DeclineFrequentSales error');
        $this->assertEquals('1',$this->_registrator->FrequentClicks,'Var FrequentClicks error');
        $this->assertEquals('1',$this->_registrator->FrequentSales,'Var FrequentSales error');
        $this->assertEquals('0',$this->_registrator->DeclineSameOrderId,'Var DeclineSameOrderId error');
        $this->assertEquals('0',$this->_registrator->ClickFrequency,'Var ClickFrequency error');
        $this->assertEquals('0',$this->_registrator->SaleFrequency,'Var SaleFrequency error');
    }

    //--------------------------------------------------------------------------

    function testCheckBannerExists()
    {
        // banner id
        $this->assertTrue($this->_registrator->checkBannerExists('1', false), 'Banner not exist');

        $this->assertEquals('1',$this->_registrator->CampaignID,'Var CampaignID error');
        $this->assertEquals('1',$this->_registrator->BannerID,'Var BannerID error');
        $this->assertEquals('http://www.qualityunit.com/',$this->_registrator->destinationURL,'Var destinationURL error');
    }

    //--------------------------------------------------------------------------

    function testCheckUserInCampaign()
    {
        // user id, campaign id
        $this->_registrator->UserID = '3';
        $this->_registrator->CampaignID = '1';
        $this->_registrator->settings['Aff_maxcommissionlevels'] = 10;

        $this->assertTrue($this->_registrator->checkUserInCampaign(), 'User in campaign not exist');

        $this->assertEquals($this->_registrator->CampaignCategoryID, '1', 'Var CampaignCategoryID error');
        $this->assertEquals($this->_registrator->ClickCommission, '0', 'Var ClickCommission error');
        $this->assertEquals($this->_registrator->SaleCommission, '20', 'Var SaleCommission error');
        $this->assertEquals($this->_registrator->maxCommissionLevels, '10', 'Var maxCommissionLevels error');
        $this->assertEquals($this->_registrator->STClickCommission[2], '0', 'Var STClickCommission 2tier error');
        $this->assertEquals($this->_registrator->STSaleCommission[2], '9', 'Var STSaleCommission 2tier error');
        $this->assertEquals($this->_registrator->STRecurringCommission[2], '9', 'Var STRecurringCommission 2tier error');
        $this->assertEquals($this->_registrator->STClickCommission[3], '0', 'Var STClickCommission 3tier error');
        $this->assertEquals($this->_registrator->STSaleCommission[3], '8', 'Var STSaleCommission 3tier error');
        $this->assertEquals($this->_registrator->STRecurringCommission[3], '8', 'Var STRecurringCommission 3tier error');
        $this->assertEquals($this->_registrator->STClickCommission[4], '0', 'Var STClickCommission 4tier error');
        $this->assertEquals($this->_registrator->STSaleCommission[4], '7', 'Var STSaleCommission 4tier error');
        $this->assertEquals($this->_registrator->STRecurringCommission[4], '7', 'Var STRecurringCommission 4tier error');
        $this->assertEquals($this->_registrator->STClickCommission[5], '0', 'Var STClickCommission 5tier error');
        $this->assertEquals($this->_registrator->STSaleCommission[5], '6', 'Var STSaleCommission 5tier error');
        $this->assertEquals($this->_registrator->STRecurringCommission[5], '6', 'Var STRecurringCommission 5tier error');
        $this->assertEquals($this->_registrator->STClickCommission[6], '0', 'Var STClickCommission 6tier error');
        $this->assertEquals($this->_registrator->STSaleCommission[6], '5', 'Var STSaleCommission 6tier error');
        $this->assertEquals($this->_registrator->STRecurringCommission[6], '5', 'Var STRecurringCommission 6tier error');
        $this->assertEquals($this->_registrator->STClickCommission[7], '0', 'Var STClickCommission 7tier error');
        $this->assertEquals($this->_registrator->STSaleCommission[7], '4', 'Var STSaleCommission 7tier error');
        $this->assertEquals($this->_registrator->STRecurringCommission[7], '4', 'Var STRecurringCommission 7tier error');
        $this->assertEquals($this->_registrator->STClickCommission[8], '0', 'Var STClickCommission 8tier error');
        $this->assertEquals($this->_registrator->STSaleCommission[8], '3', 'Var STSaleCommission 8tier error');
        $this->assertEquals($this->_registrator->STRecurringCommission[8], '3', 'Var STRecurringCommission 8tier error');
        $this->assertEquals($this->_registrator->STClickCommission[9], '0', 'Var STClickCommission 9tier error');
        $this->assertEquals($this->_registrator->STSaleCommission[9], '2', 'Var STSaleCommission 9tier error');
        $this->assertEquals($this->_registrator->STRecurringCommission[9], '2', 'Var STRecurringCommission 9tier error');
        $this->assertEquals($this->_registrator->STClickCommission[10], '0', 'Var STClickCommission 10tier error');
        $this->assertEquals($this->_registrator->STSaleCommission[10], '1', 'Var STSaleCommission 10tier error');
        $this->assertEquals($this->_registrator->STRecurringCommission[10], '1', 'Var STRecurringCommission 10tier error');

        $this->assertEquals($this->_registrator->PerSaleCommType, '$', 'Var PerSaleCommType error');
        $this->assertEquals($this->_registrator->STPerSaleCommType, '$', 'Var STPerSaleCommType error');
        $this->assertEquals($this->_registrator->RecurringCommission, '15', 'Var RecurringCommission error');
        $this->assertEquals($this->_registrator->RecurringCommType, '$', 'Var RecurringCommType error');
        $this->assertNull($this->_registrator->RecurringCommDate, 'Var RecurringCommDate error');
        $this->assertEquals($this->_registrator->RecurringDateType, '1', 'Var RecurringDateType error');
        $this->assertEquals($this->_registrator->STRecurringCommType, '$', 'Var STRecurringCommType error');
    }

    //--------------------------------------------------------------------------

    function testGetCampaignFromCampaignCategory()
    {
        // campcategory id
        $this->assertEquals('1',$this->_registrator->getCampaignFromCampaignCategory('1'),'Get campaign from campaign category failed');
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
