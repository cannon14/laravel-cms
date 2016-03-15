<?php
class QCore_Bl_Admins
{
  // function returns an array containing information about specified admin
  //   parameters: adminid (string) - admin ID
  //   return value: (array) an array containg information about specified admin
  function GetAdminInfo($adminid) {
    // prepare sql parameters
    $aid = PrepareSqlParameter($adminid, L_G_COL_USERID, CHECK_EMPTY|CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(array());
    }

    // select information about specified admin
    $sql = 'select u.userid, u.accountid, u.username, u.rpassword, u.name, u.surname, u.rstatus, u.product, u.dateinserted, u.dateapproved, u.deleted, u.userprofileid, u.rtype, ac.name as account_name, up.name as userprofile_name '.
           '  from wd_g_users u left join wd_g_accounts ac on (u.accountid=ac.accountid) left join wd_g_userprofiles up on (u.userprofileid=up.userprofileid) '.
           ' where u.rtype='._q(USERTYPE_ADMIN).
           '   and u.product='._q(PRODUCT_TYPE).
           '   and u.userid='._q($aid);
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

  // function returns array containing information about all admins
  //   parameters: $orderbycol (string)  - database table column name for order by clause
  //               $sortorder (string)   - tells, whether order in ascending order ('asc'), or descending order ('desc')
  //               $getforallaccs (bool) - tells, whether get information of all admins (true), or only for user account (false)
  //               $getforallpdts (bool) - tells, whether get information of all admins (true), or only for this product (false)
  //   return value: (array) array containing admins information
  function GetAdminsInfo($orderbycol = '', $sortorder = 'asc', $getforallaccs = false, $getforallpdts = false) {
    // prepare orderby parameter
    $orderby = '';
    if($orderbycol) {
      $obvals = array('username' => true, 'name' => true, 'surname' => true, 'rstatus' => true, 'dateinserted' => true, 'account_name' => true, 'userprofile_name' => true);
      if(isset($obvals[$orderbycol])) {
        $orderby = ' order by '.$orderbycol;
        if($sortorder == 'asc' || $sortorder == 'desc') {
          $orderby .= ' '.$sortorder;
        }
      }
    }

    // select information about admins
    if($getall) {
      $sql = 'select u.userid, u.accountid, u.username, u.rpassword, u.name, u.surname, u.rstatus, u.product, u.dateinserted, u.dateapproved, u.deleted, u.userprofileid, u.rtype, ac.name as account_name, up.name as userprofile_name '.
             '  from wd_g_users u left join wd_g_accounts ac on (u.accountid=ac.accountid) left join wd_g_userprofiles up on (u.userprofileid=up.userprofileid) '.
             ' where u.rtype='._q(USERTYPE_ADMIN).
             (($getforallpdts) ? '' : '   and u.product='._q(PRODUCT_TYPE)).$orderby;
    }
    else {
      $sql = 'select u.userid, u.accountid, u.username, u.rpassword, u.name, u.surname, u.rstatus, u.product, u.dateinserted, u.dateapproved, u.deleted, u.userprofileid, u.rtype, ac.name as account_name, up.name as userprofile_name '.
             '  from wd_g_users u, wd_g_accounts ac left join wd_g_userprofiles up on (u.userprofileid=up.userprofileid) '.
             ' where u.rtype='._q(USERTYPE_ADMIN).
             (($getforallpdts) ? '' : '   and u.product='._q(PRODUCT_TYPE)).
             '   and u.accountid=ac.accountid'.
             '   and u.accountid='._q($GLOBALS['Auth']->getAccountID()).$orderby;
    }
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if(!$rs) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(array());
    }

    // an array which will be returned
    $adms = array();

    // fill an array with information
    $i = 0;
    while(!$rs->EOF) {
      // assign actual record into array
      $adms[$i++] = $rs->fields;
      // move to next record
      $rs->MoveNext();
    }

    // return an array containing gathered information
    return($adms);
  }

  //--------------------------------------------------------------------------

  // function checks whether specified admin already exists
  //   parameters: adminid (string)  - admin ID
  //               username (string) - admin user name
  //               aidexists (bool)  - tells whether search for admin ID (true), or exclude it (false - only if specified)
  //   return value: (bool) true/false (group already exists/group does not exist)
  function CheckAdminExists($adminid = '', $username = '', $aidexists = true) {
    // at least one parameter should be specified
    if(($adminid == '') && ($username == '')) {
      return(false);
    }

    // prepare sql parameters
    $aid = PrepareSqlParameter($adminid, L_G_USERID, CHECK_ALLOWED);
    $ausername = PrepareSqlParameter($username, L_G_COL_USERNAME, CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(false);
    }

    // try to select specified admin
    $sql = 'select userid from wd_g_users where rtype='._q(USERTYPE_ADMIN).' and product='._q(PRODUCT_TYPE);
    if($username != '') {
      $sql .= ' and username='._q($ausername);
    }
    if($adminid != '') {
      if($aidexists) {
        $sql .= ' and userid='._q($aid);
      }
      else {
        $sql .= ' and userid<>'._q($aid);
      }
    }
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    // error handling
    if(!$rs) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // if no data were selected, specified admin does not exist
    if($rs->EOF) {
      return(false);
    }
    // if there were some data selected, specified admin already exists
    return(true);
  }

  //--------------------------------------------------------------------------

  // function inserts new admin
  //   parameters: username (string)      - admin username (should be set via parameter)
  //               rpassword (string)     - admin password (should be set via parameter)
  //               accountid (string)     - account ID (should be set via parameter)
  //               userprofileid (string) - user profile ID (should be set via parameter)
  //               name (string)          - admin name (default value is empty string)
  //               surname (string)       - admin surname (default value is empty string)
  //               rstatus (string)       - admin status (default value is enabled)
  //   return value: (bool) true/false (success/failure)
  function InsertAdmin($username, $rpassword, $accountid, $userprofileid, $name = '', $surname = '', $rstatus = STATUS_ENABLED) {
    // prepare sql parameters
    $ausername = PrepareSqlParameter($username, L_G_COL_USERNAME, CHECK_EMPTY|CHECK_ALLOWED);
    $arpassword = PrepareSqlParameter($rpassword, L_G_COL_RPASSWORD, CHECK_EMPTY|CHECK_ALLOWED);
    $aaccountid = PrepareSqlParameter($accountid, L_G_COL_ACCOUNTID, CHECK_EMPTY|CHECK_ALLOWED);
    $auserprofileid = PrepareSqlParameter($userprofileid, L_G_COL_USERPROFILEID, CHECK_EMPTY|CHECK_ALLOWED);
    $aname = PrepareSqlParameter($name, L_G_COL_NAME, CHECK_ALLOWED);
    $asurname = PrepareSqlParameter($surname, L_G_COL_SURNAME, CHECK_ALLOWED);
    $arstatus = PrepareSqlParameter($rstatus, L_G_COL_RSTATUS, CHECK_EMPTY|CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(false);
    }
    if(QCore_Bl_Admins::CheckAdminExists(NULL, $ausername)) {
      // admin with this user name already exists
      QUnit_Messager::setErrorMessage(L_G_ADMINNAMEALREADYEXISTS);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ADMINNAMEALREADYEXISTS, __FILE__, __LINE__);
      return(false);
    }
    QUnit_Global::includeClass('QCore_Bl_Accounts');
    if(!QCore_Bl_Accounts::CheckAccountExists($aaccountid, NULL, true)) {
      // account does not exist
      QUnit_Messager::setErrorMessage(L_G_ACCOUNTDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ACCOUNTDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }
    QUnit_Global::includeClass('QCore_Bl_Userprofiles');
    if(!QCore_Bl_Accounts::CheckAccountExists($auserprofileid, NULL, true)) {
      // user profile does not exist
      QUnit_Messager::setErrorMessage(L_G_USERPROFILEDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_USERPROFILEDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }

    // insert admin into db
//    $aid = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');
    $aid = QCore_Sql_DBUnit::generateID('seq_wd_g_users', 1);
    $sql = 'insert into wd_g_users (userid, username, rpassword, name, surname, '.
           'rtype, dateinserted, rstatus, accountid, userprofileid, product) '.
           'values '.
           '('._q($aid).','._q($ausername).','._q(md5($arpassword)).','._q($aname).
           ','._q($asurname).','._q(USERTYPE_ADMIN).','.sqlNow().','._q($arstatus).
           ','._q($aaccountid).','._q($auserprofileid).','._q(PRODUCT_TYPE).')';
    $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if(!$ret) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // log history
    QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
    QUnit_Messager::setOkMessage(L_G_ADMINADDED);

    // success
    return(true);
  }

  //--------------------------------------------------------------------------

  // function updates admin information
  //   parameters: adminid (string)   - admin user ID (should be set via parameter)
  //               username (string)  - new admin username (default value is '' - if ommited, it will not be changed)
  //               rpassword (string) - new admin password (default value is '' - if ommited, it will not be changed)
  //               name (string)      - new admin name (default value is '' - if ommited, it will not be changed)
  //               surname (string)   - new admin surname (default value is '' - if ommited, it will not be changed)
  //               rstatus (string)   - new admin status (default value is '' - if ommited, it will not be changed)
  //   return value: (bool) true/false (success/failure)
  function UpdateAdmin($adminid, $username = '', $rpassword = '', $name = '', $surname = '', $rstatus = '') {
    // prepare sql parameters
    $aid = PrepareSqlParameter($adminid, L_G_COL_USERID, CHECK_EMPTY|CHECK_ALLOWED);
    $ausername = PrepareSqlParameter($username, L_G_COL_USERNAME, CHECK_ALLOWED);
    $arpassword = PrepareSqlParameter($rpassword, L_G_COL_RPASSWORD, CHECK_ALLOWED);
    $aname = PrepareSqlParameter($name, L_G_COL_NAME, CHECK_ALLOWED);
    $asurname = PrepareSqlParameter($surname, L_G_COL_SURNAME, CHECK_ALLOWED);
    $arstatus = PrepareSqlParameter($rstatus, L_G_COL_RSTATUS, CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(false);
    }
    if(!QCore_Bl_Admins::CheckAdminExists($aid, NULL, true)) {
      // admin with this ID does not exist
      QUnit_Messager::setErrorMessage(L_G_ADMINDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ADMINDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }
    if(QCore_Bl_Admins::CheckAdminExists($aid, $ausername, false)) {
      // admin with this username already exists
      QUnit_Messager::setErrorMessage(L_G_ADMINNAMEALREADYEXISTS);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ADMINNAMEALREADYEXISTS, __FILE__, __LINE__);
      return(false);
    }

    // save changes of group into db
    $set = '';
    $sql = 'update wd_g_users set';
    // if user name is NULL, it should not be set
    if($username !== '') {
      $set .= ', username='._q($ausername);
    }
    // if password is NULL, it should not be set
    if($rpassword !== '') {
      $set .= ', rpassword='._q(md5($arpassword));
    }
    // if name is NULL, it should not be set
    if($name !== '') {
      $set .= ', name='._q($aname);
    }
    // if surname is NULL, it should not be set
    if($surname !== '') {
      $set .= ', surname='._q($asurname);
    }
    // if status is NULL, it should not be set
    if($rstatus !== '') {
      $set .= ', rstatus='._q($arstatus);
    }
    // if there's nothing to set, exit function
    if(!$set) {
      return(true);
    }
    $sql .= substr($set, 1).' where userid='._q($aid);
    $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if (!$ret) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // log history
    QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
    QUnit_Messager::setOkMessage(L_G_ADMINEDITED);

    // return success value
    return(true);
  }

  //--------------------------------------------------------------------------

  // function changes admin status (enabled/disabled)
  //   parameters: adminid (string) - admin ID
  //   return value: (bool) true/false (success/failure)
  function ChangeAdminStatus($adminid) {
    // prepare sql parameters
    $aid = PrepareSqlParameter($adminid, L_G_COL_USERID, CHECK_EMPTY|CHECK_ALLOWED);
    if(QUnit_Messager::getErrorMessage() != '') {
      QCore_History::DebugMsg(WLOG_ERROR, $errorMsg, __FILE__, __LINE__);
      return(false);
    }
    if(!QCore_Bl_Admins::CheckAdminExists($aid, NULL, true)) {
      // admin with this ID does not exist
      QUnit_Messager::setErrorMessage(L_G_ADMINDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ADMINDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }

    // select actual admin status
    $sql = 'select rstatus from wd_g_users where userid = '._q($aid);
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if(!$rs || $rs->EOF) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // change status
    $newstatus = STATUS_ENABLED;
    switch($rs->fields['rstatus']) {
      case STATUS_ENABLED  :
        $newstatus = STATUS_DISABLED;
        break;
      case STATUS_DISABLED :
        $newstatus = STATUS_ENABLED;
        break;
      default              :
        break;
    }

    // update database table
    $sql = 'update wd_g_users set rstatus = '._q($newstatus).' where userid = '._q($aid);
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

  // function deletes admin
  //   parameters: adminid - admin ID
  //   return value: true/false (success/failure)
  function DeleteAdmin($adminid) {
    // prepare sql parameters
    $aid = PrepareSqlParameter($adminid, L_G_COL_USERNAME, CHECK_EMPTY|CHECK_ALLOWED);
    if(QUnit_Messager::getErrorMessage() != '') {
      QCore_History::DebugMsg(WLOG_ERROR, $errorMsg, __FILE__, __LINE__);
      return(false);
    }
    if(!QCore_Bl_Admins::CheckAdminExists($aid, NULL, true)) {
      // admin with this ID does not exist
      QUnit_Messager::setErrorMessage(L_G_ADMINDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ADMINDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }

    // delete admin
    $sql = 'delete from wd_g_users where userid='._q($aid);
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
}
?>