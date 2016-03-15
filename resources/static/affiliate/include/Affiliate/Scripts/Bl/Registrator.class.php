<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('QCore_Settings');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');

class Affiliate_Scripts_Bl_Registrator
{
    var $className = 'Affiliate_Scripts_Bl_Registrator';
    var $CampaignCategoryID = '';
    var $cookieLifetime = '';
    var $cookieSetReturn = '';
    var $UserID = '';
    var $ParentUserID = '';  
    var $CampaignID = '';
    var $CampaignCommType = '';
    var $CPMCommission;
    var $ClickCommission = 0;
    var $SaleCommission = 0;
    var $STClickCommission = array();
    var $STSaleCommission = array();
    var $PerSaleCommType = '';
    var $STPerSaleCommType = '';
    var $RecurringCommission = 0;
    var $RecurringCommType = 0;
    var $RecurringCommDate = 0;
    var $RecurringDateType = 0;
    var $STRecurringCommission = array();
    var $STRecurringCommType = 0;
    var $ClickTransactionApproval = 0;
    var $SaleTransactionApproval = 0;
    var $BannerID = '';
    var $destinationURL = '';
    var $uniqueUser = true;
    var $DeclineFrequentClicks;
    var $FrequentClicks;
    var $DeclineFrequentSales;
    var $FrequentSales;
    var $DeclineSameOrderId;
    var $ClickFrequency;
    var $SaleFrequency;
    var $maxCommissionLevels;
    var $saleKind = TRANSKIND_NORMAL;
    var $saleType = '';
    var $AccountID = 'default1';
    var $settings = array();
    var $extraData1 = '';
    var $extraData2 = '';
    var $extraData3 = '';
    var $cookieData1 = '';
    var $cookieData2 = '';
    var $cookieData3 = '';
    var $cookieData4 = '';
    var $cookieInceptionDate = '';
    
    //--------------------------------------------------------------------------
    
    function checkUserExists($userID)
    {
        $userID = preg_replace('/[\'\"]/', '', $userID);
    
        if(trim($userID) == '') return false;
    
        $sql = 'select * from partner_affiliates where deleted != 1 '.
                ' and affiliate_id='._q($userID);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
            return false;

        $this->UserID = $rs->fields['affiliate_id'];
        $this->AccountID = $rs->fields['accountid'];
        
//        $this->settings = $GLOBALS['Auth']->getSettings();
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function checkCampaignExists($campaign = '')
    {
        if($campaign == '')
            $campaign = $this->CampaignID;
        
        $sql = 'select * from wd_pa_campaigns where deleted=0 and campaignid='._q($campaign);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
            return false;
        
        $this->CampaignID = $rs->fields['campaignid'];
        $this->CampaignCommType = $rs->fields['commtype'];
        
        $this->settings = array_merge($this->settings, Affiliate_Merchants_Bl_Settings::getCampaignInfo(array('campaignid' => $this->CampaignID)));
        
        $this->cookieLifetime = $this->settings['Aff_camp_cookielifetime'];
        $this->ClickTransactionApproval = $this->settings['Aff_camp_clickapproval'];
        $this->SaleTransactionApproval = $this->settings['Aff_camp_saleapproval'];    
        
        $this->DeclineFrequentClicks = $this->settings['Aff_declinefrequentclicks'];
        $this->FrequentClicks = $this->settings['Aff_frequentclicks'];
        $this->DeclineFrequentSales = $this->settings['Aff_declinefrequentsales'];
        $this->FrequentSales = $this->settings['Aff_frequentsales'];
        $this->DeclineSameOrderId = $this->settings['Aff_declinesameorderid'];
        $this->ClickFrequency = (int) $this->settings['Aff_clickfrequency'];
        $this->SaleFrequency = (int) $this->settings['Aff_salefrequency'];
        
        return true;
    }    
    
    //--------------------------------------------------------------------------
    
    function checkBannerExists($bannerID, $getFirstCategoryIfNotExists = false)
    {
        if($bannerID == '' && $getFirstCategoryIfNotExists)
        {
            $sql = 'select * from wd_pa_campaigns where deleted=0';
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
                return false;
            
            $this->CampaignID = $rs->fields['campaignid'];
            $this->BannerID = -1;
        }
        else
        {
            $sql = 'select * from wd_pa_banners where deleted=0 and bannerid='._q($bannerID);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
            {
                $errorMsg = "Registrator: '$bannerID' doesn't exist";
                LogError($errorMsg, __FILE__, __LINE__);        
                return false;
            }
            
            $this->BannerID = $bannerID;
            $this->CampaignID = $rs->fields['campaignid'];
            $this->destinationURL = $rs->fields['destinationurl'];
            
            if($this->destinationURL == '')
            {
                $errorMsg = "Registrator: DestinationURL for Banner is Null";
                LogError($errorMsg, __FILE__, __LINE__);
                return false;      
            }        
        }
        
        return true;
    }    
    
    //--------------------------------------------------------------------------
    
    function checkUserInCampaign()
    {
        if($this->UserID == '')
        {
            $errorMsg = "Registrator: UserID is Null";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;      
        }
        if($this->CampaignID == '')
        {
            $errorMsg = "Registrator: CampaignID is Null";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }

        $sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($this->CampaignID).
               '  and cc.campcategoryid=ac.campcategoryid'.
               '  and ac.rstatus='._q(AFFSTATUS_APPROVED).
               '  and ac.affiliateid='._q($this->UserID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        if($rs->EOF)
        {
            // get basic commission category for this campaign
            $sql = 'select * from wd_pa_campaigncategories '.
                   'where deleted=0 and campaignid='._q($this->CampaignID).
                   ' and name='._q(UNASSIGNED_USERS);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
                return false;
        }

        $this->CampaignCategoryID = $rs->fields['campcategoryid'];
        $this->CPMCommission = $rs->fields['cpmcommission'];
        $this->ClickCommission = $rs->fields['clickcommission'];
        $this->SaleCommission = $rs->fields['salecommission'];

        $this->maxCommissionLevels = $this->settings['Aff_maxcommissionlevels'];
        if($this->maxCommissionLevels == '')
            $this->maxCommissionLevels = 1;
        
        $this->STClickCommission = array();
        $this->STSaleCommission = array();
        $this->STRecurringCommission = array();
        
        for($i=2; $i<=$this->maxCommissionLevels; $i++)
        {
            $this->STClickCommission[$i] = $rs->fields['st'.$i.'clickcommission'];
            $this->STSaleCommission[$i] = $rs->fields['st'.$i.'salecommission'];
            $this->STRecurringCommission[$i] = $rs->fields['st'.$i.'recurringcommission'];
        }
        
        $this->PerSaleCommType = $rs->fields['salecommtype'];
        $this->STPerSaleCommType = $rs->fields['stsalecommtype'];
        
        $this->RecurringCommission = $rs->fields['recurringcommission'];
        $this->RecurringCommType = $rs->fields['recurringcommtype'];
        $this->RecurringCommDate = $rs->fields['recurringcommdate'];
        $this->RecurringDateType = $rs->fields['recurringdatetype'];
        $this->STRecurringCommType = $rs->fields['strecurringcommtype'];
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function setP3PPolicy($load_settings = '1')
    {
        if($load_settings)
            $this->settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT,$this->AccountID);

        $policyRef = '';
        $cp = '';
        
        if($this->settings['Aff_p3p_xml'] != '')
            $policyRef = $this->settings['Aff_p3p_xml'];
        
        if($this->settings['Aff_p3p_compact'] != '')
            $cp = $this->settings['Aff_p3p_compact'];
        
        if($cp != '' || $policyRef != '')
        {
            $p3pPolicy = 'P3P: '.($policyRef == '' ? '' : 'policyref="'.$policyRef.'"').
                                ($cp != '' && $policyRef != '' ? ', ' : '').
                                ($cp == '' ? '' : 'CP="'.$cp.'"');
            header($p3pPolicy);
            
            QCore_History::writeHistory(WLOG_DEBUG, "Registrator: P3P policy set to '$p3pPolicy'", __FILE__, __LINE__);
        }
    }
    
    //--------------------------------------------------------------------------
    
    function loadLanguage()
    {
        $default_lang = $this->settings['Aff_default_lang'];
    
        if(file_exists(LANG_PATH.$default_lang.'.php'))
        {
            include_once(LANG_PATH.$default_lang.'.php');
        }
        else
        {
            QUnit_Messager::setErrorMessage('LANGUAGE FILE '.LANG_PATH.$default_lang.'.php NOT FOUND!');
            QCore_History::DebugMsg(WLOG_ERROR, 'Sale registrator: LANGUAGE FILE '.LANG_PATH.$default_lang.'.php NOT FOUND!', __FILE__, __LINE__);
        }
    }

    //--------------------------------------------------------------------------
    
    function decodeValue($cookieval, $userID = '')
    {
        if($cookieval == '')
        {
            if($userID == '') {
                QCore_History::writeHistory(WLOG_DEBUG, "Registrator: Data/Cookie is empty", __FILE__, __LINE__);
                return false;
            }

            // get default campaign
            $sql = 'select * from wd_pa_campaigns where deleted=0';
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
                return false;
            
            $campaignID = $rs->fields['campaignid'];
            
            return array($userID, $campaignID);
        }
        
        $arr = split ( '_', $cookieval);
        
        if(!is_array($arr))
        {
            $errorMsg = "Sale registration: data/cookie value is not array";
            LogError($errorMsg, __FILE__, __LINE__);
            return false; 
        }
        
        if(count($arr) != 2)
        {
            $errorMsg = "Sale registration: data/cookie value has not 2 elements";
            LogError($errorMsg, __FILE__, __LINE__);
            return false; 
        }
        
        QCore_History::writeHistory(WLOG_DEBUG, "Registrator: Value recognized (User ID: ".$arr[0].", Product category ID: ".$arr[1].")", __FILE__, __LINE__);

        return array($arr[0], $arr[1]);
    }
    
    //--------------------------------------------------------------------------
    
    function decodeFromIP($cookieval)
    {
        $params = array('status' => AFFSTATUS_APPROVED,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'ip_validity' => $this->settings['Aff_ip_validity'],
                        'ip_validity_type' => $this->settings['Aff_ip_validity_type'],
                        'currentDate' => date("Y-n-j H:i:s")
                       );

        // look for approved records
        QCore_History::writeHistory(WLOG_DEBUG, "Sale registration: Try decode from ip from approved transaction", __FILE__, __LINE__);
        $UserID = $this->getAffiliateFromTransaction($params);

        if($UserID == false)
        {
            // look for waiting for approval records
            QCore_History::writeHistory(WLOG_DEBUG, "Sale registration: Try decode from ip from waiting for approval transaction", __FILE__, __LINE__);
            $params['status'] = AFFSTATUS_NOTAPPROVED;
            $UserID = $this->getAffiliateFromTransaction($params);
         }
        
        if($UserID == false)
            return false;
        
        return $this->getUsersCampaign($UserID);
    }
    
    //--------------------------------------------------------------------------
    
    function getAffiliateFromTransaction($params)
    {
        $sql = 'select affiliateid '.
               'from wd_pa_transactions '.
               'where transtype='.TRANSTYPE_CLICK.' and transkind='.TRANSKIND_NORMAL.
               '  and rstatus='._q($params['status']).' and IP='._q($params['ip']).
               '  and '.sqlDateAdd('dateinserted', $params['ip_validity'], $params['ip_validity_type']).' >= '._q($params['currentDate']).
               ' order by dateinserted desc';
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QCore_History::writeHistory(WLOG_DEBUG, "Registrator: Error checking referrer from IP. Sql:".$sql, __FILE__, __LINE__);
            return false;
        }

        if($rs->EOF) return false;
        
        QCore_History::writeHistory(WLOG_DEBUG, "Registrator: Get user from transaction. (User ID: ".$UserID.")", __FILE__, __LINE__);
        
        return $rs->fields['affiliateid'];
    }
    
    //--------------------------------------------------------------------------
    
    function getUsersCampaign($UserID)
    {
        // take users first campaign
        $sql = 'select c.campaignid from wd_pa_campaigns c, wd_pa_affiliatescampaigns ac '.
               ' where c.deleted=0 '.
               '   and c.campaignid=ac.campaignid'.
               '   and ac.affiliateid='._q($UserID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
            return false;

        if(!$rs->EOF)
        {
            QCore_History::writeHistory(WLOG_DEBUG, "Registrator: Get user campaign. (User ID: ".$UserID.", Product category ID: ".$rs->fields['campaignid'].")", __FILE__, __LINE__);
            
            return array($UserID, $rs->fields['campaignid']);
        }

        // user have not campaign. Take first campaign
        $sql = 'select * from wd_pa_campaigns where deleted=0';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF)
            return false;
        
        QCore_History::writeHistory(WLOG_DEBUG, "Registrator: User campaign do not exist. Get campaign. (User ID: ".$UserID.", Product category ID: ".$rs->fields['campaignid'].")", __FILE__, __LINE__);
        
        return array($UserID, $rs->fields['campaignid']);
    }
    
    //--------------------------------------------------------------------------
    
    function getCampaignFromCampaignCategory($campCategoryID)
    {
        $sql = 'select campaignid from wd_pa_campaigncategories '.
               'where campcategoryid='._q($campCategoryID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            return false;
        }
        
        return $rs->fields['campaignid'];
    }
    
    //--------------------------------------------------------------------------
    
    function setAccountID($AccountID)
    {
        QUnit_Global::includeClass('QCore_Bl_Accounts');
 
        if(!QCore_Bl_Accounts::checkAccountExists($AccountID)) return false;

        if($AccountID != '') {
            $this->AccountID = $AccountID;
            return true;
        }

        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function getParentUser($params, $accountID = '')
    {
        if($params['parentUserID'] == '')
            return false;

        $sql = 'select * from wd_g_users u '.
               'where u.userid='._q($params['parentUserID']);
        if($accountID != '')
            $sql .= '  and u.accountid='._q($accountID);
        else
            $sql .= '  and u.accountid='._q($this->AccountID);
        $sql .= '  and u.deleted=0'.
                '  and u.parentuserid <> \'\'';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
            return false;

        if($rs->EOF)
        {
            QCore_History::writeHistory(WLOG_DEBUG, "Registrator: No parent user found for user ID: ".$params['parentUserID'], __FILE__, __LINE__);
            return false;
        }

        //----------------------------------------
        // check status of user, if he is waiting for approval also transaction must have this status
        if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED && $params['status'] == AFFSTATUS_APPROVED)
            $params['status'] = AFFSTATUS_NOTAPPROVED;

        return array('userID' => $rs->fields['parentuserid'], 'status' => $params['status']);
    }
    
    //--------------------------------------------------------------------------
    
    function setExtraData($Data1, $Data2, $Data3)
    {
        $this->extraData1 = $Data1;
        $this->extraData2 = $Data2;
        $this->extraData3 = $Data3;
    }
    
    function setCookieData($Data1, $Data2, $Data3, $Data4, $date){
    	$this->cookieData1 = $Data1;
        $this->cookieData2 = $Data2;
        $this->cookieData3 = $Data3;	
        $this->cookieData4 = $Data4;
        $this->cookieInceptionDate = $date;
    }
    
    function saveBannerTrack($params){
    	$cols = "(" . implode(", ", array_keys($params)) . ")";
    	$vals = "('" . implode("','", array_values($params)) . "')"; 
    	$sql = "INSERT INTO external_visits " . $cols . " VALUES " . $vals;
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    }
}
?>
