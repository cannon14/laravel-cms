<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright � 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: BannerViewer.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class Affiliate_Scripts_Bl_Test_BannerViewer extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_BannerViewer');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------

    function testCheckUserExists()
    {
        // userid
        $this->assertTrue($this->_registrator->checkUserExists('3'), 'User not exist');
    }

    //--------------------------------------------------------------------------

    function testCheckBannerExists()
    {
        $this->assertTrue($this->_registrator->checkBannerExists('1'), 'Banner not exist');

        $this->assertNull($this->_registrator->sourceURL, 'Var sourceurl');
        $this->assertEquals('Test banner',$this->_registrator->description,'Var description');
        $this->assertEquals('1',$this->_registrator->bannerType,'Var bannerType');
    }

    //--------------------------------------------------------------------------

    function testSaveImpression()
    {
        $sql = 'delete from wd_pa_impressions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->_registrator->UserID = '3';
        $this->_registrator->AccountID = 'default1';
    
        // test insert : parameter banner id
        $this->assertTrue($this->_registrator->saveImpression('1'), 'Failed save impression');

        $sql = 'select * from wd_pa_impressions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals('default1', $rs->fields['accountid'], 'DB accountid');
        $this->assertEquals('1', $rs->fields['bannerid'], 'DB bannerid');
        $this->assertEquals('3', $rs->fields['affiliateid'], 'DB affiliateid');
        $this->assertEquals('1', $rs->fields['all_imps_count'], 'DB all_imps_count');
        $this->assertEquals('1', $rs->fields['unique_imps_count'], 'DB unique_imps_count');

        $this->_registrator->UserID = '3';
        
        // test update : parameter banner id
        $this->assertTrue($this->_registrator->saveImpression('1'), 'Failed save impression');

        $sql = 'select * from wd_pa_impressions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals('default1', $rs->fields['accountid'], 'DB accountid');
        $this->assertEquals('1', $rs->fields['bannerid'], 'DB bannerid');
        $this->assertEquals('3', $rs->fields['affiliateid'], 'DB affiliateid');
        $this->assertEquals('2', $rs->fields['all_imps_count'], 'DB all_imps_count');
        $this->assertEquals('1', $rs->fields['unique_imps_count'], 'DB unique_imps_count');
    }
}

?>