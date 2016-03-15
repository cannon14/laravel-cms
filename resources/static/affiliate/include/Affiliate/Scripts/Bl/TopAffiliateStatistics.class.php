<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');

class Affiliate_Scripts_Bl_TopAffiliateStatistics
{
    function getTopAffStats($CampaignID,
                           $topCount,
                           $d1='',$m1='',$y1='',$d2='',$m2='',$y2='',
                           $AccountID='',
                           $settings = '')
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
        
        $TopData = array();
        $TopData['cpm'] = array();
        $TopData['imps'] = array();
        $TopData['click'] = array();
        $TopData['lead'] = array();
        $TopData['sale'] = array();
        $TopData['revenue'] = array();
        
        $TopData = Affiliate_Scripts_Bl_TopAffiliateStatistics::getImpressionTopData('',          // BannerID
                                                                             $CampaignID,
                                                                             $topCount,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TopData);

        $TopData = Affiliate_Scripts_Bl_TopAffiliateStatistics::getTransactionsTopData($CampaignID,
                                                                             $topCount,
                                                                             $d1,$m1,$y1,
                                                                             $d2,$m2,$y2,
                                                                             $AccountID,
                                                                             $TopData,
                                                                             $settings);
                                                                             
        return $TopData;
    }

    //------------------------------------------------------------------------
    
    function getImpressionTopData($BannerID, $CampaignID, $topCount, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, $TopData)
    {
        $sql = "select i.affiliateid, sum(all_imps_count) as count, sum(unique_imps_count) as unique_count". 
                   " from wd_pa_impressions i, wd_pa_banners b, wd_g_users as a".
                   " where i.bannerid=b.bannerid".
                   " and i.accountid="._q($AccountID).
                   " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql().
                   " and i.affiliateid = a.userid";
                   
        if($BannerID != '_' && $BannerID != '')
        {
            $sql .= " and i.bannerid="._q($BannerID);
        }
        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $sql .= " and (".sqlToDays('i.dateimpression')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    " and (".sqlToDays('i.dateimpression')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }
        if($CampaignID != '_' && $CampaignID != '')
        {
            $sql .= " and b.campaignid="._q($CampaignID);
        }

        $sql .= " group by affiliateid order by unique_count desc";

        if($topCount != '' && $topCount != '_')
        {
            $sql .= " LIMIT $topCount";
        }
		
		//echo $sql;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['userid'] = $rs->fields['affiliateid'];
            $temp['all'] = $rs->fields['count'];
            $temp['unique'] = $rs->fields['unique_count'];
            $TopData['imps'][] = $temp;

            $rs->MoveNext();
        }
        
        return $TopData;
    }
    
    //------------------------------------------------------------------------
    
    function getTransactionsTopData($CampaignID, $topCount, $d1,$m1,$y1, $d2,$m2,$y2, $AccountID, $TopData, $settings)
    {
        if($topCount == '' || $topCount == '_') {
            $topCount = 1000;
        }
        
        // build sql
        $sql = "select t.affiliateid, a.name, a.surname, ";
        $sqlTransType = "count(transid) as countt, t.transtype ";
        
        $where = " from wd_pa_transactions t, wd_g_users a, wd_pa_campaigncategories cc".
               " where t.campcategoryid=cc.campcategoryid ".
               " and t.affiliateid=a.userid and a.deleted=0 ".
               " and a.rtype="._q(USERTYPE_USER).
               " and a.rstatus="._q(AFFSTATUS_APPROVED).
               " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and t.rstatus<>".AFFSTATUS_SUPPRESSED.
               " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
        
        $where2 = '';

        if($d1 != '' && $m1 != '' && $y1 != '')
        {
            $where2 .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }
        if($CampaignID != '_' && $CampaignID != '')
        {
            $where2 .= " and cc.campaignid="._q($CampaignID);
        }

        $groupby = " group by t.affiliateid, a.name, a.surname, t.transtype order by countt desc";

        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        $allDone = true;
        while(!$rs->EOF)
        {
            $transType = $rs->fields['transtype'];
            
            if($transType == TRANSTYPE_CPM) {
                if(count($TopData['cpm']) < $topCount) {
                    $temp = array();
                    $temp['userid'] = $rs->fields['affiliateid'];
                    $temp['name'] = $rs->fields['name'];
                    $temp['surname'] = $rs->fields['surname'];
                    $temp['count'] = $rs->fields['countt'];
                    $TopData['cpm'][] = $temp;
                }
                
                if(count($TopData['cpm']) < $topCount) {
                    $allDone = false;
                }
            }
            
            if($transType == TRANSTYPE_CLICK) {
                if(count($TopData['click']) < $topCount) {
                    $temp = array();
                    $temp['userid'] = $rs->fields['affiliateid'];
                    $temp['name'] = $rs->fields['name'];
                    $temp['surname'] = $rs->fields['surname'];
                    $temp['count'] = $rs->fields['countt'];
                    $TopData['click'][] = $temp;
                }
                
                if(count($TopData['click']) < $topCount) {
                    $allDone = false;
                }
            }

            if($transType == TRANSTYPE_LEAD) {
                if(count($TopData['lead']) < $topCount) {
                    $temp = array();
                    $temp['userid'] = $rs->fields['affiliateid'];
                    $temp['name'] = $rs->fields['name'];
                    $temp['surname'] = $rs->fields['surname'];
                    $temp['count'] = $rs->fields['countt'];
                    $TopData['lead'][] = $temp;
                }
                
                if(count($TopData['lead']) < $topCount) {
                    $allDone = false;
                }
            }

            if($transType == TRANSTYPE_SALE) {
                if(count($TopData['sale']) < $topCount) {
                    $temp = array();
                    $temp['userid'] = $rs->fields['affiliateid'];
                    $temp['name'] = $rs->fields['name'];
                    $temp['surname'] = $rs->fields['surname'];
                    $temp['count'] = $rs->fields['countt'];
                    $TopData['sale'][] = $temp;
                }
                
                if(count($TopData['sale']) < $topCount) {
                    $allDone = false;
                }
            }

            if($allDone) break;
                
            $rs->MoveNext();
        }

        //------------------------------------------------
        // get revenues
        $sqlTransType = "sum(commission) as countt";
        
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
            
            if(count($allowedTransactions) > 0)
            {
                $where2 .= " and t.transtype in (".implode(',', $allowedTransactions).")";
            }
        }        
        $groupby = " group by t.affiliateid, a.name, a.surname order by countt desc";

        $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        $topUsers = array();
        while(!$rs->EOF)
        {
            $topUsers[$rs->fields['affiliateid']]['userid'] = $rs->fields['affiliateid'];
            $topUsers[$rs->fields['affiliateid']]['name'] = $rs->fields['name'];
            $topUsers[$rs->fields['affiliateid']]['surname'] = $rs->fields['surname'];
            $topUsers[$rs->fields['affiliateid']]['sum'] = _rnd($rs->fields['countt']);
            if(count($topUsers) > $topCount*5) break;
            
            $rs->MoveNext();
        }

        //------------------------------------------------
        // process non-campaign transactions in time range
        if($CampaignID == '_' || $CampaignID == '')
        {
            $where = " from wd_pa_transactions t, wd_g_users a".
                      " where (t.campcategoryid Is Null or t.campcategoryid='' or t.campcategoryid=0)".
                      " and t.affiliateid=a.userid and a.deleted=0 ".
                      " and a.rtype="._q(USERTYPE_USER).
                      " and a.rstatus="._q(AFFSTATUS_APPROVED).
                      " and t.accountid="._q($GLOBALS['Auth']->getAccountID()).
                      //" and t.transkind=".TRANSKIND_NORMAL.
                      " and t.rstatus<>".AFFSTATUS_SUPPRESSED.
                      " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
                      
            $rs = QCore_Sql_DBUnit::execute($sql.$sqlTransType.$where.$where2.$groupby, __FILE__, __LINE__);
            if (!$rs)
            return false;
            
            while(!$rs->EOF)
            {
                $topUsers[$rs->fields['affiliateid']]['userid'] = $rs->fields['affiliateid'];
                $topUsers[$rs->fields['affiliateid']]['name'] = $rs->fields['name'];
                $topUsers[$rs->fields['affiliateid']]['surname'] = $rs->fields['surname'];
                $topUsers[$rs->fields['affiliateid']]['sum'] += _rnd($rs->fields['countt']);
                
                if(count($topUsers) > $topCount*5) break;
                
                $rs->MoveNext();
            }
        }

        // sort top users by count
        $GLOBALS['uasort_by'] = 'sum';
        $GLOBALS['uasort_order'] = 'desc';

        uasort($topUsers, 'cmp_sort');
        reset($topUsers);
        
        while (list($key, $val) = each($topUsers)) {
            $temp = array();
            $temp['userid'] = $val['userid'];
            $temp['name'] = $val['name'];
            $temp['surname'] = $val['surname'];
            $temp['sum'] = $val['sum'];
            $TopData['revenue'][] = $temp;
            
            if(count($TopData['revenue']) >= $topCount) break;
        }

        return $TopData;
    }
    
    //------------------------------------------------------------------------

}
?>
