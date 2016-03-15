<?
//============================================================================
// Addition from Rapido Technologies 
//
// based on:
// Copyright (c) Maros Fric, webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Scripts_Bl_CommissionStatistics
{
    function getCommissionStats($AffiliateID, 
                               $CampaignID, 
                               $d1='',$m1='',$y1='',$d2='',$m2='',$y2='',
                               $AccountID='',
                               $settings='')
    {
        $filterByDate = true;
        $filterByCampaign = false;
        $filterByAffiliate = true;
        
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
        
        if($d1 == '' && $m1 == '' && $y1 == '')
        {
            $filterByDate = false;
        }
        if($AffiliateID == '' || $AffiliateID == '_')
        {
            $filterByAffiliate = false;
        }
        if($CampaignID == '' || $CampaignID == '_')
        {
            $filterByCampaign = false;
        }

        $fieldArrays = Affiliate_Scripts_Bl_CommissionStatistics::initFields();
        
        $UserData = Affiliate_Scripts_Bl_CommissionStatistics::initResults($fieldArrays, $UserData);
        
        //------------------------------------------------------------------------
        // get impressions in time range
        $sql = "select a.userid, sum(all_imps_count) as today_imps, sum(unique_imps_count) as today_unique_imps ".
               "from wd_pa_impressions i, wd_g_users a, wd_pa_banners b, wd_pa_campaigns c ".
               "where i.bannerid=b.bannerid and c.campaignid=b.campaignid and i.affiliateid=a.userid and a.deleted=0 and a.rstatus=".AFFSTATUS_APPROVED;
        if($filterByDate)
        {
            $sql .= " and (".sqlToDays('dateimpression')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    " and (".sqlToDays('dateimpression')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }
        if($filterByCampaign)
        {
            $sql .= " and c.campaignid="._q($CampaignID);
        }
        if($filterByAffiliate)
        {
            $sql .= " and a.userid="._q($AffiliateID);
        }
        if($AccountID != '') 
        {
            $sql .= " and i.accountid="._q($AccountID).
                    " and c.accountid="._q($AccountID).
                    " and a.accountid="._q($AccountID);
        }
        $sql .= " group by a.userid";
		//echo ("SQL: $sql");
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        while(!$rs->EOF)
        {
            $UserData['impressions'] += $rs->fields['today_imps'];
            
            $UserData['unique_impressions'] += $rs->fields['today_unique_imps'];
            
            $rs->MoveNext();
        }
        
        
        //------------------------------------------------------------------------
        // get transactions in time range
        $sql = "select a.userid, t.rstatus, t.transtype, t.transkind, count(transid) as today_count, t.payoutstatus, sum(t.commission) as revenue ".
               "from wd_pa_transactions t, wd_g_users a ".
               "where t.campcategoryid is not null".
               "  and t.affiliateid=a.userid and a.deleted=0".
               "  and a.rtype="._q(USERTYPE_USER).
               "  and a.rstatus="._q(AFFSTATUS_APPROVED);
        if($filterByDate)
        {
            $sql .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
        }
        //if($filterByCampaign)
        //{
        //    $sql .= " and c.campaignid=".myquotes($CampaignID);
        //}
        if($filterByAffiliate)
        {
            $sql .= " and a.userid="._q($AffiliateID);
        }
        if($AccountID != '')
        {
            $sql .= " and t.accountid="._q($AccountID).
                    " and a.accountid="._q($AccountID);
                    //" and c.accountid="._q($AccountID);
        }
        $sql .= " group by a.userid, t.rstatus, t.transtype, t.transkind, t.payoutstatus";
		//echo ("<br>SQL: $sql");
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        while(!$rs->EOF)
        {
            $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processRecords($UserData, $rs, $fieldArrays, $settings);
            
            $rs->MoveNext();
        }    
        
        if(!$filterByCampaign)
        {
            //------------------------------------------------------------------------
            // process non-campaign transactions in time range
            $sql = "select a.userid, t.rstatus, t.transtype, t.transkind, count(transid) as today_count, t.payoutstatus, sum(t.commission) as revenue ".
                "from wd_pa_transactions t, wd_g_users a ".
                "where (t.campcategoryid Is Null or t.campcategoryid='' or t.campcategoryid=0) ".
                "  and t.affiliateid=a.userid and a.deleted=0".
                "  and a.rtype="._q(USERTYPE_USER).
                "  and a.rstatus="._q(AFFSTATUS_APPROVED);
            if($filterByDate)
            {
                $sql .= " and (".sqlToDays('t.dateinserted')." >= ".sqlToDays("$y1-$m1-$d1").")".
                    " and (".sqlToDays('t.dateinserted')." <= ".sqlToDays("$y2-$m2-$d2").")";
            }
            if($filterByCampaign)
            {
                $sql .= " and c.campaignid=".myquotes($CampaignID);
            }
            if($filterByAffiliate)
            {
                $sql .= " and a.userid="._q($AffiliateID);
            }
            if($AccountID != '')
            {
                $sql .= " and t.accountid="._q($AccountID).
                    " and a.accountid="._q($AccountID);
            }
            $sql .= " group by a.userid, t.rstatus, t.transtype, t.transkind, t.payoutstatus";
			//echo ("<br>SQL: $sql");
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            while(!$rs->EOF)
            {
                $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processRecords($UserData, $rs, $fieldArrays, $settings);
                
                $rs->MoveNext();
            }    
        }

        unset($rs);
        
        //------------------------------------------------------------------------
        // compute clickthtough ratio
        if($UserData['impressions'] == 0)
        {
            $UserData['ratio'] = '0.0';
        }
        else
        {
            $UserData['ratio'] = _rnd(($UserData['clicks']/$UserData['impressions'])*100.0);
        }
        //------------------------------------------------------------------------
        // compute total Paid
        $UserData['total_paid'] = $UserData['revenue_paid'] + $UserData['bonuses_paid'];
        
		//------------------------------------------------------------------------
        // compute epc
        if($UserData['clicks'] == 0)
        {
            $UserData['epc'] = '0.00';
        }
        else
        {
            $UserData['epc'] = $UserData['revenue_paid']/$UserData['clicks'];
        }
        
        //------------------------------------------------------------------------
        // Combine Sales and Clicks for total clicks
        //$UserData['clicks'] = $UserData['clicks'] + $UserData['sales'];
        // REMOVED - to allow for separate clicks and sales
        
        //------------------------------------------------------------------------
        // round results
        $UserData = Affiliate_Scripts_Bl_CommissionStatistics::roundResults($fieldArrays, $UserData);
        
        return $UserData;
    }

    //------------------------------------------------------------------------

    function processRecords($UserData, $rs, $fieldArrays, $settings)
    {
        $rs->fields['today_count'] = $rs->fields['today_count'];
        
        if($rs->fields['transtype'] == TRANSTYPE_CLICK)
        {
            $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processNormalStats($fieldArrays['clicksFields'], $rs->fields, $UserData, $settings['Aff_support_click_commissions']);
        }
        else if($rs->fields['transtype'] == TRANSTYPE_SALE)
        {
            $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processNormalStats($fieldArrays['salesFields'], $rs->fields, $UserData, $settings['Aff_support_sale_commissions']);
        }
        else if($rs->fields['transtype'] == TRANSTYPE_LEAD)
        {
            $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processNormalStats($fieldArrays['leadsFields'], $rs->fields, $UserData, $settings['Aff_support_lead_commissions']);
        }
        else if($rs->fields['transtype'] == TRANSTYPE_RECURRING)
        {
            $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processNormalStats($fieldArrays['recurringFields'], $rs->fields, $UserData, $settings['Aff_support_recurring_commissions']);
        }
        else if($rs->fields['transtype'] == TRANSTYPE_CPM)
        {
            $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processNormalStats($fieldArrays['cpmFields'], $rs->fields, $UserData, $settings['Aff_support_cpm_commissions']);
        }
        else if($rs->fields['transtype'] == TRANSTYPE_SIGNUP)
        {
            $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processNormalStats($fieldArrays['signupFields'], $rs->fields, $UserData, $settings['Aff_support_signup_commissions']);
        }
        else if($rs->fields['transtype'] == TRANSTYPE_REFERRAL)
        {
            $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processNormalStats($fieldArrays['referralFields'], $rs->fields, $UserData, $settings['Aff_support_referral_commissions']);
        }
        else if($rs->fields['transtype'] == TRANSTYPE_BONUS)
        {
            $UserData = Affiliate_Scripts_Bl_CommissionStatistics::processNormalStats($fieldArrays['bonusFields'], $rs->fields, $UserData, $settings['Aff_support_sale_commissions']);
        }
        return $UserData;
    }
    
    //------------------------------------------------------------------------

    function initFields()
    {
        $fieldArrays = array();
        
        $fieldArrays['cpmFields'] = array(
            'normal' => 'cpm',
            'normal_waiting' => 'cpm_waitingapproval',
            'normal_approved' => 'cpm_approved',
            'normal_declined' => 'cpm_declined',
            'st' => 'st_cpm',
            'st_waiting' => 'st_cpm_waitingapproval',
            'st_approved' => 'st_cpm_approved',
            'st_declined' => 'st_cpm_declined',
            'revenue' => 'revenue_cpm',
            'revenue_paid' => 'revenue_cpm_paid',
            'revenue_waiting' => 'revenue_cpm_waitingapproval',
            'revenue_approved' => 'revenue_cpm_approved',
            'revenue_declined' => 'revenue_cpm_declined',
            'st_revenue' => 'st_revenue_cpm',
            'st_revenue_paid' => 'st_revenue_cpm_paid',
            'st_revenue_waiting' => 'st_revenue_cpm_waitingapproval',
            'st_revenue_approved' => 'st_revenue_cpm_approved',
            'st_revenue_declined' => 'st_revenue_cpm_declined',
        );

        $fieldArrays['clicksFields'] = array(
            'normal' => 'clicks',
            'normal_waiting' => 'clicks_waitingapproval',
            'normal_approved' => 'clicks_approved',
            'normal_declined' => 'clicks_declined',
            'st' => 'st_clicks',
            'st_waiting' => 'st_clicks_waitingapproval',
            'st_approved' => 'st_clicks_approved',
            'st_declined' => 'st_clicks_declined',
            'revenue' => 'revenue_clicks',
            'revenue_paid' => 'revenue_clicks_paid',
            'revenue_waiting' => 'revenue_clicks_waitingapproval',
            'revenue_approved' => 'revenue_clicks_approved',
            'revenue_declined' => 'revenue_clicks_declined',
            'st_revenue' => 'st_revenue_clicks',
            'st_revenue_paid' => 'st_revenue_clicks_paid',
            'st_revenue_waiting' => 'st_revenue_clicks_waitingapproval',
            'st_revenue_approved' => 'st_revenue_clicks_approved',
            'st_revenue_declined' => 'st_revenue_clicks_declined',
        );

        $fieldArrays['salesFields'] = array(
            'normal' => 'sales',
            'normal_waiting' => 'sales_waitingapproval',
            'normal_approved' => 'sales_approved',
            'normal_declined' => 'sales_declined',
            'st' => 'st_sales',
            'st_waiting' => 'st_sales_waitingapproval',
            'st_approved' => 'st_sales_approved',
            'st_declined' => 'st_sales_declined',
            'revenue' => 'revenue_sales',
            'revenue_paid' => 'revenue_sales_paid',
            'revenue_waiting' => 'revenue_sales_waitingapproval',
            'revenue_approved' => 'revenue_sales_approved',
            'revenue_declined' => 'revenue_sales_declined',
            'st_revenue' => 'st_revenue_sales',
            'st_revenue_paid' => 'st_revenue_sales_paid',
            'st_revenue_waiting' => 'st_revenue_sales_waitingapproval',
            'st_revenue_approved' => 'st_revenue_sales_approved',
            'st_revenue_declined' => 'st_revenue_sales_declined',
        );

        $fieldArrays['leadsFields'] = array(
            'normal' => 'leads',
            'normal_waiting' => 'leads_waitingapproval',
            'normal_approved' => 'leads_approved',
            'normal_declined' => 'leads_declined',
            'st' => 'st_leads',
            'st_waiting' => 'st_leads_waitingapproval',
            'st_approved' => 'st_leads_approved',
            'st_declined' => 'st_leads_declined',
            'revenue' => 'revenue_leads',
            'revenue_paid' => 'revenue_leads_paid',
            'revenue_waiting' => 'revenue_leads_waitingapproval',
            'revenue_approved' => 'revenue_leads_approved',
            'revenue_declined' => 'revenue_leads_declined',
            'st_revenue' => 'st_revenue_leads',
            'st_revenue_paid' => 'st_revenue_leads_paid',
            'st_revenue_waiting' => 'st_revenue_leads_waitingapproval',
            'st_revenue_approved' => 'st_revenue_leads_approved',
            'st_revenue_declined' => 'st_revenue_leads_declined',
        );

        $fieldArrays['recurringFields'] = array(
            'normal' => 'recurring',
            'normal_waiting' => 'recurring_waitingapproval',
            'normal_approved' => 'recurring_approved',
            'normal_declined' => 'recurring_declined',
            'st' => 'st_recurring',
            'st_waiting' => 'st_recurring_waitingapproval',
            'st_approved' => 'st_recurring_approved',
            'st_declined' => 'st_recurring_declined',
            'revenue' => 'revenue_recurring',
            'revenue_paid' => 'revenue_recurring_paid',
            'revenue_waiting' => 'revenue_recurring_waitingapproval',
            'revenue_approved' => 'revenue_recurring_approved',
            'revenue_declined' => 'revenue_recurring_declined',
            'st_revenue' => 'st_revenue_recurring',
            'st_revenue_paid' => 'st_revenue_recurring_paid',
            'st_revenue_waiting' => 'st_revenue_recurring_waitingapproval',
            'st_revenue_approved' => 'st_revenue_recurring_approved',
            'st_revenue_declined' => 'st_revenue_recurring_declined',
        );
        
        $fieldArrays['signupFields'] = array(
            'normal' => 'signup',
            'normal_waiting' => 'signup_waitingapproval',
            'normal_approved' => 'signup_approved',
            'normal_declined' => 'signup_declined',
            'st' => 'st_signup',
            'st_waiting' => 'st_signup_waitingapproval',
            'st_approved' => 'st_signup_approved',
            'st_declined' => 'st_signup_declined',
            'revenue' => 'revenue_signup',
            'revenue_paid' => 'revenue_signup_paid',
            'revenue_waiting' => 'revenue_signup_waitingapproval',
            'revenue_approved' => 'revenue_signup_approved',
            'revenue_declined' => 'revenue_signup_declined',
            'st_revenue' => 'st_revenue_signup',
            'st_revenue_paid' => 'st_revenue_signup_paid',
            'st_revenue_waiting' => 'st_revenue_signup_waitingapproval',
            'st_revenue_approved' => 'st_revenue_signup_approved',
            'st_revenue_declined' => 'st_revenue_signup_declined',
        );
        
        $fieldArrays['referralFields'] = array(
            'normal' => 'referral',
            'normal_waiting' => 'referral_waitingapproval',
            'normal_approved' => 'referral_approved',
            'normal_declined' => 'referral_declined',
            'st' => 'st_referral',
            'st_waiting' => 'st_referral_waitingapproval',
            'st_approved' => 'st_referral_approved',
            'st_declined' => 'st_referral_declined',
            'revenue' => 'revenue_referral',
            'revenue_paid' => 'revenue_referral_paid',
            'revenue_waiting' => 'revenue_referral_waitingapproval',
            'revenue_approved' => 'revenue_referral_approved',
            'revenue_declined' => 'revenue_referral_declined',
            'st_revenue' => 'st_revenue_referral',
            'st_revenue_paid' => 'st_revenue_referral_paid',
            'st_revenue_waiting' => 'st_revenue_referral_waitingapproval',
            'st_revenue_approved' => 'st_revenue_referral_approved',
            'st_revenue_declined' => 'st_revenue_referral_declined',
        );
        
        $fieldArrays['bonusFields'] = array(
            'normal' => 'bonuses',
            'normal_waiting' => 'bonuses_waitingapproval',
            'normal_approved' => 'bonuses_approved',
            'normal_declined' => 'bonuses_declined',
            'st' => 'st_sales',
            'st_waiting' => 'st_bonuses_waitingapproval',
            'st_approved' => 'st_bonuses_approved',
            'st_declined' => 'st_bonuses_declined',
            'revenue' => 'revenue_bonuses',
            'revenue_paid' => 'revenue_bonuses_paid',
            'revenue_waiting' => 'revenue_bonuses_waitingapproval',
            'revenue_approved' => 'revenue_bonuses_approved',
            'revenue_declined' => 'revenue_bonuses_declined',
            'st_revenue' => 'st_revenue_bonuses',
            'st_revenue_paid' => 'st_revenue_bonuses_paid',
            'st_revenue_waiting' => 'st_revenue_bonuses_waitingapproval',
            'st_revenue_approved' => 'st_revenue_bonuses_approved',
            'st_revenue_declined' => 'st_revenue_bonuses_declined',
        );
        
        $fieldArrays['otherFields'] = array(
            'normal' => 'bogus',
            'normal_waiting' => 'bogus',
            'normal_approved' => 'bogus',
            'normal_declined' => 'bogus',
            'st' => 'bogus',
            'st_waiting' => 'bogus',
            'st_approved' => 'bogus',
            'st_declined' => 'bogus',
            'revenue' => 'bogus',
            'revenue_paid' => 'bogus',
            'revenue_waiting' => 'bogus',
            'revenue_approved' => 'bogus',
            'revenue_declined' => 'bogus',
            'st_revenue' => 'bogus',
            'st_revenue_paid' => 'bogus',
            'st_revenue_waiting' => 'bogus',
            'st_revenue_approved' => 'bogus',
            'st_revenue_declined' => 'bogus',
        );
        
        return $fieldArrays;
    }
    
    //------------------------------------------------------------------------
    
    function initResults($fieldsArray, $UserData)
    {
        $UserData['impressions'] = 0;
        $UserData['unique_impressions'] = 0;
        $UserData['revenue_paid'] = 0;
        $UserData['revenue_approved'] = 0;
        $UserData['revenue_waitingapproval'] = 0;
        $UserData['revenue_declined'] = 0;
        $UserData['st_revenue_paid'] = 0;
        $UserData['st_revenue_approved'] = 0;
        $UserData['st_revenue_waitingapproval'] = 0;
        $UserData['st_revenue_declined'] = 0;
        
        foreach($fieldsArray as $k => $fields)
        {
            foreach($fields as $key)
            {
                $UserData[$key] = 0;
            }
        }
        
        return $UserData;
    }

    //------------------------------------------------------------------------
    
    function roundResults($fieldsArray, $UserData)
    {
        foreach($fieldsArray as $k => $fields)
        {
            foreach($fields as $key)
            {
                $UserData[$key] = _rnd($UserData[$key]);
            }
        }
        
        return $UserData;
    }
    
    //------------------------------------------------------------------------
    
    function processNormalStats($fields, $values, $UserData, $supportedType)
    {
        // normal tier
        if($values['transkind'] == TRANSKIND_NORMAL || $values['transkind'] == TRANSKIND_RECURRING)
        {
            // amounts
            $UserData[$fields['normal']] += $values['today_count'];
            //$UserData[$fields['normal']] += $values['today_count'];
            
            switch($values['rstatus'])
            {
                case AFFSTATUS_NOTAPPROVED: $UserData[$fields['normal_waiting']] += $values['today_count']; break;
                //case AFFSTATUS_NOTAPPROVED: $UserData[$fields['normal_approved']] += $values['today_count']; break;
                case AFFSTATUS_APPROVED: $UserData[$fields['normal_approved']] += $values['today_count']; break;
                case AFFSTATUS_SUPPRESSED: $UserData[$fields['normal_declined']] += $values['today_count']; break;
            }

            if($supportedType == 1)
            {
                // revenues
                $UserData[$fields['revenue']] += $values['revenue'];
                
                if($values['payoutstatus'] == AFFSTATUS_APPROVED)
                {
                    $UserData[$fields['revenue_paid']] += $values['revenue'];
                    // sum
                    $UserData['revenue_paid'] += $values['revenue'];
                }
                else if($values['rstatus'] == AFFSTATUS_NOTAPPROVED && $values['payoutstatus'] != AFFSTATUS_SUPPRESSED)
                {
                    $UserData[$fields['revenue_waiting']] += $values['revenue'];
                    // sum
                    $UserData['revenue_waitingapproval'] += $values['revenue'];
                }
                else if($values['rstatus'] == AFFSTATUS_APPROVED && $values['payoutstatus'] != AFFSTATUS_SUPPRESSED)
                {
                    $UserData[$fields['revenue_approved']] += $values['revenue'];
                    // sum
                    $UserData['revenue_approved'] += $values['revenue'];
                }
                else if($values['rstatus'] == AFFSTATUS_SUPPRESSED || $values['payoutstatus'] == AFFSTATUS_SUPPRESSED)
                {
                    $UserData[$fields['revenue_declined']] += $values['revenue'];
                    // sum
                    $UserData['revenue_declined'] += $values['revenue'];
                }
            }
        }

        // second tier
        else if($values['transkind'] > TRANSKIND_SECONDTIER)
        {
            // amounts
            $UserData[$fields['st']] += $values['today_count'];
            
            switch($values['rstatus'])
            {
                case AFFSTATUS_NOTAPPROVED: $UserData[$fields['st_waiting']] += $values['today_count']; break;
                case AFFSTATUS_APPROVED: $UserData[$fields['st_approved']] += $values['today_count']; break;
                case AFFSTATUS_SUPPRESSED: $UserData[$fields['st_declined']] += $values['today_count']; break;
            }
            
            if($supportedType == 1)
            {
                // revenues
                $UserData[$fields['st_revenue']] += $values['revenue'];
                
                if($values['payoutstatus'] == AFFSTATUS_APPROVED)
                {
                    $UserData[$fields['st_revenue_paid']] += $values['revenue'];
                    // sum
                    $UserData['st_revenue_paid'] += $values['revenue'];
                }
                else if($values['rstatus'] == AFFSTATUS_NOTAPPROVED && $values['payoutstatus'] != AFFSTATUS_SUPPRESSED)
                {
                    $UserData[$fields['st_revenue_waiting']] += $values['revenue'];
                    // sum
                    $UserData['st_revenue_waiting'] += $values['revenue'];
                }
                else if($values['rstatus'] == AFFSTATUS_APPROVED && $values['payoutstatus'] != AFFSTATUS_SUPPRESSED)
                {
                    $UserData[$fields['st_revenue_approved']] += $values['revenue'];
                    // sum
                    $UserData['st_revenue_approved'] += $values['revenue'];
                }
                else if($values['rstatus'] == AFFSTATUS_SUPPRESSED || $values['payoutstatus'] == AFFSTATUS_SUPPRESSED)
                {
                    $UserData[$fields['st_revenue_declined']] += $values['revenue'];
                    // sum
                    $UserData['st_revenue_declined'] += $values['revenue'];
                }
            }
        }

        return $UserData;
    }

    //------------------------------------------------------------------------

}

?>
