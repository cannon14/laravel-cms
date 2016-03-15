<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_PayoutOptions');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TrendStatistics');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TimerangeStatistics');
QUnit_Global::includeClass('QCore_Bl_Communications');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');

class Affiliate_Affiliates_Views_MainPage extends QUnit_UI_TemplatePage
{
    function process()
    {
        $this->showStats();    
    }

    //------------------------------------------------------------------------

    function showStats()
    {
        if($GLOBALS['Auth']->getSetting('Aff_display_news') == '1')
        {
            $this->processNews();
        }
        
        $this->getTrendStats();
        
        // get statistics for today
        $d1 = date("j");
        $m1 = date("n");
        $y1 = date("Y");
        $d2 = date("j");
        $m2 = date("n");
        $y2 = date("Y");
        
        $data = Affiliate_Scripts_Bl_TimerangeStatistics::getTimerangeStats(
                    $GLOBALS['Auth']->getUserID(), '', $d1, $m1, $y1, $d2, $m2, $y2,
                    $GLOBALS['Auth']->getAccountID()
                    );

        $this->assign('a_data', $data);
        
        $this->addContent('mainpage');
    }

    //------------------------------------------------------------------------

    function processNews()
    {
        $params = array(
            'userid' => $GLOBALS['Auth']->getUserID(),
            'accountid' => $GLOBALS['Auth']->getAccountID(),
            'view_old' => $_REQUEST['view_old']
        );

        $user_news = QCore_Bl_Communications::getUserNews($params);
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($user_news[$GLOBALS['Auth']->getUserID()]);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_news_count', count($user_news[$GLOBALS['Auth']->getUserID()]));

        $this->assign('a_old_news_exist', QCore_Bl_Communications::checkOldNewsExist($params));
    }
    
    //------------------------------------------------------------------------
    
    function getTrendStats()
    {
        $twoYearStats = false;
        if(Affiliate_Scripts_Bl_TrendStatistics::checkSomeTransImpsExistedLastYear($GLOBALS['Auth']->getUserID()))
        {
            $trendLastYear = Affiliate_Scripts_Bl_TrendStatistics::getTrendStats(
                                                         $GLOBALS['Auth']->getUserID(),
                                                         '',
                                                         '',
                                                         '',
                                                         '',
                                                         '',
                                                         'monthly',
                                                         1, 1, date('Y')-1,
                                                         31, 12, date('Y')-1
                                                         );
            $twoYearStats = true;
        }
        
        $trendThisYear = Affiliate_Scripts_Bl_TrendStatistics::getTrendStats(
                                                     $GLOBALS['Auth']->getUserID(),
                                                     '',
                                                     '',
                                                         '',
                                                         '',
                                                         '',
													 'monthly',
                                                     1, 1, date('Y'),
                                                     31, 12, date('Y')
                                                     );
        $labels = '';
        $valuesImps = '';
        $valuesCpm = '';
        $valuesClicks = '';
        $valuesSales = '';
        $valuesLeads = '';
        $valuesRevenue = '';

        for($i=1; $i<=12; $i++)
        {
            $labels .= ($labels != '' ? ',' : '').constant($GLOBALS['wd_monthname'][$i]);
            
            $valuesImps .= ($valuesImps != '' ? ',' : '').($twoYearStats ? $trendLastYear['imps'][$i]['unique'].';' : '').$trendThisYear['imps'][$i]['unique'];
            $valuesCpm .= ($valuesCpm != '' ? ',' : '').($twoYearStats ? $trendLastYear['cpm'][$i].';' : '').$trendThisYear['cpm'][$i];
            $valuesClicks .= ($valuesClicks != '' ? ',' : '').($twoYearStats ? $trendLastYear['clicks'][$i].';' : '').$trendThisYear['clicks'][$i];
            $valuesSales .= ($valuesSales != '' ? ',' : '').($twoYearStats ? $trendLastYear['sales'][$i].';' : '').$trendThisYear['sales'][$i];
            $valuesLeads .= ($valuesLeads != '' ? ',' : '').($twoYearStats ? $trendLastYear['leads'][$i].';' : '').$trendThisYear['leads'][$i];
            $valuesRevenue .= ($valuesRevenue != '' ? ',' : '').($twoYearStats ? $trendLastYear['revenue'][$i].';' : '').$trendThisYear['revenue'][$i];
        }

        // create graph
        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
        $graph->type = 'vBar';
        
        $graph->labels = $labels;
        $graph->values = $valuesImps;
        $graph->legend = ($twoYearStats ? (date('Y')-1).','.date('Y') : '');
        $graph->barColor = ($twoYearStats ? '#B2BCCA,#2C3C74' : '#2C3C74') ;
        $graph->barBGColor = '';
        $graph->labelBGColor = '#E0E7EC';
        $graph->barLength = 0.7;
        $graph->barWidth = ($twoYearStats ? 25 : 45);
        $graph->percValuesSize = 10;
        $graph->absValuesSize = 10;
        $graph->showValues = 1;
        $gdata = $graph->create();
        $this->assign('a_impstrend_graph', $gdata);

        // cpm
        $graph->values = $valuesCpm;
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
        
        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
        $graph->type = 'vBar';
        
        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1)
        {
            $clickSupported = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1)
        {
            $cpmSupported = true;
        }
        
        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1)
        {
            $saleSupported = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1)
        {
            $leadSupported = true;
        }

        $this->assign('a_clickSupported', $clickSupported);
        $this->assign('a_cpmSupported', $cpmSupported);
        $this->assign('a_saleSupported', $saleSupported);
        $this->assign('a_leadSupported', $leadSupported);        
    }

    //--------------------------------------------------------------------------

}
?>
