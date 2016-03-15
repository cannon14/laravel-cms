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
QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('QCore_Bl_Communications');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_Affiliate');

define('WD_PATTERN_DEFAULT', '/[^\'\"]*/');

class Affiliate_Scripts_Bl_SignupUserNew extends Affiliate_Scripts_Bl_Signup
{

    function Affiliate_Scripts_Bl_SignupUserNew() {
        $this->user = QUnit_Global::newObj('Affiliate_Scripts_Bl_Affiliate');
    }
    
        
    function getErrorMessage() {
        return QUnit_Messager::getErrorMessage();
    }
    
    function addErrorMessage($msg) {
        QUnit_Messager::setErrorMessage($msg);
    }
        
    //--------------------------------------------------------------------------

    function checkForm() {        
        $correct = true;        
        if(QCore_Bl_Users::checkUserExists('', $_POST['username']) === true) {
            $this->addErrorMessage(L_G_UNAMEEXISTS);
            $correct = false;
        } 
        
        
        if($this->settings['Aff_signup_force_acceptance'] == "1") {
            if(!isset($_POST['tos']) || $_POST['tos'] !== "1") {
                $this->addErrorMessage(L_G_TOSAGREE); 
                $correct = false;
            }
        }
        if($this->user->check() == false) {
            $correct = false;
        }
        
        if($_POST['parentuserid'] != '' && !$this->checkParentUser($_POST['parentuserid'])) {
            $this->addErrorMessage(L_G_PARENTAFFDOESNTEXISTS);
            $correct = false;
        }
                
//        if(!in_array($pcountry, $GLOBALS['countries'])) {
//            $this->addErrorMessage(L_G_COUNTRYNOTINLIST);
//            $correct = false;
//        }
        
        return $correct;
    }
        
    //--------------------------------------------------------------------------
    function loadSettings($accountId) {
        $this->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $accountId);
        $this->settings = array_merge($this->settings, QCore_Settings::getGlobalSettings());        
        //$default_lang = ($this->settings['Aff_default_lang'] != '' ? $this->settings['Aff_default_lang'] : $this->settings['Glob_default_lang']);        
    }

    //--------------------------------------------------------------------------    
    
    function setMandatoryFields() {
        foreach($_POST as $key => $val) {
            if($this->settings['Aff_signup_'.$key.'_mandatory'] === "true") {
                $this->user->setNeeded($key, true);
            } else {
               $this->user->setNeeded($key, false); 
            }
        }        
    }
    
    //--------------------------------------------------------------------------

    function getStatus() {
        $approval = $this->settings['Aff_affiliateapproval'];        
        if($approval == APPROVE_AUTOMATIC) {
            $status = AFFSTATUS_APPROVED;
            $this->user->setColumn('dateapproved', strftime('%y-%m-%d %H:%M:%S', time()));
        } else if($approval == APPROVE_MANUAL) {
            $status = AFFSTATUS_NOTAPPROVED;
        } else {
            $status = AFFSTATUS_NOTAPPROVED;
        }
        return $status;        
    }
    
    //--------------------------------------------------------------------------

    function getParentUserId($userId) {
        $parentuserid =  Affiliate_Scripts_Bl_Signup::getParentUser();
        if($this->settings['Aff_matrix_width'] > 0 && $this->settings['Aff_matrix_height'] > 0 
                && $this->settings['Aff_use_forced_matrix'] == '1') {
            if( ($temp_parentuserid = Affiliate_Merchants_Bl_ForcedMatrix::useForcedMatrix($userID, 
                $parentuserid, $this->settings)) != false)
                $parentuserid = $temp_parentuserid;
        }
        return $parentuserid;
    }
    
    function setDataFieldsCaption() {
        for($i=1;$i<=5;$i++) {
            $this->user->setCaption("data$i", $this->settings["Aff_signup_data{$i}_name"]);
        }
    }
    
    //--------------------------------------------------------------------------
    
    function processSignup()
    {        
        $this->user->fillColumnsFromArray($_POST);
        $this->user->setColumn('originalparentid', $_POST['parentuserid']);
        $this->user->setColumn('rtype', USERTYPE_USER);
        $this->user->setColumn('dateinserted', strftime('%y-%m-%d %H:%M:%S', time()));
        $this->user->setColumn('deleted', '0');
        $this->user->setColumn('product', PRODUCT_AFFILIATE);
        $this->user->setColumn('userprofileid', $REQUEST['upid']);
        
        $aid = $this->getAccountId();
        $this->user->setColumn('accountid', $aid);
        
        $this->loadSettings($aid);
                
        $this->setMandatoryFields();
        $this->setDataFieldsCaption();
        
        $pwd = substr(uniqid(rand(),1), 0, 5);
        $this->user->setColumn('rpassword', $pwd);
        $userId = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');
        $this->user->setColumn('userid', $userId);
        $this->user->setColumn('refid', $userId);
        
        $initial_min_payout = $this->settings['Aff_initial_min_payout'];
        
        $status = $this->getStatus();
        $this->user->setColumn('rstatus', $status);
        
        $parentuserid = $this->getParentUserId($userId);                
        $this->user->setColumn('parentuserid', $parentuserid);        

        if($this->checkForm() == false) {
            return false;
        }
        if($this->user->insertUser() == false) {
            return false;
        }

        $this->addProgramSignupBonus($userId, $aid, $status, $parentuserid);
        QCore_Settings::_update('Aff_min_payout', $_POST['minpayout'], SETTINGTYPE_USER, $this->user->getColumn('accountid'), $userID);
        QCore_Settings::_update('Aff_user_ip', $_SERVER['REMOTE_ADDR'], SETTINGTYPE_USER, $this->user->getColumn('accountid'), $userID);        
        if($status == AFFSTATUS_APPROVED)
        {
            if(!$this->sendMailToUser($userId, $aid, $_POST['username'], $pwd)) {
                return false;
            }
        }
        
        if(!$this->sendMailToMerchant($userId, $aid)) {
            return false;
        }        
        if($this->sendMailToParentUser($_POST['parentuserid'], $aid)) {
            return false;
        }
        
        return true;
    }
}
?>
