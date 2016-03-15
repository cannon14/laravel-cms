<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright ? 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: SignupUser.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class Affiliate_Scripts_Bl_Test_SignupUser extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_SignupUser');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------

    function testCheckSignupForm()
    {
        $_POST['uname'] = 'test@mail.com';
        $_POST['name'] = 'Test name';
        $_POST['surname'] = 'Test sur name';
        $_POST['company_name'] = 'Mycompany';
        $_POST['weburl'] = 'http://www.qualityunit.com';
        $_POST['street'] = '19 street';
        $_POST['city'] = 'London';
        $_POST['state'] = 'UK';
        $_POST['country'] = 'United States';
        $_POST['zipcode'] = '24680';
        $_POST['phone'] = '12345';
        $_POST['fax'] = '67890';
        $_POST['tax_ssn'] = '13579';
        $_POST['parentuserid'] = '';
        $_POST['aid'] = 'default1';
        $_POST['upid'] = '1';
        $_POST['tos'] = '1';

        QUnit_Messager::resetMessages();

        $this->_registrator->checkSignupForm();

        $this->assertEquals('', QUnit_Messager::getErrorMessage(), 'Check signup form failed');

        //

        $_POST['uname'] = '';
        $_POST['name'] = '';
        $_POST['surname'] = '';
        $_POST['company_name'] = '';
        $_POST['weburl'] = '';
        $_POST['street'] = '';
        $_POST['city'] = '';
        $_POST['state'] = '';
        $_POST['country'] = '';
        $_POST['zipcode'] = '';
        $_POST['phone'] = '';
        $_POST['fax'] = '';
        $_POST['tax_ssn'] = '';
        $_POST['parentuserid'] = '';
        $_POST['aid'] = '';
        $_POST['upid'] = '';
        $_POST['tos'] = '';

        QUnit_Messager::resetMessages();

        $this->_registrator->checkSignupForm();

        if(QUnit_Messager::getErrorMessage() != '') $this->pass();
        else $this->fail('Check signup form passed');

    }

    //--------------------------------------------------------------------------

    function testSaveUser()
    {
        $sql = 'delete from wd_g_users';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $_POST['uname'] = 'test@mail.com';
        $_POST['name'] = 'Test name';
        $_POST['surname'] = 'Test sur name';
        $_POST['company_name'] = 'Mycompany';
        $_POST['weburl'] = 'http://www.qualityunit.com';
        $_POST['street'] = '19 street';
        $_POST['city'] = 'London';
        $_POST['state'] = 'UK';
        $_POST['country'] = 'England';
        $_POST['zipcode'] = '24680';
        $_POST['phone'] = '12345';
        $_POST['fax'] = '67890';
        $_POST['tax_ssn'] = '13579';
        $_POST['parentuserid'] = '';
        $_POST['aid'] = 'default1';
        $_POST['upid'] = '1';
        $UserID = '99';
        $pwd = 'testpwd';
        $status = '2';
        $pparentuserid = '3';

        $this->assertTrue($this->_registrator->saveUser($UserID, $pwd, $status,
                                     $pparentuserid), 'Save user failed');

        $sql = 'select * from wd_g_users';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals($UserID, $rs->fields['userid'], 'DB userid');
        $this->assertEquals($_POST['aid'], $rs->fields['accountid'], 'DB accountid');
        $this->assertEquals($_POST['uname'], $rs->fields['username'], 'DB username');
        $this->assertEquals($_POST['name'], $rs->fields['name'], 'DB name');
        $this->assertEquals($_POST['surname'], $rs->fields['surname'], 'DB surname');
        $this->assertEquals(MD5($pwd), $rs->fields['rpassword'], 'DB password');
        $this->assertEquals($status, $rs->fields['rstatus'], 'DB rstatus');
        $this->assertEquals('4', $rs->fields['rtype'], 'DB rtype');
        $this->assertEquals('0', $rs->fields['deleted'], 'DB deleted');
        $this->assertEquals($_POST['upid'], $rs->fields['userprofileid'], 'DB userprofileid');
        $this->assertEquals($pparentuserid, $rs->fields['parentuserid'], 'DB parentuserid');
        
        $sql = 'select code, value from wd_g_settings '.
               'where userid='._q($UserID).
               '  and accountid='._q($_POST['aid']).
               '  and rtype='._q(SETTINGTYPE_USER);
        $rs = $GLOBALS['db']->execute($sql, $error);
        
        while(!$rs->EOF)
        {
            $settings[$rs->fields['code']] = $rs->fields['value'];
        
            $rs->MoveNext();
        }
        
        $this->assertEquals($_POST['weburl'], $settings['Aff_weburl'], 'DB Aff_weburl');
        $this->assertEquals($_POST['company_name'],$settings['Aff_company_name'],'DB Aff_company_name');
        $this->assertEquals('', $settings['Aff_paypal_email'], 'DB Aff_paypal_email');
        $this->assertEquals($_POST['tax_snn'], $settings['Aff_tax_snn'], 'DB Aff_tax_snn');
        $this->assertEquals($_POST['street'], $settings['Aff_street'], 'DB Aff_street');
        $this->assertEquals($_POST['city'], $settings['Aff_city'], 'DB Aff_city');
        $this->assertEquals($_POST['state'], $settings['Aff_state'], 'DB Aff_state');
        $this->assertEquals($_POST['country'], $settings['Aff_country'], 'DB Aff_country');
        $this->assertEquals($_POST['zipcode'], $settings['Aff_zipcode'], 'DB Aff_zipcode');
        $this->assertEquals($_POST['phone'], $settings['Aff_phone'], 'DB Aff_phone');
        $this->assertEquals($_POST['fax'], $settings['Aff_fax'], 'DB Aff_fax');
        $this->assertEquals('', $settings['Aff_min_payout'], 'DB Aff_min_payout');
    }

    //--------------------------------------------------------------------------

    function testAddProgramSignupBonus()
    {
        $sql = 'delete from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $_POST['aid'] = 'default1';

        // userid, status
        $this->assertTrue($this->_registrator->addProgramSignupBonus('3', '2'),
                             'Add program signup bonus failed');

        $sql = 'select * from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);
        
        $this->assertEquals('default1', $rs->fields['accountid'], 'DB accountid');
        $this->assertEquals('2',$rs->fields['rstatus'],'DB rstatus');
        $this->assertEquals('5', $rs->fields['transtype'], 'DB transtype');
        if($_SERVER['HTTP_REFERER'] == $rs->fields['refererurl']) $this->pass;
        else $this->fail('DB refererurl');
        $this->assertEquals('3', $rs->fields['affiliateid'], 'DB affiliateid');
        $this->assertEquals(10, $rs->fields['commission'], 'DB commissions');
        $this->assertEquals($_SERVER['REMOTE_ADDR'], $rs->fields['ip'], 'DB ip');

    }

    //--------------------------------------------------------------------------

    function testSetMultiTierSignupGlobals()
    {
        $this->_registrator->settings['Aff_maxcommissionlevels'] = '10';
        $this->_registrator->settings['Aff_program_signup_bonus_2tr'] = '9';
        $this->_registrator->settings['Aff_program_signup_bonus_3tr'] = '8';
        $this->_registrator->settings['Aff_program_signup_bonus_4tr'] = '7';
        $this->_registrator->settings['Aff_program_signup_bonus_5tr'] = '6';
        $this->_registrator->settings['Aff_program_signup_bonus_6tr'] = '5';
        $this->_registrator->settings['Aff_program_signup_bonus_7tr'] = '4';
        $this->_registrator->settings['Aff_program_signup_bonus_8tr'] = '3';
        $this->_registrator->settings['Aff_program_signup_bonus_9tr'] = '2';
        $this->_registrator->settings['Aff_program_signup_bonus_10tr'] = '1';
    
        $this->_registrator->setMultiTierSignupGlobals();
        
        $this->assertEquals('10',$this->_registrator->maxCommissionLevels,'DB maxCommissionLevels');
        for($i=2; $i<=10; $i++) {
            $this->assertEquals((11-$i),$this->_registrator->STUserBonusCommission[$i],'DB STUserBonusCommission '.$i.' tier');
        }
    }

    //--------------------------------------------------------------------------
    
    function testRregisterMultiTierSignupCommission()
    {
        $sql = 'delete from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->_registrator->maxCommissionLevels = '10';
        $this->_registrator->STUserBonusCommission[2] = '9';
        $this->_registrator->STUserBonusCommission[3] = '8';
        $this->_registrator->STUserBonusCommission[4] = '7';
        $this->_registrator->STUserBonusCommission[5] = '6';
        $this->_registrator->STUserBonusCommission[6] = '5';
        $this->_registrator->STUserBonusCommission[7] = '4';
        $this->_registrator->STUserBonusCommission[8] = '3';
        $this->_registrator->STUserBonusCommission[9] = '2';
        $this->_registrator->STUserBonusCommission[10] = '1';
        $_POST['aid'] = 'default1';
        
        $remoteAddr = '127.0.0.1';
        $ip = '127.0.0.1';

        // parentTransID, remoteAddr, ip, status, parentUserID, tier
        $this->assertTrue($this->_registrator->registerMultiTierSignupCommission(
                             '1', $remoteAddr, $ip, '2', '14', '2'),
                             'Register Multi Tier Signup Commission failed');

        $sql = 'select * from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $i = 0; 
        while(!$rs->EOF)
        {
            $i++;

            $this->assertEquals('5', $rs->fields['transtype'], 'DB transtype '.$i);
            $this->assertEquals(($i+11), $rs->fields['transkind'], 'DB transkind '.$i);
            $this->assertEquals((14-$i), $rs->fields['affiliateid'], 'DB affiliateid '.$i);
            $this->assertEquals((10-$i), $rs->fields['commission'], 'DB commissions '.$i);
            $this->assertEquals('2', $rs->fields['rstatus'], 'DB rstatus '.$i);
            $this->assertEquals($_POST['aid'], $rs->fields['accountid'], 'DB accountid '.$i);
            $this->assertEquals(TRANSTYPE_SIGNUP, $rs->fields['transtype'], 'DB transtype '.$i);

            $rs->MoveNext();
        }
    }

    //--------------------------------------------------------------------------

    function testProcessSignup()
    {
        $sql = 'delete from wd_g_users';
        $rs = $GLOBALS['db']->execute($sql, $error);
        $sql = 'delete from wd_pa_transactions';
        $rs = $GLOBALS['db']->execute($sql, $error);
        QUnit_Messager::resetMessages();

        $GLOBALS['Test_mode'] = '1';
        $_POST['uname'] = 'test@mail.com';
        $_POST['name'] = 'Test name';
        $_POST['surname'] = 'Test sur name';
        $_POST['company_name'] = 'Mycompany';
        $_POST['weburl'] = 'http://www.qualityunit.com';
        $_POST['street'] = '19 street';
        $_POST['city'] = 'London';
        $_POST['state'] = 'UK';
        $_POST['country'] = 'United States';
        $_POST['zipcode'] = '24680';
        $_POST['phone'] = '12345';
        $_POST['fax'] = '67890';
        $_POST['tax_ssn'] = '13579';
        $_POST['parentuserid'] = '';
        $_POST['aid'] = 'default1';
        $_POST['upid'] = '1';
        $_POST['tos'] = '1';
        $_POST['l'] = 'english';

        $this->_registrator->processSignup();

        $sql = 'select * from wd_g_users';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals($_POST['aid'], $rs->fields['accountid'], 'DB accountid');
        $this->assertEquals($_POST['uname'], $rs->fields['username'], 'DB username');
        $this->assertEquals($_POST['name'], $rs->fields['name'], 'DB name');
        $this->assertEquals($_POST['surname'], $rs->fields['surname'], 'DB surname');
        $this->assertEquals('2', $rs->fields['rstatus'], 'DB rstatus');
        $this->assertEquals('4', $rs->fields['rtype'], 'DB rtype');
        $this->assertEquals('0', $rs->fields['deleted'], 'DB deleted');
        $this->assertEquals($_POST['upid'], $rs->fields['userprofileid'], 'DB userprofileid');

        $sql = 'select * from wd_g_parentusers where userid='._q($rs->fields['userid']);
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals($pparentuserid, $rs->fields['parentuserid'], 'DB parentuserid');
        
        $sql = 'select code, value from wd_g_settings '.
               'where userid like \'___%\''.
               '  and accountid='._q($_POST['aid']).
               '  and rtype='._q(SETTINGTYPE_USER);
        $rs = $GLOBALS['db']->execute($sql, $error);
        
        while(!$rs->EOF)
        {
            $settings[$rs->fields['code']] = $rs->fields['value'];
        
            $rs->MoveNext();
        }
        
        $this->assertEquals($_POST['weburl'], $settings['Aff_weburl'], 'DB Aff_weburl');
        $this->assertEquals($_POST['company_name'],$settings['Aff_company_name'],'DB Aff_company_name');
        $this->assertEquals('', $settings['Aff_paypal_email'], 'DB Aff_paypal_email');
        $this->assertEquals($_POST['tax_snn'], $settings['Aff_tax_snn'], 'DB Aff_tax_snn');
        $this->assertEquals($_POST['street'], $settings['Aff_street'], 'DB Aff_street');
        $this->assertEquals($_POST['city'], $settings['Aff_city'], 'DB Aff_city');
        $this->assertEquals($_POST['state'], $settings['Aff_state'], 'DB Aff_state');
        $this->assertEquals($_POST['country'], $settings['Aff_country'], 'DB Aff_country');
        $this->assertEquals($_POST['zipcode'], $settings['Aff_zipcode'], 'DB Aff_zipcode');
        $this->assertEquals($_POST['phone'], $settings['Aff_phone'], 'DB Aff_phone');
        $this->assertEquals($_POST['fax'], $settings['Aff_fax'], 'DB Aff_fax');
        $this->assertEquals('', $settings['Aff_min_payout'], 'DB Aff_min_payout');

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
