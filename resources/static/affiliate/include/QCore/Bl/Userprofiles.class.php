<?php

QUnit_Global::includeClass('QCore_Bl_RightTypes');

class QCore_Bl_Userprofiles
{
  // function returns an array containing information about specified userprofile
  //   parameters: userprofileid (string) - user profile ID
  //   return value: (array) an array containg information about specified user profile
  function GetUserprofileInfo($userprofileid) {
    // prepare sql parameters
    $uid = PrepareSqlParameter($userprofileid, L_G_COL_USERPROFILEID, CHECK_EMPTY|CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(array());
    }

    // select information about specified account
    $sql = 'select up.userprofileid, up.name, up.rtype, up.accountid, ac.name as account_name '.
           '  from wd_g_userprofiles up left join wd_g_accounts ac on (up.accountid=ac.accountid) '.
           ' where up.userprofileid='._q($uid);
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if(!$rs) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(array());
    }

    if($rs->EOF) {
      return(array());
    }

    // return selected information
    return($rs->fields);
  }

  //--------------------------------------------------------------------------

  // function returns array containing information about all user profiles
  //   parameters: $orderbycol (string)  - database table column name for order by clause
  //               $sortorder (string)   - tells, whether order in ascending order ('asc'), or descending order ('desc')
  //               $getforallaccs (bool) - tells, whether get information for all userprofiles (true), or only for user account (false)
  //   return value: (array) array containing admins information
  function GetUserprofilesInfo($orderbycol = '', $sortorder = 'asc', $getforallaccs = false) {
    // prepare orderby parameter
    $orderby = '';
    if($orderbycol) {
      $obvals = array('name' => true, 'rtype' => true, 'account_name' => true);
      if(isset($obvals[$orderbycol])) {
        $orderby = ' order by '.$orderbycol;
        if($sortorder == 'asc' || $sortorder == 'desc') {
          $orderby .= ' '.$sortorder;
        }
      }
    }

    // select information for user profiles
    if($getforallaccs) {
      $sql = 'select up.userprofileid, up.name, up.rtype, up.accountid, ac.name as account_name '.
             '  from wd_g_userprofiles up left join wd_g_accounts ac on (up.accountid=ac.accountid) '.$orderby;
    }
    else {
      $sql = 'select up.userprofileid, up.name, up.rtype, up.accountid, ac.name as account_name '.
             '  from wd_g_userprofiles up, wd_g_accounts ac '.
             ' where up.accountid=ac.accountid'.
             '   and up.accountid='._q($GLOBALS['Auth']->getAccountID()).$orderby;
    }
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if(!$rs) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(array());
    }

    // an array which will be returned
    $uprs = array();

    // fill an array with information
    $i = 0;
    while(!$rs->EOF) {
      // assign actual record into array
      $uprs[$i++] = $rs->fields;
      // move to next record
      $rs->MoveNext();
    }

    // return an array containing gathered information
    return($uprs);
  }

  //--------------------------------------------------------------------------

  // function checks whether specified user profile already exists
  //   parameters: userprofileid (string) - user profile ID
  //               name (string)          - user profile name
  //               uidexists (bool)       - tells whether search for user profile ID (true), or exclude it (false - only if specified)
  //   return value: (bool) true/false (group already exists/group does not exist)
  function checkUserprofileExists($userprofileid = '', $name = '', $uidexists = true) {
    // at least one parameter should be specified
    if(($userprofileid == '') && ($name == '')) {
      return(false);
    }

    // prepare sql parameters
    $uid = PrepareSqlParameter($userprofileid, L_G_USERPROFILEID, CHECK_ALLOWED);
    $uname = PrepareSqlParameter($name, L_G_COL_NAME, CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(false);
    }

    // try to select specified user profile
    $sql = 'select userprofileid from wd_g_userprofiles where userprofileid=userprofileid';
    if($name != '') {
      $sql .= ' and name='._q($uname);
    }
    if($userprofileid != '') {
      if($uidexists) {
        $sql .= ' and userprofileid='._q($uid);
      }
      else {
        $sql .= ' and userprofileid<>'._q($uid);
      }
    }
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    // error handling
    if(!$rs) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // if no data were selected, specified user profile does not exist
    if($rs->EOF) {
      return(false);
    }
    // if there were some data selected, specified user profile already exists
    return(true);
  }

  //--------------------------------------------------------------------------

  // function inserts new user profile
  //   parameters: name (string)      - user profile name (should be set via parameter)
  //               accountid (string) - account ID (should be set via parameter)
  //               rtype (string)     - user profile type (should be set via parameter)
  //   return value: (bool) true/false (success/failure)
  function InsertUserprofile($name, $accountid, $rtype) {
    // prepare sql parameters
    $uname = PrepareSqlParameter($name, L_G_COL_NAME, CHECK_EMPTY|CHECK_ALLOWED);
    $uaccountid = PrepareSqlParameter($accountid, L_G_COL_ACCOUNTID, CHECK_EMPTY|CHECK_ALLOWED);
    $urtype = PrepareSqlParameter($rtype, L_G_COL_RTYPE, CHECK_EMPTY|CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(false);
    }
    if(QCore_Bl_Userprofiles::CheckUserprofileExists(NULL, $uname)) {
      // user profile with this user name already exists
      QUnit_Messager::setErrorMessage(L_G_USERPROFILENAMEALREADYEXISTS);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_USERPROFILENAMEALREADYEXISTS, __FILE__, __LINE__);
      return(false);
    }
    QUnit_Global::includeClass('QCore_Bl_Accounts');
    if(!QCore_Bl_Accounts::CheckAccountExists($uaccountid, NULL, true)) {
      // account does not exist
      QUnit_Messager::setErrorMessage(L_G_ACCOUNTDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ACCOUNTDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }

    // insert account into db
//    $uid = QCore_Sql_DBUnit::createUniqueID('wd_g_userprofiles', 'accountid');
    $aid = QCore_Sql_DBUnit::generateID('seq_wd_g_userprofiles', 1);
    $sql = 'insert into wd_g_accounts (userprofileid, name, rtype, accountid) '.
           'values '.
           '('._q($uid).','._q($uname).','._q($urtype).','._q($uaccountid).')';
    $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if(!$ret) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // log history
    QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
    QUnit_Messager::setOkMessage(L_G_USERPROFILEADDED);

    // success
    return(true);
  }

  //--------------------------------------------------------------------------

  // function updates user profile information
  //   parameters: userprofileid (string) - user profile ID (should be set via parameter)
  //               name (string)          - new user profile name (default value is '' - if ommited, it will not be changed)
  //               rtype (string)         - new user profile type (default value is '' - if ommited, it will not be changed)
  //               accountid (string)     - new account ID (default value is '' - if ommited, it will not be changed)
  //   return value: (bool) true/false (success/failure)
  function UpdateUserprofile($userprofileid, $name = '', $rtype = '', $accountid = '') {
    // prepare sql parameters
    $uid = PrepareSqlParameter($userprofileid, L_G_COL_USERPROFILEID, CHECK_EMPTY|CHECK_ALLOWED);
    $uname = PrepareSqlParameter($name, L_G_COL_NAME, CHECK_ALLOWED);
    $urtype = PrepareSqlParameter($rtype, L_G_COL_RTYPE, CHECK_ALLOWED);
    $uaccountid = PrepareSqlParameter($accountid, L_G_COL_ACCOUNTID, CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(false);
    }
    if(!QCore_Bl_Userprofiles::CheckUserprofileExists($uid, NULL, true)) {
      // user profile with this ID does not exist
      QUnit_Messager::setErrorMessage(L_G_USERPROFILEDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_USERPROFILEDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }
    if(QCore_Bl_Userprofiles::CheckUserprofileExists($uid, $uname, false)) {
      // user profile with this name already exists
      QUnit_Messager::setErrorMessage(L_G_USERPROFILENAMEALREADYEXISTS);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_USERPROFILENAMEALREADYEXISTS, __FILE__, __LINE__);
      return(false);
    }
    QUnit_Global::includeClass('QCore_Bl_Accounts');
    if(!QCore_Bl_Accounts::CheckAccountExists($uaccountid, NULL, true)) {
      // account does not exist
      QUnit_Messager::setErrorMessage(L_G_ACCOUNTDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ACCOUNTDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }

    // save changes of group into db
    $set = '';
    $sql = 'update wd_g_userprofiles set';
    // if name is NULL, it should not be set
    if($name !== '') {
      $set .= ', name='._q($uname);
    }
    // if type is NULL, it should not be set
    if($rtype !== '') {
      $set .= ', rtype='._q($urtype);
    }
    // if account ID is NULL, it should not be set
    if($accountid !== '') {
      $set .= ', accountid='._q($uaccountid);
    }
    // if there's nothing to set, exit function
    if(!$set) {
      return(true);
    }
    $sql .= substr($set, 1).' where userprofileid='._q($uid);
    $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if (!$ret) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // log history
    QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
    QUnit_Messager::setOkMessage(L_G_USERPROFILEEDITED);

    // return success value
    return(true);
  }

  //--------------------------------------------------------------------------

  // function deletes user profile
  //   parameters: userprofileid - user profile ID
  //   return value: true/false (success/failure)
  function DeleteAdmin($accountid) {
    // prepare sql parameters
    $uid = PrepareSqlParameter($userprofileid, L_G_COL_USERNAME, CHECK_EMPTY|CHECK_ALLOWED);
    if(QUnit_Messager::getErrorMessage() != '') {
      QCore_History::DebugMsg(WLOG_ERROR, $errorMsg, __FILE__, __LINE__);
      return(false);
    }
    if(!QCore_Bl_Userprofiles::CheckUserprofileExists($uid, NULL, true)) {
      // user profile with this ID does not exist
      QUnit_Messager::setErrorMessage(L_G_USERPROFILEDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_USERPROFILEDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }

    // delete user profile
    $sql = 'delete from wd_g_userprofiles where userprofileid='._q($uid);
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if(!$rs) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // write history
    QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);

    // return success value
    return(true);
  }
  
    //--------------------------------------------------------------------------
  
    function getUserProfilesAsArray($type = '', $accountid = '')
    {
        $sql = 'select * from wd_g_userprofiles where 1=1';
        if($type !== '')
            $sql .= ' and rtype = '._q($type);
        if($accountid != '')
            $sql .= ' and accountid = '._q($accountid);
        $sql .= ' order by name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return array();
        }        

        $ups = array();

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['userprofileid'] = $rs->fields['userprofileid'];
            $temp['name'] = $rs->fields['name'];

            $ups[$rs->fields['userprofileid']] = $temp;

            $rs->MoveNext();
        }

        return $ups;
    }
    
    //--------------------------------------------------------------------------
 
    function loadUserProfileInfo()
    {
        $userprofileid = preg_replace('/[\'\"]/', '', $_REQUEST['upid']);
        $sql = 'select * from wd_g_userprofiles where userprofileid='._q($userprofileid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs || $rs->EOF) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }        

        $_POST['upid'] = $rs->fields['userprofileid'];
        $_POST['name'] = $rs->fields['name'];
        $_POST['rtype'] = $rs->fields['rtype'];
        $_POST['accountid'] = $rs->fields['accountid'];

        $sql = 'select * from wd_g_userrights where userprofileid='._q($userprofileid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }
        
        $_POST['userrighttype'] = array();
        
        while(!$rs->EOF)
        {
            $_POST['userrighttype'][] = $rs->fields['righttypeid'];
            $rs->MoveNext();
        }
        
        return true;
    }
       
    //--------------------------------------------------------------------------
    
    function processDeleteUserProfile()
    {
        $userprofileid = preg_replace('/[\'\"]/', '', $_REQUEST['upid']);

        if($userprofileid == '') return false;

        $sql = 'select count(userid) as counter '.
               'from wd_g_users '.
               'where userprofileid='._q($userprofileid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }        

        if($rs->fields['counter'] <= 0)
        {
            $sql = 'delete from wd_g_userprofiles where userprofileid='._q($userprofileid);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            if(!$rs) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
                return false;
            }

            QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);

            if(!QCore_Bl_RightTypes::deleteUserRights($userprofileid)) return false;
            
            return true;
        }

        return false;
    }
}
?>
