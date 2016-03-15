<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');

class Affiliate_Merchants_Views_RecurringManager extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['delete'] = 'aff_trans_recurr_transactions_modify';
        $this->modulePermissions['suppress'] = 'aff_trans_recurr_transactions_approvedecline';
        $this->modulePermissions['approve'] = 'aff_trans_recurr_transactions_approvedecline';
        $this->modulePermissions['view'] = 'aff_trans_recurr_transactions_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'delete':
                    if($this->processDeleteRecurringComm())
                        return;
                    break;
              
                case 'suppress':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                    break;

                case 'approve':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                    break;
            }
        }
    
        $this->showRecurringTransactions();
    }

  //==========================================================================
  // PROCESSING FUNCTIONS
  //==========================================================================
  
  function processDeleteRecurringComm()
  {
    $reccomid = preg_replace('/[\'\"]/', '', $_REQUEST['rid']);
    $sql = 'update wd_pa_recurringcommissions set deleted=1 where recurringcommid='._q($reccomid);
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
          
    if(!$rs)
    {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      return false;
    }        
    
    return false;
  }

  //--------------------------------------------------------------------------

  function processChangeState($state)
  {
    $reccomid = preg_replace('/[\'\"]/', '', $_REQUEST['rid']);
    $sql = 'update wd_pa_recurringcommissions set rstatus='.myquotes($state).' where recurringcommid='._q($reccomid);
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
          
    if(!$rs)
    {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      return false;
    }        
    
    return false;
  }
  
  //==========================================================================
  // FORMS FUNCTIONS
  //==========================================================================
  
  function showRecurringTransactions()
  {
    $paffiliateid = preg_replace('/[\'\"]/', '', $_REQUEST['f_affiliateid']);
    $porderid = preg_replace('/[\'\"]/', '', $_REQUEST['f_orderid']);
    $pstatus = preg_replace('/[^0-9]/', '', $_REQUEST['f_status']);

    $a = array('t.recurringcommid', 'cc.campaignid', 'affiliateid', 't.orderid',
               'r.dateinserted', 'r.commission', 'r.commdate', 'r.datetype', 'r.rstatus');
    if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
      $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder']; 
    else
      $orderby = ' order by r.dateinserted desc';
      
    $where = 'where r.deleted=0 and r.originaltransid=t.transid'.
             '  and r.campcategoryid=cc.campcategoryid'.
             '  and t.accountid='._q($GLOBALS['Auth']->getAccountID());

    if($paffiliateid != '_' && $paffiliateid != '')
      $where .= ' and r.affiliateid='._q($paffiliateid);
    if($porderid != '')
      $where .= ' and t.orderid like \'%'._q_noendtags($porderid).'%\'';
    if($pstatus != '_' && $pstatus != '')
      $where .= ' and r.rstatus='._q($pstatus);

    //------------------------------------------------
    // get total number of records
    $sql = 'select count(r.recurringcommid) as count '.
           'from wd_pa_recurringcommissions r, wd_pa_transactions t, wd_pa_campaigncategories cc ';
    $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
    if(!$rs)
    {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      return;
    }

    $this->assign('a_numrows', $rs->fields['count']);

    $sql = 'select r.*, '.sqlDayOfMonth('r.dateinserted').' as dayofmonth, '.
           'MONTH(r.dateinserted) as month, '.sqlWeek('r.dateinserted').' as week, '.
           sqlDayOfWeek('r.dateinserted').' as dayofweek, YEAR(r.dateinserted) as year, '.
           't.orderid, cc.campaignid '.
           'from wd_pa_recurringcommissions r, wd_pa_transactions t, wd_pa_campaigncategories cc ';
    //------------------------------------------------
    // get records
    $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);

    if(!$rs)
    {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      return;
    }

    QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

    $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();
    $affiliates = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();

    $list_data = QUnit_Global::newobj('QCore_RecordSet');
    $list_data->setTemplateRS($affiliates);

    $this->assign('a_list_data', $list_data);

    $this->addContent('rc_filter');

    $list_data = QUnit_Global::newobj('QCore_RecordSet');
    $list_data->setTemplateRS($rs);

    $this->assign('a_list_data', $list_data);
    $this->assign('a_campaigns', $campaigns);
    $this->assign('a_affiliates', $affiliates);

    $temp_perm['approve'] = $this->checkPermissions('approve');
    $temp_perm['suppress'] = $this->checkPermissions('suppress');
    $temp_perm['delete'] = $this->checkPermissions('delete');

    $this->assign('a_action_permission', $temp_perm);

    $this->addContent('rc_list');
  }  
  
  //==========================================================================
  // OTHER FUNCTIONS
  //==========================================================================
}
?>
