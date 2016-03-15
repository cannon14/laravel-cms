<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Bl_Users');
QUnit_Global::includeClass('QCore_Bl_Userprofiles');
QUnit_Global::includeClass('QCore_Bl_RightTypes');
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_UserProfiles extends QUnit_UI_TemplatePage
{
    var $fromPage = '';

    //--------------------------------------------------------------------------

    function initPermissions()
    {
        $this->modulePermissions['insert'] = 'aff_tool_user_profiles_modify';
        $this->modulePermissions['update'] = 'aff_tool_user_profiles_modify';
        $this->modulePermissions['add_new'] = 'aff_tool_user_profiles_modify';
        $this->modulePermissions['edit'] = 'aff_tool_user_profiles_modify';
        $this->modulePermissions['delete'] = 'aff_tool_user_profiles_modify';
        $this->modulePermissions['view'] = 'aff_tool_user_profiles_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['postaction']))
        {
            switch($_POST['postaction'])
            {              
                case 'insert':
                    if($this->processInsertUserProfile())
                        return;
                break;

                case 'update':
                    if($this->processUpdateUserProfile())
                        return;
                break;
            }
        }
    
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'add_new':
                    if($this->drawFormAddUserProfile())
                        return;
                break;

                case 'edit':
                    if($this->drawFormEditUserProfile())
                        return;
                break;

                case 'delete':
                    if($this->processDeleteUserProfile())
                        return;
                break;
            }
        }

        return $this->showUserProfiles();
    }

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================

    function showUserProfiles()
    {
        $orderby = '';

        $a = array('up.userprofileid', 'up.name', 'up.rtype');

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = "order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder']; 
        else
            $orderby = "order by up.name"; 

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'filter_') === 0 && !isset($_REQUEST[$k]))
                $_REQUEST[$k] = $v;
            if($k == 'up_numrows' && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;                
        }
       
        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['up_numrows'])) $_REQUEST['up_numrows'] = 10;
        if($_REQUEST['filter_name'] == '') $_REQUEST['filter_name'] = '';

        //--------------------------------------
        // put settings into session
        $_SESSION['up_numrows'] = $_REQUEST['up_numrows'];
        $_SESSION['filter_name'] = $_REQUEST['filter_name'];

        $_REQUEST['numrows'] = $_REQUEST['up_numrows'];

        $where = ' where 1=1 and up.accountid='._q($GLOBALS['Auth']->getAccountID());

        $filter_name = preg_replace('/[\'\"]/', '', $_REQUEST['filter_name']);

        if($filter_name != '')
            $where .= ' and (up.name like "%'._q_noendtags($filter_name).'%")';

        //------------------------------------------------
        // get total number of records
        $sql = 'select count(userprofileid) as count from wd_g_userprofiles up';
        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return;
        }

        $limitOffset = initPaging($rs->fields['count']);

        //------------------------------------------------
        // get user profile records
        $sql = 'select up.* from wd_g_userprofiles up';
        $sql .= $where.' '.$orderby;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return;
        }

        $upData = array();
    
        while(!$rs->EOF)
        {
            $upData[$rs->fields['userprofileid']]['userprofileid'] = $rs->fields['userprofileid'];
            $upData[$rs->fields['userprofileid']]['name'] = $rs->fields['name'];
            $upData[$rs->fields['userprofileid']]['rtype'] = $rs->fields['rtype'];
            $upData[$rs->fields['userprofileid']]['accountid'] = $rs->fields['accountid'];

            $rs->moveNext();
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($upData);
    
        $this->assign('a_list_data', $list_data);

        $this->pageLimitsAssign();

        $temp_perm['add_new'] = $this->checkPermissions('add_new');
        $temp_perm['edit'] = $this->checkPermissions('edit');
        $temp_perm['delete'] = $this->checkPermissions('delete');

        $this->assign('a_action_permission', $temp_perm);

        $this->addContent('user_profiles_filter');
        $this->addContent('user_profiles_show');
    }

    //--------------------------------------------------------------------------

    function drawFormEditUserProfile()
    {
        if($_POST['commited'] != 'yes')
        {
            QCore_Bl_Userprofiles::loadUserProfileInfo();
        }
   
        $_POST['header'] = L_G_EDIT_USER_PROFILE;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'update';

        $this->drawFormAddUserProfile();

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormAddUserProfile()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add_new';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'insert';

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADD_USER_PROFILE;

        if(!is_array($_POST['userrighttype']))
            $_POST['userrighttype'] = array();

//        $list_data = QUnit_Global::newobj('QCore_RecordSet');
//        $list_data->setTemplateRS(QCore_Bl_RightTypes::getRightTypesAsArray());
//        $this->assign('a_list_data', $list_data);
  
        $rts = QCore_Bl_RightTypes::getRightTypesAsArray();
        $this->assign('a_rts', $rts);

        $this->addContent('user_profiles_edit');

        return true;
    }

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processDeleteUserProfile()
    {
        if(AFF_DEMO == 1 && $_REQUEST['upid'] == 'userpro1') {
            return false;
        }
        
        QCore_Bl_Userprofiles::processDeleteUserProfile();

        return false;
    }

    //--------------------------------------------------------------------------

    function processUpdateUserProfile()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $UserProfileID = preg_replace('/[\'\"]/', '', $_POST['upid']);

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);
        if($_POST['name'] != '' && QCore_Bl_Userprofiles::checkUserProfileExists($UserProfileID,$_POST['name'],false))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTS);

        if(QUnit_Messager::getErrorMessage() != '') {
            QCore_History::DebugMsg(WLOG_ACTIONS, $errorMsg, __FILE__, __LINE__);
            return false;
        }
        else
        {
            // save changes of userprofile to db
            $sql = 'update wd_g_userprofiles '.
                   'set name='._q($pname).
                   ' where userprofileid='._q($UserProfileID).
                   '   and accountid='._q($GLOBALS['Auth']->getAccountID()).
                   '   and rtype='._q(USERTYPE_ADMIN);
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
                return false;
            }
            
            QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);

            if(AFF_DEMO != 1 || $_REQUEST['upid'] == 'userpro1') {
                if(!QCore_Bl_RightTypes::insertUserRight($UserProfileID)) return false;
            }

            QUnit_Messager::setOkMessage(L_G_USER_PROFILE_EDITED);

            $this->closeWindow('Affiliate_Merchants_Views_UserProfiles');
            $this->addContent('closewindow', 'main_popup');

            return true;
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function processInsertUserProfile()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $UserProfileID = QCore_Sql_DBUnit::createUniqueID('wd_g_userprofiles', 'userprofileid');

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);
        if($_POST['name'] != '' && QCore_Bl_Userprofiles::checkUserProfileExists('',$_POST['name']))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTS);

        if(QUnit_Messager::getErrorMessage() != '') {
            QCore_History::DebugMsg(WLOG_ERROR, $errorMsg, __FILE__, __LINE__);
            return false;
        }
        else
        {
            // save changes of userprofile to db
            $sql = 'insert into wd_g_userprofiles '.
                   '(userprofileid, name, rtype, accountid) '.
                   'values '.
                   '('._q($UserProfileID).','._q($pname).','._q(USERTYPE_ADMIN).
                   ','._q($GLOBALS['Auth']->getAccountID()).')';
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            if(!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
                return false;
            }
            
            QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
            
            if(!QCore_Bl_RightTypes::insertUserRight($UserProfileID)) return false;

            QUnit_Messager::setOkMessage(L_G_USER_PROFILE_ADDED);

            $this->closeWindow('Affiliate_Merchants_Views_UserProfiles');
            $this->addContent('closewindow', 'main_popup');

            return true;
        }

        return false;
    }

    //--------------------------------------------------------------------------
}
?>
