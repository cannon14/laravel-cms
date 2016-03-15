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

class Affiliate_Merchants_Bl_AffiliateAddNew extends Affiliate_Scripts_Bl_Signup {

    function Affiliate_Merchants_Bl_AffiliateAddNew() {
        $this->user = QUnit_Global::newObj('Affiliate_Scripts_Bl_Affiliate');
    }
    
        
    function getErrorMessage() {
        return QUnit_Messager::getErrorMessage();
    }
    
    function addErrorMessage($msg) {
        QUnit_Messager::setErrorMessage($msg);
    }
        
    function addOkMessage($msg) {
        QUnit_Messager::setOkMessage($msg);
    }
    //--------------------------------------------------------------------------

    function checkForm($edit = false) {        
        $correct = true;
        
        if($this->checkUserExists() === false) {
            $correct = false;            
        }
        
        if($this->settings['Aff_signup_force_acceptance'] == "1") {
            if(!isset($_POST['tos']) || $_POST['tos'] !== "1") {
                $this->addErrorMessage(L_G_TOSAGREE); 
                $correct = false;
            }
        }
        if($this->user->check() === false) {
            $correct = false;
        }
        
        if($this->checkPassword() === false) {
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
        if($this->checkPayoutMethods() === false) {
            $correct = false;
        }


        return $correct;
    }

    function checkUserExists() {
        if(QCore_Bl_Users::checkUserExists('', $this->getUserName()) === true) {
            $this->addErrorMessage(L_G_UNAMEEXISTS);
            return false;
        }         
        return true;
    }    
    
    function checkPassword() {
        if(empty($_POST['pwd1'])) {
            $this->addErrorMessage(L_G_PWD1EMPTY);
            return false;            
        }
        if(empty($_POST['pwd2'])) {
            $this->addErrorMessage(L_G_PWD2EMPTY);
            return false;            
        }
        if($_POST['pwd1'] != $_POST['pwd2']) {
            $this->addErrorMessage(L_G_PWDDONTMATCH);
            return false;            
        }
        return true;
    }
    
    function checkPayoutMethods() {
        $payout_methods = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray(
                $GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        foreach($payout_methods as $method)
        {
            if($_POST['payout_type'] == $method['payoptid'])
            {
                foreach($payout_fields[$method['payoptid']] as $field)
                {
                    $check = CHECK_ALLOWED;
                    if($field['mandatory'] == STATUS_ENABLED)
                    {
                        $check = CHECK_EMPTYALLOWED;
                    }

                    checkCorrectness($_POST['field'.$field['payfieldid']], $params['field'.$field['payfieldid']],
                             (defined($field['langid']) ? constant($field['langid']) : $field['name']), $check);
                }
            }
        }  
        return true;      
    }
        
    //--------------------------------------------------------------------------
    function loadSettings($accountId) {
        $this->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $accountId);
        $this->settings = array_merge($this->settings, QCore_Settings::getGlobalSettings());        
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
        $this->user->setNeeded('payoptid', true);      
    }
    
    //--------------------------------------------------------------------------

    function setStatus() {
        $this->user->setColumn('rstatus', $this->getStatus());
    }
    
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
    
    function getUserId() {
        return QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');
    }
    
    function setPassword($pwd) {
        $this->user->setColumn('rpassword', $pwd);
    }
    
    function getUserName() {
        return $_POST['uname'];
    }
        
    //--------------------------------------------------------------------------
    
    function process($edit = false)
    {        
        $this->user->fillColumnsFromArray($_POST);
        $this->user->setColumn('originalparentid', $_POST['parentuserid']);
        $this->user->setColumn('rtype', USERTYPE_USER);
        $this->user->setColumn('dateinserted', strftime('%y-%m-%d %H:%M:%S', time()));
        $this->user->setColumn('deleted', '0');
        $this->user->setColumn('product', PRODUCT_AFFILIATE);
        $this->user->setColumn('userprofileid', $REQUEST['upid']);
        
        $this->user->setColumn('accountid', $GLOBALS['Auth']->getAccountID());
        
        $this->loadSettings($aid);
                
        $this->setMandatoryFields();
        $this->setDataFieldsCaption();
        
        //$pwd = substr(md5(uniqid(rand(),1)), 0, 5);
        // pwd
        $pwd = $_POST['pwd1'];
        $this->setPassword($pwd);

        // userid
        $userId = $this->getUserId();
        $this->user->setColumn('userid', $userId);
        $this->user->setColumn('username', $this->getUserName());
        
        $initial_min_payout = $this->settings['Aff_initial_min_payout'];
        
        // status
        $this->setStatus();
        
        // parentuserid
        $parentuserid = $this->getParentUserId($userId);                
        $this->user->setColumn('parentuserid', $parentuserid);        

        // payouttype
        $this->user->setColumn('payoptid', $_POST['payout_type']);
        
        if($this->checkForm($edit) == false) {
            return false;
        }
        
        if($this->saveUser() == false) {
            return false;
        }

        $this->saveSettings($userId);        
        
        if(!$this->sendMail($userId, $aid, $this->getUserName(), $pwd, $this->getStatus())) {
            return false;
        }
 
        return true;
    }
    
    function saveUser() {
        return $this->user->insertUser();
    }
    
    function sendMail($userId, $aid, $userName, $pwd, $status) {
        if($status == AFFSTATUS_APPROVED)
        {
            if(!$this->sendMailToUser($userId, $aid, $userName, $pwd)) {
                return false;
            }
        }
        return true;
    }
    
    function saveSettings($userId) {
        $payout_fields = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray(
                $GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
                
        $sql = 'delete from wd_g_settings '.
               'where accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and rtype='._q(SETTINGTYPE_USER).
               '  and userid='._q($userId).
               '  and code like \'%'._q_noendtags('Aff_payoptionfield_').'%\'';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }                
        QCore_Settings::_update('Aff_payout_type', $_POST['payout_type'], SETTINGTYPE_USER, 
                $GLOBALS['Auth']->getAccountID(), $userID);        
        QCore_Settings::_update('Aff_min_payout', $_POST['minpayout'], SETTINGTYPE_USER, 
                $GLOBALS['Auth']->getAccountID(), $userID);
        QCore_Settings::_update('Aff_user_ip', $_SERVER['REMOTE_ADDR'], SETTINGTYPE_USER, 
                $GLOBALS['Auth']->getAccountID(), $userID);        
        if(is_array($payout_fields[$_POST['payout_type']])) {
            foreach($payout_fields[$_POST['payout_type']] as $field)
            {
                QCore_Settings::_update('Aff_payoptionfield_'.$field['payfieldid'], 
                    $_POST['field'.$field['payfieldid']], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), 
                    $userId, $field['payfieldid']);
            }
        }
    }
}
?>
