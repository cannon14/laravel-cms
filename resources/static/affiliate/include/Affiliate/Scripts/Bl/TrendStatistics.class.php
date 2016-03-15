<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2005
// All rights reserved
//
// For support contact info@@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Bl_AffiliateGroups');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CampaignCategoryGroups');
QUnit_Global::includeClass('Affiliate_Merchants_Views_ExpensesManager');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');

class Affiliate_Scripts_Bl_TrendStatistics
{
	
	// $selected is an array of fields you want to compute in this order:
	// (Impressions,Clicks,Sales,Commission,Revenues,Expenses,Profits,CPC,EPC,EPU,EPM)
	// Defaults to compute all
    function getTrendStats($AffiliateID,
						   $AffiliateGroupID,
                           $CampaignID,
						   $CampaignTypeID,
                           $TrackerID,
                           $KeywordID,
                           $TimeslotID,
                           $PageID,
                           $reportType,
                           $d1='',$m1='',$y1='',$d2='',$m2='',$y2='',
                           $AccountID='',
                           $settings = '',
                           $selected = '')
    {
        if(is_object($GLOBALS['Auth']))
        {
            if($AccountID == '')
            {
                $AccountID = $GLOBALS['Auth']->getAccountID();
            }
            if($settings == '')
            {
                $settings = array();
                $settings['Aff_support_signup_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_signup_commissions');
                $settings['Aff_support_referral_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_referral_commissions');
                $settings['Aff_support_cpm_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions');
                $settings['Aff_support_click_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_click_commissions');
                $settings['Aff_support_sale_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_sale_commissions');
                $settings['Aff_support_lead_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_lead_commissions');
                $settings['Aff_support_recurring_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions');
            }
        }
        
        $TrendData = Affiliate_Scripts_Bl_TrendStatistics::initResults($reportType);
        
		if ((($selected == '') || ($selected['imps'] == 1) || ($selected['clicks'] == 1) || ($selected['epu'] == 1) || ($selected['epm'] == 1))
			&& (($TrackerID == '' || $TrackerID == '_' ) && ($KeywordID == '' || $KeywordID == '_' ) && ($TimeslotID == '' || $TimeslotID == '_' ) && ($PageID == '' || $PageID == '_' ))) {
        $TrendData = Affiliate_Scripts_Bl_TrendStatistics::getImpressionStats($AffiliateID, 
                                                                             '',            // BannerID
                                                                             $CampaignID,
                           													 $reportType,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TrendData,
                                                                             $selected,
																			 $AffiliateGroupID,
																			 $CampaignTypeID);
		}

        $TrendData = Affiliate_Scripts_Bl_TrendStatistics::getTransactionsStats($AffiliateID, 
                                                                             $CampaignID,
                                                                             $TrackerID,
                           													 $KeywordID,
                           													 $TimeslotID,
                           													 $PageID,
                           													 $reportType,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TrendData,
                                                                             $settings,
                                                                             $selected,
																			 $AffiliateGroupID,
																			 $CampaignTypeID);
                                                                             
        $TrendData = Affiliate_Scripts_Bl_TrendStatistics::getExpenseStats($AffiliateID, 
                                                                             $CampaignID,
                                                                             $TrackerID,
                           													 $KeywordID,
                           													 $TimeslotID,
                           													 $PageID,
                           													 $reportType,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TrendData,
                                                                             $settings,
                                                                             $selected,
																			 $AffiliateGroupID,
																			 $CampaignTypeID);       
        return $TrendData;
    }

    //------------------------------------------------------------------------
    
     function getATrendStats($AffiliateID,
						   $AffiliateGroupID,
                           $CampaignID,
						   $CampaignTypeID,
                           $TrackerID,
                           $KeywordID,
                           $TimeslotID,
                           $PageID,
                           $reportType,
                           $d1='',$m1='',$y1='',$d2='',$m2='',$y2='',
                           $AccountID='',
                           $settings = '',
                           $selected = '')
    {
        if(is_object($GLOBALS['Auth']))
        {
            if($AccountID == '')
            {
                $AccountID = $GLOBALS['Auth']->getAccountID();
            }
            if($settings == '')
            {
                $settings = array();
                $settings['Aff_support_signup_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_signup_commissions');
                $settings['Aff_support_referral_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_referral_commissions');
                $settings['Aff_support_cpm_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions');
                $settings['Aff_support_click_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_click_commissions');
                $settings['Aff_support_sale_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_sale_commissions');
                $settings['Aff_support_lead_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_lead_commissions');
                $settings['Aff_support_recurring_commissions'] = $GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions');
            }
        }
        
        $TrendData = Affiliate_Scripts_Bl_TrendStatistics::initResults($reportType);
        
		if ((($selected == '') || ($selected['imps'] == 1) || ($selected['clicks'] == 1) || ($selected['epu'] == 1) || ($selected['epm'] == 1))
			&& (($TrackerID == '' || $TrackerID == '_' ) && ($KeywordID == '' || $KeywordID == '_' ) && ($TimeslotID == '' || $TimeslotID == '_' ) && ($PageID == '' || $PageID == '_' ))) {
        $TrendData = Affiliate_Scripts_Bl_TrendStatistics::getImpressionStats($AffiliateID, 
                                                                             '',            // BannerID
                                                                             $CampaignID,
                           													 $reportType,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TrendData,
                                                                             $selected,
																			 $AffiliateGroupID,
																			 $CampaignTypeID);
		}
		

        $TrendData = Affiliate_Scripts_Bl_TrendStatistics::getATransactionsStats($AffiliateID, 
                                                                             $CampaignID,
                                                                             $TrackerID,
                           													 $KeywordID,
                           													 $TimeslotID,
                           													 $PageID,
                           													 $reportType,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TrendData,
                                                                             $settings,
                                                                             $selected,
																			 $AffiliateGroupID,
																			 $CampaignTypeID);
                                                                             
        $TrendData = Affiliate_Scripts_Bl_TrendStatistics::getExpenseStats($AffiliateID, 
                                                                             $CampaignID,
                                                                             $TrackerID,
                           													 $KeywordID,
                           													 $TimeslotID,
                           													 $PageID,
                           													 $reportType,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TrendData,
                                                                             $settings,
                                                                             $selected,
																			 $AffiliateGroupID,
																			 $CampaignTypeID);                                                              
        return $TrendData;
    }

    //------------------------------------------------------------------------
    
    function initResults($reportType)
    {
        $TrendData = array();
        
        if($reportType == 'tenmins')
        {
            $min = 0;
            $max = 143;
        }
        if($reportType == 'hourly')
        {
            $min = 0;
            $max = 23;
        }
        else if($reportType == 'daily')
        {
            $min = 1;
            $max = 31;
        }
        else if($reportType == 'monthly')
        {
            $min = 1;
            $max = 12;
        }
        
        for($i=$min; $i<=$max; $i++)
        {
            $TrendData['imps'][$i]['unique'] = 0;
            $TrendData['imps'][$i]['all'] = 0;
            $TrendData['cpm'][$i] = 0;
            $TrendData['clicks'][$i] = 0;
            $TrendData['sales'][$i] = 0;
            $TrendData['leads'][$i] = 0;
            $TrendData['revenue'][$i] = 0;
            $TrendData['estimatedrevenue'][$i] = 0;
            $TrendData['totalcost'][$i] = 0;
            $TrendData['estimatedbysales'][$i] = 0;
            $TrendData['expense'][$i] = 0;
        }
        
        return $TrendData;
    }
    
    //------------------------------------------------------------------------
    
    function getImpressionStats($AffiliateID, $BannerID, $CampaignID, $reportType, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, $TrendData, $selected, $AffiliateGroupID, $CampaignTypeID)
    {   
        if($reportType == 'tenmins')
        {
            $period = "HOUR(i.dateimpression)*6+TRUNCATE(TRUNCATE(MINUTE(i.dateimpression),-1)/10,0)";
        }
        if($reportType == 'hourly')
        {
            $period = sqlHour('i.dateimpression');
        }
        else if($reportType == 'daily')
        {
            $period = sqlDayOfMonth('i.dateimpression');
        }
        else if($reportType == 'monthly')
        {
            $period = sqlMonth('i.dateimpression');
        }

        
        $sql = "select ".$period." as period, sum(all_imps_count) as count, sum(unique_imps_count) as unique_count". 
                   " from wd_pa_impressions i, wd_pa_banners b, wd_g_users as a".
                   " where i.bannerid=b.bannerid".
                   " and i.affiliateid = a.userid".
                   " and i.accountid="._q($AccountID).
                   " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
      
        if($BannerID != '_' && $BannerID != '')
        {
            $sql .= " and i.bannerid="._q($BannerID);
        }
        if($AffiliateID != '_' && $AffiliateID != '')
        {
			$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$sql .= " and (i.affiliateid = " . _q($AffiliateID) . " or i.affiliateid in ('" . $inSQL . "'))"; 
			}else
				$sql .= " and i.affiliateid = "._q($AffiliateID);
		}
		else{
			if($AffiliateGroupID != '_' && $AffiliateGroupID != ''){
				$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
				if(is_array($members)){
					$inSQL = implode("','", $members);
					$sql .= " and i.affiliateid in ('" . $inSQL . "') "; 
				}
			}
        }
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $sql .= " and i.dateimpression >= '$y1-".zeroPadMonth($m1)."-".zeroPadDay($d1)."'".
                   " and i.dateimpression < DATE_ADD('$y2-".zeroPadMonth($m2)."-".zeroPadDay($d2)."', INTERVAL 1 DAY)";
        }
        
        
        
        if($CampaignID != '_' && $CampaignID != '')
        {
			$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$sql .= " and (b.campaignid = " . _q($CampaignID) . " or b.campaignid in ('" . $inSQL . "'))"; 
			}
			else $sql .= " and b.campaignid = "._q($CampaignID);
		}
		else{
			if($CampaignTypeID != '_' && $CampaignTypeID != ''){
				$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
				if(is_array($members)){
					$inSQL = implode("','", $members);
					$sql .= " and b.campaignid in ('" . $inSQL . "') "; 
				}
			}
        }

        $sql .= " group by ".$period;
		
		echo $sql . "<br /><br />";
		
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            $TrendData['imps'][$rs->fields['period']]['all'] = $rs->fields['count'];

            $TrendData['imps'][$rs->fields['period']]['unique'] = $rs->fields['unique_count'];

            $rs->MoveNext();
        }
        
        return $TrendData;
    }
    
    //------------------------------------------------------------------------
    
    function getTransactionsStats($AffiliateID, $CampaignID, $TrackerID, $KeywordID, $TimeslotID, $PageID, $reportType, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, $TrendData, $settings, $selected, $AffiliateGroupID, $CampaignTypeID)
    {
        // build sql
        if($reportType == 'tenmins')
        {
            $period = "HOUR(t.dateinserted)*6+TRUNCATE(TRUNCATE(MINUTE(t.dateinserted),-1)/10,0)";
        }
        if($reportType == 'hourly')
        {
            $period = sqlHour('t.dateinserted');
        }
        else if($reportType == 'daily')
        {
            $period = sqlDayOfMonth('t.dateinserted');
        }
        else if($reportType == 'monthly')
        {
            $period = sqlMonth('t.dateinserted');
        }
        
        $sql = "select ".$period." as period, ";
        
        $sqlTransType = " sum(t.quantity) as count, t.transtype ";
			   $where = "from wd_pa_transactions t, wd_g_users a, wd_pa_campaigncategories cc ";
			   $where .= " where t.campcategoryid=cc.campcategoryid ";
           	   $where .= " and t.affiliateid=a.userid and a.deleted=0";
           	   $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
               $where .= " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
               //" and t.transkind=".TRANSKIND_NORMAL.
               " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
        $where2 = '';
        if($AffiliateID != '_' && $AffiliateID != '')
        {
			$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (t.affiliateid = " . _q($AffiliateID) . " or t.affiliateid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and t.affiliateid = "._q($AffiliateID);
		}else{
			if($AffiliateGroupID != '_' && $AffiliateGroupID != ''){
				$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and t.affiliateid in ('" . $inSQL . "') "; 
			}
		}
        }
		
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $where2 .= " and t.dateinserted >= '$y1-".zeroPadMonth($m1)."-".zeroPadDay($d1)."'" .
                    " and t.dateinserted < DATE_ADD('$y2-".zeroPadMonth($m2)."-".zeroPadDay($d2)."', INTERVAL 1 DAY)";
        }
        if($CampaignID != '_' && $CampaignID != '')
        {
			$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (cc.campaignid = " . _q($CampaignID) . " or cc.campaignid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and cc.campaignid = "._q($CampaignID);
		}else{
			if($CampaignTypeID != '_' && $CampaignTypeID != ''){
				$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and cc.campaignid in ('" . $inSQL . "') "; 
			}
		}
        }
        
		if($TrackerID != '_' && $TrackerID != '')
        {
            $where2 .= " and t.channel="._q($TrackerID);
        }
        if($KeywordID != '_' && $KeywordID != '')
        {
            $where2 .= " and t.episode="._q($KeywordID);
        }
        if($TimeslotID != '_' && $TimeslotID != '')
        {
            $where2 .= " and t.timeslot="._q($TimeslotID);
        }
        if($PageID != '_' && $PageID != '')
        {
            $where2 .= " and t.exit="._q($PageID);
        }
        
        
        $groupby = " group by t.transtype, ".$period;

		if (($selected == '') || (($selected['imps'] == 1) || ($selected['clicks'] == 1) || ($selected['sales'] == 1) || ($selected['commission'] == 1) || ($selected['cpc'] == 1) || ($selected['epc'] == 1))) {
		
		echo $sql.$sqlTransType.$where.$where2.$groupby . "<br /><br />";
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);

        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            switch($rs->fields['transtype'])
            {
                case TRANSTYPE_CPM: 
                	$TrendData['cpm'][$rs->fields['period']] = $rs->fields['count']; 
                	break;
                case TRANSTYPE_CLICK: 
                	$TrendData['clicks'][$rs->fields['period']] = $rs->fields['count']; 
                	break;
                
                case TRANSTYPE_LEAD: 
                	$TrendData['leads'][$rs->fields['period']] = $rs->fields['count']; 
                	break;
       
                case TRANSTYPE_SALE: 
					$TrendData['sales'][$rs->fields['period']] = $rs->fields['count'];
                	break;
                	
                case 99: 
                	$TrendData['commissionadjustment'][$rs->fields['period']] = $rs->fields['count'];
                	break;                	

                case 95: 
                	$TrendData['revenueadjustment'][$rs->fields['period']] = $rs->fields['count'];
                	break;            

                case 90: 
                	$TrendData['bonus'][$rs->fields['period']] = $rs->fields['count'];
                	break;
                case 100: 
                	$TrendData['salerev'][$rs->fields['period']] = $rs->fields['count'];
                	break;
                case 101: 
                	$TrendData['adjustrev'][$rs->fields['period']] = $rs->fields['count'];
                	break;
		
            }
            
            $rs->MoveNext();
        }

		}

        // get revenues
        $sqlTransType = "sum(commission) as count ";
        
        if($settings != '')
        {
            $allowedTransactions = array();

            if($settings['Aff_support_signup_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_SIGNUP;
            if($settings['Aff_support_referral_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_REFERRAL;
            if($settings['Aff_support_cpm_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_CPM;
            if($settings['Aff_support_click_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_CLICK;
            if($settings['Aff_support_sale_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_SALE;
            if($settings['Aff_support_lead_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_LEAD;
            if($settings['Aff_support_recurring_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_RECURRING;
            // temporary fix, will add these into settings when time permits.
            $allowedTransactions[] = 99;
            $allowedTransactions[] = 90;
            $allowedTransactions[] = 95;
            $allowedTransactions[] = 100;
            $allowedTransactions[] = 101;
			$allowedTransactions[] = 102;
            
            
            if(count($allowedTransactions) > 0)
            {
                $where2 .= " and t.transtype in (".implode(',', $allowedTransactions).")";
            }
        }        
        $groupby = " group by ".$period;

		if (($selected == '') || (($selected['commission'] == 1) || ($selected['profits'] == 1))) {
		
		echo $sql.$sqlTransType.$where.$where2.$groupby . '<br /><br />';
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        //QUnit_Messager::setErrorMessage($sql.$sqlTransType.$where.$where2.$groupby);
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            $TrendData['revenue'][$rs->fields['period']] = _rnd($rs->fields['count']);
			
            $rs->MoveNext();
        }
        
        if($CampaignID == '_' || $CampaignID == '')
        {
            // process non-campaign transactions in time range
            $where = " from wd_pa_transactions t, wd_g_users a, wd_pa_campaigncategories cc ";
                      
               if($CampaignID != '_' && $CampaignID != ''){
			   	$where .= "  where t.campcategoryid=cc.campcategoryid ".
               	" and t.affiliateid=a.userid and a.deleted=0 ";
               }else
               	$where.= " where t.affiliateid=a.userid and a.deleted=0 ";
               
                $where .= " and a.rtype="._q(USERTYPE_USER).
                      " and t.transtype != 1 " .
					  " and a.rtype="._q(USERTYPE_USER).
                      " and a.rstatus="._q(AFFSTATUS_APPROVED).
                      " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
                      //" and t.transkind=".TRANSKIND_NORMAL.
                      " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
                 $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
            
            echo $sql.$sqlTransType.$where.$where2.$groupby . '<br /><br />';
            $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
            //QUnit_Messager::setErrorMessage($sql.$sqlTransType.$where.$where2.$groupby);
            if (!$rs)
            return false;
            
            while(!$rs->EOF)
            {
                //$TrendData['revenue'][$rs->fields['period']] += _rnd($rs->fields['count']);
                
                $rs->MoveNext();
            }            
            
        }
        
		}
        
// estimated totalcosts        
        $sqlTransType = " sum(estimatedrevenue) as count, t.transtype ";
       
        $where = " from wd_pa_transactions t, wd_g_users a ";
    
		
		if(($CampaignID != '_' && $CampaignID != '') || ($CampaignTypeID != '_' && $CampaignTypeID != '')){
				$where .= ", wd_pa_campaigncategories cc where t.campcategoryid=cc.campcategoryid ".
               	" and t.affiliateid=a.userid and a.deleted=0 ";
        }else
               $where.= " where t.affiliateid=a.userid and a.deleted=0 ";
               
               $where .= " and a.rtype="._q(USERTYPE_USER).
               " and t.transtype != 1 " .
			   " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
               $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
                   
        $where2 = ''; 
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $where2 .= " and t.dateinserted >= '$y1-".zeroPadMonth($m1)."-".zeroPadDay($d1)."'" .
                    " and t.dateinserted < DATE_ADD('$y2-".zeroPadMonth($m2)."-".zeroPadDay($d2)."', INTERVAL 1 DAY)";
        }
        if($CampaignID != '_' && $CampaignID != '')
        {
			
			$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (cc.campaignid = " . _q($CampaignID) . " or cc.campaignid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and cc.campaignid = "._q($CampaignID);
		}else{
			if($CampaignTypeID != '_' && $CampaignTypeID != ''){
				$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				
				$inSQL = implode("','", $members);
				$where2 .= " and cc.campaignid in ('" . $inSQL . "') "; 
			}
		}
        }
        if($AffiliateID != '_' && $AffiliateID != '')
        {
			$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (t.affiliateid = " . _q($AffiliateID) . " or t.affiliateid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and t.affiliateid = "._q($AffiliateID);
		}else{
			if($AffiliateGroupID != '_' && $AffiliateGroupID != ''){
				$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and t.affiliateid in ('" . $inSQL . "') "; 
			}
		}
        }         
        
        if($TrackerID != '_' && $TrackerID != '')
        {
            $where2 .= " and t.channel="._q($TrackerID);
        }
        if($KeywordID != '_' && $KeywordID != '')
        {
            $where2 .= " and t.episode="._q($KeywordID);
        }
        if($TimeslotID != '_' && $TimeslotID != '')
        {
            $where2 .= " and t.timeslot="._q($TimeslotID);
        }
        if($PageID != '_' && $PageID != '')
        {
            $where2 .= " and t.exit="._q($PageID);
        }
		
        $groupby = " group by ".$period;

		if (($selected == '') || (($selected['revenue'] == 1) || ($selected['profits'] == 1))) {
        echo $sql.$sqlTransType.$where.$where2.$groupby . '<br /><br />';
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
        return false;
        
        while(!$rs->EOF)
        {
            $TrendData['estimatedrevenue'][$rs->fields['period']] += _rnd($rs->fields['count']);
            if ($TrendData['sales'][$rs->fields['period']] > 0){
            	$TrendData['estimatedbysales'][$rs->fields['period']] = round($TrendData['estimatedrevenue'][$rs->fields['period']]/$TrendData['sales'][$rs->fields['period']],2);
            }
           	else { $TrendData['estimatedbysales'][$rs->fields['period']] = 0; }
            $rs->MoveNext();
        }   
        
		}                 
        
// actual totalcosts        
        $sqlTransType = " sum(totalcost) as count, t.transtype ";
                
        $where = " from wd_pa_transactions t, wd_g_users a ";
		
		
               if(($CampaignID != '_' && $CampaignID != '') || ($CampaignTypeID != '_' && $CampaignTypeID != '')){
			   	$where .= ", wd_pa_campaigncategories cc where t.campcategoryid=cc.campcategoryid ".
               	" and t.affiliateid=a.userid and a.deleted=0 ";
               }else
               	$where.= " where t.affiliateid=a.userid and a.deleted=0 ";
               
               $where .= " and a.rtype="._q(USERTYPE_USER).
               " and t.transtype != 1 " .
			   " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and t.rstatus<>".AFFSTATUS_SUPPRESSED;  
               $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
        $where2 = '';
		
		
		 
        if($CampaignID != '_' && $CampaignID != '')
        {
			$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (cc.campaignid = " . _q($CampaignID) . " or cc.campaignid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and cc.campaignid = "._q($CampaignID);
		}else{
			if($CampaignTypeID != '_' && $CampaignTypeID != ''){
				$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and cc.campaignid in ('" . $inSQL . "') "; 
			}
		}
        }
        if($AffiliateID != '_' && $AffiliateID != '')
        {
			$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (t.affiliateid = " . _q($AffiliateID) . " or t.affiliateid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and t.affiliateid = "._q($AffiliateID);
		}else{
			if($AffiliateGroupID != '_' && $AffiliateGroupID != ''){
				$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and t.affiliateid in ('" . $inSQL . "') "; 
			}
		}
        }
        
        if($TrackerID != '_' && $TrackerID != '')
        {
            $where2 .= " and t.channel="._q($TrackerID);
        }
        if($KeywordID != '_' && $KeywordID != '')
        {
            $where2 .= " and t.episode="._q($KeywordID);
        }
        if($TimeslotID != '_' && $TimeslotID != '')
        {
            $where2 .= " and t.timeslot="._q($TimeslotID);
        }
        if($PageID != '_' && $PageID != '')
        {
            $where2 .= " and t.exit="._q($PageID);
        }
        
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $where2 .= " and t.dateinserted >= '$y1-".zeroPadMonth($m1)."-".zeroPadDay($d1)."'" .
                    " and t.dateinserted < DATE_ADD('$y2-".zeroPadMonth($m2)."-".zeroPadDay($d2)."', INTERVAL 1 DAY)";
        }               
        $groupby = " group by ".$period;

		if (($selected == '') || (($selected['revenue'] == 1) || ($selected['profits'] == 1) || ($selected['epc'] == 1) || ($selected['epu'] == 1) || ($selected['epm'] == 1))) {
        
		echo $sql.$sqlTransType.$where.$where2.$groupby ."<br><br>";	  
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
        return false;
        
        while(!$rs->EOF)
        {
            $TrendData['totalcost'][$rs->fields['period']] += _rnd($rs->fields['count']);
            
            $rs->MoveNext();
        }   
        
		}                 
               
        return $TrendData;
    }
    
    
      //------------------------------------------------------------------------
    
    function getATransactionsStats($AffiliateID, $CampaignID, $TrackerID, $KeywordID, $TimeslotID, $PageID, $reportType, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, $TrendData, $settings, $selected, $AffiliateGroupID, $CampaignTypeID)
    {
        // build sql
        if($reportType == 'tenmins')
        {
            $period = "HOUR(t.dateinserted)*6+TRUNCATE(TRUNCATE(MINUTE(t.dateinserted),-1)/10,0)";
        }
        if($reportType == 'hourly')
        {
            $period = sqlHour('t.dateinserted');
        }
        else if($reportType == 'daily')
        {
            $period = sqlDayOfMonth('t.dateinserted');
        }
        else if($reportType == 'monthly')
        {
            $period = sqlMonth('t.dateinserted');
        }
        
        $sql = "select ".$period." as period, ";
        
        $sqlTransType = " sum(t.quantity) as count, t.transtype ";
			   $where = "from all_transactions t, wd_g_users a, wd_pa_campaigncategories cc ";
			   $where .= " where t.campcategoryid=cc.campcategoryid ";
           	   $where .= " and t.affiliateid=a.userid and a.deleted=0";
               $where .= " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
               //" and t.transkind=".TRANSKIND_NORMAL.
               " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
               $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
        
        $where2 = '';
        if($AffiliateID != '_' && $AffiliateID != '')
        {
			$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (t.affiliateid = " . _q($AffiliateID) . " or t.affiliateid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and t.affiliateid = "._q($AffiliateID);
		}else{
			if($AffiliateGroupID != '_' && $AffiliateGroupID != ''){
				$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and t.affiliateid in ('" . $inSQL . "') "; 
			}
		}
        }
		
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $where2 .= " and t.dateinserted >= '$y1-".zeroPadMonth($m1)."-".zeroPadDay($d1)."'" .
                    " and t.dateinserted < DATE_ADD('$y2-".zeroPadMonth($m2)."-".zeroPadDay($d2)."', INTERVAL 1 DAY)";
        }
        if($CampaignID != '_' && $CampaignID != '')
        {
			$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (cc.campaignid = " . _q($CampaignID) . " or cc.campaignid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and cc.campaignid = "._q($CampaignID);
		}else{
			if($CampaignTypeID != '_' && $CampaignTypeID != ''){
				$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and cc.campaignid in ('" . $inSQL . "') "; 
			}
		}
        }
        
		if($TrackerID != '_' && $TrackerID != '')
        {
            $where2 .= " and t.channel="._q($TrackerID);
        }
        if($KeywordID != '_' && $KeywordID != '')
        {
            $where2 .= " and t.episode="._q($KeywordID);
        }
        if($TimeslotID != '_' && $TimeslotID != '')
        {
            $where2 .= " and t.timeslot="._q($TimeslotID);
        }
        if($PageID != '_' && $PageID != '')
        {
            $where2 .= " and t.exit="._q($PageID);
        }
        
        
        $groupby = " group by t.transtype, ".$period;

		if (($selected == '') || (($selected['imps'] == 1) || ($selected['clicks'] == 1) || ($selected['sales'] == 1) || ($selected['commission'] == 1) || ($selected['cpc'] == 1) || ($selected['epc'] == 1))) {
		
		
		echo $sql.$sqlTransType.$where.$where2.$groupby . "<br /><br />";
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
		
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            switch($rs->fields['transtype'])
            {
                case TRANSTYPE_CPM: 
                	$TrendData['cpm'][$rs->fields['period']] = $rs->fields['count']; 
                	break;
                case TRANSTYPE_CLICK: 
                	$TrendData['clicks'][$rs->fields['period']] = $rs->fields['count']; 
                	break;
                
                case TRANSTYPE_LEAD: 
                	$TrendData['leads'][$rs->fields['period']] = $rs->fields['count']; 
                	break;
       
                case TRANSTYPE_SALE: 
					$TrendData['sales'][$rs->fields['period']] = $rs->fields['count'];
                	break;
                	
                case 99: 
                	$TrendData['commissionadjustment'][$rs->fields['period']] = $rs->fields['count'];
                	break;                	

                case 95: 
                	$TrendData['revenueadjustment'][$rs->fields['period']] = $rs->fields['count'];
                	break;            

                case 90: 
                	$TrendData['bonus'][$rs->fields['period']] = $rs->fields['count'];
                	break;
                case 100: 
                	$TrendData['salerev'][$rs->fields['period']] = $rs->fields['count'];
                	break;
                case 101: 
                	$TrendData['adjustrev'][$rs->fields['period']] = $rs->fields['count'];
                	break;
		
            }
            
            $rs->MoveNext();
        }

		}

        // get revenues
        $sqlTransType = "sum(commission) as count ";
        
        if($settings != '')
        {
            $allowedTransactions = array();

            if($settings['Aff_support_signup_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_SIGNUP;
            if($settings['Aff_support_referral_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_REFERRAL;
            if($settings['Aff_support_cpm_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_CPM;
            if($settings['Aff_support_click_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_CLICK;
            if($settings['Aff_support_sale_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_SALE;
            if($settings['Aff_support_lead_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_LEAD;
            if($settings['Aff_support_recurring_commissions'] == 1) $allowedTransactions[] = TRANSTYPE_RECURRING;
            // temporary fix, will add these into settings when time permits.
            $allowedTransactions[] = 99;
            $allowedTransactions[] = 90;
            $allowedTransactions[] = 95;
            $allowedTransactions[] = 100;
            $allowedTransactions[] = 101;
			$allowedTransactions[] = 102;
            
            
            if(count($allowedTransactions) > 0)
            {
                $where2 .= " and t.transtype in (".implode(',', $allowedTransactions).")";
            }
        }        
        $groupby = " group by ".$period;

		if (($selected == '') || (($selected['commission'] == 1) || ($selected['profits'] == 1))) {
		
		echo $sql.$sqlTransType.$where.$where2.$groupby ."<br /><br />";
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            $TrendData['revenue'][$rs->fields['period']] = _rnd($rs->fields['count']);
			
            $rs->MoveNext();
        }
        
        if($CampaignID == '_' || $CampaignID == '')
        {
            // process non-campaign transactions in time range
            $where = " from all_transactions t, wd_g_users a, wd_pa_campaigncategories cc ";
                      
               if($CampaignID != '_' && $CampaignID != ''){
			   	$where .= "  where t.campcategoryid=cc.campcategoryid ".
               	" and t.affiliateid=a.userid and a.deleted=0 ";
               }else
               	$where.= " where t.affiliateid=a.userid and a.deleted=0 ";
               
                $where .= " and a.rtype="._q(USERTYPE_USER).
                      " and t.transtype != 1 " .
					  " and a.rtype="._q(USERTYPE_USER).
                      " and a.rstatus="._q(AFFSTATUS_APPROVED).
                      " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
                      //" and t.transkind=".TRANSKIND_NORMAL.
                      " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
                      $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
            
            echo $sql.$sqlTransType.$where.$where2.$groupby . "<br /><br />";
            $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);

            if (!$rs)
            return false;
            
            while(!$rs->EOF)
            {
                //$TrendData['revenue'][$rs->fields['period']] += _rnd($rs->fields['count']);
                
                $rs->MoveNext();
            }            
            
        }
        
		}
        
// estimated totalcosts        
        $sqlTransType = " sum(estimatedrevenue) as count, t.transtype ";
       
        $where = " from all_transactions t, wd_g_users a ";
    
		
		if(($CampaignID != '_' && $CampaignID != '') || ($CampaignTypeID != '_' && $CampaignTypeID != '')){
				$where .= ", wd_pa_campaigncategories cc where t.campcategoryid=cc.campcategoryid ".
               	" and t.affiliateid=a.userid and a.deleted=0 ";
        }else
               	$where.= " where t.affiliateid=a.userid and a.deleted=0 ";
               
               $where .= " and a.rtype="._q(USERTYPE_USER).
               " and t.transtype != 1 " .
			   " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
               $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
        $where2 = ''; 
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $where2 .= " and t.dateinserted >= '$y1-".zeroPadMonth($m1)."-".zeroPadDay($d1)."'" .
                   " and t.dateinserted < DATE_ADD('$y2-".zeroPadMonth($m2)."-".zeroPadDay($d2)."', INTERVAL 1 DAY)";
        }
        if($CampaignID != '_' && $CampaignID != '')
        {
			
			$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (cc.campaignid = " . _q($CampaignID) . " or cc.campaignid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and cc.campaignid = "._q($CampaignID);
		}else{
			if($CampaignTypeID != '_' && $CampaignTypeID != ''){
				$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				
				$inSQL = implode("','", $members);
				$where2 .= " and cc.campaignid in ('" . $inSQL . "') "; 
			}
		}
        }
        if($AffiliateID != '_' && $AffiliateID != '')
        {
			$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (t.affiliateid = " . _q($AffiliateID) . " or t.affiliateid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and t.affiliateid = "._q($AffiliateID);
		}else{
			if($AffiliateGroupID != '_' && $AffiliateGroupID != ''){
				$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and t.affiliateid in ('" . $inSQL . "') "; 
			}
		}
        }         
        
        if($TrackerID != '_' && $TrackerID != '')
        {
            $where2 .= " and t.channel="._q($TrackerID);
        }
        if($KeywordID != '_' && $KeywordID != '')
        {
            $where2 .= " and t.episode="._q($KeywordID);
        }
        if($TimeslotID != '_' && $TimeslotID != '')
        {
            $where2 .= " and t.timeslot="._q($TimeslotID);
        }
        if($PageID != '_' && $PageID != '')
        {
            $where2 .= " and t.exit="._q($PageID);
        }
		
        $groupby = " group by ".$period;

		if (($selected == '') || (($selected['revenue'] == 1) || ($selected['profits'] == 1))) {
        echo $sql.$sqlTransType.$where.$where2.$groupby . "<br /><br />";
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
        return false;
        
        while(!$rs->EOF)
        {
            $TrendData['estimatedrevenue'][$rs->fields['period']] += _rnd($rs->fields['count']);
            if ($TrendData['sales'][$rs->fields['period']] > 0){
            	$TrendData['estimatedbysales'][$rs->fields['period']] = round($TrendData['estimatedrevenue'][$rs->fields['period']]/$TrendData['sales'][$rs->fields['period']],2);
            }
           	else { $TrendData['estimatedbysales'][$rs->fields['period']] = 0; }
            $rs->MoveNext();
        }   
        
		}                 
        
// actual totalcosts        
        $sqlTransType = " sum(totalcost) as count, t.transtype ";
                
        $where = " from all_transactions t, wd_g_users a ";
		
		
               if(($CampaignID != '_' && $CampaignID != '') || ($CampaignTypeID != '_' && $CampaignTypeID != '')){
			   	$where .= ", wd_pa_campaigncategories cc where t.campcategoryid=cc.campcategoryid ".
               	" and t.affiliateid=a.userid and a.deleted=0 ";
               }else
               	$where.= " where t.affiliateid=a.userid and a.deleted=0 ";
               
               $where .= " and a.rtype="._q(USERTYPE_USER).
               " and t.transtype != 1 " .
			   " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and t.rstatus<>".AFFSTATUS_SUPPRESSED;
               $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
                  
        $where2 = '';
		
		
		 
        if($CampaignID != '_' && $CampaignID != '')
        {
			$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (cc.campaignid = " . _q($CampaignID) . " or cc.campaignid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and cc.campaignid = "._q($CampaignID);
		}else{
			if($CampaignTypeID != '_' && $CampaignTypeID != ''){
				$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and cc.campaignid in ('" . $inSQL . "') "; 
			}
		}
        }
        if($AffiliateID != '_' && $AffiliateID != '')
        {
			$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and (t.affiliateid = " . _q($AffiliateID) . " or t.affiliateid in ('" . $inSQL . "'))"; 
			}else
				$where2 .= " and t.affiliateid = "._q($AffiliateID);
		}else{
			if($AffiliateGroupID != '_' && $AffiliateGroupID != ''){
				$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where2 .= " and t.affiliateid in ('" . $inSQL . "') "; 
			}
		}
        }
        
        if($TrackerID != '_' && $TrackerID != '')
        {
            $where2 .= " and t.channel="._q($TrackerID);
        }
        if($KeywordID != '_' && $KeywordID != '')
        {
            $where2 .= " and t.episode="._q($KeywordID);
        }
        if($TimeslotID != '_' && $TimeslotID != '')
        {
            $where2 .= " and t.timeslot="._q($TimeslotID);
        }
        if($PageID != '_' && $PageID != '')
        {
            $where2 .= " and t.exit="._q($PageID);
        }
        
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $where2 .= " and t.dateinserted >= '$y1-".zeroPadMonth($m1)."-".zeroPadDay($d1)."'" .
                    " and t.dateinserted < DATE_ADD('$y2-".zeroPadMonth($m2)."-".zeroPadDay($d2)."', INTERVAL 1 DAY)";
        }               
        $groupby = " group by ".$period;

		if (($selected == '') || (($selected['revenue'] == 1) || ($selected['profits'] == 1) || ($selected['epc'] == 1) || ($selected['epu'] == 1) || ($selected['epm'] == 1))) {
        
		echo $sql.$sqlTransType.$where.$where2.$groupby ."<br><br>";	  
        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
        return false;
        
        while(!$rs->EOF)
        {
            $TrendData['totalcost'][$rs->fields['period']] += _rnd($rs->fields['count']);
            
            $rs->MoveNext();
        }   
        
		}                 
               
        return $TrendData;
    }
    
    
      //------------------------------------------------------------------------
      
      
    function getExpenseStats($AffiliateID, $CampaignID, $TrackerID, $KeywordID, $TimeslotID, $PageID, $reportType, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, $TrendData, $settings, $selected,$AffiliateGroupID,$CampaignTypeID)
    {
        // build sql
        if($reportType == 'tenmins')
        {
            $period = "HOUR(e.expense_start)*6+TRUNCATE(TRUNCATE(MINUTE(e.expense_start),-1)/10,0)";
        }
        if($reportType == 'hourly')
        {
            $period = sqlHour('e.expense_start');
        }
        else if($reportType == 'daily')
        {
            $period = sqlDayOfMonth('e.expense_start');
        }
        else if($reportType == 'monthly')
        {
            $period = sqlMonth('e.expense_start');
        }

        $sql = "select $period as period, ";

        
        $sqlTransType = "sum(e.total_expense) as count ";

        $where = " from " . EXPENSE_TABLE . " e, wd_g_users a ";
        if(($CampaignID != '_' && $CampaignID != '') || ($CampaignTypeID != '_' && $CampaignTypeID != '')){
			   	$where .= ", wd_pa_campaigncategories cc where e.affiliate_id=a.userid ";
        }
        else {
               	$where .= " where e.affiliate_id=a.userid ";
        }
               
        $where .= " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and a.accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and a.rstatus<>".AFFSTATUS_SUPPRESSED;
        $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
        
        if($CampaignID != '_' && $CampaignID != ''){
			
			$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where .= " and (cc.campaignid = " . _q($CampaignID) . " or cc.campaignid in ('" . $inSQL . "'))"; 
			}
			else
				$where .= " and cc.campaignid = "._q($CampaignID);
		}
		else{
			if($CampaignTypeID != '_' && $CampaignTypeID != ''){
				$members = Affiliate_Merchants_Bl_CampaignCategoryGroups::getCampaignMembersForSQL($CampaignTypeID);
				if(is_array($members)){
					
					$inSQL = implode("','", $members);
					$where .= " and cc.campaignid in ('" . $inSQL . "') "; 
				}
			}
        }
        if($AffiliateID != '_' && $AffiliateID != ''){
			$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
			if(is_array($members)){
				$inSQL = implode("','", $members);
				$where .= " and (e.affiliate_id = " . _q($AffiliateID) . " or e.affiliate_id in ('" . $inSQL . "'))"; 
			}
			else
				$where .= " and e.affiliate_id = "._q($AffiliateID);
		}
		else{
			if($AffiliateGroupID != '_' && $AffiliateGroupID != ''){
				$members = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersForSQL($AffiliateGroupID);
				if(is_array($members)){
					$inSQL = implode("','", $members);
					$where .= " and e.affiliate_id in ('" . $inSQL . "') "; 
				}
			}
        }
      
        if($TrackerID != '_' && $TrackerID != '')
        {
            $where .= " and e.extcampaign_id="._q($TrackerID);
        }
        if($KeywordID != '_' && $KeywordID != '')
        {
            $where .= " and e.keyword_id="._q($KeywordID);
        }
     
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
			if($reportType == 'tenmins'){
				$where .= " and (".sqlToDays('e.expense_start')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    " and (".sqlToDays('e.expense_start')." <= ".sqlToDays("$y2-$m2-$d2").")";
			}
        }
        $groupby = " group by $period";
		
		if (($selected == '') || (($selected['expenses'] == 1) || ($selected['profits'] == 1) || ($selected['cpc'] == 1))) {
			
			if($reportType == 'monthly'){
				for($month = 1; $month < 13; ++ $month)
					$TrendData['expense'][$month] += _r(Affiliate_Merchants_Views_ExpensesManager::ammortizedExpensesOverYear($where, $month,$y1), 2);
			}else if ($reportType == 'daily'){
				$month = $m1;
				$year = $y1;
				$leap = 28;
				if($year % 4 == 0)
					$leap = 29;
				$numdays = array(null, 31, $leap, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
				for($day = 1; $day <= $numdays[$month]; ++ $day)
					$TrendData['expense'][$day] += _r(Affiliate_Merchants_Views_ExpensesManager::ammortizedExpensesOverMonth($where, $day,$month,$year), 2);
			}else if ($reportType == 'hourly'){
				$month = $m1;
				$year = $y1;
				$day = $d1;
				for($hour = 0; $hour <= 23; ++ $hour)
					$TrendData['expense'][$hour] += _r(Affiliate_Merchants_Views_ExpensesManager::ammortizedExpensesOverDay($where, $hour,$day,$month,$year), 2);
			}
			else{
			
				echo $sql.$sqlTransType.$where.$groupby . "<br /><br />";
				$rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$groupby, __FILE__, __LINE__);
				if (!$rs)
				return false;
            
				while(!$rs->EOF)
				{     
					$TrendData['expense'][$rs->fields['period']] += _rnd($rs->fields['count']);       
					$rs->MoveNext();
				}
			}
             
		}           
        
        return $TrendData;
    }
    
    //------------------------------------------------------------------------
    

    function checkSomeTransImpsExistedLastYear($affiliateID = '')
    {
        $year = date('Y') - 1;
        
        $sql = "select * from wd_pa_transactions where accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and (".sqlToDays('dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
               " and (".sqlToDays('dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
               
        if($affiliateID != '')
        {
            $sql .= " and affiliateid="._q($affiliateID);
        }

        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$groupby, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
            return false;

        return true;
    }
}
?>
