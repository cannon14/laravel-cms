<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactions');
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Merchants_Views_ApprovalManager extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
    }

    //--------------------------------------------------------------------------

  function process()
  {
    if(!empty($_POST['commited']))
    {
      switch($_POST['postaction'])
      {
        case 'approveurls':
              if($this->processApproveURLs(AFFSTATUS_APPROVED))
                return;
              break;

        case 'denyurls':
              if($this->processApproveURLs(AFFSTATUS_SUPPRESSED))
                return;
              break;
              
        case 'approvecamps':
              if($this->processApproveCampaigns(AFFSTATUS_APPROVED))
                return;
              break;

        case 'denycamps':
              if($this->processApproveCampaigns(AFFSTATUS_SUPPRESSED))
                return;
              break;
      }
    }
    
    if($_REQUEST['type'] == 'urls')
      $this->showURLs();
    else if($_REQUEST['type'] == 'camps')
      $this->showCampaigns();
  }  
  

  //==========================================================================
  // PROCESSING FUNCTIONS
  //==========================================================================
  
  function processApproveURLs($state)
  {
    foreach($_POST as $k=>$v)
    {
      if(strpos($k, "urlid_") !== false)
      {
        $urlid = substr($k, 6);
        
        $urlid = preg_replace('/[\'\"]/', '', $urlid);
        $sql = 'update wd_g_affiliateurls set rstatus='._q($state).' where affiliateurlid='._q($urlid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
              
        if (!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        } 
      }
    }
         
    return false;
  }

  //--------------------------------------------------------------------------

  function processApproveCampaigns($state)
  {
    foreach($_POST as $k=>$v)
    {
      if(strpos($k, "campid_") !== false)
      {
        $cid = substr($k, 7);
        
        $cid = preg_replace('/[\'\"]/', '', $cid);
        $sql = 'update wd_pa_affiliatescampaigns set rstatus='._q($state).' where affiliatecampaignid='._q($cid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
              
        if (!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        } 
      }
    }
         
    return false;
  }

    //--------------------------------------------------------------------------

    function processApproveTransactions($state)
    {
        foreach($_POST as $k=>$v)
        {
            if(strpos($k, "transid_") !== false)
            {
                $transid = substr($k, 8);
        
                $transid = preg_replace('/[\'\"]/', '', $transid);
                $sql = 'update wd_pa_transactions set rstatus='._q($state).
                       ' where transid='._q($transid).
                       '   and accountid='._q($GLOBALS['Auth']->getAccountID());
                $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
              
                if(!$rs) {
                    QUnit_Messager::setErrorMessage(L_G_DBERROR);
                    return false;
                }
        
                if($state == AFFSTATUS_APPROVED)
                {
                    $trans_user = Affiliate_Merchants_Bl_Transactions::getUserFromTransaction(array($transid));
                
                    $params = array('users' => $trans_user,
                                    'AccountID' => $GLOBALS['Auth']->getAccountID(),
                                    'decimal_places' => $GLOBALS['Auth']->getSetting('Aff_round_numbers')
                                   );
        
                    if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params)) !== false)
                        Affiliate_Merchants_Bl_Rules::checkPerformanceRules($params, $rules);
                }
            }
        }
         
        return false;
    }

  //==========================================================================
  // FORMS FUNCTIONS
  //==========================================================================

  function showURLs()
  {
    $where = 'where a.userid=u.affiliateid and u.deleted=0 '.
             '  and u.rstatus='.AFFSTATUS_NOTAPPROVED.' and a.deleted=0'.
             '  and a.accountid='._q($GLOBALS['Auth']->getAccountID());
    $sql = 'select * from wd_g_affiliateurls u, wd_g_users a '.$where;
    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
         
    if (!$rs)
    {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      return;
    }

    $this->assign('a_numrows', $rs->PO_RecordCount('wd_g_affiliateurls u, wd_g_users a', $where));

    $list_data = QUnit_Global::newobj('QCore_RecordSet');
    $list_data->setTemplateRS($rs);

    $this->assign('a_list_data', $list_data);

    $this->addContent('urls_show');
  }

  //--------------------------------------------------------------------------

  function showCampaigns()
  {
    $where = 'where ac.campaignid=c.campaignid and a.userid=ac.affiliateid'.
             '  and ac.deleted=0 and c.deleted=0 and ac.rstatus='.AFFSTATUS_NOTAPPROVED.
             ' and a.deleted=0 and ac.accountid='._q($GLOBALS['Auth']->getAccountID());
    $sql = 'select * from wd_pa_campaigns c, wd_pa_affiliatescampaigns ac, wd_g_users a ';
    $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
         
    if(!$rs)
    {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      return;
    }

    $this->assign('a_numrows', $rs->PO_RecordCount('wd_pa_campaigns c, wd_pa_affiliatescampaigns ac, wd_g_users a ', $where));

    $list_data = QUnit_Global::newobj('QCore_RecordSet');
    $list_data->setTemplateRS($rs);

    $this->assign('a_list_data', $list_data);

    $this->addContent('camp_show');
  }  
  
  //==========================================================================
  // OTHER FUNCTIONS
  //==========================================================================
  
}
?>
