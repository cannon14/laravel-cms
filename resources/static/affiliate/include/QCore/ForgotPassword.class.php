<?
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('QCore_Settings');

class QCore_ForgotPassword extends QUnit_UI_TemplatePage
{
    var $userType;
    
    //------------------------------------------------------------------------

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'check_user':
                    $this->processCheckUser();
                break;
            }
        }

        $this->showFormForgotPassword();
    }

    //------------------------------------------------------------------------

    function showFormForgotPassword()
    {
        $_POST['action'] = 'check_user';

        $this->addContent('forgot_password');
    }

    //------------------------------------------------------------------------

    function processCheckUser()
    {
        if($_POST['commited'] == 'yes')
        {
            switch($_POST['postaction']) {
                case 'step1':
                    return $this->processStepOne();                                               
                    break;
                    
                case 'step2':
                    if($this->processStepTwo()) {
                        return true;
                    } 
                return false;
                break;
            }
        }
        return false;
    }
    
    //------------------------------------------------------------------------
    
    function processStepOne() {
        if($_POST['username'] == '') {
            QUnit_Messager::setErrorMessage(L_G_YOUHAVETOENTEREMAIL);
            return false;
        }    
        $puname = preg_replace('/[^a-zA-Z0-9_@\.\-]/', '', $_POST['username']);
        if(($rs = $this->checkUserExists($puname)) === false) {
            return false;
        }        
        if(($code = $this->saveCode($rs->Fields('accountid'), $rs->Fields('userid'))) === false) {
            return false;
        } 
        return $this->sendPasswordByEmail($rs->Fields('userid'), $puname, $code, 'AFF_EMAIL_FORGOTPAS1');        
    }
    
    //------------------------------------------------------------------------

    function processStepTwo() {        
        if(($rs = $this->checkCode()) === false) {
            return false;
        }        
        if(($pwd = $this->resetPassword($rs->Fields('username'))) === false) {
            return false;
        }            
        if($this->sendPasswordByEmail($rs->Fields('userid'), $rs->Fields('username'), $pwd, 'AFF_EMAIL_FORGOTPAS2') === false) {
            return false;
        }
        if(($code = $this->saveCode($rs->Fields('accountid'), $rs->Fields('userid'))) === false) {
            return false;
        } 
        
        $this->assign('a_passwordResetSuccess', true);
        return true;
    }
    
    //------------------------------------------------------------------------

    function saveCode($accountId, $userId) {
        $code = substr(md5(uniqid(rand(), true)), 0, 8);
        
        if(QCore_Settings::_update('Aff_forgotpassword_code', md5($code), $this->type, $accountId, $userId) === false) {
            QCore_History::DebugMsg(WLOG_ERROR, L_G_SAVECODEERROR, __FILE__, __LINE__);
            QUnit_Messager::setErrorMessage(L_G_CONTACTADMINISTRATOR);
            return false;
        }
        return $code;                        
    }
    
    //------------------------------------------------------------------------

    function checkCode() {
        if($_POST['code'] == '') {
            QUnit_Messager::setErrorMessage(L_G_YOUHAVETOENTERCODE);
            return false;
        }
        $sql = "select u.userid, u.username, u.rtype from ".
                "wd_g_settings s, wd_g_users u ".
                "where ".
                "s.code='Aff_forgotpassword_code'".
                " and s.value="._q(md5($_POST['code'])).
                " and s.userid=u.userid";
               
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) {
            QUnit_Messager::setErrorMessage(L_G_CODEDOESNTMATCH);            
            return false;
        }
        
        $this->userType = $rs->fields['rtype'];
        
        return $rs;            
    }
    
    //------------------------------------------------------------------------

    function checkUserExists($puname) {
        // first check, if there is not already user with the same name
        if(QUnit_Messager::getErrorMessage() != '')
        return false;
        
        $sql = 'select * from wd_g_users '.
            'where deleted=0 '.
            '  and rtype='._q($this->user_type).
            '  and username='._q($puname);
        if($this->user_type == USERTYPE_USER) $sql .= '  and rstatus='._q(AFFSTATUS_APPROVED);
        else if($this->user_type == USERTYPE_ADMIN) $sql .= '  and rstatus='._q(STATUS_ENABLED);
        else if($this->user_type == USERTYPE_SUPERADMIN) $sql .= '  and rstatus='._q(STATUS_ENABLED);
        else 
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        if($rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_USERDOESNTEXIST);
            return false;
        }       
        return $rs;
    }
    
    //------------------------------------------------------------------------

    function resetPassword($puname) {
        $pwd = substr(md5(uniqid(rand(), true)), 0, 8);
        
        $sql = 'update wd_g_users '.
            'set rpassword='._q(($this->userType == USERTYPE_ADMIN ? md5($pwd) : $pwd)).
            'where username='._q($puname);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        return $pwd;
        
    }
    
    //------------------------------------------------------------------------

    function sendPasswordByEmail($userId, $userName, $pwd, $template) {
        $params = array();
        $params['pwd'] = $pwd;
        $emaildata = QCore_EmailTemplates::getFilledEmailMessage($userId, $template, $_SESSION[SESSION_PREFIX.'lang'], $params);
        
        if($emaildata != false && !empty($emaildata['subject']) && !empty($emaildata['text']))
        {
            $emaildata['email'] = $userName;
            if(!QCore_Bl_Communications::sendEmail($emaildata))
            {
                QUnit_Messager::setErrorMessage(L_G_EMAILSEND);
                return false;
            }
            else
            {
                if($template == 'AFF_EMAIL_FORGOTPAS1') {
                    QUnit_Messager::setOkMessage(L_G_EMAILWITHVEFIFYCATIONCODESENT);
                } else {
                    QUnit_Messager::setOkMessage(L_G_EMAILWITHPWDSENT);
                }
                return true;            
            }
        }
        else
        {
            QCore_History::DebugMsg(WLOG_ERROR, L_G_EMAILTEMPERR, __FILE__, __LINE__);
            QUnit_Messager::setErrorMessage(L_G_CONTACTADMINISTRATOR);
            return false;                  
        }
    }
    
    //------------------------------------------------------------------------
}
?>