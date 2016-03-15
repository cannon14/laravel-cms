<?
/**
*
*   @author webradev.com
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @since Version 2.0
*
*   For support contact info@webradev.com
*/

class QCore_Auth
{
    var $logged = false;
    var $accountID = 'default1';
    var $userID = '';
    var $userName = '';
    var $userType = '';
    var $params = null;
    var $className = 'Auth';
    var $settings = null;
    var $sessionPrefix = 'auth';
    var $permissions = array();
   
    //------------------------------------------------------------------------

    function QCore_Auth()
    {
    }

    //------------------------------------------------------------------------

    function getAccountID()
    {
        return $GLOBALS['Auth']->accountID;
    }

    //------------------------------------------------------------------------

    function getUserID()
    {
        return $GLOBALS['Auth']->userID;
    }

    //------------------------------------------------------------------------

    function getUserType()
    {
        return $GLOBALS['Auth']->userType;
    }

    //------------------------------------------------------------------------

    function getAccountData()
    {
        return $GLOBALS['Auth']->accountData;
    }

    //------------------------------------------------------------------------

    function isLogged()
    {
        return $GLOBALS['Auth']->logged;
    }

    //------------------------------------------------------------------------

    function getPermissions()
    {
        return $GLOBALS['Auth']->permissions;
    }

    //------------------------------------------------------------------------

    function checkLogon($uname, $pwd, $type)
    {
        if($GLOBALS['Auth']->getSetting('login_protection_retries') != '' && $GLOBALS['Auth']->getSetting('login_protection_delay') != '')
        {
            if(isset($_SESSION['lastbadlogin']))
            {
                if((time()-$_SESSION['lastbadlogin'])<$GLOBALS['Auth']->getSetting('login_protection_delay'))
                    return false;
            }
        }

        // protection against sql injection
        $username = preg_replace('/[\'\"]/', '', $uname);
        $password = md5(preg_replace('/[\'\"]/', '', $pwd));
        $cpassword = preg_replace('/[\'\"]/', '', $pwd);
        
        $sql = 'select userid, accountid '.
               'from wd_g_users '.
               'where username='._q($username);
               
        if($type == USERTYPE_ADMIN)
            $sql .= ' and rpassword='._q($password);
        else if($type == USERTYPE_USER)
            $sql .= ' and rpassword='._q($cpassword);
               
        $sql .= '  and deleted='._q('0').
                '  and rtype='._q($type);
        if($type == USERTYPE_ADMIN)
            $sql .= ' and rstatus='._q(STATUS_ENABLED);
        else if($type == USERTYPE_USER)
            $sql .= ' and rstatus='._q(AFFSTATUS_APPROVED);

        $rs = $GLOBALS['db']->execute($sql);
        $GLOBALS['dbrequests']++;
        if (!$rs || $rs->EOF)
        {
            if($GLOBALS['Auth']->getSetting('login_protection_retries') != '' && $GLOBALS['Auth']->getSetting('login_protection_delay') != '')
            { 
                if(!isset($_SESSION['loginretries']))
                {
                    $_SESSION['lastbadlogin'] = 0;
                    $_SESSION['loginretries'] = 1;
                }
                else
                    $_SESSION['loginretries']++;

                if($_SESSION['loginretries'] >= $GLOBALS['Auth']->getSetting('login_protection_retries'))
                {
                    unset($_SESSION['loginretries']);
                    $_SESSION['lastbadlogin'] = time();
                }
            }

            return false;
        }

        // user is ok
        return array( 'userid' => $rs->fields['userid'], 'accountid' => $rs->fields['accountid']);
    }

    //------------------------------------------------------------------------

    function logUser($userID, $username, $type)
    {
        // load data about user
        // protection against sql injection
        $userID = preg_replace('/[\'\"]/', '', $userID);

        $sql = 'select userid, accountid, name, surname '.
               'from wd_g_users '.
               'where userid='._q($userID['userid']).
               '  and deleted='._q('0');
        if($type != USERTYPE_SUPERADMIN)
            $sql .= ' and accountid='._q($userID['accountid']);
        if($type == USERTYPE_ADMIN)
            $sql .= ' and rstatus='._q(STATUS_ENABLED);
        else if($type == USERTYPE_USER)
            $sql .= ' and rstatus='._q(AFFSTATUS_APPROVED);

        $rs = $GLOBALS['db']->execute($sql);
        if (!$rs || $rs->EOF)
            return false;

        $accountID = $rs->fields['accountid'];
        $userID = $rs->fields['userid'];
        $username = $rs->fields['name'].' '.$rs->fields['surname'];

        $params = array();

        if(QCore_Auth::logUserData($userID, $username, $params, $type, $accountID))
        {
            $this->loadSettings();
            
            // log this to history
            QCore_History::DebugMsg(WLOG_ACTIONS, 'User logged in', __FILE__, __LINE__);

            return true;
        }
        else
        {
            $historyMsg = 'Can not log in super admin';
            QCore_History::DebugMsg(WLOG_DEBUG, $historyMsg, __FILE__, __LINE__);

            return false;
        }
    }

    //------------------------------------------------------------------------

    function loadSettings() {
        if($GLOBALS['Auth']->accountID != '') {
//dbg(QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, 'default1'));
            $GLOBALS['Auth']->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $this->accountID);
//        dbg($GLOBALS['Auth']->settings);
        }
    }

    //------------------------------------------------------------------------

    function loadPermissions()
    {
        if(QCore_Auth::getUserID() == '' || QCore_Auth::getAccountID() == '')
            return false;
    
        $sql = 'select rt.code, rt.righttype '.
               'from wd_g_righttypes rt, wd_g_users u, wd_g_userrights ur '.
               'where u.userid='._q(QCore_Auth::getUserID()).
               '  and u.accountid='._q(QCore_Auth::getAccountID()).
               '  and u.userprofileid=ur.userprofileid'.
               '  and ur.righttypeid=rt.righttypeid';
        $rs = $GLOBALS['db']->execute($sql);
        $GLOBALS['dbrequests']++;
        if(!$rs) return false;
        
        if($rs->EOF)
        {
            // try load default permissions
            $sql = 'select rt.code, rt.righttype '.
                   'from wd_g_righttypes rt, wd_g_userrights ur '.
                   'where ur.userprofileid='._q(DEFAULT_USER_PROFILE).
                   '  and ur.righttypeid=rt.righttypeid';
            $rs = $GLOBALS['db']->execute($sql);
            $GLOBALS['dbrequests']++;
            if(!$rs) return false;
        }

        $GLOBALS['Auth']->permissions = array();

        while(!$rs->EOF)
        {
            $GLOBALS['Auth']->permissions[] = $rs->fields['code'].'_'.$rs->fields['righttype'];
            
            $rs->MoveNext();
        }

        return true;
    }

    //------------------------------------------------------------------------

    function checkPermission($permission)
    {
        if($GLOBALS['Auth']->getUserType() == USERTYPE_USER)
            return true;
    
        if(is_array($GLOBALS['Auth']->permissions) && in_array($permission, $GLOBALS['Auth']->permissions))
            return true;
     
        return false;
    }
    
    //------------------------------------------------------------------------

    function logUserData($userID, $username, $params = null, $userType, $accountID = '')
    {
        $GLOBALS['Auth']->accountID = $accountID;
        $GLOBALS['Auth']->userID = $userID;
        $GLOBALS['Auth']->userName = $username;
        $GLOBALS['Auth']->userType = $userType;
        $GLOBALS['Auth']->params = $params;
        $GLOBALS['Auth']->logged = true;

        QCore_Auth::loadPermissions();

        QCore_Auth::saveToSession();

        return true;
    }

    //------------------------------------------------------------------------

    function logout()
    {
        switch($GLOBALS['Auth']->userType)
        {
            case USERTYPE_ADMIN:      $historyMsg = "Merchant '".$this->userName."' logged out."; break;
            case USERTYPE_SUPERADMIN: $historyMsg = "Super admin '".$this->userName."' logged out."; break;
            case USERTYPE_USER:       $historyMsg = "User '".$this->userName."' logged out."; break;
            default: $historyMsg = 'Logged out. User type do not known.'; break;
        }

        QCore_History::DebugMsg(WLOG_ACTIONS, $historyMsg, __FILE__, __LINE__);
   
        $GLOBALS['Auth']->logged = false;
        //$GLOBALS['Auth']->accountID = '';
        $GLOBALS['Auth']->userID = '';
        $GLOBALS['Auth']->userName = '';
        $GLOBALS['Auth']->userType = '';
        $GLOBALS['Auth']->params = null;
        $GLOBALS['Auth']->settings = null;
        $GLOBALS['Auth']->permissions = array();

        QCore_Auth::saveToSession();        
    }

    //------------------------------------------------------------------------

    function getParams()
    {
        return $GLOBALS['Auth']->params;  
    }

    //------------------------------------------------------------------------

    function getParam($paramName)
    {
        return $GLOBALS['Auth']->params[$paramName];
    }

    //------------------------------------------------------------------------

    function hasRights($rights)
    {
        return true;
    }

    //------------------------------------------------------------------------

    function showLoginPage()
    {
        $_REQUEST['md'] = LOGIN_PAGE;
    }

    //------------------------------------------------------------------------

    function showNoRightsPage()
    {
    }

    //------------------------------------------------------------------------

    function getSetting($code)
    {
        if(is_array($GLOBALS['Auth']->settings) && count($GLOBALS['Auth']->settings)>0)
            return $GLOBALS['Auth']->settings[$code];

        return false;
    }

    //------------------------------------------------------------------------

    function getSettings()
    {
        return $GLOBALS['Auth']->settings;
    }

    //------------------------------------------------------------------------

    function getUsernameForUser($userID, $accountID = '')
    {
        $sql = 'select username from wd_g_users '.
               'where userid='._q($userID);
        if($accountID != '')
            $sql .= '  and accountid='._q($accountID);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
            return false;

        return $rs->fields['username'];
    }

    //------------------------------------------------------------------------

    function getFromSession()
    {
        //$GLOBALS['Auth']->accountID = $this->_getSessionValue('accountID');
        $GLOBALS['Auth']->userID = $this->_getSessionValue('userID');
        $GLOBALS['Auth']->userName = $this->_getSessionValue('userName');
        $GLOBALS['Auth']->userType = $this->_getSessionValue('userType');
        $GLOBALS['Auth']->params = $this->_getSessionValue('params');
        $GLOBALS['Auth']->logged = $this->_getSessionValue('logged');
        $GLOBALS['Auth']->settings = unserialize($this->_getSessionValue('settings'));
        $GLOBALS['Auth']->permissions = unserialize($this->_getSessionValue('permissions'));
    }

	private function _getSessionValue($field) {
		$key = SESSION_PREFIX.$GLOBALS['Auth']->sessionPrefix.$field;
		if(isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}

		return false;
	}

    //------------------------------------------------------------------------

    function saveToSession()
    {
        //$_SESSION[SESSION_PREFIX.$GLOBALS['Auth']->sessionPrefix.'accountID'] = $GLOBALS['Auth']->accountID;
        $_SESSION[SESSION_PREFIX.$GLOBALS['Auth']->sessionPrefix.'userID'] = $GLOBALS['Auth']->userID;
        $_SESSION[SESSION_PREFIX.$GLOBALS['Auth']->sessionPrefix.'userName'] = $GLOBALS['Auth']->userName;
        $_SESSION[SESSION_PREFIX.$GLOBALS['Auth']->sessionPrefix.'userType'] = $GLOBALS['Auth']->userType;
        $_SESSION[SESSION_PREFIX.$GLOBALS['Auth']->sessionPrefix.'params'] = $GLOBALS['Auth']->params;
        $_SESSION[SESSION_PREFIX.$GLOBALS['Auth']->sessionPrefix.'logged'] = $GLOBALS['Auth']->logged;
        $_SESSION[SESSION_PREFIX.$GLOBALS['Auth']->sessionPrefix.'settings'] = serialize($GLOBALS['Auth']->settings);
        $_SESSION[SESSION_PREFIX.$GLOBALS['Auth']->sessionPrefix.'permissions'] = serialize($GLOBALS['Auth']->permissions);
    }
    
    //------------------------------------------------------------------------
    
    function setAccountByUser($userID)
    {
        $sql = 'select userid, accountid '.
               'from wd_g_users '.
               'where (userid='._q($userID).' or refid='._q($userID).')'.
               '  and rtype='._q(USERTYPE_USER);

        $rs = $GLOBALS['db']->execute($sql);
        $GLOBALS['dbrequests']++;
        if (!$rs || $rs->EOF)
        {
            return false;
        }
        
        $this->accountID = $rs->fields['accountid'];

        $this->loadSettings();
        
        return true;
    }
    
    //------------------------------------------------------------------------

    function setAccountID($accountID)
    {
        $this->accountID = $accountID;
    }
}
