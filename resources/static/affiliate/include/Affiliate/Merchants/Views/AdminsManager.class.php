<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');

class Affiliate_Merchants_Views_AdminsManager extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['insert'] = 'aff_tool_admins_modify';
        $this->modulePermissions['update'] = 'aff_tool_admins_modify';
        $this->modulePermissions['add_new'] = 'aff_tool_admins_modify';
        $this->modulePermissions['edit'] = 'aff_tool_admins_modify';
        $this->modulePermissions['delete'] = 'aff_tool_admins_modify';
        $this->modulePermissions['change_status'] = 'aff_tool_admins_modify';
        $this->modulePermissions['view'] = 'aff_tool_admins_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['postaction']))
        {
            switch($_POST['postaction'])
            {              
                case 'insert':
                    if($this->processInsertAdmin())
                        return;
                    break;

                case 'update':
                    if($this->processUpdateAdmin())
                        return;
                    break;
            }
        }
    
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'add_new':
                    if($this->drawFormAddAdmin())
                        return;
                    break;

                case 'edit':
                    if($this->drawFormEditAdmin())
                        return;
                    break;

                case 'delete':
                    if($this->processDeleteAdmin())
                        return;
                    break;

                case 'change_status':
                    if($this->processChangeStatusAdmin())
                        return;
                    break;
            }
        }

        $this->showAdmins();
    }

    //------------------------------------------------------------------------

    function showAdmins()
    {
        $orderby = '';
    
        $a = array('a.userid', 'a.name', 'a.surname', 'a.username', 'a.dateinserted',
                   'a.rstatus', 'account_name', 'userprofile_name');
    
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder']; 
        else
            $orderby = ' order by a.username';
  
        $where = ' where a.accountid=ac.accountid'.
                 '   and ac.accountid='._q($GLOBALS['Auth']->getAccountID()).
                 '   and a.userprofileid=up.userprofileid'.
                 '   and a.rtype='._q(USERTYPE_ADMIN);

        $sql = 'select a.*, ac.name as account_name, up.name as userprofile_name '.
               'from wd_g_users a, wd_g_accounts ac, wd_g_userprofiles up
               '.$where.' '.$orderby;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return;
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);

        $this->assign('a_list_data', $list_data);
        $this->assign('a_numrows', $rs->PO_RecordCount('wd_g_users', $where));

        $temp_perm['add_new'] = $this->checkPermissions('add_new');
        $temp_perm['edit'] = $this->checkPermissions('edit');
        $temp_perm['delete'] = $this->checkPermissions('delete');
        $temp_perm['change_status'] = $this->checkPermissions('change_status');

        $this->assign('a_action_permission', $temp_perm);

        $this->addContent('admins_show');
    }

    //--------------------------------------------------------------------------
 
    function loadAdminInfo()
    {
        $adminid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);
        $sql = 'select a.*, ac.name as account_name from wd_g_users a, wd_g_accounts ac '.
               'where userid='._q($adminid).
               '  and a.accountid = ac.accountid'.
               '  and ac.accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
    
        $_POST['aid'] = $rs->fields['userid'];
        $_POST['username'] = $rs->fields['username'];
        $_POST['pwd1'] = '';
        $_POST['pwd2'] = '';
        $_POST['name'] = $rs->fields['name'];
        $_POST['surname'] = $rs->fields['surname'];
        $_POST['rstatus'] = $rs->fields['rstatus'];
        $_POST['accountid'] = $rs->fields['accountid'];
        $_POST['account_name'] = $rs->fields['account_name'];
        $_POST['userprofile'] = $rs->fields['userprofileid'];
        $_POST['allAffiliates'] = $rs->fields['data5'];
    }

    //------------------------------------------------------------------------

    function drawFormEditAdmin()
    {
        if($_POST['commited'] != 'yes')
        {
            $this->loadAdminInfo();
        }
        
        $pshow_no_popup = preg_replace('/[\'\"]/', '', $_REQUEST['show_no_popup']);
        
        if($pshow_no_popup != '')
            $_POST['show_no_popup'] = $pshow_no_popup;
    
        if($_POST['aid'] == '') $_POST['aid'] = $_REQUEST['aid'];
    
        $_POST['header'] = L_G_EDIT_ADMIN;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'update';
        
        $assigned = Affiliate_Merchants_Bl_Affiliate::getAssignedAffiliatesByAdmin($_REQUEST['aid']);
        $unassigned = Affiliate_Merchants_Bl_Affiliate::getUnassignedAffiliatesByAdmin($_REQUEST['aid']);

		$this->assign('assigned', $assigned);
		$this->assign('unassigned', $unassigned);
		
        $this->drawFormAddAdmin();
    
        return true;
    }
  
    //--------------------------------------------------------------------------
  
    function drawFormAddAdmin()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add_new';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'insert';

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADD_ADMIN;

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS(Affiliate_Merchants_Views_AdminsManager::getUserProfilesAsArray());

        $this->assign('a_list_data', $list_data);
        
        $assigned = Affiliate_Merchants_Bl_Affiliate::getAssignedAffiliatesByAdmin($_REQUEST['aid']);
        $unassigned = Affiliate_Merchants_Bl_Affiliate::getUnassignedAffiliatesByAdmin($_REQUEST['aid']);
        $this->assign('assigned', $assigned);
		$this->assign('unassigned', $unassigned);

        $this->addContent('admins_edit');
          
        return true;
    }

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processChangeStatusAdmin()
    {
        $adminid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);
    
        if($GLOBALS['Auth']->getUserID() != $adminid)
        {
            $sql = 'select rstatus from wd_g_users '.
                   'where userid='._q($adminid).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            if(!$rs || $rs->EOF) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            else
            {
                $new_status = '';
                if($rs->fields['rstatus'] == STATUS_ENABLED) $new_status = STATUS_DISABLED;
                else if($rs->fields['rstatus'] == STATUS_DISABLED) $new_status = STATUS_ENABLED;
      
                if($new_status != '')
                {
                    $sql = 'update wd_g_users set rstatus = '._q($new_status).
                           ' where userid = '._q($adminid).
                           '  and accountid='._q($GLOBALS['Auth']->getAccountID());
                    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
                    if(!$rs) {
                        QUnit_Messager::setErrorMessage(L_G_DBERROR);
                        return false;
                    }

                    $this->redirect('Affiliate_Merchants_Views_AdminsManager');
                }
            }
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processDeleteAdmin()
    {
        $adminid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);

        if(AFF_DEMO == 1 && $adminid == 'merch001') {
            return false;
        }
        
        if($GLOBALS['Auth']->getUserID() != $adminid)
        {
            $sql = 'delete from wd_g_users '.
                   'where userid='._q($adminid).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
          
            if (!$rs) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        return false;
    }
  
    //--------------------------------------------------------------------------

    function processUpdateAdmin()
    {
        // protect against script injection
        $pusername = preg_replace('/[\'\"]/', '', $_POST['username']);
        $ppwd1 = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $ppwd2 = preg_replace('/[\'\"]/', '', $_POST['pwd2']);
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $psurname = preg_replace('/[\'\"]/', '', $_POST['surname']);
        $pstatus = preg_replace('/[^0-9]/', '', $_POST['rstatus']);
        $puserprofile = preg_replace('/[\'\"]/', '', $_POST['userprofile']);
        $AdminID = preg_replace('/[\'\"]/', '', $_POST['aid']);
        $addAff = $_POST['affiliateId'];
    
        // check correctness of the fields
        checkCorrectness($_POST['username'], $pusername, L_G_USER_NAME, CHECK_EMPTYALLOWED);
        if($_POST['username'] != '' && $this->checkAdminExists($_POST['username'], $AdminID))
            QUnit_Messager::setErrorMessage(L_G_UNAMEEXISTS);
    
        checkCorrectness($_POST['pwd1'], $ppwd1, L_G_PWD1, CHECK_ALLOWED);
        checkCorrectness($_POST['pwd2'], $ppwd2, L_G_PWD2, CHECK_ALLOWED);
        if($_POST['pwd1'] != $_POST['pwd2'])
            QUnit_Messager::setErrorMessage(L_G_PWDDONTMATCH);

        if($AdminID != $GLOBALS['Auth']->getUserID())
            checkCorrectness($_POST['rstatus'], $pstatus, L_G_STATUS, CHECK_EMPTYALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['userprofile'], $puserprofile, L_G_USER_PROFILE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_ALLOWED);
        checkCorrectness($_POST['surname'], $psurname, L_G_SURNAME, CHECK_ALLOWED);

        if(QUnit_Messager::getErrorMessage() != '')
        {
        }
        else
        {
            if(AFF_DEMO == 1 && $AdminID == 'merch001') {
                $ppwd = $ppwd1;
                $sql = 'update wd_g_users '.
                       'set name='._q($pname).
                       '   ,surname='._q($psurname).
                        ' where userid='._q($AdminID).
                        '   and accountid='._q($GLOBALS['Auth']->getAccountID());
            } else {
                $ppwd = $ppwd1;
                $sql = 'update wd_g_users '.
                       'set username='._q($pusername).
                       '   ,name='._q($pname).
                       '   ,surname='._q($psurname);
                if($ppwd != '') $sql .= ',rpassword='._q(MD5($ppwd));
                if($AdminID != $GLOBALS['Auth']->getUserID()) $sql .= '  ,rstatus='._q($pstatus);
                $sql .= '  ,userprofileid='._q($puserprofile).
                        ' where userid='._q($AdminID).
                        '   and accountid='._q($GLOBALS['Auth']->getAccountID());
            }
            
            // save changes of admin to db
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
            $sql = "DELETE FROM cs_affiliateaccess WHERE userid="._q($AdminID);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
            if($_REQUEST['allAffs']){
            	$sql = "UPDATE wd_g_users SET data5="._q($_REQUEST['allAffs'])." WHERE userId="._q($AdminID);
            	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            }
            
            else{
            	$sql = "UPDATE wd_g_users SET data5=null WHERE userId="._q($AdminID);
            	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            	if(is_array($addAff)){
	            foreach($addAff as $add)
	            {
	            	$sql = "INSERT INTO cs_affiliateaccess (userid, affiliateid) VALUES ("._q($AdminID).","._q($add).")";
	            	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	            }}
            }
            
            if (!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }    
            else
            {
                QUnit_Messager::setOkMessage(L_G_ADMIN_EDITED);

                if($_POST['show_no_popup'] == '1') return false;

                $this->closeWindow('Affiliate_Merchants_Views_AdminsManager');
                $this->addContent('closewindow');

                return true;
            }
        }
    
        return false;
    } 

    //--------------------------------------------------------------------------

    function processInsertAdmin()
    {
        // protect against script injection
        $pusername = preg_replace('/[\'\"]/', '', $_POST['username']);
        $ppwd1 = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $ppwd2 = preg_replace('/[\'\"]/', '', $_POST['pwd2']);
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $psurname = preg_replace('/[\'\"]/', '', $_POST['surname']);
        $pstatus = preg_replace('/[^0-9]/', '', $_POST['rstatus']);
        $puserprofile = preg_replace('/[\'\"]/', '', $_POST['userprofile']);
        $AdminID = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');
        
        // check correctness of the fields
        checkCorrectness($_POST['username'], $pusername, L_G_USER_NAME, CHECK_EMPTYALLOWED);
        
        if($_POST['username'] != '' && $this->checkAdminExists($_POST['username']))
            QUnit_Messager::setErrorMessage(L_G_UNAMEEXISTS);
        
        checkCorrectness($_POST['pwd1'], $ppwd1, L_G_PWD1, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['pwd2'], $ppwd2, L_G_PWD2, CHECK_EMPTYALLOWED);
        if($_POST['pwd1'] != $_POST['pwd2'])
            QUnit_Messager::setErrorMessage(L_G_PWDDONTMATCH);
        
        checkCorrectness($_POST['rstatus'], $pstatus, L_G_STATUS, CHECK_EMPTYALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['userprofile'], $puserprofile, L_G_USER_PROFILE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_ALLOWED);
        checkCorrectness($_POST['surname'], $psurname, L_G_SURNAME, CHECK_ALLOWED);
        
        if(QUnit_Messager::getErrorMessage() != '') {
            return;
        }
        else
        {
            // save changes of admin to db
            $ppwd = $ppwd1;
            $sql = 'insert into wd_g_users '.
                   '(userid, username, rpassword, name, '.
                   'surname, dateinserted, rstatus, rtype, accountid, userprofileid)'.
                   ' values '.
                   '('._q($AdminID).','._q($pusername).','._q(MD5($ppwd)).','._q($pname).
                   ','._q($psurname).','.sqlNow().','._q($pstatus).','._q(USERTYPE_ADMIN).
                   ','._q($GLOBALS['Auth']->getAccountID()).','._q($puserprofile).')';
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            else
            {
                QUnit_Messager::setOkMessage(L_G_ADMIN_ADDED);

                $this->closeWindow('Affiliate_Merchants_Views_AdminsManager');
                $this->addContent('closewindow');

                return true;
            }
        }
    
        return false;
    } 

    //==========================================================================
    // OTHER FUNCTIONS
    //==========================================================================
  
    function checkAdminExists($username, $aid = '')
    {
        $sql = 'select * from wd_g_users '.
               'where username='._q($username);
//               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        if($aid != '') $sql .= ' and userid <> '._q($aid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
    
        if($rs->EOF)
            return false;
      
        return true;
    }
  
    //--------------------------------------------------------------------------

    function getUserProfilesAsArray()
    {
        $sql = 'select * from wd_g_userprofiles '.
               'where rtype='._q(USERTYPE_ADMIN).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID()).
               ' order by name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
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
}
?>
