<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Tracker');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Timeslot');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Page');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Keyword');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TimerangeStatistics');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TrendStatistics');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TopAffiliateStatistics');
QUnit_Global::includeClass('QUnit_Graphics_HtmlGraph');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Campaign');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_AffiliateGroups');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CampaignCategoryGroups');

class Affiliate_Merchants_Views_MerchantReports extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['quick'] = 'aff_rep_quick_report_view';
        $this->modulePermissions['transactions'] = 'aff_rep_transactions_view';
        $this->modulePermissions['traffic'] = 'aff_rep_traffic_and_sales_view';
        $this->modulePermissions['top20affiliates'] = 'aff_rep_top_20_affiliates_view';
        $this->modulePermissions['affiliatecounts'] = 'aff_rep_number_of_affiliates_view';
        $this->modulePermissions['view'] = 'aff_rep_quick_report_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if($_REQUEST['action'] == "viewSQL"){
        	$this->showSQL();
        	return;
        }        
        
        
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
                
                case 'top20affiliates':
                    if($this->showReportTop20Aff())
                        return;
                    break;
                
                case 'affiliatecounts':
                    if($this->showAffCounts())
                        return;
                    break;
                case 'aquick':
                	if($this->showAffCounts())
						return;
                	break;
                case 'atransactions':
                    if($this->showAReportTransactions())
                        return;
                    break;
                
                case 'atraffic':
                    if($this->showAReportTraffic())
                        return;
                    break;
                
                case 'atop20affiliates':
                    if($this->showReportTop20Aff())
                        return;
                    break;
                
                case 'aaffiliatecounts':
                    if($this->showAAffCounts())
                        return;
                    break;              
            }
        }
        

    }  

    //------------------------------------------------------------------------

    function showAffCounts()
    {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rac_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rac_py_year'] == '') 
        	$_REQUEST['rac_py_year'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rac_py_year'] = $_REQUEST['rac_py_year'];
        
        $this->assign('a_curyear', date("Y"));
		$this->addContent('rep_affcounts_filter');

        if ($_REQUEST['commited'] == 'yes'){
			
	        $this->getAffiliateCounts($_REQUEST['rac_py_year'], $signedCounts, $allCounts);
	
	        for($i=1; $i<=12; $i++)
	        {
	            $labels .= ($labels != '' ? ',' : '').constant($GLOBALS['wd_monthname'][$i]);
	            $values .= ($values != '' ? ',' : '').$allCounts['data'][$i].';'.$signedCounts['data'][$i];
	        }
	        
	        // make graphs
	        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
	        $graph->type = 'vBar';
	        $graph->labels = $labels;
	        $graph->values = $values;
	        $graph->legend = L_G_ALLINMONTH.','.L_G_SIGNEDINMONTH;
	        $graph->barColor = "#486B8F,#AEC4D2";
	        $graph->barBGColor = '';
	        $graph->labelBGColor = '#E0E0E0';
	        $graph->barLength = 2.7;
	        $graph->barWidth = 15;
	        $graph->percValuesSize = 10;
	        $graph->absValuesSize = 10;
	        $graph->showValues = 2;
	        $gdata = $graph->create();
	        $this->assign('a_aff_graph', $gdata);
	        
	        $this->addContent('rep_affcounts_list');
        }
    }
    
     //------------------------------------------------------------------------

    function showAAffCounts()
    {      	
        if(!isset($_REQUEST['commited']))
        	$this->addContent('rep_a_affcounts_filter');
        
		else if($_REQUEST['commited'] == 'yes'){
        	$this->getAAffiliateCounts($signedCounts, $allCounts);
	   		for($i=1; $i<=12; $i++)
	    	{
	       		$labels .= ($labels != '' ? ',' : '').constant($GLOBALS['wd_monthname'][$i]);
	       		$values .= ($values != '' ? ',' : '').$allCounts['data'][$i].';'.$signedCounts['data'][$i];
	    	}
	        
	        // make graphs
	        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
	        $graph->type = 'vBar';
	        $graph->labels = $labels;
	        $graph->values = $values;
	        $graph->legend = L_G_ALLINMONTH.','.L_G_SIGNEDINMONTH;
	        $graph->barColor = "#486B8F,#AEC4D2";
	        $graph->barBGColor = '';
	        $graph->labelBGColor = '#E0E0E0';
	        $graph->barLength = 2.7;
	        $graph->barWidth = 15;
	        $graph->percValuesSize = 10;
	        $graph->absValuesSize = 10;
	        $graph->showValues = 2;
	        $gdata = $graph->create();
	        
	        $this->assign('a_aff_graph', $gdata);
	        $this->addContent('rep_affcounts_list');
    	}
    }

    //------------------------------------------------------------------------
    
    function getAffiliateCounts($py_year, &$signedCounts, &$allCounts)
    {
        $maxY = 0;
        $rs = null;
        $signedCounts = array();
        $signedCounts['data'] = null;
        
        $allCounts = array();
        $allCounts['data'] = null;
        
        // get number of affiliates before this period
        $sql = "select count(*) as count". 
               " from wd_g_users where accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and rtype="._q(USERTYPE_USER).
               " and deleted=0".
               " and rstatus<>"._q(AFFSTATUS_SUPPRESSED).
               " and YEAR(dateinserted)<$py_year".
               " and userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;

        $allAffiliatesBefore = $rs->fields['count'];
        
        $sql = "select MONTH(dateinserted) as period, count(*) as count". 
               " from wd_g_users".
               " where YEAR(dateinserted)=$py_year".
               " and rtype="._q(USERTYPE_USER).
               " and deleted=0".               
               " and rstatus<>"._q(AFFSTATUS_SUPPRESSED).
               " and accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
               " group by MONTH(dateinserted)";
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        $all = array();
        $signed = array();

        if($rs == null)
            return null;
        
        for($i=1; $i<=12; $i++)
        {
            $all[$i] = $allAffiliatesBefore;
            $signed[$i] = 0;
        }
        
        while(!$rs->EOF)
        {
            $signed[$rs->fields['period']] = $rs->fields['count'];
            $rs->MoveNext();
        }
        
        // compute all affiliates in current month
        $signedUntil = 0;
        $currentYear = date("Y");
        $currentMonth = date("n");

        for($i=1; $i<=12; $i++)
        {
            if($currentYear == $py_year && $currentMonth < $i)
                $all[$i] = 0;
            else
            {
                $signedUntil += $signed[$i];
            
                $all[$i] += $signedUntil;
            }
        }

        $maxY = $signedUntil + $allAffiliatesBefore;
        
        $signedCounts['data'] = $signed;
        $allCounts['data'] = $all;
        
        //return $graph_data;
    }
    
    //------------------------------------------------------------------------
    
    function getAAffiliateCounts(&$signedCounts, &$allCounts)
    {
        $maxY = 0;
        $rs = null;
        $signedCounts = array();
        $signedCounts['data'] = null;
        
        $allCounts = array();
        $allCounts['data'] = null;
        
        // get number of affiliates before this period
        $sql = "select count(*) as count". 
               " from all_transactions where accountid="._q($GLOBALS['Auth']->getAccountID()).
               " and rtype="._q(USERTYPE_USER).
               " and deleted=0".
               " and rstatus<>"._q(AFFSTATUS_SUPPRESSED).
               " and YEAR(dateinserted)<" . date('Y');
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;

        $allAffiliatesBefore = $rs->fields['count'];
        
        $sql = "select MONTH(dateinserted) as period, count(*) as count". 
               " from wd_g_users".
               " where YEAR(dateinserted)= '2006'".
               " and rtype="._q(USERTYPE_USER).
               " and deleted=0".               
               " and rstatus<>"._q(AFFSTATUS_SUPPRESSED).
               " and accountid="._q($GLOBALS['Auth']->getAccountID()).
               " group by MONTH(dateinserted)";
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        $all = array();
        $signed = array();

        if($rs == null)
            return null;
        
        for($i=1; $i<=12; $i++)
        {
            $all[$i] = $allAffiliatesBefore;
            $signed[$i] = 0;
        }
        
        while(!$rs->EOF)
        {
            $signed[$rs->fields['period']] = $rs->fields['count'];
            $rs->MoveNext();
        }
        
        // compute all affiliates in current month
        $signedUntil = 0;
        $currentYear = date("Y");
        $currentMonth = date("n");

        for($i=1; $i<=12; $i++)
        {
            if($currentYear == 2006 && $currentMonth < $i)
                $all[$i] = 0;
            else
            {
                $signedUntil += $signed[$i];
            
                $all[$i] += $signedUntil;
            }
        }

        $maxY = $signedUntil + $allAffiliatesBefore;
        
        $signedCounts['data'] = $signed;
        $allCounts['data'] = $all;
    }
    
    //------------------------------------------------------------------------
    
    function showReportTop20Aff()
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
        if($_REQUEST['rt_reporttype'] == '') $_REQUEST['rt_reporttype'] = 'perday';
        if($_REQUEST['rt_pd_day'] == '') $_REQUEST['rt_pd_day'] = date("j");
        if($_REQUEST['rt_pd_month'] == '') $_REQUEST['rt_pd_month'] = date("n");
        if($_REQUEST['rt_pd_year'] == '') $_REQUEST['rt_pd_year'] = date("Y");
        if($_REQUEST['rt_pm_month'] == '') $_REQUEST['rt_pm_month'] = date("n");
        if($_REQUEST['rt_pm_year'] == '') $_REQUEST['rt_pm_year'] = date("Y");
        if($_REQUEST['rt_py_year'] == '') $_REQUEST['rt_py_year'] = date("Y");
        if($_REQUEST['rt_topcount'] == '') $_REQUEST['rt_topcount'] = 20;
        
        
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
        $_SESSION['rt_topcount'] = $_REQUEST['rt_topcount'];
        
        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_top20aff_filter');
        if ($_REQUEST['commited'] == 'yes'){
	        if($_REQUEST['rt_reporttype'] == 'perday')
	        {
	            $d1 = $_REQUEST['rt_pd_day'];
	            $m1 = $_REQUEST['rt_pd_month'];
	            $y1 = $_REQUEST['rt_pd_year'];
	            $d2 = $d1;
	            $m2 = $m1;
	            $y2 = $y1;
	        }
	        else if($_REQUEST['rt_reporttype'] == 'permonth')
	        {
	            $d1 = 1;
	            $m1 = $_REQUEST['rt_pm_month'];
	            $y1 = $_REQUEST['rt_pm_year'];
	            $d2 = getDaysInMonth($m1, $y1);
	            $m2 = $m1;
	            $y2 = $y1;
	        }
	        else // per year
	        {
	            $d1 = 1;
	            $m1 = 1;
	            $y1 = $_REQUEST['rt_py_year'];
	            $d2 = 12;
	            $m2 = 12;
	            $y2 = $y1;
	        }
	        
	        $data = Affiliate_Scripts_Bl_TopAffiliateStatistics::getTopAffStats($_REQUEST['rt_campaign'],
	                                                                            $_REQUEST['rt_topcount'],
	                                                                            $d1, $m1, $y1, $d2, $m2, $y2
	                                                                           );
	
	        // prepare data
	        $labelsImps = '';
	        $valuesImps = '';
	        $labelsCpm = '';
	        $valuesCpm = '';
	        $labelsClick = '';
	        $valuesClick = '';
	        $labelsSale = '';
	        $valuesSale = '';
	        $labelsLead = '';
	        $valuesLead = '';
	        $labelsRev = '';
	        $valuesRev = '';
	        
	        foreach($data['imps'] as $rec) {
	            $labelsImps .= ($labelsImps != '' ? ',' : '').$rec['userid'].': '.$rec['name'].' '.$rec['surname'];
	            $valuesImps .= ($valuesImps != '' ? ',' : '').$rec['unique'].';'.$rec['all'];
	        }
	        for($i=count($data['imps']); $i<10; $i++) {
	            $labelsImps .= ($labelsImps != '' ? ',-' : '-');
	            $valuesImps .= ($valuesImps != '' ? ',0' : '0');
	        }
	        
	        foreach($data['cpm'] as $rec) {
	            $labelsCpm .= ($labelsCpm != '' ? ',' : '').$rec['userid'].': '.$rec['name'].' '.$rec['surname'];
	            $valuesCpm .= ($valuesCpm != '' ? ',' : '').$rec['count'];
	        }
	        for($i=count($data['cpm']); $i<10; $i++) {
	            $labelsCpm .= ($labelsCpm != '' ? ',-' : '-');
	            $valuesCpm .= ($valuesCpm != '' ? ',0' : '0');
	        }
	        
	        foreach($data['click'] as $rec) {
	            $labelsClick .= ($labelsClick != '' ? ',' : '').$rec['userid'].': '.$rec['name'].' '.$rec['surname'];
	            $valuesClick .= ($valuesClick != '' ? ',' : '').$rec['count'];
	        }
	        for($i=count($data['click']); $i<10; $i++) {
	            $labelsClick .= ($labelsClick != '' ? ',-' : '-');
	            $valuesClick .= ($valuesClick != '' ? ',0' : '0');
	        }
	        
	        foreach($data['sale'] as $rec) {
	            $labelsSale .= ($labelsSale != '' ? ',' : '').$rec['userid'].': '.$rec['name'].' '.$rec['surname'];
	            $valuesSale .= ($valuesSale != '' ? ',' : '').$rec['count'];
	        }
	        for($i=count($data['sale']); $i<10; $i++) {
	            $labelsSale .= ($labelsSale != '' ? ',-' : '-');
	            $valuesSale .= ($valuesSale != '' ? ',0' : '0');
	        }
	        
	        foreach($data['lead'] as $rec) {
	            $labelsLead .= ($labelsLead != '' ? ',' : '').$rec['userid'].': '.$rec['name'].' '.$rec['surname'];
	            $valuesLead .= ($valuesLead != '' ? ',' : '').$rec['count'];
	        }
	        for($i=count($data['lead']); $i<10; $i++) {
	            $labelsLead .= ($labelsLead != '' ? ',-' : '-');
	            $valuesLead .= ($valuesLead != '' ? ',0' : '0');
	        }
	        
	        foreach($data['revenue'] as $rec) {
	            $labelsRev .= ($labelsRev != '' ? ',' : '').$rec['userid'].': '.$rec['name'].' '.$rec['surname'];
	            $valuesRev .= ($valuesRev != '' ? ',' : '').$rec['sum'];
	        }
	        for($i=count($data['revenue']); $i<10; $i++) {
	            $labelsRev .= ($labelsRev != '' ? ',-' : '-');
	            $valuesRev .= ($valuesRev != '' ? ',0' : '0');
	        }
	
	        // make graphs
	        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
	        $graph->type = 'hBar';
	        $graph->labels = $labelsImps;
	        $graph->values = $valuesImps;
	        $graph->legend = L_G_UNIQUEIMPRESSIONS.','.L_G_ALLIMPRESSIONS;
	        $graph->barColor = "#486B8F,#AEC4D2";
	        $graph->barBGColor = '';
	        $graph->labelBGColor = '#E0E0E0';
	        $graph->barLength = 3.7;
	        $graph->barWidth = 15;
	        $graph->percValuesSize = 10;
	        $graph->absValuesSize = 10;
	        $graph->showValues = 2;
	        $gdata = $graph->create();
	        $this->assign('a_impstop_graph', $gdata);
	        
	        $graph->labels = $labelsCpm;
	        $graph->values = $valuesCpm;
	        $graph->legend = '';
	        $graph->showValues = 1;        
	        $graph->barColor = "#486B8F";
	        $gdata = $graph->create();
	        $this->assign('a_cpmtop_graph', $gdata);
	        
	        $graph->labels = $labelsClick;
	        $graph->values = $valuesClick;
	        $gdata = $graph->create();
	        $this->assign('a_clickstop_graph', $gdata);
	
	        $graph->labels = $labelsSale;
	        $graph->values = $valuesSale;
	        $gdata = $graph->create();
	        $this->assign('a_salestop_graph', $gdata);
	
	        $graph->labels = $labelsLead;
	        $graph->values = $valuesLead;
	        $gdata = $graph->create();
	        $this->assign('a_leadstop_graph', $gdata);
	
	        $graph->labels = $labelsRev;
	        $graph->values = $valuesRev;
	        $gdata = $graph->create();
	        $this->assign('a_revenuetop_graph', $gdata);
	
	        $this->setSupportedResults($_REQUEST['rt_campaign']);
	        
	        $this->addContent('rep_top20aff_list');
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
        
        ob_start();
        
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rt_affiliategroup'] == '') $_REQUEST['rt_affiliategroup'] = '_';
        if($_REQUEST['rt_affiliate'] == '') $_REQUEST['rt_affiliate'] = '_';
		if($_REQUEST['rt_campaign'] == '') $_REQUEST['rt_campaign'] = '_';
		if($_REQUEST['rt_campaigntype'] == '') $_REQUEST['rt_campaigntype'] = '_';
        if($_REQUEST['rt_trackerId'] == '') $_REQUEST['rt_trackerId'] = '_';
        if($_REQUEST['rt_timeslotId'] == '') $_REQUEST['rt_timeslotId'] = '_';
        if($_REQUEST['rt_pageId'] == '') $_REQUEST['rt_pageId'] = '_';
        //if($_REQUEST['rt_keywordId'] == '') $_REQUEST['rt_keywordId'] = '_';
        
        //if($_REQUEST['rt_campaign'] == '') $_REQUEST['rt_campaign'] = '_';
        if($_REQUEST['rt_reporttype'] == '') $_REQUEST['rt_reporttype'] = 'hourlyperday';
        if($_REQUEST['rt_ptm_day'] == '') $_REQUEST['rt_ptm_day'] = date("j");
        if($_REQUEST['rt_ptm_month'] == '') $_REQUEST['rt_ptm_month'] = date("n");
        if($_REQUEST['rt_ptm_year'] == '') $_REQUEST['rt_ptm_year'] = date("Y");
        if($_REQUEST['rt_pd_day'] == '') $_REQUEST['rt_pd_day'] = date("j");
        if($_REQUEST['rt_pd_month'] == '') $_REQUEST['rt_pd_month'] = date("n");
        if($_REQUEST['rt_pd_year'] == '') $_REQUEST['rt_pd_year'] = date("Y");
        if($_REQUEST['rt_pm_month'] == '') $_REQUEST['rt_pm_month'] = date("n");
        if($_REQUEST['rt_pm_year'] == '') $_REQUEST['rt_pm_year'] = date("Y");
        if($_REQUEST['rt_py_year'] == '') $_REQUEST['rt_py_year'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rt_affiliate'] = $_REQUEST['rt_affiliate'];
        $_SESSION['rt_affiliategroup'] = $_REQUEST['rt_affiliategroup'];
		$_SESSION['rt_campaign'] = $_REQUEST['rt_campaign'];
		$_SESSION['rt_campaigntype'] = $_REQUEST['rt_campaigntype'];
        $_SESSION['rt_trackerId'] = $_REQUEST['rt_trackerId'];
        $_SESSION['rt_pageId'] = $_REQUEST['rt_pageId'];
        $_SESSION['rt_timeslotId'] = $_REQUEST['rt_timeslotId'];
        //$_SESSION['rt_keywordId'] = $_REQUEST['rt_keywordId'];
        
        $_SESSION['rt_reporttype'] = $_REQUEST['rt_reporttype'];
        $_SESSION['rt_ptm_day'] = $_REQUEST['rt_ptm_day'];
        $_SESSION['rt_ptm_month'] = $_REQUEST['rt_ptm_month'];
        $_SESSION['rt_ptm_year'] = $_REQUEST['rt_ptm_year'];
        $_SESSION['rt_pd_day'] = $_REQUEST['rt_pd_day'];
        $_SESSION['rt_pd_month'] = $_REQUEST['rt_pd_month'];
        $_SESSION['rt_pd_year'] = $_REQUEST['rt_pd_year'];
        $_SESSION['rt_pm_month'] = $_REQUEST['rt_pm_month'];
        $_SESSION['rt_pm_year'] = $_REQUEST['rt_pm_year'];
        $_SESSION['rt_py_year'] = $_REQUEST['rt_py_year'];

        QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray(true);
        $affiliates = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($affiliates);
        $this->assign('a_list_data2', $list_data2);
        
        //get affiliate groups
		
		$affiliategroups = Affiliate_Merchants_Bl_AffiliateGroups::getGroupsAsArray();
		$list_data3 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data3->setTemplateRS($affiliategroups);
        $this->assign('a_list_data3', $list_data3);
		
		//get product category types
		
		$camptypes = Affiliate_Merchants_Bl_CampaignCategoryGroups::getGroupsAsArray();
		$list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($camptypes);
        $this->assign('a_list_data4', $list_data4);
		
		$cids = Affiliate_Merchants_Bl_Tracker::getTrackersAsArray();
        $list_data3 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data3->setTemplateRS($cids);
        $this->assign('cid_list_data1', $list_data3);
        
        /*$dids = Affiliate_Merchants_Bl_Keyword::getKeywordsAsArray();
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($dids);
        $this->assign('did_list_data1', $list_data4);
        */
        $eids = Affiliate_Merchants_Bl_Timeslot::getTimeslotsAsArray();
        $list_data5 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data5->setTemplateRS($eids);
        $this->assign('eid_list_data1', $list_data5);
        
        $fids = Affiliate_Merchants_Bl_Page::getPagesAsArray();
        $list_data6 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data6->setTemplateRS($fids);
        $this->assign('fid_list_data1', $list_data6);
        

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_traffic_filter');
        if ($_REQUEST['commited'] == 'yes'){
	        if($_REQUEST['rt_reporttype'] == 'tenminsperday')
	        {
	            $reportType = 'tenmins';
	            $d1 = $_REQUEST['rt_ptm_day'];
	            $m1 = $_REQUEST['rt_ptm_month'];
	            $y1 = $_REQUEST['rt_ptm_year'];
	            $d2 = $_REQUEST['rt_ptm_day'];
	            $m2 = $_REQUEST['rt_ptm_month'];
	            $y2 = $_REQUEST['rt_ptm_year'];
	        }
	
	        if($_REQUEST['rt_reporttype'] == 'hourlyperday')
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
	        
	        $selected = array(	'imps' 			=> $_REQUEST['rt_imps'],
	        					'clicks' 		=> $_REQUEST['rt_clicks'],
	        					'sales' 		=> $_REQUEST['rt_sales'],
	        					'commission' 	=> $_REQUEST['rt_commission'],
	        					'revenue' 		=> $_REQUEST['rt_revenue'],
	        					'expenses' 		=> $_REQUEST['rt_expenses'],
	        					'profits' 		=> $_REQUEST['rt_profits'],
	        					'cpc' 			=> $_REQUEST['rt_cpc'],
	        					'epc' 			=> $_REQUEST['rt_epc'],
	        					'epu' 			=> $_REQUEST['rt_epu'],
	        					'epm' 			=> $_REQUEST['rt_epm']);
	        
	        $trend = Affiliate_Scripts_Bl_TrendStatistics::getTrendStats(
	                                                     $_REQUEST['rt_affiliate'],
	                                                     $_REQUEST['rt_affiliategroup'],
														 $_REQUEST['rt_campaign'],
														 $_REQUEST['rt_campaigntype'],
	                                                     $_REQUEST['rt_trackerId'],
	                                                     $_REQUEST['rt_keywordId'],
	                                                     $_REQUEST['rt_timeslotId'],
	                                                     $_REQUEST['rt_pageId'],
	                                                     $reportType,
	                                                     $d1, $m1, $y1,
	                                                     $d2, $m2, $y2,
														 '','',
														 $selected);
	        // create graph
	        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
	        $graph->type = 'vBar';
	        
	        $labels = '';
	        $valuesImps = '';
	        $valuesCpm = '';
	        $valuesClicks = '';
	        $valuesSales = '';
	        $valuesLeads = '';
	        $valuesCommission = '';
	        $valuesRevenue = '';
	        $valuesRevenueActual = '';
	        $valuesExpense = '';
	        $valuesProfit = '';
	        $valuesProfitActual = '';
	        
	        if($reportType == 'tenmins')
	        {
	            $periodMin = 0;
	            $periodMax = 143;
	            
	            $this->assign('a_period', L_G_TENMINS);
	        }
	
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
	            switch($reportType) {
	                case "tenmins":
	                    $label = strftime('%H:%M', mktime(0,$i*10)); 
	                    break;
	                case "monthly":
	                    $label = constant($GLOBALS['wd_monthname'][$i]);
	                    break;
	                default:
	                    $label = $i;
	                    break;
	            }                       
	            $labels .= ($labels != '' ? ',' : '').$label;
	            $valuesImps .= ($valuesImps != '' ? ',' : '').$trend['imps'][$i]['unique'].';'.$trend['imps'][$i]['all'];
	            $valuesCpm .= ($valuesCpm != '' ? ',' : '').$trend['cmp'][$i];
	            $valuesClicks .= ($valuesClicks != '' ? ',' : '').$trend['clicks'][$i];
	            $valuesSales .= ($valuesSales != '' ? ',' : '').$trend['sales'][$i];
	            $valuesLeads .= ($valuesLeads != '' ? ',' : '').$trend['leads'][$i];
	            $valuesCommission .= ($valuesCommission != '' ? ',' : '').$trend['revenue'][$i];	            
	            $valuesRevenue .= ($valuesRevenue != '' ? ',' : '').$trend['estimatedrevenue'][$i];
	            $valuesRevenueActual .= ($valuesRevenueActual != '' ? ',' : '').$trend['totalcost'][$i];
	            $valuesExpense .= ($valuesExpense != '' ? ',' : '').$trend['expense'][$i];
	            $valuesProfit .= ($valuesProfit != '' ? ',' : '').($trend['estimatedrevenue'][$i] - ($trend['revenue'][$i] + $trend['expense'][$i]));
	            $valuesProfitActual .= ($valuesProfitActual != '' ? ',' : '').($trend['totalcost'][$i] - ($trend['revenue'][$i] + $trend['expense'][$i]));
	        
	        }
			
	        $legendImps = L_G_UNIQUEIMPRESSIONS.','.L_G_ALLIMPRESSIONS;
			
	        $graph->labels = $labels;
	        $graph->legend = $legendImps;
	        $graph->barColor = "#486B8F,#AEC4D2";
	        $graph->barBGColor = '';
	        $graph->labelBGColor = '#E0E0E0';
	        $graph->barLength = 1.7;
	        $graph->barWidth = 25;
	        $graph->percValuesSize = 10;
	        $graph->absValuesSize = 10;
	        $graph->showValues = 2;
	        
	        if ($selected['imps'] == '1') {
	        	$graph->values = $valuesImps;
	        	$gdata = $graph->create();
	        	$this->assign('a_impstrend_graph', $gdata);
	        }
	
	        // cpm
	        $graph->legend = '';
	        $graph->barColor = "#486B8F";
	        $graph->showValues = 1;
	        
	        $graph->values = $valuesCpm;
	        $gdata = $graph->create();
	        $this->assign('a_cpmtrend_graph', $gdata);
	
	        // clicks
	        if ($selected['clicks'] == '1') {
	        	$graph->values = $valuesClicks;
	        	$gdata = $graph->create();
	        	$this->assign('a_clickstrend_graph', $gdata);
	        }
	                                                    
	        // sales
	        if ($selected['sales'] == '1') {
	        	$graph->values = $valuesSales;
	        	$gdata = $graph->create();
	        	$this->assign('a_salestrend_graph', $gdata);
	        }
	
	        // leads
	        $graph->values = $valuesLeads;
	        $gdata = $graph->create();
	        $this->assign('a_leadstrend_graph', $gdata);
	
	        // commission
	        if ($selected['commission'] == '1') {
	        	$graph->values = $valuesCommission;
	        	$gdata = $graph->create();
	        	$this->assign('a_commissiontrend_graph', $gdata);
	        }
	
	        if ($selected['revenue'] == '1') {
	        // estimated revenue
	        	$graph->values = $valuesRevenue;
	        	$gdata = $graph->create();
	        	$this->assign('a_revenuetrend_graph', $gdata);

	        // actual revenue
	        	$graph->values = $valuesRevenueActual;
	        	$gdata = $graph->create();
	        	$this->assign('a_revenuetrend_act_graph', $gdata);
	        }
	
	        $this->assign('a_periodMin', $periodMin);
	        $this->assign('a_periodMax', $periodMax);
	        $this->assign('a_reportType', $reportType);
	        $this->assign('a_trendData', $trend);
	        
	        // expenses
	        if ($selected['expenses'] == '1') {
	        	$graph->values = $valuesExpense;
	        	$gdata = $graph->create();
	        	$this->assign('a_expensetrend_graph', $gdata);
	        }
	
	        if ($selected['profits'] == '1') {
	        // estimated profits
	        	$graph->values = $valuesProfit;
	        	$gdata = $graph->create();
	       		$this->assign('a_profittrend_graph', $gdata);

	        // estimated profits
	        	$graph->values = $valuesProfitActual;
	        	$gdata = $graph->create();
	       		$this->assign('a_profittrend_act_graph', $gdata);
	        }
	
	        $this->setSupportedResults($_REQUEST['rt_campaign']);
	        
	        $sql = ob_get_clean();
	       
	        
	        $_SESSION['report_sql'] = $sql;
	        
	        $this->addContent('rep_traffic_list');
        }
    }
    
    function showSQL()
    {
    	echo $_SESSION['report_sql'];
    }
    
    //------------------------------------------------------------------------

    function showAReportTraffic()
    {
        ob_start();
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'rt_') === 0 && $_REQUEST[$k] == '')
                $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['rt_affiliategroup'] == '') $_REQUEST['rt_affiliategroup'] = '_';
        if($_REQUEST['rt_affiliate'] == '') $_REQUEST['rt_affiliate'] = '_';
		if($_REQUEST['rt_campaign'] == '') $_REQUEST['rt_campaign'] = '_';
		if($_REQUEST['rt_campaigntype'] == '') $_REQUEST['rt_campaigntype'] = '_';
        if($_REQUEST['rt_trackerId'] == '') $_REQUEST['rt_trackerId'] = '_';
        if($_REQUEST['rt_timeslotId'] == '') $_REQUEST['rt_timeslotId'] = '_';
        if($_REQUEST['rt_pageId'] == '') $_REQUEST['rt_pageId'] = '_';
        //if($_REQUEST['rt_keywordId'] == '') $_REQUEST['rt_keywordId'] = '_';
        //if($_REQUEST['rt_campaign'] == '') $_REQUEST['rt_campaign'] = '_';
        if($_REQUEST['rt_reporttype'] == '') $_REQUEST['rt_reporttype'] = 'hourlyperday';
        if($_REQUEST['rt_ptm_day'] == '') $_REQUEST['rt_ptm_day'] = date("j");
        if($_REQUEST['rt_ptm_month'] == '') $_REQUEST['rt_ptm_month'] = date("n");
        if($_REQUEST['rt_ptm_year'] == '') $_REQUEST['rt_ptm_year'] = date("Y");
        if($_REQUEST['rt_pd_day'] == '') $_REQUEST['rt_pd_day'] = date("j");
        if($_REQUEST['rt_pd_month'] == '') $_REQUEST['rt_pd_month'] = date("n");
        if($_REQUEST['rt_pd_year'] == '') $_REQUEST['rt_pd_year'] = date("Y");
        if($_REQUEST['rt_pm_month'] == '') $_REQUEST['rt_pm_month'] = date("n");
        if($_REQUEST['rt_pm_year'] == '') $_REQUEST['rt_pm_year'] = date("Y");
        if($_REQUEST['rt_py_year'] == '') $_REQUEST['rt_py_year'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['rt_affiliate'] = $_REQUEST['rt_affiliate'];
        $_SESSION['rt_affiliategroup'] = $_REQUEST['rt_affiliategroup'];
		$_SESSION['rt_campaign'] = $_REQUEST['rt_campaign'];
		$_SESSION['rt_campaigntype'] = $_REQUEST['rt_campaigntype'];
        $_SESSION['rt_trackerId'] = $_REQUEST['rt_trackerId'];
        $_SESSION['rt_pageId'] = $_REQUEST['rt_pageId'];
        $_SESSION['rt_timeslotId'] = $_REQUEST['rt_timeslotId'];
        //$_SESSION['rt_keywordId'] = $_REQUEST['rt_keywordId'];
        
        $_SESSION['rt_reporttype'] = $_REQUEST['rt_reporttype'];
        $_SESSION['rt_ptm_day'] = $_REQUEST['rt_ptm_day'];
        $_SESSION['rt_ptm_month'] = $_REQUEST['rt_ptm_month'];
        $_SESSION['rt_ptm_year'] = $_REQUEST['rt_ptm_year'];
        $_SESSION['rt_pd_day'] = $_REQUEST['rt_pd_day'];
        $_SESSION['rt_pd_month'] = $_REQUEST['rt_pd_month'];
        $_SESSION['rt_pd_year'] = $_REQUEST['rt_pd_year'];
        $_SESSION['rt_pm_month'] = $_REQUEST['rt_pm_month'];
        $_SESSION['rt_pm_year'] = $_REQUEST['rt_pm_year'];
        $_SESSION['rt_py_year'] = $_REQUEST['rt_py_year'];

        QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray(true);
        $affiliates = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($affiliates);
        $this->assign('a_list_data2', $list_data2);
        
        //get affiliate groups
		
		$affiliategroups = Affiliate_Merchants_Bl_AffiliateGroups::getGroupsAsArray();
		$list_data3 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data3->setTemplateRS($affiliategroups);
        $this->assign('a_list_data3', $list_data3);
		
		//get product category types
		
		$camptypes = Affiliate_Merchants_Bl_CampaignCategoryGroups::getGroupsAsArray();
		$list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($camptypes);
        $this->assign('a_list_data4', $list_data4);
		
		$cids = Affiliate_Merchants_Bl_Tracker::getTrackersAsArray();
        $list_data3 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data3->setTemplateRS($cids);
        $this->assign('cid_list_data1', $list_data3);
        
        /*$dids = Affiliate_Merchants_Bl_Keyword::getKeywordsAsArray();
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($dids);
        $this->assign('did_list_data1', $list_data4);
        */
        $eids = Affiliate_Merchants_Bl_Timeslot::getTimeslotsAsArray();
        $list_data5 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data5->setTemplateRS($eids);
        $this->assign('eid_list_data1', $list_data5);
        
        $fids = Affiliate_Merchants_Bl_Page::getPagesAsArray();
        $list_data6 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data6->setTemplateRS($fids);
        $this->assign('fid_list_data1', $list_data6);
        

        $this->assign('a_curyear', date("Y"));
        $this->addContent('rep_a_traffic_filter');

        if ($_REQUEST['commited'] == 'yes'){
	        if($_REQUEST['rt_reporttype'] == 'tenminsperday')
	        {
	            $reportType = 'tenmins';
	            $d1 = $_REQUEST['rt_ptm_day'];
	            $m1 = $_REQUEST['rt_ptm_month'];
	            $y1 = $_REQUEST['rt_ptm_year'];
	            $d2 = $_REQUEST['rt_ptm_day'];
	            $m2 = $_REQUEST['rt_ptm_month'];
	            $y2 = $_REQUEST['rt_ptm_year'];
	        }
	
	        if($_REQUEST['rt_reporttype'] == 'hourlyperday')
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
	        
	        $selected = array(	'imps' 			=> $_REQUEST['rt_imps'],
	        					'clicks' 		=> $_REQUEST['rt_clicks'],
	        					'sales' 		=> $_REQUEST['rt_sales'],
	        					'commission' 	=> $_REQUEST['rt_commission'],
	        					'revenue' 		=> $_REQUEST['rt_revenue'],
	        					'expenses' 		=> $_REQUEST['rt_expenses'],
	        					'profits' 		=> $_REQUEST['rt_profits'],
	        					'cpc' 			=> $_REQUEST['rt_cpc'],
	        					'epc' 			=> $_REQUEST['rt_epc'],
	        					'epu' 			=> $_REQUEST['rt_epu'],
	        					'epm' 			=> $_REQUEST['rt_epm']);
	        
	        $trend = Affiliate_Scripts_Bl_TrendStatistics::getATrendStats(
	                                                     $_REQUEST['rt_affiliate'],
	                                                     $_REQUEST['rt_affiliategroup'],
														 $_REQUEST['rt_campaign'],
														 $_REQUEST['rt_campaigntype'],
	                                                     $_REQUEST['rt_trackerId'],
	                                                     $_REQUEST['rt_keywordId'],
	                                                     $_REQUEST['rt_timeslotId'],
	                                                     $_REQUEST['rt_pageId'],
	                                                     $reportType,
	                                                     $d1, $m1, $y1,
	                                                     $d2, $m2, $y2,
														 '','',
														 $selected);
	        // create graph
	        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
	        $graph->type = 'vBar';
	        
	        $labels = '';
	        $valuesImps = '';
	        $valuesCpm = '';
	        $valuesClicks = '';
	        $valuesSales = '';
	        $valuesLeads = '';
	        $valuesCommission = '';
	        $valuesRevenue = '';
	        $valuesRevenueActual = '';
	        $valuesExpense = '';
	        $valuesProfit = '';
	        $valuesProfitActual = '';
	        
	        if($reportType == 'tenmins')
	        {
	            $periodMin = 0;
	            $periodMax = 143;
	            
	            $this->assign('a_period', L_G_TENMINS);
	        }
	
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
	            switch($reportType) {
	                case "tenmins":
	                    $label = strftime('%H:%M', mktime(0,$i*10)); 
	                    break;
	                case "monthly":
	                    $label = constant($GLOBALS['wd_monthname'][$i]);
	                    break;
	                default:
	                    $label = $i;
	                    break;
	            }                       
	            $labels .= ($labels != '' ? ',' : '').$label;
	            $valuesImps .= ($valuesImps != '' ? ',' : '').$trend['imps'][$i]['unique'].';'.$trend['imps'][$i]['all'];
	            $valuesCpm .= ($valuesCpm != '' ? ',' : '').$trend['cmp'][$i];
	            $valuesClicks .= ($valuesClicks != '' ? ',' : '').$trend['clicks'][$i];
	            $valuesSales .= ($valuesSales != '' ? ',' : '').$trend['sales'][$i];
	            $valuesLeads .= ($valuesLeads != '' ? ',' : '').$trend['leads'][$i];
	            $valuesCommission .= ($valuesCommission != '' ? ',' : '').$trend['revenue'][$i];	            
	            $valuesRevenue .= ($valuesRevenue != '' ? ',' : '').$trend['estimatedrevenue'][$i];
	            $valuesRevenueActual .= ($valuesRevenueActual != '' ? ',' : '').$trend['totalcost'][$i];
	            $valuesExpense .= ($valuesExpense != '' ? ',' : '').$trend['expense'][$i];
	            $valuesProfit .= ($valuesProfit != '' ? ',' : '').($trend['estimatedrevenue'][$i] - ($trend['revenue'][$i] + $trend['expense'][$i]));
	            $valuesProfitActual .= ($valuesProfitActual != '' ? ',' : '').($trend['totalcost'][$i] - ($trend['revenue'][$i] + $trend['expense'][$i]));
	        
	        }
			
	        $legendImps = L_G_UNIQUEIMPRESSIONS.','.L_G_ALLIMPRESSIONS;
			
	        $graph->labels = $labels;
	        $graph->legend = $legendImps;
	        $graph->barColor = "#486B8F,#AEC4D2";
	        $graph->barBGColor = '';
	        $graph->labelBGColor = '#E0E0E0';
	        $graph->barLength = 1.7;
	        $graph->barWidth = 25;
	        $graph->percValuesSize = 10;
	        $graph->absValuesSize = 10;
	        $graph->showValues = 2;
	        
	        if ($selected['imps'] == '1') {
	        	$graph->values = $valuesImps;
	        	$gdata = $graph->create();
	        	$this->assign('a_impstrend_graph', $gdata);
	        }
	
	        // cpm
	        $graph->legend = '';
	        $graph->barColor = "#486B8F";
	        $graph->showValues = 1;
	        
	        $graph->values = $valuesCpm;
	        $gdata = $graph->create();
	        $this->assign('a_cpmtrend_graph', $gdata);
	
	        // clicks
	        if ($selected['clicks'] == '1') {
	        	$graph->values = $valuesClicks;
	        	$gdata = $graph->create();
	        	$this->assign('a_clickstrend_graph', $gdata);
	        }
	                                                    
	        // sales
	        if ($selected['sales'] == '1') {
	        	$graph->values = $valuesSales;
	        	$gdata = $graph->create();
	        	$this->assign('a_salestrend_graph', $gdata);
	        }
	
	        // leads
	        $graph->values = $valuesLeads;
	        $gdata = $graph->create();
	        $this->assign('a_leadstrend_graph', $gdata);
	
	        // commission
	        if ($selected['commission'] == '1') {
	        	$graph->values = $valuesCommission;
	        	$gdata = $graph->create();
	        	$this->assign('a_commissiontrend_graph', $gdata);
	        }
	
	        if ($selected['revenue'] == '1') {
	        // estimated revenue
	        	$graph->values = $valuesRevenue;
	        	$gdata = $graph->create();
	        	$this->assign('a_revenuetrend_graph', $gdata);

	        // actual revenue
	        	$graph->values = $valuesRevenueActual;
	        	$gdata = $graph->create();
	        	$this->assign('a_revenuetrend_act_graph', $gdata);
	        }
	
	        $this->assign('a_periodMin', $periodMin);
	        $this->assign('a_periodMax', $periodMax);
	        $this->assign('a_reportType', $reportType);
	        $this->assign('a_trendData', $trend);
	        
	        // expenses
	        if ($selected['expenses'] == '1') {
	        	$graph->values = $valuesExpense;
	        	$gdata = $graph->create();
	        	$this->assign('a_expensetrend_graph', $gdata);
	        }
	
	        if ($selected['profits'] == '1') {
	        // estimated profits
	        	$graph->values = $valuesProfit;
	        	$gdata = $graph->create();
	       		$this->assign('a_profittrend_graph', $gdata);

	        // estimated profits
	        	$graph->values = $valuesProfitActual;
	        	$gdata = $graph->create();
	       		$this->assign('a_profittrend_act_graph', $gdata);
	        }
	
	        $this->setSupportedResults($_REQUEST['rt_campaign']);
	        
	        $sql = ob_get_clean();
	       
	        
	        $_SESSION['report_sql'] = $sql;	        
	        
	        $this->addContent('rep_a_traffic_list');
        }
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
        if($_REQUEST['rq_affiliate'] == '') $_REQUEST['rq_affiliate'] = '_';
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '_';
        if($_REQUEST['rq_transtype'] == '') $_REQUEST['rq_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
        if($_REQUEST['rq_status'] == '') $_REQUEST['rq_status'] = '_';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'today';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['rq_affiliate'] = $_REQUEST['rq_affiliate'];
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
        $affiliates = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);
		

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($affiliates);
        $this->assign('a_list_data2', $list_data2);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_trans_filter');
        if ($_REQUEST['commited'] == 'yes'){
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
	        
	        if($_REQUEST['rq_affiliate'] != '' && $_REQUEST['rq_affiliate'] != '_')
	            $AffiliateID = $_REQUEST['rq_affiliate'];
	        else
	            $AffiliateID = '';
	
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
    }
    
    //------------------------------------------------------------------------
    function showAReportTransactions()
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
        if($_REQUEST['rq_affiliate'] == '') $_REQUEST['rq_affiliate'] = '_';
        if($_REQUEST['rq_campaign'] == '') $_REQUEST['rq_campaign'] = '_';
        if($_REQUEST['rq_transtype'] == '') $_REQUEST['rq_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
        if($_REQUEST['rq_status'] == '') $_REQUEST['rq_status'] = '_';
        if($_REQUEST['rq_reporttype'] == '') $_REQUEST['rq_reporttype'] = 'today';
        if($_REQUEST['rq_day1'] == '') $_REQUEST['rq_day1'] = date("j");
        if($_REQUEST['rq_month1'] == '') $_REQUEST['rq_month1'] = date("n");
        if($_REQUEST['rq_year1'] == '') $_REQUEST['rq_year1'] = date("Y");
        if($_REQUEST['rq_day2'] == '') $_REQUEST['rq_day2'] = date("j");
        if($_REQUEST['rq_month2'] == '') $_REQUEST['rq_month2'] = date("n");
        if($_REQUEST['rq_year2'] == '') $_REQUEST['rq_year2'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['rq_affiliate'] = $_REQUEST['rq_affiliate'];
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
        $affiliates = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);
		

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($affiliates);
        $this->assign('a_list_data2', $list_data2);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_a_trans_filter');
        if ($_REQUEST['commited'] == 'yes'){
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
	        
	        if($_REQUEST['rq_affiliate'] != '' && $_REQUEST['rq_affiliate'] != '_')
	            $AffiliateID = $_REQUEST['rq_affiliate'];
	        else
	            $AffiliateID = '';
	
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
	
	        $transdata = Affiliate_Scripts_Bl_SaleStatistics::getATransactionsStats($conditions);
	        $summaries = Affiliate_Scripts_Bl_SaleStatistics::getATransactionsSummaries($conditions);
	
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
	        
	        $sql = ob_get_clean();
	       
	        
	        $_SESSION['report_sql'] = $sql;	        
	
	        $this->addContent('rep_a_trans_list');
        }
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
        if($_REQUEST['rq_affiliate'] == '') $_REQUEST['rq_affiliate'] = '_';
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
        $_SESSION['rq_affiliate'] = $_REQUEST['rq_affiliate'];
        $_SESSION['rq_campaign'] = $_REQUEST['rq_campaign'];
        $_SESSION['rq_reporttype'] = $_REQUEST['rq_reporttype'];
        $_SESSION['rq_day1'] = $_REQUEST['rq_day1'];
        $_SESSION['rq_month1'] = $_REQUEST['rq_month1'];
        $_SESSION['rq_year1'] = $_REQUEST['rq_year1'];
        $_SESSION['rq_day2'] = $_REQUEST['rq_day2'];
        $_SESSION['rq_month2'] = $_REQUEST['rq_month2'];
        $_SESSION['rq_year2'] = $_REQUEST['rq_year2'];

        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();
        $affiliates = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($affiliates);
        $this->assign('a_list_data2', $list_data2);

        $this->assign('a_curyear', date("Y"));

        $this->addContent('rep_quick_filter');
		
        if ($_REQUEST['commited'] == 'yes'){
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
	                        $_REQUEST['rq_affiliate'], $CampaignID, $d1, $m1, $y1, $d2, $m2, $y2, 
	                        $GLOBALS['Auth']->getAccountID()
	                        );
	         
	        $this->assign('a_data', $data);
	
	        $this->setSupportedResults($CampaignID);
	        
	        $this->addContent('rep_quick_list');
        }
    }
}

?>
