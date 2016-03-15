<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Views_AdvertisementManager');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');

class Affiliate_Merchants_Views_BannerManager extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['addbanner'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['editbanner'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['add'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['edit'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['delete'] = 'aff_camp_banner_links_modify';
        $this->modulePermissions['view'] = 'aff_camp_banner_links_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'addbanner':
                    if($this->processAddBanner())
                        return;
                    break;
              
                case 'editbanner':
                    if($this->processEditBanner())
                        return;
                    break;
            }
        }
    
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'add':
                    if($this->drawFormAddBanner())
                        return;
                    break;              

                case 'edit':
                    if($this->drawFormEditBanner())
                        return;
                    break;
              
                case 'delete':
                    if($this->processDeleteBanner())
                        return;
                    break;
            }
        }
    
        $this->showBanners();
    }

    //------------------------------------------------------------------------
  
    function processDeleteBanner()
    {
        $bannerid = preg_replace('/[\'\"]/', '', $_REQUEST['bid']);
    
        if(AFF_DEMO == 1 && $bannerid == '2')
            return false;
          
        $sql = 'update wd_pa_banners set deleted=1 where bannerid='._q($bannerid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
          
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
    
        return false;
    }

    //--------------------------------------------------------------------------

    function processEditBanner()
    {
        $type = $_POST['type'];
        if($type == 'text' || $type == 'image' || $type == 'html')
        {
            // protect against script injection
            $pdesturl = preg_replace('/[\'\"]/', '', $_POST['desturl']);
            $psourceurl = preg_replace('/[\'\"]/', '', $_POST['sourceurl']);
            $pdesc = $_POST['desc'];
            $BannerID = preg_replace('/[\'\"]/', '', $_POST['bid']);
            $CampaignID = preg_replace('/[\'\"]/', '', $_POST['campaign']);      
      
            if(AFF_DEMO == 1 && $BannerID == '2')
                return false;
        
            // check correctness of the fields
            checkCorrectness($_POST['desturl'], $pdesturl, L_G_DESTURL, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['campaign'], $CampaignID, L_G_PCNAME, CHECK_EMPTYALLOWED);
      
            if($_POST['catname'] != '' && $this->checkBannerExists($_POST['catname'], $BannerID))
                QUnit_Messager::setErrorMessage(L_G_CATEGORYEXISTS);
      
            if($type == 'text')
            {
                checkCorrectness($_POST['sourceurl'], $psourceurl, L_G_TITLE, CHECK_EMPTYALLOWED);
                checkCorrectness($_POST['desc'], $pdesc, L_G_DESCRIPTION, CHECK_ALLOWED);
                $btype = BANNERTYPE_TEXT;
            }
            else if($type == 'html')
            {
                checkCorrectness($_POST['desc'], $pdesc, L_G_DESCRIPTION, CHECK_ALLOWED);
                $btype = BANNERTYPE_HTML;
            }
            else if($type == 'image')
            {
                $btype = BANNERTYPE_IMAGE;

                // check file upload
                if($_FILES['sourcebanner']['name'] == '')
                {
                    if($_POST['sourceurl'] != '')
                    {
                        checkCorrectness($_POST['sourceurl'], $psourceurl, L_G_PICTUREURL, CHECK_EMPTYALLOWED);
                    }
                    else
                        QUnit_Messager::setErrorMessage(L_G_YOUHAVETOSELECTIMAGE);
                }
                else
                {
                    // check directory exists
                    if(!file_exists($GLOBALS['Auth']->getSetting('Aff_banners_dir')))
                    {
                        QUnit_Messager::setErrorMessage(L_G_SPECIFIEDBANNERSDIRDOESNOTEXISTS.$GLOBALS['Auth']->getSetting('Aff_banners_dir'));
                    }
                    else
                    {
                        // check if the file doesn't exist in the banners directory
                        if(file_exists($GLOBALS['Auth']->getSetting('Aff_banners_dir').$_FILES['sourcebanner']['name']))
                        {
                            QUnit_Messager::setErrorMessage(L_G_SPECIFIEDIMAGENAMEALREADYEXISTS.$GLOBALS['Auth']->getSetting('Aff_banners_dir'));
                        }
                        else
                        {
                            if(!is_uploaded_file($_FILES['sourcebanner']['tmp_name'])) 
                                QUnit_Messager::setErrorMessage(L_G_FILEUPLOADATTACK);
                            else
                            {
                                if(QUnit_Messager::getErrorMessage() == '')
                                {
                                    // upload the banner
                                    if(@move_uploaded_file($_FILES['sourcebanner']['tmp_name'], $GLOBALS['Auth']->getSetting('Aff_banners_dir').$_FILES['sourcebanner']['name']))
                                    {
                                        $psourceurl = $GLOBALS['Auth']->getSetting('Aff_banners_url').$_FILES['sourcebanner']['name'];
                                        @chmod($GLOBALS['Auth']->getSetting('Aff_banners_dir').$_FILES['sourcebanner']['name'], 0644);
                                    }
                                    else
                                        QUnit_Messager::setErrorMessage(L_G_ERRORUPLOADINGBANNER);
                                }
                            }
                        }
                    }
                }
            }
        }
        else
            QUnit_Messager::setErrorMessage(L_G_WRONGBANNERTYPE);
    
        if(QUnit_Messager::getErrorMessage() != '')
        {
        }
        else
        {
            // save changes of user to db
            $sql = "update wd_pa_banners set destinationurl=".myquotes($pdesturl).", sourceurl=".myquotes($psourceurl).", description=".myquotes($pdesc).", campaignid=".myquotes($CampaignID)." where bannerid="._q($BannerID);
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            else
            {
                QUnit_Messager::setOkMessage(L_G_BANNEREDITED);
                $_REQUEST['action'] = '';

                return false;
            }
        }
    
        return false;
    }

    //------------------------------------------------------------------------

    function processAddBanner()
    {
        $type = $_POST['type'];
        if($type == 'text' || $type == 'image' || $type == 'html')
        {
            // protect against script injection
            $pdesturl = preg_replace('/[\'\"]/', '', $_POST['desturl']);
            $psourceurl = preg_replace('/[\'\"]/', '', $_POST['sourceurl']);
            $pdesc = $_POST['desc'];
           if($_POST['bid'] != '')
		   {
			$BannerID = preg_replace('/[\'\"]/', '', $_POST['bid']);
			}
			else
			{
			$BannerID = QCore_Sql_DBUnit::createUniqueID('wd_pa_banners', 'bannerid');
			}
            $CampaignID = preg_replace('/[\'\"]/', '', $_POST['campaign']);
    
            // check correctness of the fields
            checkCorrectness($_POST['desturl'], $pdesturl, L_G_DESTURL, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['campaign'], $CampaignID, L_G_PCNAME, CHECK_EMPTYALLOWED);
      
            if($_POST['catname'] != '' && $this->checkBannerExists($_POST['catname'], $BannerID))
                QUnit_Messager::setErrorMessage(L_G_CATEGORYEXISTS);

            if($type == 'text')
            {
                checkCorrectness($_POST['sourceurl'], $psourceurl, L_G_TITLE, CHECK_EMPTYALLOWED);
                checkCorrectness($_POST['desc'], $pdesc, L_G_DESCRIPTION, CHECK_ALLOWED);
                $btype = BANNERTYPE_TEXT;
            }
            else if($type == 'html')
            {
                checkCorrectness($_POST['desc'], $pdesc, L_G_DESCRIPTION, CHECK_ALLOWED);
                $btype = BANNERTYPE_HTML;
            }
            else if($type == 'image')
            {
                $btype = BANNERTYPE_IMAGE;

                // check file upload
                if($_FILES['sourcebanner']['name'] == '')
                {
                    if($_POST['sourceurl'] != '')
                    {
                        checkCorrectness($_POST['sourceurl'], $psourceurl, L_G_PICTUREURL, CHECK_EMPTYALLOWED);
                    }
                    else
                        QUnit_Messager::setErrorMessage(L_G_YOUHAVETOSELECTIMAGE);
                }
                else
                {
                    // check directory exists
                    if(!file_exists($GLOBALS['Auth']->getSetting('Aff_banners_dir')))
                    {
                        QUnit_Messager::setErrorMessage(L_G_SPECIFIEDBANNERSDIRDOESNOTEXISTS);
                    }
                    else
                    {
                        // check if the file doesn't exist in the banners directory
                        if(file_exists($GLOBALS['Auth']->getSetting('Aff_banners_dir').$_FILES['sourcebanner']['name']))
                        {
                            QUnit_Messager::setErrorMessage(L_G_SPECIFIEDIMAGENAMEALREADYEXISTS);
                        }
                        else
                        {
                            if(!is_uploaded_file($_FILES['sourcebanner']['tmp_name'])) 
                                QUnit_Messager::setErrorMessage(L_G_FILEUPLOADATTACK);
                            else
                            {
                                if(QUnit_Messager::getErrorMessage() == '')
                                {
                                    // upload the banner
                                    if(@move_uploaded_file($_FILES['sourcebanner']['tmp_name'], $GLOBALS['Auth']->getSetting('Aff_banners_dir').$_FILES['sourcebanner']['name']))
                                    {
                                        $psourceurl = $GLOBALS['Auth']->getSetting('Aff_banners_url').$_FILES['sourcebanner']['name'];
                                        @chmod($GLOBALS['Auth']->getSetting('Aff_banners_dir').$_FILES['sourcebanner']['name'], 0644);
                                    }
                                    else
                                        QUnit_Messager::setErrorMessage(L_G_ERRORUPLOADINGBANNER);
                                }
                            }
                        }
                    }
                }
            }
        }
        else
            QUnit_Messager::setErrorMessage(L_G_WRONGBANNERTYPE);
    
        if(QUnit_Messager::getErrorMessage() != '')
        {
        }
        else
        {
            // save changes of user to db
            $ppwd = md5($ppwd1);
     // insert all into db
            $sql = "insert into wd_pa_banners(bannerid, campaignid, destinationurl, sourceurl, description, bannertype)".
                   "values(".myquotes($BannerID).",".myquotes($CampaignID).",".myquotes($pdesturl).",".myquotes($psourceurl).",".myquotes($pdesc).",".myquotes($btype).")";

            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            else
            {
                QUnit_Messager::setOkMessage(L_G_BANNERADDED);
                $_REQUEST['action'] = '';
                
                return false;
            }
        }
    
        return false;
    }

    //------------------------------------------------------------------------

    function drawFormEditBanner()
    {
        if($_POST['commited'] != 'yes')
        {
            $bannerid = preg_replace('/[\'\"]/', '', $_REQUEST['bid']);
            $sql = 'select * from wd_pa_banners where deleted=0 and bannerid='._q($bannerid);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
      
            $_POST['bid'] = $rs->fields['bannerid'];
            $_POST['desturl'] = $rs->fields['destinationurl'];
            $_POST['sourceurl'] = $rs->fields['sourceurl'];
            $_POST['desc'] = $rs->fields['description'];
            $_POST['campaign'] = $rs->fields['campaign'];      
            $_REQUEST['campaign'] = $rs->fields['campaignid'];      

            if($rs->fields['bannertype'] == BANNERTYPE_TEXT)
                $_REQUEST['type'] = 'text';
            else if($rs->fields['bannertype'] == BANNERTYPE_IMAGE)
                $_REQUEST['type'] = 'image';
            else if($rs->fields['bannertype'] == BANNERTYPE_HTML)
                $_REQUEST['type'] = 'html';        
        }
    
        $_POST['header'] = L_G_EDITBANNER;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'editbanner';  
    
        $this->drawFormAddBanner();
    
        return true;
    }

    //------------------------------------------------------------------------

    function drawFormAddBanner()
    {
        if(!isset($_POST['action'])) $_POST['action'] = 'add';
        if(!isset($_POST['postaction'])) $_POST['postaction'] = 'addbanner';  
    
        if(!isset($_POST['header']))
        {
            if($_REQUEST['type'] == 'text')
                $_POST['header'] = L_G_ADDTEXT;
            else if($_REQUEST['type'] == 'image')
                $_POST['header'] = L_G_ADDIMAGE;
            else if($_REQUEST['type'] == 'html')
                $_POST['header'] = L_G_ADDHTML;
        }
    
        if($_POST['desturl'] == '')
            $_POST['desturl'] = 'http://';

        $campaigns = Affiliate_Merchants_Views_AdvertisementManager::getAdvertisementsAsArray();    

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns);

        $this->assign('a_list_data', $list_data);

        $this->addContent('banner_edit');

        return true;
    }

    //------------------------------------------------------------------------

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
        if($_REQUEST['showBannerStats'] == '') $_REQUEST['showBannerStats'] = 0;
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
        $_SESSION['showBannerStats'] = $_REQUEST['showBannerStats'];
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
        
        $this->assign('a_curyear', date("Y"));
        $campaignid = preg_replace('/[\'\"]/', '', $_REQUEST['campaign']);

        $sql = 'select b.*, c.name as campaignname '.
               'from wd_pa_banners b, wd_pa_campaigns c ';
               
        $where='where c.campaignid=b.campaignid and c.deleted=0 and b.deleted=0 '.
               '  and c.accountid='._q($GLOBALS['Auth']->getAccountID()) . ' AND c.campaign_type = ' . _q('ADVERTISEMENT');
        
        if($campaignid != '' && $campaignid != '_') {
            $where .= ' and b.campaignid='._q($campaignid);
        }

        $rs = QCore_Sql_DBUnit::execute($sql.$where, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $this->assign('a_numrows', $rs->PO_RecordCount('wd_pa_banners b, wd_pa_campaigns c ', $where));

        $campaigns = Affiliate_Merchants_Views_AdvertisementManager::getAdvertisementsAsArray();
        
        if ($_REQUEST['showBannerStats']){
        	$bannerStats = Affiliate_Scripts_Bl_SaleStatistics::getBannerStats($_REQUEST['bs_affiliate'], $d1, $m1, $y1, $d2, $m2, $y2);
        }
        $affiliates = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();

        $aff_list = QUnit_Global::newobj('QCore_RecordSet');
        $aff_list->setTemplateRS($affiliates);
        $this->assign('a_aff_list', $aff_list);

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);

        $this->assign('a_list_data', $list_data);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($campaigns);

        $this->assign('a_list_data2', $list_data2);

        $this->assign('a_bannerStats', $bannerStats);
        $this->assign('a_campaignbanners', $campaignbanners);

        $temp_perm['add'] = $this->checkPermissions('add');
        $temp_perm['edit'] = $this->checkPermissions('edit');
        $temp_perm['delete'] = $this->checkPermissions('delete');

        $this->assign('a_action_permission', $temp_perm);

        $this->addContent('banner_show');
    }

    //------------------------------------------------------------------------
  
    function checkBannerExists($catname, $cid = '')
    {
        $sql = 'select * from wd_g_linkcategories where deleted=0 and campaignid='._q($_SESSION[SESSION_PREFIX.'campaignchosen']).' and bannername='.myquotes($catname);
        if($cid != '')
            $sql .= ' and linkbannerid<>'._q($cid);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
    
        if($rs->EOF)
            return false;
      
        return true;
    }

    //------------------------------------------------------------------------

    function getCountBannersAsArray()
    {
        $sql = 'select campaignid, count(bannerid) as countbanners from wd_pa_banners where deleted=0 group by campaignid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
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
}
?>
