<?php
class QCore_Bl_Accounts
{
  // function returns an array containing information about specified account
  //   parameters: accountid (string) - account ID
  //   return value: (array) an array containg information about specified account
  function GetAccountInfo($accountid) {
    // prepare sql parameters
    $aid = PrepareSqlParameter($accountid, L_G_COL_ACCOUNTID, CHECK_EMPTY|CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(array());
    }

    // select information about specified account
    $sql = 'select ac.accountid, ac.name, ac.description, ac.dateinserted, ac.rstatus '.
           '  from wd_g_accounts ac '.
           ' where ac.accountid='._q($aid);
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

  // function returns array containing information about all accounts
  //   parameters: $orderbycol (string) - database table column name for order by clause
  //               $sortorder (string)  - tells, whether order in ascending order ('asc'), or descending order ('desc')
  //   return value: (array) array containing admins information
  function GetAccountsInfo($orderbycol = '', $sortorder = 'asc') {
    // prepare orderby parameter
    $orderby = '';
    if($orderbycol) {
      $obvals = array('name' => true, 'description' => true, 'dateinserted' => true, 'rstatus' => true);
      if(isset($obvals[$orderbycol])) {
        $orderby = ' order by '.$orderbycol;
        if($sortorder == 'asc' || $sortorder == 'desc') {
          $orderby .= ' '.$sortorder;
        }
      }
    }

    // select information about accounts
    $sql = 'select ac.accountid, ac.name, ac.description, ac.dateinserted, ac.rstatus '.
           '  from wd_g_accounts ac'.$orderby;
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if(!$rs) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(array());
    }

    // an array which will be returned
    $accs = array();

    // fill an array with information
    $i = 0;
    while(!$rs->EOF) {
      // assign actual record into array
      $accs[$i++] = $rs->fields;
      // move to next record
      $rs->MoveNext();
    }

    // return an array containing gathered information
    return($accs);
  }

  //--------------------------------------------------------------------------

  // function checks whether specified account already exists
  //   parameters: accountid (string) - account ID
  //               name (string)      - admin name
  //               aidexists (bool)   - tells whether search for account ID (true), or exclude it (false - only if specified)
  //   return value: (bool) true/false (group already exists/group does not exist)
  function checkAccountExists($accountid = '', $name = '', $aidexists = true) {
    // at least one parameter should be specified
    if(($accountid == '') && ($name == '')) {
      return(false);
    }

    // prepare sql parameters
    $aid = PrepareSqlParameter($accountid, L_G_ACCOUNTID, CHECK_ALLOWED);
    $aname = PrepareSqlParameter($name, L_G_COL_NAME, CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(false);
    }

    // try to select specified account
    $sql = 'select accountid from wd_g_accounts where accountid=accountid';
    if($name != '') {
      $sql .= ' and name='._q($aname);
    }
    if($accountid != '') {
      if($aidexists) {
        $sql .= ' and accountid='._q($aid);
      }
      else {
        $sql .= ' and accountid<>'._q($aid);
      }
    }
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    // error handling
    if(!$rs) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // if no data were selected, specified account does not exist
    if($rs->EOF) {
      return(false);
    }
    // if there were some data selected, specified account already exists
    return(true);
  }

  //--------------------------------------------------------------------------

  // function inserts new account
  //   parameters: name (string)        - account name (should be set via parameter)
  //               description (string) - account description (should be set via parameter)
  //               rstatus (string)     - account status (default value is enabled)
  //   return value: (bool) true/false (success/failure)
  function InsertAccount($name, $description, $rstatus = STATUS_ENABLED) {
    // prepare sql parameters
    $aname = PrepareSqlParameter($name, L_G_COL_NAME, CHECK_EMPTY|CHECK_ALLOWED);
    $adescription = PrepareSqlParameter($description, L_G_COL_DESCRIPTION, CHECK_ALLOWED);
    $arstatus = PrepareSqlParameter($rstatus, L_G_COL_RSTATUS, CHECK_EMPTY|CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(false);
    }
    if(QCore_Bl_Accounts::CheckAccountExists(NULL, $aname)) {
      // account with this user name already exists
      QUnit_Messager::setErrorMessage(L_G_ACCOUNTNAMEALREADYEXISTS);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ACCOUNTNAMEALREADYEXISTS, __FILE__, __LINE__);
      return(false);
    }

    // insert account into db
//    $aid = QCore_Sql_DBUnit::createUniqueID('wd_g_accounts', 'accountid');
    $aid = QCore_Sql_DBUnit::generateID('seq_wd_g_accounts', 1);
    $sql = 'insert into wd_g_accounts (accountid, name, description, dateinserted, rstatus) '.
           'values '.
           '('._q($aid).','._q($aname).','._q($adescription).','.sqlNow().','._q($arstatus).')';
    $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if(!$ret) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // log history
    QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
    QUnit_Messager::setOkMessage(L_G_ACCOUNTADDED);

    // success
    return(true);
  }

  //--------------------------------------------------------------------------

  // function updates account information
  //   parameters: accountid (string)   - account ID (should be set via parameter)
  //               name (string)        - new account name (default value is '' - if ommited, it will not be changed)
  //               description (string) - new account description (default value is '' - if ommited, it will not be changed)
  //               rstatus (string)     - new account status (default value is '' - if ommited, it will not be changed)
  //   return value: (bool) true/false (success/failure)
  function UpdateAccount($accountid, $name = '', $description = '', $rstatus = '') {
    // prepare sql parameters
    $aid = PrepareSqlParameter($accountid, L_G_COL_ACCOUNTID, CHECK_EMPTY|CHECK_ALLOWED);
    $aname = PrepareSqlParameter($name, L_G_COL_NAME, CHECK_ALLOWED);
    $adescription = PrepareSqlParameter($description, L_G_COL_DESCRIPTION, CHECK_ALLOWED);
    $arstatus = PrepareSqlParameter($rstatus, L_G_COL_RSTATUS, CHECK_ALLOWED);
    if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
      QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
      return(false);
    }
    if(!QCore_Bl_Accounts::CheckAccountExists($aid, NULL, true)) {
      // account with this ID does not exist
      QUnit_Messager::setErrorMessage(L_G_ACCOUNTDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ACCOUNTDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }
    if(QCore_Bl_Accounts::CheckAccountsExists($aid, $aname, false)) {
      // account with this name already exists
      QUnit_Messager::setErrorMessage(L_G_ACCOUNTNAMEALREADYEXISTS);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ACCOUNTNAMEALREADYEXISTS, __FILE__, __LINE__);
      return(false);
    }

    // save changes of group into db
    $set = '';
    $sql = 'update wd_g_accounts set';
    // if name is NULL, it should not be set
    if($name !== '') {
      $set .= ', name='._q($aname);
    }
    // if description is NULL, it should not be set
    if($description !== '') {
      $set .= ', description='._q($adescription);
    }
    // if status is NULL, it should not be set
    if($rstatus !== '') {
      $set .= ', rstatus='._q($arstatus);
    }
    // if there's nothing to set, exit function
    if(!$set) {
      return(true);
    }
    $sql .= substr($set, 1).' where accountid='._q($aid);
    $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

    // error handling
    if (!$ret) {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
      return(false);
    }

    // log history
    QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
    QUnit_Messager::setOkMessage(L_G_ACCOUNTEDITED);

    // return success value
    return(true);
  }

  //--------------------------------------------------------------------------

  // function changes account status (enabled/disabled)
  //   parameters: accountid (string) - account ID
  //   return value: (bool) true/false (success/failure)
  function ChangeAccountStatus($accountid) {
    // prepare sql parameters
    $aid = PrepareSqlParameter($accountid, L_G_COL_ACCOUNTID, CHECK_EMPTY|CHECK_ALLOWED);
    if(QUnit_Messager::getErrorMessage() != '') {
      QCore_History::DebugMsg(WLOG_ERROR, $errorMsg, __FILE__, __LINE__);
      return(false);
    }
    if(!QCore_Bl_Accounts::CheckAccountExists($aid, NULL, true)) {
      // account with this ID does not exist
      QUnit_Messager::setErrorMessage(L_G_ACCOUNTDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ACCOUNTDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }

    // select actual account status
    $sql = 'select rstatus from wd_g_accounts where accountid = '._q($aid);
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
    $sql = 'update wd_g_accounts set rstatus = '._q($newstatus).' where accountid = '._q($aid);
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

  // function deletes account
  //   parameters: accountid - account ID
  //   return value: true/false (success/failure)
  function DeleteAccount($accountid) {
    // prepare sql parameters
    $aid = PrepareSqlParameter($accountid, L_G_COL_USERNAME, CHECK_EMPTY|CHECK_ALLOWED);
    if(QUnit_Messager::getErrorMessage() != '') {
      QCore_History::DebugMsg(WLOG_ERROR, $errorMsg, __FILE__, __LINE__);
      return(false);
    }
    if(!QCore_Bl_Accounts::CheckAccountExists($aid, NULL, true)) {
      // account with this ID does not exist
      QUnit_Messager::setErrorMessage(L_G_ACCOUNTDOESNOTEXIST);
      QCore_History::DebugMsg(WLOG_DBERROR, L_G_ACCOUNTDOESNOTEXIST, __FILE__, __LINE__);
      return(false);
    }

    // delete account
    $sql = 'delete from wd_g_accounts where accountid='._q($aid);
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
/*
    function checkAccountExists($name, $aid = '')
    {
        $sql = 'select * from wd_g_accounts where name='._q($name);
        if($aid != '')
            $sql .= ' and accountid <> '._q($aid);
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
*/
    //--------------------------------------------------------------------------

    function getAccountsAsArray()
    {
        $sql = 'select * from wd_g_accounts where rstatus = '._q(STATUS_ENABLE).' order by name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return array();
        }

        $accts = array();

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['accountid'] = $rs->fields['accountid'];
            $temp['name'] = $rs->fields['name'];
            $accts[$rs->fields['accountid']] = $temp;

            $rs->MoveNext();
        }

        return $accts;
    }
}
?>
