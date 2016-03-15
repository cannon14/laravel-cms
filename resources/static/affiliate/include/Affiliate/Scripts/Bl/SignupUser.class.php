<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QCore_Bl_Users');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_Signup');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_Registrator');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_ForcedMatrix');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Scripts_Bl_SignupUser extends Affiliate_Scripts_Bl_Signup
{
    var $maxCommissionLevels = '';
    var $STUserBonusCommission = array();

    //--------------------------------------------------------------------------

    function checkSignupForm()
    {
        if($_POST['parentuserid'] == '') $_POST['parentuserid'] = $_POST['pid'];
    
        $puname = preg_replace('/[\'\"]/', '', $_POST['uname']);
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $psurname = preg_replace('/[\'\"]/', '', $_POST['surname']);
        $pcompany_name = preg_replace('/[\'\"]/', '', $_POST['company_name']);
        $pweburl = preg_replace('/[\'\"]/', '', $_POST['weburl']);
        $pstreet = preg_replace('/[\'\"]/', '', $_POST['street']);
        $pcity = preg_replace('/[\'\"]/', '', $_POST['city']);
        $pstate = preg_replace('/[\'\"]/', '', $_POST['state']);
        $pcountry = preg_replace('/[\'\"]/', '', $_POST['country']);
        $pzipcode = preg_replace('/[\'\"]/', '', $_POST['zipcode']);
        $pphone = preg_replace('/[\'\"]/', '', $_POST['phone']);
        $pfax = preg_replace('/[\'\"]/', '', $_POST['fax']);
        $ptax_ssn = preg_replace('/[\'\"]/', '', $_POST['tax_ssn']);
        $pparentuserid = preg_replace('/[\'\"]/', '', $_POST['parentuserid']);
        $paccountid = preg_replace('/[\'\"]/', '', $_POST['aid']);

        // check correctness of the fields
        if($_POST['aid'] == '' || $paccountid == '') {
            $_POST['aid'] = DEFAULT_ACCOUNT;
            $paccountid = DEFAULT_ACCOUNT;
            
        }
        if($_POST['aid'] != $paccountid) {
            QUnit_Messager::setErrorMessage(L_G_ACCOUNTERROR);
        }
        
        $GLOBALS['Auth']->setAccountID($paccountid);
            
        checkCorrectness($_POST['uname'], $puname, L_G_USERNAME, CHECK_EMPTYALLOWED);
        
        if($_POST['uname'] != '' && QCore_Bl_Users::checkUserExists('', $_POST['uname']))
            QUnit_Messager::setErrorMessage(L_G_UNAMEEXISTS);
        
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['surname'], $psurname, L_G_SURNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['weburl'], $pweburl, L_G_WEBURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['street'], $pstreet, L_G_STREET, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['city'], $pcity, L_G_CITY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['country'], $pcountry, L_G_COUNTRY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['zipcode'], $pzipcode, L_G_ZIPCODE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['parentuserid'], $pparentuserid, L_G_NAME, CHECK_ALLOWED);

        if($_POST['parentuserid'] != '' && !$this->checkParentUser($_POST['parentuserid']))
            QUnit_Messager::setErrorMessage(L_G_PARENTAFFDOESNTEXISTS);
        
        if($_POST['tos'] != 1)
            QUnit_Messager::setErrorMessage(L_G_TOSAGREE);
        
        if(!in_array($pcountry, $GLOBALS['countries']))
            QUnit_Messager::setErrorMessage(L_G_COUNTRYNOTINLIST);
    }
    
    //--------------------------------------------------------------------------
    
    function saveUser($UserID, $pwd, $status, $originalparentid)
    {
        if($this->settings['Aff_matrix_width'] > 0 && $this->settings['Aff_matrix_height'] > 0 
                && $this->settings['Aff_use_forced_matrix'] == '1') {
            if( ($temp_parentuserid = Affiliate_Merchants_Bl_ForcedMatrix::useForcedMatrix($UserID, $originalparentid, $this->settings)) != false)
                $parentuserid = $temp_parentuserid;
        }
        else {
            $parentuserid = $originalparentid;
        }
        
        $sql = 'insert into wd_g_users(userid, refid, accountid, username, rpassword, '.
               'name, surname, rstatus, product, dateinserted, deleted, '.
               'rtype, parentuserid, company_name, weburl, street, '.
               'city, state, country, zipcode, phone, fax, tax_ssn, originalparentid)'.
               ' values ('._q($UserID).','._q($UserID).','._q($_POST['aid']).','._q($_POST['uname']).
               ','._q($pwd).','._q($_POST['name']).','._q($_POST['surname']).
               ','._q($status).','._q(PRODUCT_AFFILIATE).','.sqlNow().','._q('0').
               ','._q(USERTYPE_USER).','._q($parentuserid).
               ','._q($_POST['company_name']).','._q($_POST['weburl']).
               ','._q($_POST['street']).','._q($_POST['city']).','._q($_POST['state']).
               ','._q($_POST['country']).','._q($_POST['zipcode']).
               ','._q($_POST['phone']).','._q($_POST['fax']).
               ','._q($_POST['tax_ssn']).','._q($originalparentid).')';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        // save data into settings
        QCore_Settings::_update('Aff_min_payout', $_POST['minpayout'], SETTINGTYPE_USER, $_POST['aid'], $UserID);
        QCore_Settings::_update('Aff_user_ip', $_SERVER['REMOTE_ADDR'], SETTINGTYPE_USER, $_POST['aid'], $UserID);
        
        return $parentuserid;
    }
    
    //--------------------------------------------------------------------------
    
    function processSignup()
    {
        $this->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $_POST['aid']);
        $this->settings = array_merge($this->settings, QCore_Settings::getGlobalSettings());
        $default_lang = ($this->settings['Aff_default_lang'] != '' ? $this->settings['Aff_default_lang'] : $this->settings['Glob_default_lang']);

        if($GLOBALS['Test_mode'] != '1')
            if($this->setLanguageFile($default_lang) == false) return false;
        
        $aid = $this->getAccountId();
        $this->checkSignupForm();

        if(QUnit_Messager::getErrorMessage() != '')
            return false;

        $pwd = substr(md5(uniqid(rand(),1)), 0, 5);
        $UserID = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');
        $approval = $this->settings['Aff_affiliateapproval'];
        $initial_min_payout = $this->settings['Aff_initial_min_payout'];

        if($approval == APPROVE_AUTOMATIC)
            $status = AFFSTATUS_APPROVED;
        else if($approval == APPROVE_MANUAL)
            $status = AFFSTATUS_NOTAPPROVED;
        else
            $status = AFFSTATUS_NOTAPPROVED;

        $_POST['parentuserid'] = Affiliate_Scripts_Bl_Signup::getParentUser();
    
        $parentuserid = $this->saveUser($UserID, $pwd, $status, $_POST['parentuserid']);

        if($parentuserid === false) return false;

        $this->addProgramSignupBonus($UserID, $aid, $status, $parentuserid);

        if($status == AFFSTATUS_APPROVED)
        {
            $this->sendMailToUser($UserID, $aid, $_POST['uname'], $pwd);
        }

        $this->sendMailToMerchant($UserID, $aid);
        $this->sendMailToParentUser($UserID, $parentuserid, $aid);

        return false;
    }
}
?>
