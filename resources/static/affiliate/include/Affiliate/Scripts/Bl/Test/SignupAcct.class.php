<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright � 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: SignupAcct.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class Affiliate_Scripts_Bl_Test_SignupAcct extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_SignupAcct');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------

    function testCheckSignupForm()
    {
        $_POST['account_name'] = 'My Account';
        $_POST['account_description'] = 'My Account Description';
        $_POST['userprofile_name'] = 'My Userprofile name';
        $_POST['username'] = 'My username';
        $_POST['pwd1'] = 'xxx';
        $_POST['pwd2'] = 'xxx';
        $_POST['admin_name'] = 'My admin name';
        $_POST['surname'] = 'surname';
        $_POST['tos'] = '1';

        QUnit_Messager::resetMessages();

        $this->_registrator->checkSignupForm();

        $this->assertEquals('', QUnit_Messager::getErrorMessage(), 'Check signup form failed');

        //

        $_POST['account_name'] = '';
        $_POST['account_description'] = '';
        $_POST['userprofile_name'] = '';
        $_POST['username'] = '';
        $_POST['pwd1'] = '';
        $_POST['pwd2'] = '';
        $_POST['admin_name'] = '';
        $_POST['surname'] = '';
        $_POST['tos'] = '';

        QUnit_Messager::resetMessages();

        $this->_registrator->checkSignupForm();

        if(QUnit_Messager::getErrorMessage() != '') $this->pass();
        else $this->fail('Check signup form passed');

    }

    //--------------------------------------------------------------------------

    function testSaveData()
    {
        $sql = 'delete from wd_g_accounts';
        $rs = $GLOBALS['db']->execute($sql, $error);
        $sql = 'delete from wd_g_userprofiles';
        $rs = $GLOBALS['db']->execute($sql, $error);
        $sql = 'delete from wd_g_users';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $_POST['account_name'] = 'My Account';
        $_POST['account_description'] = 'My Account Description';
        $_POST['userprofile_name'] = 'My Userprofile name';
        $_POST['username'] = 'My username';
        $_POST['pwd1'] = 'xxx';
        $_POST['pwd2'] = 'xxx';
        $_POST['admin_name'] = 'My admin name';
        $_POST['surname'] = 'surname';
        $_POST['tos'] = '1';

        $AccountID = '99';
        $UserProfileID = '99';
        $AdminID = '99';
        $status = '2';
        
        // account id, userprofileid, adminid, status
        $this->assertTrue($this->_registrator->saveData($AccountID, $UserProfileID,
                        $AdminID, $status), 'Add program signup bonus failed');

        $sql = 'select * from wd_g_accounts';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals($AccountID, $rs->fields['accountid'], 'DB accountid');
        $this->assertEquals($_POST['account_name'], $rs->fields['name'], 'DB accounts name');
        $this->assertEquals($_POST['account_description'], $rs->fields['description'], 'DB description');
        $this->assertEquals($status, $rs->fields['rstatus'], 'DB rstatus');

        $sql = 'select * from wd_g_userprofiles';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals($UserProfileID, $rs->fields['userprofileid'], 'DB userprofileid');
        $this->assertEquals($_POST['userprofile_name'], $rs->fields['name'], 'DB user profile name');
        $this->assertEquals('3', $rs->fields['rtype'], 'DB rtype');
        $this->assertEquals($AccountID, $rs->fields['accountid'], 'DB accountid');

        $sql = 'select * from wd_g_users';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertEquals($AdminID, $rs->fields['userid'], 'DB userid');
        $this->assertEquals($AccountID, $rs->fields['accountid'], 'DB accountid');
        $this->assertEquals($_POST['username'], $rs->fields['username'], 'DB username');
        $this->assertEquals($_POST['admin_name'], $rs->fields['name'], 'DB name');
        $this->assertEquals($_POST['surname'], $rs->fields['surname'], 'DB surname');
        $this->assertEquals(md5($_POST['pwd1']), $rs->fields['rpassword'], 'DB password');
        $this->assertEquals($status, $rs->fields['rstatus'], 'DB rstatus');
        $this->assertEquals('3', $rs->fields['rtype'], 'DB rtype');
        $this->assertEquals('0', $rs->fields['deleted'], 'DB deleted');
        $this->assertEquals($UserProfileID, $rs->fields['userprofileid'], 'DB userprofileid');

    }

    //--------------------------------------------------------------------------

    function testProcessSignup()
    {
        $sql = 'delete from wd_g_accounts';
        $rs = $GLOBALS['db']->execute($sql, $error);
        $sql = 'delete from wd_g_userprofiles';
        $rs = $GLOBALS['db']->execute($sql, $error);
        $sql = 'delete from wd_g_users';
        $rs = $GLOBALS['db']->execute($sql, $error);
        QUnit_Messager::resetMessages();

        $GLOBALS['Test_mode'] = '1';
        $_POST['account_name'] = 'My Account';
        $_POST['account_description'] = 'My Account Description';
        $_POST['userprofile_name'] = 'My Userprofile name';
        $_POST['username'] = 'My username';
        $_POST['pwd1'] = 'xxx';
        $_POST['pwd2'] = 'xxx';
        $_POST['admin_name'] = 'My admin name';
        $_POST['surname'] = 'surname';
        $_POST['tos'] = '1';
        $_POST['l'] = 'english';
        $status = '1';

        $this->_registrator->processSignup();

                $sql = 'select * from wd_g_accounts';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $AccountID = $rs->fields['accountid'];
        $this->assertNotNull($rs->fields['accountid'], 'DB accountid');
        $this->assertEquals($_POST['account_name'], $rs->fields['name'], 'DB accounts name');
        $this->assertEquals($_POST['account_description'], $rs->fields['description'], 'DB description');
        $this->assertEquals($status, $rs->fields['rstatus'], 'DB rstatus');

        $sql = 'select * from wd_g_userprofiles';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $UserProfileID = $rs->fields['userprofileid'];
        $this->assertNotNull($rs->fields['userprofileid'], 'DB userprofileid');
        $this->assertEquals($_POST['userprofile_name'], $rs->fields['name'], 'DB user profile name');
        $this->assertEquals('3', $rs->fields['rtype'], 'DB rtype');
        $this->assertEquals($AccountID, $rs->fields['accountid'], 'DB accountid');

        $sql = 'select * from wd_g_users';
        $rs = $GLOBALS['db']->execute($sql, $error);

        $this->assertNotNull($rs->fields['userid'], 'DB userid');
        $this->assertEquals($AccountID, $rs->fields['accountid'], 'DB accountid');
        $this->assertEquals($_POST['username'], $rs->fields['username'], 'DB username');
        $this->assertEquals($_POST['admin_name'], $rs->fields['name'], 'DB name');
        $this->assertEquals($_POST['surname'], $rs->fields['surname'], 'DB surname');
        $this->assertEquals(md5($_POST['pwd1']), $rs->fields['rpassword'], 'DB password');
        $this->assertEquals($status, $rs->fields['rstatus'], 'DB rstatus');
        $this->assertEquals('3', $rs->fields['rtype'], 'DB rtype');
        $this->assertEquals('0', $rs->fields['deleted'], 'DB deleted');
        $this->assertEquals($UserProfileID, $rs->fields['userprofileid'], 'DB userprofileid');

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