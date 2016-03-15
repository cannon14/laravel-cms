<?php
class QCore_Bl_Users
{
    function getUsersUsernamesAsArray($AccountID = '')
    {
        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and rtype='._q(USERTYPE_USER);
        if($AccountID != '')
            $sql .= '  and accountid='._q($AccountID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return array();
        }

        $users = array();
        while(!$rs->EOF)
        {
            $temp = array();

            $temp['userid'] = $rs->fields['userid'];
            $temp['username'] = $rs->fields['username'];

            $users[$rs->fields['accountid']][$rs->fields['userid']] = $temp;

            $rs->MoveNext();
        }
        
        return $users;
    }
    
    //--------------------------------------------------------------------------
    
    function getUsersShort($AccountID = '')
    {
        $sql = 'select userid, name, surname, username, rstatus from wd_g_users '.
               'where rtype='._q(USERTYPE_USER).' and deleted=0';
        $sql .= ' and userid in (select affiliateid from cs_affiliateaccess where userid='._q($GLOBALS["Auth"]->getUserID()).')';
        if($AccountID != '') $sql .= ' and accountid='._q($AccountID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return array();
        }
        
        $userDataShort = array();
        
        while(!$rs->EOF)
        {
            $userDataShort[$rs->fields['userid']]['userid'] = $rs->fields['userid'];
            $userDataShort[$rs->fields['userid']]['name'] = $rs->fields['name'];
            $userDataShort[$rs->fields['userid']]['surname'] = $rs->fields['surname'];
            $userDataShort[$rs->fields['userid']]['username'] = $rs->fields['username'];
            $userDataShort[$rs->fields['userid']]['rstatus'] = $rs->fields['rstatus'];
            $rs->MoveNext();
        }
        
        return $userDataShort;

    }
    
    //--------------------------------------------------------------------------
    
    function getUserData($UserID)
    {
        if($UserID == '') return false;
        
        $sql = 'select * from wd_g_users where userid='._q($UserID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }

        if($rs->EOF) return false;
        
        $data = array();
        $data['userid'] = $rs->fields['userid'];
        $data['accountid'] = $rs->fields['accountid'];
        $data['refid'] = $rs->fields['refid'];
        $data['username'] = $rs->fields['username'];
        $data['rpassword'] = $rs->fields['rpassword'];
        $data['name'] = $rs->fields['name'];
        $data['surname'] = $rs->fields['surname'];
        $data['rstatus'] = $rs->fields['rstatus'];
        $data['dateinserted'] = $rs->fields['dateinserted'];
        $data['dateapproved'] = $rs->fields['dateapproved'];
        $data['userprofileid'] = $rs->fields['userprofileid'];
        $data['parentuserid'] = $rs->fields['parentuserid'];
        $data['company_name'] = $rs->fields['company_name'];
        $data['weburl'] = $rs->fields['weburl'];
        $data['street'] = $rs->fields['street'];
        $data['city'] = $rs->fields['city'];
        $data['state'] = $rs->fields['state'];
        $data['country'] = $rs->fields['country'];
        $data['zipcode'] = $rs->fields['zipcode'];
        $data['phone'] = $rs->fields['phone'];
        $data['fax'] = $rs->fields['fax'];
        $data['tax_ssn'] = $rs->fields['tax_snn'];
        $data['data1'] = $rs->fields['data1'];
        $data['data2'] = $rs->fields['data2'];
        $data['data3'] = $rs->fields['data3'];
        $data['data4'] = $rs->fields['data4'];
        $data['data5'] = $rs->fields['data5'];
        
        return $data;
    }
    
    //--------------------------------------------------------------------------
    
    function checkUserExists($userid = '', $username = '', $uidexists = true)
    {
        if(($userid == '') && ($username == '')) {
            return(false);
        }

        // prepare sql parameters
        $uid = PrepareSqlParameter($userid, L_G_USERID, CHECK_ALLOWED);
        $username = PrepareSqlParameter($username, L_G_COL_USERNAME, CHECK_ALLOWED);
        if(($errmsg = QUnit_Messager::getErrorMessage()) != '') {
            QCore_History::DebugMsg(WLOG_DBERROR, $errmsg, __FILE__, __LINE__);
            return(false);
        }

        $sql = 'select userid from wd_g_users where 1=1 ';
        if($username != '') {
            $sql .= ' and username='._q($username);
        }
        if($uid != '') {
            if($uidexists) {
                $sql .= ' and userid='._q($uid);
            }
            else {
                $sql .= ' and userid<>'._q($uid);
            }
        }

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return(false);
        }

        if($rs->EOF) {
            return(false);
        }

        return(true);
    }
    
    //--------------------------------------------------------------------------
    
    function getUsersToBroadcastMessage($params)
    {
        if($params['AccountID'] == '' || $params['userid_str'] == '')
            return array();

        $sql = "select * from wd_g_users ".
               "where deleted=0 and userid in ".$params['userid_str'].
               "  and accountid="._q($params['AccountID']);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF)
            return false;

        $users = array();

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['userid'] = $rs->fields['userid'];
            $temp['username'] = $rs->fields['username'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['rpassword'] = $rs->fields['rpassword'];
            $temp['company_name'] = $rs->fields['company_name'];
            $temp['weburl'] = $rs->fields['weburl'];
            $temp['street'] = $rs->fields['street'];
            $temp['city'] = $rs->fields['city'];
            $temp['state'] = $rs->fields['state'];
            $temp['country'] = $rs->fields['country'];
            $temp['zipcode'] = $rs->fields['zipcode'];
            $temp['phone'] = $rs->fields['phone'];
            $temp['fax'] = $rs->fields['fax'];
            $temp['tax_ssn'] = $rs->fields['tax_ssn'];
            $temp['data1'] = $rs->fields['data1'];
            $temp['data2'] = $rs->fields['data2'];
            $temp['data3'] = $rs->fields['data3'];
            $temp['data4'] = $rs->fields['data4'];
            $temp['data5'] = $rs->fields['data5'];
    
            $users[] = $temp;
    
            $rs->MoveNext();
        }

        return $users;
    }
}
?>
