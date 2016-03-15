<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Messager');

class Affiliate_Merchants_Bl_CampaignCategories
{
    function getCampCategoryIdForAffiliate($affiliateid, $campaignid)
    {
    	$sql = 'SELECT campcategoryid ' .
    			'FROM wd_pa_affiliatescampaigns as ac ' .
    			'LEFT JOIN wd_pa_campaigncategroeis as cc ' .
    			'USING(campcategoryid) ' .
    			'WHERE cc.affiliateid = ' ._q($campaignid) . ' ' .
    			'AND cc.campcategoryid = ' . _q($campaignid);
    	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {      
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        return $rs->fields['campcategoryid'];
    
    }
    
    function getDefaultCategoryID($campaignID)
    {
        // get option from campaign
        $sql = 'select campcategoryid from wd_pa_campaigncategories '.
               'where deleted=0 and campaignid='._q($campaignID).
               '  and name='._q(UNASSIGNED_USERS);
      
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {      
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        return $rs->fields['campcategoryid'];
    }
    
    //--------------------------------------------------------------------------
    
    function loadDefaultCommissionCategory($campaignID)
    {
        $CategoryID = Affiliate_Merchants_Bl_CampaignCategories::getDefaultCategoryID($campaignID);
        if($CategoryID == false)
            return false;

        $sql = 'select * from wd_pa_campaigncategories '.
               'where deleted=0 and campaignid='._q($campaignID).
               '  and campcategoryid='._q($CategoryID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $data = array();
        
        $data['catname'] = $rs->fields['name'];
        $data['cpmcommission'] = $rs->fields['cpmcommission'];
        $data['clickcommission'] = $rs->fields['clickcommission'];
        $data['salecommission'] = $rs->fields['salecommission'];
        $data['st2clickcommission'] = ($rs->fields['st2clickcommission'] == 0 ? '' : $rs->fields['st2clickcommission']);
        $data['st2salecommission'] = ($rs->fields['st2salecommission'] == 0 ? '' : $rs->fields['st2salecommission']);
        $data['st3clickcommission'] = ($rs->fields['st3clickcommission'] == 0 ? '' : $rs->fields['st3clickcommission']);
        $data['st3salecommission'] = ($rs->fields['st3salecommission'] == 0 ? '' : $rs->fields['st3salecommission']);
        $data['st4clickcommission'] = ($rs->fields['st4clickcommission'] == 0 ? '' : $rs->fields['st4clickcommission']);
        $data['st4salecommission'] = ($rs->fields['st4salecommission'] == 0 ? '' : $rs->fields['st4salecommission']);
        $data['st5clickcommission'] = ($rs->fields['st5clickcommission'] == 0 ? '' : $rs->fields['st5clickcommission']);
        $data['st5salecommission'] = ($rs->fields['st5salecommission'] == 0 ? '' : $rs->fields['st5salecommission']);
        $data['st6clickcommission'] = ($rs->fields['st6clickcommission'] == 0 ? '' : $rs->fields['st6clickcommission']);
        $data['st6salecommission'] = ($rs->fields['st6salecommission'] == 0 ? '' : $rs->fields['st6salecommission']);
        $data['st7clickcommission'] = ($rs->fields['st7clickcommission'] == 0 ? '' : $rs->fields['st7clickcommission']);
        $data['st7salecommission'] = ($rs->fields['st7salecommission'] == 0 ? '' : $rs->fields['st7salecommission']);
        $data['st8clickcommission'] = ($rs->fields['st8clickcommission'] == 0 ? '' : $rs->fields['st8clickcommission']);
        $data['st8salecommission'] = ($rs->fields['st8salecommission'] == 0 ? '' : $rs->fields['st8salecommission']);
        $data['st9clickcommission'] = ($rs->fields['st9clickcommission'] == 0 ? '' : $rs->fields['st9clickcommission']);
        $data['st9salecommission'] = ($rs->fields['st9salecommission'] == 0 ? '' : $rs->fields['st9salecommission']);
        $data['st10clickcommission'] = ($rs->fields['st10clickcommission'] == 0 ? '' : $rs->fields['st10clickcommission']);
        $data['st10salecommission'] = ($rs->fields['st10salecommission'] == 0 ? '' : $rs->fields['st10salecommission']);
        
        $data['salecommtype'] = $rs->fields['salecommtype'];
        $data['stsalecommtype'] = $rs->fields['stsalecommtype'];
        $data['recurringcommission'] = $rs->fields['recurringcommission'];
        $data['recurringcommtype'] = $rs->fields['recurringcommtype'];
        $data['recurringdate'] = $rs->fields['recurringcommdate'];
        $data['recurringdatetype'] = $rs->fields['recurringdatetype'];
        $data['strecurringcommtype'] = $rs->fields['strecurringcommtype'];
        $data['st2recurringcommission'] = ($rs->fields['st2recurringcommission'] == 0 ? '' : $rs->fields['st2recurringcommission']);
        $data['st3recurringcommission'] = ($rs->fields['st3recurringcommission'] == 0 ? '' : $rs->fields['st3recurringcommission']);
        $data['st4recurringcommission'] = ($rs->fields['st4recurringcommission'] == 0 ? '' : $rs->fields['st4recurringcommission']);
        $data['st5recurringcommission'] = ($rs->fields['st5recurringcommission'] == 0 ? '' : $rs->fields['st5recurringcommission']);
        $data['st6recurringcommission'] = ($rs->fields['st6recurringcommission'] == 0 ? '' : $rs->fields['st6recurringcommission']);
        $data['st7recurringcommission'] = ($rs->fields['st7recurringcommission'] == 0 ? '' : $rs->fields['st7recurringcommission']);
        $data['st8recurringcommission'] = ($rs->fields['st8recurringcommission'] == 0 ? '' : $rs->fields['st8recurringcommission']);
        $data['st9recurringcommission'] = ($rs->fields['st9recurringcommission'] == 0 ? '' : $rs->fields['st9recurringcommission']);
        $data['st10recurringcommission'] = ($rs->fields['st10recurringcommission'] == 0 ? '' : $rs->fields['st10recurringcommission']);
        
        if($data['recurringcommission'] != '' && $data['recurringcommission'] != '0')
            $data['recurring'] = 1;
        
        if($data['recurringdatetype'] == RECURRINGTYPE_DATEOFORDER)
            $data['recurringtype'] = RECURRINGTYPE_DATEOFORDER;
        else if($data['recurringdatetype'] == RECURRINGTYPE_ANNUALDATEOFORDER)
            $data['recurringtype'] = RECURRINGTYPE_ANNUALDATEOFORDER;
        else
            $data['recurringtype'] = 1;
        
        return $data;
    }
    
    //--------------------------------------------------------------------------
    
    function protectVars()
    {
        $maxCommissionLevels = $GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels');
        if($maxCommissionLevels == '')
        {
            $maxCommissionLevels = 1;
        }
        
        $params = array();
        
        $params['catname'] = preg_replace('/[\'\"]/', '', $_POST['catname']);
        $params['cpmcommission'] = preg_replace('/[^0-9\.]/', '', $_POST['cpmcommission']);
        $params['clickcommission'] = preg_replace('/[^0-9\.]/', '', $_POST['clickcommission']);
        $params['salecommission'] = preg_replace('/[^0-9\.]/', '', $_POST['salecommission']);
        $params['salecommtype'] = preg_replace('/[^\$\%]/', '', $_POST['salecommtype']);
        $params['stsalecommtype'] = preg_replace('/[^\$\%]/', '', $_POST['stsalecommtype']);
        $params['commtype'] = preg_replace('/[^0-9\.]/', '', $_POST['commtype']);
        
        $params['recurring'] = preg_replace('/[^0-9]/', '', $_POST['recurring']);
        $params['recurringcommission'] = preg_replace('/[^0-9\.]/', '', $_POST['recurringcommission']);
        $params['recurringcommtype'] = preg_replace('/[^\$\%]/', '', $_POST['recurringcommtype']);
        $params['recurringdatetype'] = preg_replace('/[^0-9\.]/', '', $_POST['recurringdatetype']);
        $params['strecurringcommtype'] = preg_replace('/[^\$\%]/', '', $_POST['strecurringcommtype']);
        
        // add all multi tier commissions
        for($i=2; $i<=$maxCommissionLevels; $i++)
        {
            // clicks
            $params['st'.$i.'clickcommission'] = preg_replace('/[^0-9\.]/', '', $_POST['st'.$i.'clickcommission']);
            
            // sales
            $params['st'.$i.'salecommission'] = preg_replace('/[^0-9\.]/', '', $_POST['st'.$i.'salecommission']);
            
            // recurring
            $stcommission = preg_replace('/[^0-9\.]/', '', $_POST['st'.$i.'recurringcommission']);
            if($params['recurring'] == 1)
            {
                $params['st'.$i.'recurringcommission'] = preg_replace('/[^0-9\.]/', '', $_POST['st'.$i.'recurringcommission']);
            }
            else
            {
                $params['st'.$i.'recurringcommission'] = 0;
            }
        }
        
        $params['CategoryID'] = preg_replace('/[\'\"]/', '', $_POST['catid']);
        $params['CampaignID'] = preg_replace('/[\'\"]/', '', $_POST['cid']);
        
        return $params;
    }
    
    //--------------------------------------------------------------------------
    
    function updateCategory($params)
    {
        $maxCommissionLevels = $GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels');
        if($maxCommissionLevels == '')
        {
            $maxCommissionLevels = 1;
        }
        
        if($params['recurring'] != 1)
            $params['recurringcommission'] = 0;
            
        // save changes to db
        $sql = "update wd_pa_campaigncategories set ".
               "cpmcommission="._q($params['cpmcommission']).",". 
               "clickcommission="._q($params['clickcommission']).",". 
               "salecommission="._q($params['salecommission']).", ".
               "salecommtype="._q($params['salecommtype']).", ".
               "stsalecommtype="._q($params['stsalecommtype']).", ".  
               "recurringcommission="._q($params['recurringcommission']).", ".  
               "recurringcommtype="._q($params['recurringcommtype']).", ".  
               "recurringdatetype="._q($params['recurringdatetype']).", ".  
               "strecurringcommtype="._q($params['strecurringcommtype']).", ";  
        
        // add all multi tier commissions
        for($i=2; $i<=$maxCommissionLevels; $i++)
        {
            $sql .= 'st'.$i.'clickcommission='._q($params['st'.$i.'clickcommission']).',';
            $sql .= 'st'.$i.'salecommission='._q($params['st'.$i.'salecommission']).',';
            $sql .= 'st'.$i.'recurringcommission='._q($params['st'.$i.'recurringcommission']).',';
        }
        
        $sql .= " name="._q($params['catname']);
        $sql .= " where campcategoryid="._q($params['CategoryID']);
        
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    
        
        return true;
    }

    //--------------------------------------------------------------------------
    
    function getCategoriesAsArray($AffiliateID, &$campaignCategories, &$affiliateCategories)
    {
        $sql = 'select cc.campaignid, cc.campcategoryid, cc.name, cc.cpmcommission, '.
               'cc.clickcommission, cc.st2clickcommission, cc.salecommission, cc.st2salecommission, cc.salecommtype, '.
               'cc.stsalecommtype, cc.recurringdatetype, cc.recurringcommission, cc.recurringcommtype, c.commtype '.
               ' from wd_pa_campaigncategories cc, wd_pa_campaigns c where c.deleted=0 and c.campaignid=cc.campaignid '.
               ' and cc.deleted=0 and c.accountid='._q($GLOBALS['Auth']->getAccountID()).
               ' group by cc.campaignid, cc.campcategoryid, cc.name, cc.cpmcommission, '.
               'cc.clickcommission, cc.st2clickcommission, cc.salecommission, cc.st2salecommission, cc.salecommtype, '.
               'cc.stsalecommtype, cc.recurringdatetype, cc.recurringcommission, cc.recurringcommtype, c.commtype'.
               ' order by cc.campaignid, cc.campcategoryid';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $campaignCategories = array();
        $affiliateCategories = array();    
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['commtype'] = $rs->fields['commtype'];
            $temp['campcategoryid'] = $rs->fields['campcategoryid'];
            $temp['name'] = $rs->fields['name'];
            $temp['cpmcommission'] = $rs->fields['cpmcommission'];
            $temp['clickcommission'] = $rs->fields['clickcommission'];
            $temp['st2clickcommission'] = $rs->fields['st2clickcommission'];
            $temp['salecommission'] = $rs->fields['salecommission'];
            $temp['stsalecommission'] = $rs->fields['stsalecommission'];
            $temp['salecommtype'] = $rs->fields['salecommtype'];
            $temp['stsalecommtype'] = $rs->fields['stsalecommtype'];
            $temp['recurringcommission'] = $rs->fields['recurringcommission'];
            $temp['recurringcommtype'] = $rs->fields['recurringcommtype'];
            $temp['recurringdatetype'] = $rs->fields['recurringdatetype'];
            
            if(!isset($campaignCategories[$temp['campaignid']]))
            {
                $campaignCategories[$temp['campaignid']] = array();
                
                $affiliateCategories[$temp['campaignid']] = $temp['campcategoryid'];
            }
            
            $campaignCategories[$temp['campaignid']][] = $temp;
            
            $rs->MoveNext();
        }
        
        $sql = 'select cc.campaignid, cc.campcategoryid '.
               'from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campcategoryid=ac.campcategoryid'.
               '  and ac.affiliateid='._q($AffiliateID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        while(!$rs->EOF)
        {
            $affiliateCategories[$rs->fields['campaignid']] = $rs->fields['campcategoryid'];
//            $affiliateCategories[$rs->fields['campaignid']][$rs->fields['campcategoryid']] = $rs->fields['rstatus'];
            
            $rs->MoveNext();
        }
    }
    
    //--------------------------------------------------------------------------
    
    function getFirstCampaignsCategory($params)
    {

        if($params['campaignIDs'] == '') return false;

        if(!is_array($params['campaignIDs'])) $params['campaignIDs'] = array($params['campaignIDs']);
    
        $campaignIDsql = "('".implode("','", $params['campaignIDs'])."')";
    
        $sql = 'select campcategoryid, campaignid from wd_pa_campaigncategories '.
               'where campaignid in '.$campaignIDsql.
               '  and name='._q(UNASSIGNED_USERS);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) return false;

        $camp_data = array();

        while(!$rs->EOF)
        {
            $camp_data[$rs->fields['campaignid']]['campaignid'] = $rs->fields['campaignid'];
            $camp_data[$rs->fields['campaignid']]['campcategoryid'] = $rs->fields['campcategoryid'];
        
            $rs->MoveNext();
        }
        
        return $camp_data;
    }
    
    //--------------------------------------------------------------------------
    
    function getUserSpecialCategoriesShortAsArray($params)
    {
        if(!is_array($params['users']) || count($params['users']) < 1 ) return false;

        $affiliateIDSql = "('".implode("','", $params['users'])."')";
    
        $sql = 'select campcategoryid, affiliateid '.
               'from wd_pa_affiliatescampaigns '.
               'where rstatus='._q(AFFSTATUS_APPROVED);
               '  and affiliateid in '.$affiliateIDSql;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) return array();

        $spec_categories = array();

        while(!$rs->EOF)
        {
            $spec_categories[$rs->fields['affiliateid']][] = $rs->fields['campcategoryid'];

            $rs->MoveNext();
        }

        return $spec_categories;
    }
    
    //--------------------------------------------------------------------------

    function getPrivateCategoriesShortAsArray($params)
    {
        $sql = 'select c.campaignid, c.name from wd_g_settings s, wd_pa_campaigns c '.
               'where s.code='._q(SETTINGTYPEPREFIX_AFF_CAMP.'status').
               '  and s.value='._q(AFF_CAMP_PRIVATE).
               '  and s.id1=c.campaignid '.
               '  and c.accountid='._q($params['AccountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) return false;

        $private_camp_cat = array();
        
        while(!$rs->EOF)
        {
            $private_camp_cat[$rs->fields['campaignid']]['campaignid'] = $rs->fields['campaignid'];
            $private_camp_cat[$rs->fields['campaignid']]['name'] = $rs->fields['name'];
        
            $rs->MoveNext();
        }

        return $private_camp_cat;
    }
    
    //--------------------------------------------------------------------------
    
    function insertAffiliateSpecialCategory($params, $rule, $userid)
    {
        if($rule['campaignid'] == '' || $userid == '') return false;

        $AffCampID = QCore_Sql_DBUnit::createUniqueID('wd_pa_affiliatescampaigns', 'affcampid');

        $status = AFFSTATUS_APPROVED;

        $sql = 'insert into wd_pa_affiliatescampaigns '.
               '(affcampid, campcategoryid, affiliateid, campaignid, rstatus)'.
               ' values '.
               '('._q($AffCampID).','._q($rule['cond_action_value']).
               ','._q($userid).','._q($rule['campaignid']).
               ','._q($status).')';
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }    
}

?>
