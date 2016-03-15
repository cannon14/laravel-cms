<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_History extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['purge'] = 'aff_tool_history_purge';
        $this->modulePermissions['view'] = 'aff_tool_history_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'purge':
                    if($this->purgeHistory())
                        return;
                break;
                case 'purgeSystemNotify':
                    if($this->purgeSystemNotify())
                        return;
                break;           
            }
        }

        $this->showHistory();
    }
    
    //------------------------------------------------------------------------

    function purgeHistory()
    {
        $sql = 'delete from wd_g_history '.
               'where accountid='._q($GLOBALS['Auth']->getAccountID()) . " AND rtype != '100'";;
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }

        return false;
    }
    
    function purgeSystemNotify()
    {
        $sql = 'delete from wd_g_history '.
               'where accountid='._q($GLOBALS['Auth']->getAccountID()) . " AND rtype = '100'";
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }

        return false;
    }
    
    
    
    //------------------------------------------------------------------------
    
    function showHistory()
    {
        // sorting
        $orderby = '';
        $a = array("historyid", "dateinserted", "rtype", "value", "ip", "file", "line");
        
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder']; 
        else
            $orderby = " order by dateinserted desc"; 
        
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'h_') === 0 && !isset($_REQUEST[$k]))
            $_REQUEST[$k] = $v;
        }

        $_REQUEST['h_note'] = preg_replace('/[\'\"]/', '', $_REQUEST['h_note']);
        $_REQUEST['h_historytype'] = preg_replace('/[\'\"]/', '', $_REQUEST['h_historytype']);

        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['h_historytype'] == '') $_REQUEST['h_historytype'] = '_';
        if($_REQUEST['h_day1'] == '') $_REQUEST['h_day1'] = date("j");
        if($_REQUEST['h_month1'] == '') $_REQUEST['h_month1'] = date("n");
        if($_REQUEST['h_year1'] == '') $_REQUEST['h_year1'] = date("Y");
        if($_REQUEST['h_day2'] == '') $_REQUEST['h_day2'] = date("j");
        if($_REQUEST['h_month2'] == '') $_REQUEST['h_month2'] = date("n");
        if($_REQUEST['h_year2'] == '') $_REQUEST['h_year2'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['h_note'] = $_REQUEST['h_note'];
        $_SESSION['h_historytype'] = $_REQUEST['h_historytype'];
        $_SESSION['h_day1'] = $_REQUEST['h_day1'];
        $_SESSION['h_month1'] = $_REQUEST['h_month1'];
        $_SESSION['h_year1'] = $_REQUEST['h_year1'];
        $_SESSION['h_day2'] = $_REQUEST['h_day2'];
        $_SESSION['h_month2'] = $_REQUEST['h_month2'];
        $_SESSION['h_year2'] = $_REQUEST['h_year2'];

        $this->assign('a_curyear', date("Y"));

        $this->addContent('hist_filter');

        //------------------------------------------------
        // build where statement
        $where = ' where 1=1';
        if($_REQUEST['h_note'] != '')
            $where .= ' and value like \'%'._q_noendtags($_REQUEST['h_note']).'%\'';
        if($_REQUEST['h_historytype'] != '' && $_REQUEST['h_historytype'] != '_')
            $where .= ' and rtype='._q($_REQUEST['h_historytype']);
        $where .= ' and ('.sqlToDays('dateinserted').' >= '.sqlToDays($_REQUEST['h_year1'].'-'.$_REQUEST['h_month1'].'-'.$_REQUEST['h_day1']).')'.
                  ' and ('.sqlToDays('dateinserted').' <= '.sqlToDays($_REQUEST['h_year2'].'-'.$_REQUEST['h_month2'].'-'.$_REQUEST['h_day2']).')'.
                  ' and accountid='._q($GLOBALS['Auth']->getAccountID());

        //------------------------------------------------
        // get total number of records
        $sql = 'select count(historyid) as count from wd_g_history';
        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql.$where, __FILE__, __LINE__);
            return;
        }

        $limitOffset = initPaging($rs->fields['count']);

        //------------------------------------------------
        // get records
        $sql = 'select * from wd_g_history';

		//echo $sql.$where.$orderby;
        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql.$where.$orderby, __FILE__, __LINE__);
            return;
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);
        
        $this->assign('a_list_data', $list_data);
        $this->pageLimitsAssign();

        $temp_perm['purge'] = $this->checkPermissions('purge');

        $this->assign('a_action_permission', $temp_perm);


        $this->addContent('hist_list');
    }
}
?>
