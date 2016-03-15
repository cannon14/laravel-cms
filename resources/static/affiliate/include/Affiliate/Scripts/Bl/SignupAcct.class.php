<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Scripts_Bl_Signup');
QUnit_Global::includeClass('QCore_Bl_Users');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Scripts_Bl_SignupAcct extends Affiliate_Scripts_Bl_Signup
{
    function checkSignupForm()
    {
        $paccount_name = preg_replace('/[\'\"]/', '', $_POST['account_name']);
        $paccount_description = preg_replace('/[\'\"]/', '', $_POST['account_description']);

        $puserprofile_name = preg_replace('/[\'\"]/', '', $_POST['userprofile_name']);
    
        $pusername = preg_replace('/[\'\"]/', '', $_POST['username']);
        $ppwd1 = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $ppwd2 = preg_replace('/[\'\"]/', '', $_POST['pwd2']);
        $padmin_name = preg_replace('/[\'\"]/', '', $_POST['admin_name']);
        $psurname = preg_replace('/[\'\"]/', '', $_POST['surname']);

        // check correctness of the fields
        checkCorrectness($_POST['account_name'], $paccount_name, L_G_ACCOUNT.' '.L_G_NAME, CHECK_EMPTYALLOWED);
        if($_POST['account_name'] != '' && $this->checkAccountExists($_POST['account_name']))
            QUnit_Messager::setErrorMessage(L_G_ACCOUNTNAMEEXISTS);
        checkCorrectness($_POST['account_description'], $paccount_description, L_G_ACCOUNT.' '.L_G_DESCRIPTION, CHECK_ALLOWED);

        checkCorrectness($_POST['userprofile_name'], $puserprofile_name, L_G_USER_PROFILE.' '.L_G_NAME, CHECK_EMPTYALLOWED);
        if($_POST['userprofile_name'] != '' && $this->checkUserProfileExists($_POST['userprofile_name']))
            QUnit_Messager::setErrorMessage(L_G_USERPROFILENAMEEXISTS);

        checkCorrectness($_POST['username'], $pusername, L_G_USER_NAME, CHECK_EMPTYALLOWED);
        if($_POST['username'] != '' && QCore_Bl_Users::checkUserExists('', $_POST['username']))
            QUnit_Messager::setErrorMessage(L_G_UNAMEEXISTS);
        checkCorrectness($_POST['pwd1'], $ppwd1, L_G_PWD1, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['pwd2'], $ppwd2, L_G_PWD2, CHECK_EMPTYALLOWED);
        if($_POST['pwd1'] != $_POST['pwd2'])
            QUnit_Messager::setErrorMessage(L_G_PWDDONTMATCH);
        checkCorrectness($_POST['admin_name'], $padmin_name, L_G_ADMIN.' '.L_G_NAME, CHECK_ALLOWED);
        checkCorrectness($_POST['surname'], $psurname, L_G_SURNAME, CHECK_ALLOWED); 

        if($_POST['tos'] != 1)
            QUnit_Messager::setErrorMessage(L_G_TOSAGREE);
    }

    //--------------------------------------------------------------------------

    function saveData($AccountID, $UserProfileID, $AdminID, $status)
    {
        $sql = 'insert into wd_g_accounts(accountid, name, description,'.
               'dateinserted, rstatus)'.
               'values('._q($AccountID).','._q($_POST['account_name']).
               ','._q($_POST['account_description']).','.sqlNow().
               ','._q($status).')';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $sql = 'insert into wd_g_userprofiles(userprofileid, name, rtype,'.
               'accountid)'.
               'values('._q($UserProfileID).','._q($_POST['userprofile_name']).
               ','._q(USERTYPE_ADMIN).','._q($AccountID).')';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $sql = 'insert into wd_g_users(userid, accountid, username,'.
               'rpassword, name, surname, rstatus, rtype, dateinserted,'.
               'deleted, userprofileid)'.
               'values('._q($AdminID).','._q($AccountID).','._q($_POST['username']).
               ','._q(md5($_POST['pwd1'])).','._q($_POST['admin_name']).
               ','._q($_POST['surname']).','._q($status).','._q(USERTYPE_ADMIN).
               ','.sqlNow().','._q('0').','._q($UserProfileID).')';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        QCore_Settings::_update('Aff_admin_ip', $_SERVER['REMOTE_ADDR'], SETTINGTYPE_ADMIN, $AccountID, $AdminID);

        return true;
    }

    //--------------------------------------------------------------------------
  
    function processSignup()
    {
        $this->settings = QCore_Settings::getGlobalSettings(SETTINGTYPE_GLOBAL);

        // set language file
        if($GLOBALS['Test_mode'] != '1')
            if($this->setLanguageFile($this->settings['Glob_default_lang']) == false) return false;

        // process signup
        $this->checkSignupForm();

        if(QUnit_Messager::getErrorMessage() != '')
            return false;

        $AccountID = QCore_Sql_DBUnit::createUniqueID('wd_g_accounts', 'accountid');
        $UserProfileID = QCore_Sql_DBUnit::createUniqueID('wd_g_userprofiles', 'userprofileid');
        $AdminID = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');

        // check admin approval type
        $approval = $this->settings['Glob_adminapproval'];
          
        if($approval == APPROVE_AUTOMATIC)
            $status = AFFSTATUS_APPROVED;
        else if($approval == APPROVE_MANUAL)
            $status = AFFSTATUS_NOTAPPROVED;
        else
            $status = AFFSTATUS_NOTAPPROVED;

        if($this->saveData($AccountID,$UserProfileID,$AdminID,$status) == false) return false;

        //----------------------------------------
        // check whether to send notification email to admin
        if($status == AFFSTATUS_APPROVED)
        {
            $params = array();
            $params['pwd'] = $_POST['pwd1'];
            $params['account_name'] = $_POST['account_name'];
            $params['userprofile_name'] = $_POST['userprofile_name'];
        
            QUnit_Global::includeClass('QCore_EmailTemplates');
        
            $emaildata = QCore_EmailTemplates::getFilledEmailMessage($AdminID, 'ADMIN_EMAIL_SIGNUP', $_SESSION[SESSION_PREFIX.'lang'], $params);

            $password_sent = false;
              
            if($emaildata != false)
            {
                $params = array('accountid' => $AccountID,
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $AdminID,
                            'email' => $_POST['username']
                );
                
                if(!QCore_Bl_Communications::sendEmail($params)) {
                    QUnit_Messager::setErrorMessage(L_G_EMAILSEND);
                    QCore_History::DebugMsg(WLOG_ERROR, 'Signup account: There was a problem sending confirmation email to \''.$_POST['username'].'\'', __FILE__, __LINE__);
                }
            }
            else
            {
                QUnit_Messager::setErrorMessage(L_G_EMAILTEMPERR);
                QCore_History::DebugMsg(WLOG_ERROR, 'Signup account:  There was a problem generating confirmation email from template for \''.$_POST['username'].'\'', __FILE__, __LINE__);
            }
        }

        //----------------------------------------
        // check whether to send notification email to super admin
        if($this->settings['Glob_email_onadminsignup'] == 1)
        {
            $params = array();
            
            $emaildata = QCore_EmailTemplates::getFilledEmailMessage($UserID, 'ADMIN_EMAIL_NTF_SIGNUP', $this->settings['Glob_default_lang'], $params);
            
            if($emaildata != false)
            {
                $systemEmail = $this->settings['Glob_notifications_email'];

                $params = array('accountid' => $AccountID,
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => '',
                            'email' => $systemEmail
                );
                
                if(!QCore_Bl_Communications::sendEmail($params)) {
                    QCore_History::DebugMsg(WLOG_ERROR, 'Signup account: There was a problem sending super admin notification email about admin \''.$_POST['uname'].'\' to \''.$systemEmail.'\'', __FILE__, __LINE__);
                } else {
                    QCore_History::DebugMsg(WLOG_ACTION, 'Signup account: Super admin notification email was succesfully generated and sent to \''.$systemEmail.'\'', __FILE__, __LINE__);
                }
            }
            else
            {
                QCore_History::DebugMsg(WLOG_ERROR, 'Signup account:  There was a problem generating super admin notification email from template about admin \''.$_POST['uname'].'\' to \''.$systemEmail.'\'', __FILE__, __LINE__);
            }
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function checkAccountExists($name)
    {
        $sql = 'select * from wd_g_accounts where name='._q($name);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }

        if($rs->EOF)
            return false;

        return true;
    }

    //--------------------------------------------------------------------------

    function checkUserProfileExists($name)
    {
        $sql = 'select userprofileid from wd_g_userprofiles where name='._q($name);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }

        if($rs->EOF)
            return false;

        return true;
    }
}
?>
