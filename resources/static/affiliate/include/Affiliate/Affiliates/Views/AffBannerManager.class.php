<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');
QUnit_Global::includeClass('Affiliate_Affiliates_Views_AffCampaignManager');
QUnit_Global::includeClass('Affiliate_Affiliates_Bl_Affiliate');

class Affiliate_Affiliates_Views_AffBannerManager extends QUnit_UI_TemplatePage
{
    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'gendynamiclink':
                if($this->generateDynamicLink())
                    return;
                break;              
                
                case 'gencustdynamiclink':
                if($this->generateCustomDynamicLink())
                    return;
                break;              
                
                case 'dynamiclink':
                if($this->drawDynamicLinkForm())
                    return;
                break;    
                
                case 'custdynamiclink':
                if($this->drawCustomDynamicLinkForm())
                    return;
                break;
                
                case 'subaffsignup':
                if($this->drawSubAffSignup())
                    return;
                break;              
            }
        }
        
        $this->showBanners();
    }  
    
    //--------------------------------------------------------------------------
    
    function drawDynamicLinkForm()
    {
        $this->addContent('dyn_link');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function drawCustomDynamicLinkForm()
    {
        $this->addContent('dyn_link_c');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function generateDynamicLink()
    {
        // get affiliate data first
        $sql = 'select * from wd_g_users '.
                'where userid='._q($GLOBALS['Auth']->userID).
                '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $specialDestUrl = $_REQUEST['desturl'];
        
        $params = array();
        $params['Affiliate_id'] = urlencode($rs->fields['userid']);
        $params['Affiliate_refid'] = urlencode($rs->fields['refid']);
        $params['Affiliate_name'] = urlencode($rs->fields['name'].' '.$rs->fields['surname']);
        $params['Affiliate_username'] = urlencode($rs->fields['username']);
        
        $sql = 'select * from wd_pa_banners where bannerid='._q($_REQUEST['bid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $clickUrlOnly = $this->getClickUrl($rs->fields['destinationurl'], $params);
        
        print '<br><center>';
        $bannerCode = $this->showBannerAndGetCode($clickUrlOnly, $rs->fields['bannertype'], $rs->fields['bannerid'], $rs->fields['sourceurl'], $rs->fields['description'], $params, $specialDestUrl);
        print '</center>';
        
        $this->assign('a_bannerCode', $bannerCode);
        
        $this->addContent('gen_dyn_link');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function generateCustomDynamicLink()
    {
        // protect against script injection
        $pdesturl = preg_replace('/[\'\"]/', '', $_POST['desturl']);
        $psourceurl = preg_replace('/[\'\"]/', '', $_POST['sourceurl']);
        $pdesc = $_POST['desc'];
        
        // check correctness of the fields
        checkCorrectness($_POST['desturl'], $pdesturl, L_G_DESTURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['sourceurl'], $psourceurl, L_G_TITLE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['desc'], $pdesc, L_G_DESCRIPTION, CHECK_ALLOWED);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            $this->drawCustomDynamicLinkForm();
        }
        else
        {
            // get affiliate data first
            $sql = 'select * from wd_g_users '.
            'where userid='._q($GLOBALS['Auth']->userID).
            '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }        
            
            $specialDestUrl = $_REQUEST['desturl'];
            
            $params = array();
            $params['Affiliate_id'] = urlencode($rs->fields['affiliateid']);
            $params['Affiliate_refid'] = urlencode($rs->fields['refid']);
            $params['Affiliate_name'] = urlencode($rs->fields['name'].' '.$rs->fields['surname']);
            $params['Affiliate_username'] = urlencode($rs->fields['username']);
            
            $clickUrlOnly = $this->getClickUrl($specialDestUrl, $params);
            
            $bannerCode = $this->showBannerAndGetCode($clickUrlOnly, BANNERTYPE_TEXT, '', $psourceurl, $pdesc, $params, $specialDestUrl);
            
            $this->assign('a_bannerCode', $bannerCode);
            
            $this->addContent('gen_dyn_link_c');
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function showBanners()
    {
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'bs_') === 0 && $_REQUEST[$k] == '')
            $_REQUEST[$k] = $v;
        }

        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['bs_affiliate'] == '') $_REQUEST['bs_affiliate'] = '_';
        if($_REQUEST['bs_sortby'] == '') $_REQUEST['bs_sortby'] = 'campaign';
        if($_REQUEST['bs_campaign'] == '') $_REQUEST['bs_campaign'] = '_';
        if($_REQUEST['bs_reporttype'] == '') $_REQUEST['bs_reporttype'] = 'today';
        if($_REQUEST['bs_day1'] == '') $_REQUEST['bs_day1'] = date("j");
        if($_REQUEST['bs_month1'] == '') $_REQUEST['bs_month1'] = date("n");
        if($_REQUEST['bs_year1'] == '') $_REQUEST['bs_year1'] = date("Y");
        if($_REQUEST['bs_day2'] == '') $_REQUEST['bs_day2'] = date("j");
        if($_REQUEST['bs_month2'] == '') $_REQUEST['bs_month2'] = date("n");
        if($_REQUEST['bs_year2'] == '') $_REQUEST['bs_year2'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['bs_affiliate'] = $_REQUEST['bs_affiliate'];
        $_SESSION['bs_sortby'] = $_REQUEST['bs_sortby'];
        $_SESSION['bs_campaign'] = $_REQUEST['bs_campaign'];
        $_SESSION['bs_reporttype'] = $_REQUEST['bs_reporttype'];
        $_SESSION['bs_day1'] = $_REQUEST['bs_day1'];
        $_SESSION['bs_month1'] = $_REQUEST['bs_month1'];
        $_SESSION['bs_year1'] = $_REQUEST['bs_year1'];
        $_SESSION['bs_day2'] = $_REQUEST['bs_day2'];
        $_SESSION['bs_month2'] = $_REQUEST['bs_month2'];
        $_SESSION['bs_year2'] = $_REQUEST['bs_year2'];
        
        if($_REQUEST['bs_reporttype'] == 'timerange')
        {
            $d1 = $_REQUEST['bs_day1'];
            $m1 = $_REQUEST['bs_month1'];
            $y1 = $_REQUEST['bs_year1'];
            $d2 = $_REQUEST['bs_day2'];
            $m2 = $_REQUEST['bs_month2'];
            $y2 = $_REQUEST['bs_year2'];
        }
        else if($_REQUEST['bs_reporttype'] == 'today')
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");
        }
        else if($_REQUEST['bs_reporttype'] == 'thismonth')
        {
            $d1 = 1;
            $m1 = date("n");
            $y1 = date("Y");
            $m2 = date("n");
            $y2 = date("Y");
            $d2 = getDaysInMonth($m2, $y2);
        }
        else if($_REQUEST['bs_reporttype'] == 'thisweek')
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
        
        // added
        else
        {
            $d1 = date("j");
            $m1 = date("n");
            $y1 = date("Y");
            $d2 = date("j");
            $m2 = date("n");
            $y2 = date("Y");
        }
         
        $this->assign('a_curyear', date("Y"));
        
        // get affiliate data first
        $sql = 'select * from wd_g_users '.
                'where userid='._q($GLOBALS['Auth']->getUserID()).
                '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $params = array();
        $params['Affiliate_id'] = urlencode($rs->fields['userid']);
        $params['Affiliate_refid'] = urlencode($rs->fields['refid']);
        $params['Affiliate_name'] = urlencode($rs->fields['name'].' '.$rs->fields['surname']);
        $params['Affiliate_username'] = urlencode($rs->fields['username']);
        
        $this->assign('a_params', $params);
        
        $campaignid = preg_replace('/[\'\"]/', '', $_REQUEST['bs_campaign']);
        
        $sql = 'select b.*, c.name as campaignname '.
                'from wd_pa_banners b, wd_pa_campaigns c';
        
        $where = ' where c.campaignid=b.campaignid and c.deleted=0 and b.deleted=0 '.
                '   and c.accountid='._q($GLOBALS['Auth']->getAccountID());
/*        if($campaignid != '_' && $campaignid != '') {
            $where .= '   and b.campaignid='._q($campaignid);
        }
        
        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        */
        
        $showfilter = 0;
        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == 1)
        {
            // get affiliates campaigns
            $params = array('userID' => $GLOBALS['Auth']->getUserID(),
                'accountID' => $GLOBALS['Auth']->getAccountID()
            );

            $campaigns = Affiliate_Affiliates_Bl_Affiliate::getAffiliatesCampaigns($params);
            
            if($campaigns == false) {
            	//$this->addContent('banners_shows');
            	//$this->addContent('banner_show_filter');
            	//return false;
            }
        } else {
            $campaigns = Affiliate_Affiliates_Views_AffCampaignManager::getCampaignsAsArray();
        }

        if($campaignid != '_' && $campaignid != '') {
            $where .= '   and b.campaignid='._q($campaignid);
        }
        
        if (count($campaigns) > 0) {
        	$where .= ' and b.campaignid in(';
        	$tmp = '';
        	foreach ($campaigns as $camp) {
        		$tmp .= '\''.$camp['campaignid'].'\',';
        	}
        	$where .= substr($tmp,0,strlen($tmp)-1).')';
        } else {
        	$where .= ' and b.campaignid in ("")';
        }
        
        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        
        //$bannerStats = Affiliate_Scripts_Bl_SaleStatistics::getBannerStats($GLOBALS['Auth']->getUserID(), $d1, $m1, $y1, $d2, $m2, $y2);    
        //$this->assign('a_bannerStats', $bannerStats);
        
        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);
        
        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($rs);
        $this->assign('a_list_data2', $list_data2);
        
        $this->assign('a_numrows', $rs->PO_RecordCount('wd_pa_banners b, wd_pa_campaigns c', $where));
        
        $this->addContent('banners_show');
    }  
    
    //--------------------------------------------------------------------------
    
    function getClickUrl($destinationUrl, $params)
    {
        if($GLOBALS['Auth']->getSetting('Aff_link_style') == LINK_STYLE_NEW)
        {
            $destUrl = $destinationUrl;
            if(strpos($destUrl, '?') === false)
                $char = '?';
            else
                $char = '&';
            
            $destUrl = str_replace('$Affiliate_id', $params['Affiliate_id'], $destUrl);
            $destUrl = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $destUrl);
            $destUrl = str_replace('$Affiliate_name', $params['Affiliate_name'], $destUrl);
            $destUrl = str_replace('$Affiliate_username', $params['Affiliate_username'], $destUrl);
            
            $clickUrlOnly = $destUrl.$char."a_aid=".$params['Affiliate_refid'];
        }
        else
        {
            $clickUrlOnly = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."t.php?a_aid=".$params['Affiliate_refid'];
        }
        
        return $clickUrlOnly;
    }
    
    //--------------------------------------------------------------------------
    
    function showBannerAndGetCode($clickUrlOnly, $bannerType, $bannerID, $sourceUrl, $description, $params, $specialDestUrl = '')
    {
        if($bannerType == BANNERTYPE_TEXT)
        {
            $title = $sourceUrl;
            $title = str_replace('$Affiliate_id', $params['Affiliate_id'], $title);
            $title = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $title);
            $title = str_replace('$Affiliate_name', $params['Affiliate_name'], $title);
            $title = str_replace('$Affiliate_username', $params['Affiliate_username'], $title);
            
            $description = str_replace('$Affiliate_id', $params['Affiliate_id'], $description);
            $description = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $description);
            $description = str_replace('$Affiliate_name', $params['Affiliate_name'], $description);
            $description = str_replace('$Affiliate_username', $params['Affiliate_username'], $description);
            
            $settings = $GLOBALS['Auth']->getSettings();
            if(isset($settings['Aff_bannerformat_textformat'])) {
                $code = $settings['Aff_bannerformat_textformat'];
                $code = str_replace('$TITLE', $title, $code);
                $code = str_replace('$DESCRIPTION', $description, $code);
                $code = str_replace('$DESTINATION', 
                $clickUrlOnly."&a_bid=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : ''), $code);
                $code = str_replace('$IMPRESSION_TRACK', "<IMG SRC='".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?a_aid=".$params['Affiliate_refid']."&a_bid=".$bannerID."' WIDTH=1 HEIGHT=1 BORDER=0>", $code);

                echo $code;
                
            } else {
                
                echo "<b>".$title."</b><br>".$description;
                
                $code = "<A HREF=\"".$clickUrlOnly."&a_bid=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : '')."\">";
                $code .= "<IMG SRC='".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?a_aid=".$params['Affiliate_refid']."&a_bid=".$bannerID."' WIDTH=1 HEIGHT=1 BORDER=0>";
                $code .= "<center><b>".$title."</b><br>".$description."</center>";
                $code .= "</A>";
            }
            
            return $code;
        }
        else if($bannerType == BANNERTYPE_HTML)
        {
            $description = str_replace('$Affiliate_id', $params['Affiliate_id'], $description);
            $description = str_replace('$Affiliate_name', $params['Affiliate_name'], $description);
            $description = str_replace('$Affiliate_username', $params['Affiliate_username'], $description);
            
            echo $description;
            
            $code = "<IMG SRC=\"".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?a_aid=".$params['Affiliate_refid']."&a_bid=".$bannerID."\" WIDTH=\"1\" HEIGHT=\"1\" BORDER=\"0\">";
            $html = str_replace('$CLICKURL', urlencode($clickUrlOnly."&a_bid=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : '')), $description);
            $code .= $html;  
            
            return $code;
        }
        else if($bannerType == BANNERTYPE_IMAGE)
        {
            echo "<img src='".$sourceUrl."' border=0><br>";
            
            $code = "<A HREF=\"".$clickUrlOnly."&a_bid=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : '')."\">";
            $code .= "<IMG SRC=\"".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?a_aid=".$params['Affiliate_refid']."&a_bid=".$bannerID."\" BORDER=\"0\">";
            $code .= "</A>";  
            
            return $code;
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function drawSubAffSignup()
    {
        $this->addContent('sub_aff_signup');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function getCountBannersAsArray()
    {
        $sql = 'select campaignid, count(bannerid) as countbanners from wd_pa_banners where deleted=0 group by campaignid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $countbanners = array();
        
        while(!$rs->EOF)
        {
            $countbanners[$rs->fields['campaignid']] = $rs->fields['countbanners'];
            
            $rs->MoveNext();
        }
        
        return $countbanners;
    }  
    
    //--------------------------------------------------------------------------
    
    function getBannerUrlsAsArray()
    {
        $sql = 'select id1, value from wd_g_settings '.
        'where accountid='._q($GLOBALS['Auth']->getAccountID()).
        '  and code = \''.SETTINGTYPEPREFIX_AFF_CAMP.'banner_url\'';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $banner_urls = array();
        
        while(!$rs->EOF)
        {
            $banner_urls[$rs->fields['id1']] = $rs->fields['value'];
            
            $rs->MoveNext();
        }
        
        return $banner_urls;
    }
}
?>
