<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Affiliates_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');
QUnit_Global::includeClass('Affiliate_Affiliates_Bl_Settings');
QUnit_Global::includeClass('Affiliate_Affiliates_Views_AffBannerManager');
QUnit_Global::includeClass('Affiliate_Affiliates_Views_AffCampaignManager');

class Affiliate_Affiliates_Views_AffCampaignManager extends Affiliate_Merchants_Views_CampaignManager
{
    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'join_camp':
                    if($this->processJoinToCampaign())
                        return;
                    break;

                case 'show_decline_reason':
                    if($this->drawDeclineReason())
                        return;
                    break;

                case 'details':
                    if($this->drawFormDetails())
                        return;
                    break;
            }
        }
    
        $this->showCampaigns();
    }
  
    //------------------------------------------------------------------------

    function processJoinToCampaign()
    {
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['campaign']);

        $params = array('userID' => $GLOBALS['Auth']->getUserID(),
                        'CampaignID' => $CampaignID
                       );

        $ret = Affiliate_Affiliates_Bl_Affiliate::insertAffCamp($params);

        if($ret == false) return false;

        QUnit_Messager::setOkMessage(L_G_JOINCAMPAIGNREQUESTSENT);

        $this->redirect('Affiliate_Affiliates_Views_AffCampaignManager');

        return true;
    }

    //------------------------------------------------------------------------

    function drawDeclineReason()
    {
        $_POST['header'] = L_G_CAMPAIGN_DECLINE_REASON;
    
        $params = array('userID' => $GLOBALS['Auth']->getUserID(),
                        'campaign' => $_REQUEST['campaign']
                       );

        $data = Affiliate_Affiliates_Bl_Affiliate::getDeclineReason($params);

        if($data == false) return false;

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS(array($data));
        $this->assign('a_list_data', $list_data);

        $this->addContent('decline_reason_view');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormDetails()
    {
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['campaign']);

        $_POST['header'] = L_G_CAMPAIGN_DETAILS;

        // get aff campaigns status
        $params = array('userID' => $GLOBALS['Auth']->getUserID());

        $affcamps = Affiliate_Affiliates_Bl_Affiliate::getAffiliateCampaignsStatus($params);

        if($affcamps == false) return false;

        // get campaign data
        $sql = 'select * from wd_pa_campaigns '.
               'where deleted=0 ';
        if($CampaignID != '') $sql .= '  and campaignid='._q($CampaignID);
        $sql .= '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return true;
        }

        // colect other campaign data
        $params = array('accountid' => $GLOBALS['Auth']->getAccountID());
    
        $affs_camp = Affiliate_Affiliates_Bl_Settings::getAffCampaignSettings($params);
        $bannercount = Affiliate_Affiliates_Views_AffBannerManager::getCountBannersAsArray();
        $campaignCommissions = $this->getCommissionsAsArray($GLOBALS['Auth']->userID);

        $params = array('userID' => $GLOBALS['Auth']->getUserID(),
                        'campaign' => $CampaignID
                       );

        $declinereason = Affiliate_Affiliates_Bl_Affiliate::getDeclineReason($params);

        // now we have all data
        $data['campaignid'] = $rs->fields['campaignid'];
        $data['name'] = $rs->fields['name'];
        $data['shortdescription'] = $rs->fields['shortdescription'];
        $data['description'] = nl2br($rs->fields['description']);
        $data['commtype'] = $rs->fields['commtype'];

        $data['banner_url'] = $affs_camp[$rs->fields['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'banner_url'];
        $data['rstatus'] = $affcamps[$rs->fields['campaignid']];

        $data['cpmcommission'] = $campaignCommissions[$rs->fields['campaignid']]['cpmcommission'];
        $data['clickcommission'] = $campaignCommissions[$rs->fields['campaignid']]['clickcommission'];
        $data['salecommission'] = $campaignCommissions[$rs->fields['campaignid']]['salecommission'];
        $data['salecommtype'] = $campaignCommissions[$rs->fields['campaignid']]['salecommtype'];
        $data['recurringcommission'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommission'];
        $data['recurringcommtype'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommtype'];

        $data['bannercount'] = ($bannercount[$rs->fields['campaignid']] != '' ? $bannercount[$rs->fields['campaignid']] : '0');

        $data['declinereason'] = $declinereason['declinereason'];

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS(array($data));
        $this->assign('a_list_data', $list_data);

        $this->addContent('cm_details');

        return true;
    }

    //--------------------------------------------------------------------------
  
    function showCampaigns()
    {
        // get aff campaigns status
        $params = array('userID' => $GLOBALS['Auth']->getUserID());

        $affcamps = Affiliate_Affiliates_Bl_Affiliate::getAffiliateCampaignsStatus($params);

        if(is_bool($affcamps) && $affcamps == false) return false;

        $orderby = '';
    
        $a = array('name', 'description', 'commtype');
    
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = ' order by dateinserted desc';
        }
    
        if(!isset($_REQUEST['filtered']) && $_SESSION[SESSION_PREFIX.'cmwhere'] != '')
        {
            $where = $_SESSION[SESSION_PREFIX.'cmwhere'];
        }
        else
        {
            $where = ' where deleted=0'.
                     '  and accountid='._q($GLOBALS['Auth']->getAccountID());
    
            if($_REQUEST['filtered'] == 1)
            {
                $_REQUEST['f_cname'] = preg_replace('/[\'\"]/', '', $_REQUEST['f_cname']);
//                $_REQUEST['f_weburl'] = preg_replace('/[^0-9]/', '', $_REQUEST['f_weburl']);
                $_REQUEST['f_ctype'] = preg_replace('/[^0-9]/', '', $_REQUEST['f_ctype']);
      
                if($_REQUEST['f_cname'] != '')
                    $where .= ' and (name like \'%'._q_noendtags($_REQUEST['f_cname']).'%\')';
//                if($_REQUEST['f_weburl'] != '')
//                      $where .= ' and (weburl like \'%'._q_noendtags($_REQUEST['f_weburl']).'%\')';
                if($_REQUEST['f_ctype'] != '')
                    $where .= ' and (commtype ='._q($_REQUEST['f_ctype']).')';
            }

            $_SESSION[SESSION_PREFIX.'cmwhere'] = $where;
        }
  
        $sql = 'select * from wd_pa_campaigns '.$where.' '.$orderby;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $data = array();
    
        $params = array('accountid' => $GLOBALS['Auth']->getAccountID());
    
        $affs_camp = Affiliate_Affiliates_Bl_Settings::getAffCampaignSettings($params);
        $bannercount = Affiliate_Affiliates_Views_AffBannerManager::getCountBannersAsArray();
        $campaignCommissions = $this->getCommissionsAsArray($GLOBALS['Auth']->userID);

        while(!$rs->EOF)
        {
            if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1'
               && $affs_camp[$rs->fields['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'status'] == AFF_CAMP_PRIVATE
               && $affcamps[$rs->fields['campaignid']] == '')
            {
                $rs->MoveNext();
                continue;
            }

            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['name'] = $rs->fields['name'];
            $temp['shortdescription'] = $rs->fields['shortdescription'];
            $temp['commtype'] = $rs->fields['commtype'];

            $temp['banner_url'] = $affs_camp[$rs->fields['campaignid']][SETTINGTYPEPREFIX_AFF_CAMP.'banner_url'];

            $temp['rstatus'] = $affcamps[$rs->fields['campaignid']];

            $temp['cpmcommission'] = $campaignCommissions[$rs->fields['campaignid']]['cpmcommission'];
            $temp['clickcommission'] = $campaignCommissions[$rs->fields['campaignid']]['clickcommission'];
            $temp['salecommission'] = $campaignCommissions[$rs->fields['campaignid']]['salecommission'];
            $temp['salecommtype'] = $campaignCommissions[$rs->fields['campaignid']]['salecommtype'];
            $temp['recurringcommission'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommission'];
            $temp['recurringcommtype'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommtype'];

            $temp['bannercount'] = ($bannercount[$rs->fields['campaignid']] != '' ? $bannercount[$rs->fields['campaignid']] : '0');
            $data[] = $temp;
        
            $rs->MoveNext();
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($data);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_numrows', count($data));

        $this->addContent('cm_list');
    }

    //------------------------------------------------------------------------
    
    function getCommissionsAsArray($AffiliateID)
    {
        $sql = 'select cc.* from wd_pa_campaigncategories cc, wd_pa_campaigns c '.
               'where c.deleted=0 and cc.deleted=0'.
               '  and c.campaignid=cc.campaignid and c.accountid='._q($GLOBALS['Auth']->getAccountID()).
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
            $temp['campcategoryid'] = $rs->fields['campcategoryid'];
            $temp['name'] = $rs->fields['name'];
            $temp['cpmcommission'] = $rs->fields['cpmcommission'];
            $temp['clickcommission'] = $rs->fields['clickcommission'];
            $temp['stclickcommission'] = $rs->fields['stclickcommission'];
            $temp['salecommission'] = $rs->fields['salecommission'];
            $temp['stsalecommission'] = $rs->fields['stsalecommission'];
            $temp['salecommtype'] = $rs->fields['salecommtype'];
            $temp['stsalecommtype'] = $rs->fields['stsalecommtype'];
            $temp['recurringcommission'] = $rs->fields['recurringcommission'];       
            $temp['recurringcommtype'] = $rs->fields['recurringcommtype'];       
            
            if(!isset($campaignCategories[$temp['campaignid']]))
            {
                $campaignCategories[$temp['campaignid']] = array();
                
                $affiliateCategories[$temp['campaignid']] = $temp['campcategoryid'];
            }
            
            $campaignCategories[$temp['campaignid']][$temp['campcategoryid']] = $temp;
            
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
            
            $rs->MoveNext();
        }

        // now get commissions for every campaign
        $campaignCommissions = array();
        foreach($affiliateCategories as $CampaignID => $CampCategoryID)
        {
            $temp = array();
            $temp['cpmcommission'] = $campaignCategories[$CampaignID][$CampCategoryID]['cpmcommission'];
            $temp['clickcommission'] = $campaignCategories[$CampaignID][$CampCategoryID]['clickcommission'];
            $temp['stclickcommission'] = $campaignCategories[$CampaignID][$CampCategoryID]['stclickcommission'];
            $temp['salecommission'] = $campaignCategories[$CampaignID][$CampCategoryID]['salecommission'];
            $temp['stsalecommission'] = $campaignCategories[$CampaignID][$CampCategoryID]['stsalecommission'];
            $temp['salecommtype'] = $campaignCategories[$CampaignID][$CampCategoryID]['salecommtype'];
            $temp['stsalecommtype'] = $campaignCategories[$CampaignID][$CampCategoryID]['stsalecommtype'];    
            $temp['recurringcommission'] = $campaignCategories[$CampaignID][$CampCategoryID]['recurringcommission'];
            $temp['recurringcommtype'] = $campaignCategories[$CampaignID][$CampCategoryID]['recurringcommtype'];
            
            $campaignCommissions[$CampaignID] = $temp;
        }
        
        return $campaignCommissions;
    }
}
?>
