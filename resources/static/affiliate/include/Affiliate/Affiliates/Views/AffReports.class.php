<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_CommissionStatistics');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_PendingCommissionStatistics');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TimerangeStatistics');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TrendStatistics');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');
QUnit_Global::includeClass('QUnit_Graphics_HtmlGraph');

class Affiliate_Affiliates_Views_AffReports extends QUnit_UI_TemplatePage
{
    function process()
    {
        if($_REQUEST['reporttype'] == '')
            $_REQUEST['reporttype'] = 'quick';
            
        if(!empty($_REQUEST['reporttype']))
        {
            switch($_REQUEST['reporttype'])
            {
                case 'quick':
                    if($this->showReportQuick())
                        return;
                    break;              
                
                case 'transactions':
                    if($this->showReportTransactions())
                        return;
                    break;
                
                case 'traffic':
                    if($this->showReportTraffic())
                        return;
                    break; 
                    
                case 'trafficprocess':
                    if($this->showReportTraffic())
                        return;
                    break;         

                case 'subaffiliates':
                    if($this->drawTree())
                        return;
                    break;  
					
				case 'pending':
                    if($this->showReportPending())
                        return;
                    break;
					
				case 'paid':
                    if($this->showReportPaid())
                        return;
                    break;       
            }
        }
    }  

    //------------------------------------------------------------------------

    function showReportTraffic()
    {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rt_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rt_campaign'] == '') $_REQUEST['rt_campaign'] = '_';
        if($_REQUEST['rt_reporttype'] == '') $_REQUEST['rt_reporttype'] = 'permonth';
        if($_REQUEST['rt_pd_day'] == '') $_REQUEST['rt_pd_day'] = date("j");
        if($_REQUEST['rt_pd_month'] == '') $_REQUEST['rt_pd_month'] = date("n");
        if($_REQUEST['rt_pd_year'] == '') $_REQUEST['rt_pd_year'] = date("Y");
        if($_REQUEST['rt_pm_month'] == '') $_REQUEST['rt_pm_month'] = date("n");
        if($_REQUEST['rt_pm_year'] == '') $_REQUEST['rt_pm_year'] = date("Y");
        if($_REQUEST['rt_py_year'] == '') $_REQUEST['rt_py_year'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rt_campaign'] = $_REQUEST['rt_campaign'];
        $_SESSION['rt_reporttype'] = $_REQUEST['rt_reporttype'];
        $_SESSION['rt_pd_day'] = $_REQUEST['rt_pd_day'];
        $_SESSION['rt_pd_month'] = $_REQUEST['rt_pd_month'];
        $_SESSION['rt_pd_year'] = $_REQUEST['rt_pd_year'];
        $_SESSION['rt_pm_month'] = $_REQUEST['rt_pm_month'];
        $_SESSION['rt_pm_year'] = $_REQUEST['rt_pm_year'];
        $_SESSION['rt_py_year'] = $_REQUEST['rt_py_year'];

        QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_traffic_filter');
        
        if($_REQUEST['rt_reporttype'] == 'perday')
        {
            $reportType = 'hourly';
            $d1 = $_REQUEST['rt_pd_day'];
            $m1 = $_REQUEST['rt_pd_month'];
            $y1 = $_REQUEST['rt_pd_year'];
            $d2 = $_REQUEST['rt_pd_day'];
            $m2 = $_REQUEST['rt_pd_month'];
            $y2 = $_REQUEST['rt_pd_year'];
        }
        else if($_REQUEST['rt_reporttype'] == 'permonth')
        {
            $reportType = 'daily';
            $d1 = 1;
            $m1 = $_REQUEST['rt_pm_month'];
            $y1 = $_REQUEST['rt_pm_year'];
            $d2 = getDaysInMonth($_REQUEST['rt_pm_month'], $_REQUEST['rt_pm_year']);
            $m2 = $_REQUEST['rt_pm_month'];
            $y2 = $_REQUEST['rt_pm_year'];
        }
        else if($_REQUEST['rt_reporttype'] == 'peryear')
        {
            $reportType = 'monthly';
            $d1 = 1;
            $m1 = 1;
            $y1 = $_REQUEST['rt_py_year'];
            $d2 = 31;
            $m2 = 12;
            $y2 = $_REQUEST['rt_py_year'];
        } 
        // added
        else {
            $reportType = 'daily';
            $d1 = 1;
            $m1 = $_REQUEST['rt_pm_month'];
            $y1 = $_REQUEST['rt_pm_year'];
            $d2 = getDaysInMonth($_REQUEST['rt_pm_month'], $_REQUEST['rt_pm_year']);
            $m2 = $_REQUEST['rt_pm_month'];
            $y2 = $_REQUEST['rt_pm_year'];
        }
        
        
        $trend = Affiliate_Scripts_Bl_TrendStatistics::getTrendStats(
                                                     $GLOBALS['Auth']->getUserID(),
                                                     $_REQUEST['rt_campaign'],
                                                     $_REQUEST['rt_trackerId'],
                                                     $_REQUEST['rt_keywordId'],
                                                     $_REQUEST['rt_timeslotId'],
                                                     $_REQUEST['rt_pageId'],
                                                     $reportType,
                                                     $d1, $m1, $y1,
                                                     $d2, $m2, $y2
                                                     );
        // create graph
        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
        $graph->type = 'vBar';
        
        $labels = '';
        $valuesImps = '';
        $valuesCpm = '';
        $valuesClicks = '';
        $valuesSales = '';
        $valuesLeads = '';
        $valuesRevenue = '';
        
        if($reportType == 'hourly')
        {
            $periodMin = 0;
            $periodMax = 23;
            
            $this->assign('a_period', L_G_HOURS);
        }
        else if($reportType == 'daily')
        {
            $periodMin = 1;
            $periodMax = getDaysInMonth($_REQUEST['rt_pm_month'], $_REQUEST['rt_pm_year']);

            $this->assign('a_period', L_G_DAYS);
        }
        else if($reportType == 'monthly')
        {
            $periodMin = 1;
            $periodMax = 12;

            $this->assign('a_period', L_G_MONTHS);
        }

        for($i=$periodMin; $i<=$periodMax; $i++)
        {
            $labels .= ($labels != '' ? ',' : '').($reportType == 'monthly' ? constant($GLOBALS['wd_monthname'][$i]) : $i);
            
            $valuesImps .= ($valuesImps != '' ? ',' : '').$trend['imps'][$i]['unique'].';'.$trend['imps'][$i]['all'];
            $valuesCpm .= ($valuesCpm != '' ? ',' : '').$trend['cmp'][$i];
            $valuesClicks .= ($valuesClicks != '' ? ',' : '').$trend['clicks'][$i];
            $valuesSales .= ($valuesSales != '' ? ',' : '').$trend['sales'][$i];
            $valuesLeads .= ($valuesLeads != '' ? ',' : '').$trend['leads'][$i];
            $valuesRevenue .= ($valuesRevenue != '' ? ',' : '').$trend['revenue'][$i];
        }

        $legendImps = L_G_UNIQUEIMPRESSIONS.','.L_G_ALLIMPRESSIONS;
        
        $graph->labels = $labels;
        $graph->values = $valuesImps;
        $graph->legend = $legendImps;
        $graph->barColor = "#2C3C74,#B2BCCA";
        $graph->barBGColor = '';
        $graph->labelBGColor = '#E0E7EC';
        $graph->barLength = 1.7;
        $graph->barWidth = 25;
        $graph->percValuesSize = 10;
        $graph->absValuesSize = 10;
        $graph->showValues = 2;
        $gdata = $graph->create();
        $this->assign('a_impstrend_graph', $gdata);

        // cpm
        $graph->values = $valuesCpm;
        $graph->legend = '';
        $graph->barColor = "#2C3C74";
        $graph->showValues = 1;
        $gdata = $graph->create();
        $this->assign('a_cpmtrend_graph', $gdata);

        // clicks
        $graph->values = $valuesClicks;
        $gdata = $graph->create();
        $this->assign('a_clickstrend_graph', $gdata);
                                                    
        // sales
        $graph->values = $valuesSales;
        $gdata = $graph->create();
        $this->assign('a_salestrend_graph', $gdata);

        // leads
        $graph->values = $valuesLeads;
        $gdata = $graph->create();
        $this->assign('a_leadstrend_graph', $gdata);

        // revenue
        $graph->values = $valuesRevenue;
        $gdata = $graph->create();
        $this->assign('a_revenuetrend_graph', $gdata);

        $this->assign('a_periodMin', $periodMin);
        $this->assign('a_periodMax', $periodMax);
        $this->assign('a_reportType', $reportType);
        $this->assign('a_trendData', $trend);
        
        $this->setSupportedResults($_REQUEST['rt_campaign']);
        
        $this->addContent('rep_traffic_list');    }
    
    //------------------------------------------------------------------------
    
    function showReportTransactions()
    {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
            if($k == 'numrows' && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;                
        }

        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '_';
        if($_REQUEST['rq_transtype'] == '') $_REQUEST['rq_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
        if($_REQUEST['rq_status'] == '') $_REQUEST['rq_status'] = '_';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'thismonth';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['rq_campaign'] = $_REQUEST['rq_campaign'];
        $_SESSION['rq_transtype'] = $_REQUEST['rq_transtype'];
        $_SESSION['rq_status'] = $_REQUEST['rq_status'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];

        QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_trans_filter');
        
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);
        
        if($_REQUEST['rq_reporttype'] == 'timerange')
        {
            $d1 = $_REQUEST['rq_day1'];
            $m1 = $_REQUEST['rq_month1'];
            $y1 = $_REQUEST['rq_year1'];
            $d2 = $_REQUEST['rq_day2'];
            $m2 = $_REQUEST['rq_month2'];
            $y2 = $_REQUEST['rq_year2'];
        }
        else if($_REQUEST['rq_reporttype'] == 'today')
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");
        }
        else if($_REQUEST['rq_reporttype'] == 'thismonth')
        {
            $d1 = 1;
            $m1 = date("n");
            $y1 = date("Y");
            $m2 = date("n");
            $y2 = date("Y");
            $d2 = getDaysInMonth($m2, $y2);
        }
        else if($_REQUEST['rq_reporttype'] == 'thisweek')
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");

            $dayOfWeek = date("w");

            // compute beginning of week
            $beginOfWeek = (computeDateToDays(date("j"), date("n"), date("Y")) - ($dayOfWeek - 1));
            computeDaysToDate($beginOfWeek, $d1, $m1, $y1);
            
            // compute end of week
            $endOfWeek = (computeDateToDays(date("j"), date("n"), date("Y")) + (7 - $dayOfWeek));
            computeDaysToDate($endOfWeek, $d2, $m2, $y2);
        }
        
        if(empty($_REQUEST['list_page'])) 
            $page = 0;
        else 
            $page = $_REQUEST['list_page'];
        
        if($_REQUEST['rq_transtype'] != '') 
        {
            $transType = $_REQUEST['rq_transtype'];
        }
        
        if($_REQUEST['rq_status'] != '' && $_REQUEST['rq_status'] != '_')
            $status = $_REQUEST['rq_status'];
        else
            $status = '';
        
        $AffiliateID = $GLOBALS['Auth']->getUserID();

        $conditions = array(
                            'CampaignID' => $CampaignID,
                            'UserID' => $AffiliateID,
                            'TransactionType' => $transType,
                            'Status' => $status,
                            'page' => $page,
                            'rowsPerPage' => $_REQUEST['numrows'],
                            'day1' => $d1,
                            'month1' => $m1,
                            'year1' => $y1,
                            'day2' => $d2,
                            'month2' => $m2,
                            'year2' => $y2
                        );

        $transdata = Affiliate_Scripts_Bl_SaleStatistics::getTransactionsStats($conditions);
        $summaries = Affiliate_Scripts_Bl_SaleStatistics::getTransactionsSummaries($conditions);

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($transdata['transactions']);
        $this->assign('a_list_data', $list_data);

        if($AffiliateID != '')
        {
            $this->assign('a_summaries', $summaries[$AffiliateID]);
        }
        else
        {
            $summ = array();
            foreach($summaries as $aff => $summary)
            {
                $summ['paid'] += $summary['paid'];
                $summ['pending'] += $summary['pending'];
                $summ['approved'] += $summary['approved'];
                $summ['reversed'] += $summary['reversed'];
                $summ['totalcost'] += $summary['totalcost'];
            }

            $this->assign('a_summaries', $summ);
        }

        $this->pageLimitsAssign();

        $this->addContent('rep_trans_list');
    }
    
    //------------------------------------------------------------------------
    
    function showReportQuick()
    {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '_';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'today';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rq_campaign'] = $_REQUEST['rq_campaign'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];
        
        
        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_quick_filter');
        
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);
        
        if($_REQUEST['rq_reporttype'] == 'timerange')
        {
            $d1 = $_REQUEST['rq_day1'];
            $m1 = $_REQUEST['rq_month1'];
            $y1 = $_REQUEST['rq_year1'];
            $d2 = $_REQUEST['rq_day2'];
            $m2 = $_REQUEST['rq_month2'];
            $y2 = $_REQUEST['rq_year2'];
        }
        else if($_REQUEST['rq_reporttype'] == 'today')
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");
        }
        else if($_REQUEST['rq_reporttype'] == 'thismonth')
        {
            $d1 = 1;
            $m1 = date("n");
            $y1 = date("Y");
            $m2 = date("n");
            $y2 = date("Y");
            $d2 = getDaysInMonth($m2, $y2);
        }
        else if($_REQUEST['rq_reporttype'] == 'thisweek')
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");

            $dayOfWeek = date("w");

            // compute beginning of week
            $beginOfWeek = (computeDateToDays(date("j"), date("n"), date("Y")) - ($dayOfWeek - 1));
            computeDaysToDate($beginOfWeek, $d1, $m1, $y1);
            
            // compute end of week
            $endOfWeek = (computeDateToDays(date("j"), date("n"), date("Y")) + (7 - $dayOfWeek));
            computeDaysToDate($endOfWeek, $d2, $m2, $y2);
        }

        $data = Affiliate_Scripts_Bl_TimerangeStatistics::getTimerangeStats(
                        $GLOBALS['Auth']->getUserID(), $CampaignID, $d1, $m1, $y1, $d2, $m2, $y2, 
                        $GLOBALS['Auth']->getAccountID()
                        );
         
        $this->assign('a_data', $data);

        $this->setSupportedResults($CampaignID);
        
        $this->addContent('rep_quick_list');
    }  

    //------------------------------------------------------------------------
    
    function showReportPending()
    {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }
        $lastmonth = mktime(0, 0, 0, date("n")-1, date("d"),  date("Y"));
//        //--------------------------------------
//        // get default settings for unset variables
//        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '_';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'compareMonths';
//        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
//        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
//        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
//        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j",$lastmonth);
//        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n",$lastmonth);
//        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y",$lastmonth);
//        
//        //--------------------------------------
//        // put settings into session
//        $_SESSION['rq_campaign'] = $_REQUEST['rq_campaign'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
//        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
//        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
//        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
//        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
//        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
//        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];
//        
//        //ADDED LABELS
        $_SESSION['pmonthLabel'] = date("F", $lastmonth);
        $_SESSION['cmonthLabel'] = date("F");
        
        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $this->assign('a_curyear', date("Y"));

        //$this->addContent('rep_pending_filter');
        
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);
        
        if($_REQUEST['rq_reporttype'] == 'compareMonths')
        {
            $d1 = 1;
            $m1 = date("n");
            $y1 = date("Y");
            $m2 = date("n");
            $y2 = date("Y");
            $d2 = getDaysInMonth($m2, $y2);
            $pd1 = 1;
            $pm1 = date("n",$lastmonth);
            $py1 = date("Y",$lastmonth);
            $pm2 = date("n",$lastmonth);
            $py2 = date("Y",$lastmonth);
            $pd2 = getDaysInMonth($pm2, $py2);
        }
		

        $adata = Affiliate_Scripts_Bl_PendingCommissionStatistics::getPendingCommissionStats(
                        $GLOBALS['Auth']->getUserID(), $CampaignID, $d1, $m1, $y1, $d2, $m2, $y2, 
                        $GLOBALS['Auth']->getAccountID()
                        );
         
        $this->assign('a_data', $adata);
        
        $bdata = Affiliate_Scripts_Bl_PendingCommissionStatistics::getPendingCommissionStats(
                        $GLOBALS['Auth']->getUserID(), $CampaignID, $pd1, $pm1, $py1, $pd2, $pm2, $py2, 
                        $GLOBALS['Auth']->getAccountID()
                        );
         
        $this->assign('b_data', $bdata);

        $this->setSupportedResults($CampaignID);
        
        $this->addContent('rep_pending_list');
    }    
	
	//------------------------------------------------------------------------
    
    function showReportPaid()
    {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rq_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '_';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'thismonth';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rq_campaign'] = $_REQUEST['rq_campaign'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];
        
        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_paid_filter');
        
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['rq_campaign']);
        
        if($_REQUEST['rq_reporttype'] == 'timerange')
        {
            $d1 = $_REQUEST['rq_day1'];
            $m1 = $_REQUEST['rq_month1'];
            $y1 = $_REQUEST['rq_year1'];
            $d2 = $_REQUEST['rq_day2'];
            $m2 = $_REQUEST['rq_month2'];
            $y2 = $_REQUEST['rq_year2'];
        }
        else if($_REQUEST['rq_reporttype'] == 'today')
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");
        }
        else if($_REQUEST['rq_reporttype'] == 'thismonth')
        {
            $d1 = 1;
            $m1 = date("n");
            $y1 = date("Y");
            $m2 = date("n");
            $y2 = date("Y");
            $d2 = getDaysInMonth($m2, $y2);
        }
		else if($_REQUEST['rq_reporttype'] == 'permonth')
        {
            //$reportType = 'daily';
            $d1 = 1;
            $m1 = $_REQUEST['rq_month1'];
            $y1 = $_REQUEST['rq_year1'];
            $d2 = getDaysInMonth($_REQUEST['rq_month1'], $_REQUEST['rq_year1']);
            $m2 = $_REQUEST['rq_month1'];
            $y2 = $_REQUEST['rq_year1'];
        }
        else if($_REQUEST['rq_reporttype'] == 'thisweek')
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");

            $dayOfWeek = date("w");

            // compute beginning of week
            $beginOfWeek = (computeDateToDays(date("j"), date("n"), date("Y")) - ($dayOfWeek - 1));
            computeDaysToDate($beginOfWeek, $d1, $m1, $y1);
            
            // compute end of week
            $endOfWeek = (computeDateToDays(date("j"), date("n"), date("Y")) + (7 - $dayOfWeek));
            computeDaysToDate($endOfWeek, $d2, $m2, $y2);
        }

        $data = Affiliate_Scripts_Bl_CommissionStatistics::getCommissionStats(
                        $GLOBALS['Auth']->getUserID(), $CampaignID, $d1, $m1, $y1, $d2, $m2, $y2, 
                        $GLOBALS['Auth']->getAccountID()
                        );
         
        $this->assign('a_data', $data);

        $this->setSupportedResults($CampaignID);
        
        $this->addContent('rep_paid_list');
    }  

	//------------------------------------------------------------------------
    
    function drawTree()
    {
      $userTree = array();
      
      // put this affiliate as a root of the tree
      $sql = 'select * from wd_g_users '.
            'where userid='._q($GLOBALS['Auth']->getUserID()).
            '  and rtype='._q(USERTYPE_USER).
            '  and accountid='._q($GLOBALS['Auth']->getAccountID());
      $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
      if (!$rs || $rs->EOF)
      {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return;
      }
      
      $temp = array();
      $temp['userid'] = $rs->fields['userid'];
      $temp['username'] = $rs->fields['username'];
      $temp['name'] = $rs->fields['name'];
      $temp['surname'] = $rs->fields['surname'];
      $temp['tab'] = $tab;
        
      $userTree[] = $temp;

      $levels = $GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels');
      if($levels == '' || $levels <= 1)
        $levels = 1;
      else
        $levels -= 1;

      // display only one level of affiliates, as we have only 2 tier program
      QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
      
      Affiliate_Merchants_Bl_Affiliate::getTreeOfUsers($GLOBALS['Auth']->getUserID(), $userTree, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $levels);
      
      $list_data = QUnit_Global::newobj('QCore_RecordSet');
      $list_data->setTemplateRS($userTree);
      $this->assign('a_list_data', $list_data);

      $this->addContent('am_tree');
      
      return true;
    }

    //------------------------------------------------------------------------

    function setSupportedResults($campaign)
    {
        // get supported results
        $signupSupported = false;
        $referralSupported = false;
        $clickSupported = false;
        $clickRevenueSupported = false;
        $cpmSupported = false;
        $saleSupported = false;
        $leadSupported = false;
        
        $campaignUsed = false;
        if($campaign != '' && $campaign != '_')
        {
            // check if this campaign supports CPM
            $campaignInfo = Affiliate_Merchants_Bl_Campaign::load($campaign);
            $campaignUsed = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_signup_commissions') == 1 && !$campaignUsed)
        {
            $signupSupported = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_referral_commissions') == 1 && !$campaignUsed)
        {
            $referralSupported = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_CLICK))
            {
                $clickSupported = true;
            }
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_CLICK))
            {
                $clickSupported = true;
            }
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_CPM))
            {
                $cpmSupported = true;
            }
        }
        
        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_SALE))
            {
                $saleSupported = true;
            }
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1)
        {
            // no campaign defined, set supported transaction types
            if(!$campaignUsed || ($campaignUsed && $campaignInfo['commtype'] & TRANSTYPE_LEAD))
            {
                $leadSupported = true;
            }
        }

        $this->assign('a_signupSupported', $signupSupported);
        $this->assign('a_referralSupported', $referralSupported);
        $this->assign('a_clickSupported', $clickSupported);
        $this->assign('a_clickRevenueSupported', $clickRevenueSupported);
        $this->assign('a_cpmSupported', $cpmSupported);
        $this->assign('a_saleSupported', $saleSupported);
        $this->assign('a_leadSupported', $leadSupported);
    }
    
    //------------------------------------------------------------------------

}
?>
