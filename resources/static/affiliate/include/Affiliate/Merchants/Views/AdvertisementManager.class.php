<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Campaign');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampCategoriesManager');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CampaignCategories');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');
QUnit_Global::includeClass('Affiliate_Merchants_Views_BannerManager');

class Affiliate_Merchants_Views_AdvertisementManager extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['addcampaign'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['edit'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['add'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['view_banner'] = 'aff_camp_banner_links_view';
        $this->modulePermissions['delete'] = 'aff_camp_product_categories_modify';
        $this->modulePermissions['view'] = 'aff_camp_product_categories_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'addcampaign':
                    if($this->processAddCampaign())
                        return;
                    break;
                
                case 'edit':
                    if($this->processEditCampaign())
                        return;
                    break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'add':
                    if($this->drawFormAddCampaign())
                        return;
                    break;       
                
                case 'edit':
                    if($this->drawFormEditCampaign())
                        return;
                    break;       
                
                case 'delete':
                    if($this->processDeleteCampaign())
                        return;
                    break;
                
                case 'deleteRule':
                    if($this->processDeleteRule())
                        return;
                    break;
            }
        }
        
        $this->showCampaigns();
    }
    
    //--------------------------------------------------------------------------

    function processDeleteCampaign()
    {
        $CampaignID = preg_replace('/[\'\"]/', '', $_REQUEST['cid']);
        
        if(AFF_DEMO == 1 && $CampaignID == 3)
            return false;
        
        $params = array('campaignid' => $CampaignID);
        
        $ret = Affiliate_Merchants_Bl_Campaign::delete($params);
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function processDeleteRule()
    {
        $RuleID = preg_replace('/[\'\"]/', '', $_POST['rid']);

        if(AFF_DEMO == 1 && $CampaignID == 3)
            return false;
        
        $params = array('ruleid' => $RuleID,
                        'AccountID' => $GLOBALS['Auth']->getAccountID());
        
        $ret = Affiliate_Merchants_Bl_Rules::deleteRule($params);

        $this->redirect('Affiliate_Merchants_Views_CampaignManager&action=edit&&sheet=performance_rules&cid='.$_POST['cid']);
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function processEditCampaign()
    {
        $data = $this->protectData();
        
        $campaignProcessedData = $this->processCampaign($data);

        $campaignCommission = false;
        $processedData = true;
        switch($_POST['subact'])
        {
            case 'commissions': $campaignCommissions = $this->processEditCampaignCommissions($data); break;
            case 'specialcommissions': $processedData = $this->processEditCampaignSpecialCommissions($data); break;
            case 'campsettings': $processedData = $this->processEditCampaignSettings($data); break;
            case 'performance_rules': $campaignRule = $this->processEditCampaignPerformanceRules($data); break;
        }

        if(!$processedData || !$campaignProcessedData || QUnit_Messager::getErrorMessage() != '')
        {
            if(QUnit_Messager::getErrorMessage() == '')
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVECAMPAIGN);
                
            // stay in the same page
            $_REQUEST['sheet'] = $_POST['subact'];
            Affiliate_Merchants_Views_CampaignManager::drawFormEditCampaign();
        }
        else
        {
            // save change
            $ret = Affiliate_Merchants_Bl_Campaign::updateAd($campaignProcessedData);

            if($campaignCommissions != false)
            {
                // save commissions
                $ret = Affiliate_Merchants_Bl_CampaignCategories::updateCategory($campaignCommissions);
            }

            if(is_array($processedData) && $ret)
            {
                $ret = Affiliate_Merchants_Bl_Campaign::updateSettings($processedData);
            }

            if(is_array($campaignRule) && $ret)
            {
                $ret = Affiliate_Merchants_Bl_Rules::updateRule($campaignRule);
            }
            
            if(!$ret)
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
            else
                QUnit_Messager::setOkMessage(L_G_SETTINGSSAVED);
            
            $GLOBALS['Auth']->loadSettings();

            if($data['psheet'] != '')
                $_REQUEST['sheet'] = $data['psheet'];
                
            Affiliate_Merchants_Views_CampaignManager::drawFormEditCampaign();
        }
        
        return true;
    }
    
    //------------------------------------------------------------------------

    function protectData()
    {
        // protect against script injection
        $data = array();
        
        $data['cname'] = preg_replace('/[\'\"]/', '', $_POST['cname']);
        $data['banner_url'] = preg_replace('/[\'\"]/', '', $_POST['banner_url']);
        $data['description'] = preg_replace('/[\'\"]/', '', $_POST['description']);
        $data['commtype'] = preg_replace('/[\'\"]/', '', $_POST['commtype']);
        $data['commtype2'] = preg_replace('/[\'\"]/', '', $_POST['commtype2']);
        $data['sheet'] = preg_replace('/[\'\"]/', '', $_POST['sheet']);
        $data['cid'] = preg_replace('/[\'\"]/', '', $_POST['cid']);
        $data['cookielifetime'] = preg_replace('/[^0-9]/', '', $_POST['cookielifetime']);
        $data['clickapproval'] = preg_replace('/[^0-9]/', '', $_POST['clickapproval']);
        $data['saleapproval'] = preg_replace('/[^0-9]/', '', $_POST['saleapproval']);
        $data['affapproval'] = preg_replace('/[^0-9]/', '', $_POST['affapproval']);
        $data['status'] = preg_replace('/[^0-9]/', '', $_POST['status']);
        $data['signup_bonus'] = preg_replace('/[\'\"]/', '', $_POST['signup_bonus']);
        $data['products'] = preg_replace('/[\'\"]/', '', $_POST['products']);
        $data['banner_url'] = preg_replace('/[\'\"]/', '', $_POST['banner_url']);
        $data['shortdescription'] = preg_replace('/[\'\"]/', '', $_POST['shortdescription']);
        $data['description'] = preg_replace('/[\'\"]/', '', $_POST['description']);
        $data['cond_action'] = preg_replace('/[\'\"]/', '', $_POST['cond_action']);
        $data['cond_action_value'] = preg_replace('/[\'\"]/', '', $_POST['cond_action_value']);
        $data['cond_when'] = preg_replace('/[^0-9]/', '', $_POST['cond_when']);
        $data['cond_in'] = preg_replace('/[^0-9]/', '', $_POST['cond_in']);
        $data['cond_is'] = preg_replace('/[^0-9]/', '', $_POST['cond_is']);
        $data['cond_is_type'] = preg_replace('/[^0-9]/', '', $_POST['cond_is_type']);
        $data['cond_value1'] = preg_replace('/[\'\"]/', '', $_POST['cond_value1']);
        $data['cond_value2'] = preg_replace('/[\'\"]/', '', $_POST['cond_value2']);
        $data['cond_value3'] = preg_replace('/[\'\"]/', '', $_POST['cond_value3']);
        $data['ruleid'] = preg_replace('/[\'\"]/', '', $_POST['rid']);
        $data['editrid'] = preg_replace('/[\'\"]/', '', $_POST['editrid']);
        $data['sheet'] = preg_replace('/[\'\"]/', '', $_POST['sheet']);
        $data['catname'] = preg_replace('/[\'\"]/', '', $_POST['catname']);

        return $data;
    }
    
    //--------------------------------------------------------------------------

    function processCampaign($data)
    {
        // check correctness of the fields
        checkCorrectness($_POST['cname'], $data['cname'], L_G_PCNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banner_url'], $data['banner_url'], L_G_COMPLETE_URL_BANNERS_IMAGE, CHECK_ALLOWED);
        checkCorrectness($_POST['shortdescription'], $data['shortdescription'], L_G_DESCRIPTION, CHECK_ALLOWED);
        checkCorrectness($_POST['description'], $data['description'], L_G_DESCRIPTION, CHECK_ALLOWED);
        
        if(!is_array($data['commtype']) || count($data['commtype']) < 1 )
        {
            QUnit_Messager::setErrorMessage(L_G_COMMISSIONTYPEMUSTBECHOSEN);
        }
        else
        {
            $data['commtype'] = Affiliate_Merchants_Views_CampaignManager::convertCommtypeToArray2($data['commtype'], $data['commtype2']);
        }

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'cname' => $data['cname'],
                            'commtype' => $data['commtype'],
                            'campaignid' => $data['cid'],
                            'shortdescription' => $data['shortdescription'],
                            'description' => $data['description'],
                            'banner_url' => $data['banner_url'],
                            'products' => $data['products'],
                        );
        }
        
        return false;
    }

    //--------------------------------------------------------------------------

    function convertCommtypeToArray2($oldcommtype, $commtype2)
    {
        $commtype = 0;
        foreach($oldcommtype as $ct)
        {
            if($ct != '_')
            {
                $commtype |= $ct;
            }
            else
            {
                $commtype |= $commtype2;
            }
        }
        
        return $commtype;
    }
    
    //--------------------------------------------------------------------------
    
    function processEditCampaignCommissions($data)
    {
        $_POST['catid'] = Affiliate_Merchants_Bl_CampaignCategories::getDefaultCategoryID($data['cid']);
        if($_POST['catname'] == '')
            $_POST['catname'] = UNASSIGNED_USERS;

        return Affiliate_Merchants_Bl_CampaignCategories::protectVars();
    }
    
    //--------------------------------------------------------------------------
    
    function processEditCampaignSpecialCommissions()
    {
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function processEditCampaignSettings($data)
    {
        // check correctness of the fields
        checkCorrectness($_POST['cookielifetime'], $data['cookielifetime'], L_G_COOKIELIFETIME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['clickapproval'], $data['clickapproval'], L_G_TRANSCLICKAPPROVAL, CHECK_EMPTYALLOWED, CHECK_INARRAY, array(APPROVE_AUTOMATIC, APPROVE_MANUAL));
        checkCorrectness($_POST['saleapproval'], $data['saleapproval'], L_G_TRANSSALEAPPROVAL, CHECK_EMPTYALLOWED, CHECK_INARRAY, array(APPROVE_AUTOMATIC, APPROVE_MANUAL));
        checkCorrectness($_POST['affapproval'], $data['affapproval'], L_G_AFFILIATE_APPROVAL, CHECK_EMPTYALLOWED);
        
        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1')
        {
            checkCorrectness($_POST['status'], $data['status'], L_G_STATUS, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['signup_bonus'], $data['signup_bonus'], L_G_SIGNUP_BONUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        }
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            $params = array(
                            'cid' => $data['cid'],
                            'cookielifetime' => $data['cookielifetime'],
                            'clickapproval' => $data['clickapproval'],
                            'saleapproval' => $data['saleapproval'],
                            'affapproval' => $data['affapproval']
                           );

            if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1')
                $params = array_merge($params, array('status' => $data['status'],'signup_bonus' => $data['signup_bonus']));

            return $params;
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function processEditCampaignPerformanceRules($data)
    {
        // check correctness of the fields
        checkCorrectness($_POST['cond_action'], $data['cond_action'], L_G_ACTION, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['cond_action_value'], $data['cond_action_value'], L_G_ACTION.' '.L_G_VALUE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['cond_when'], $data['cond_when'], L_G_WHEN, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['cond_in'], $data['cond_in'], L_G_IN.' '.L_G_VALUE, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['cond_is'], $data['cond_is'], L_G_IS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        if($data['cond_is_type'] == RULE_IS_BETWEEN) {
            checkCorrectness($_POST['cond_value2'], $data['cond_value2'], L_G_VALUE, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['cond_value3'], $data['cond_value3'], L_G_VALUE, CHECK_EMPTYALLOWED);
        }
        else
        {
          checkCorrectness($_POST['cond_value1'], $data['cond_value1'], L_G_VALUE, CHECK_EMPTYALLOWED);
          $data['cond_value2'] = '';
        }
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            if($data['cond_is_type'] == RULE_IS_BETWEEN)
            {
                if($data['cond_value2'] > $data['cond_value3'])
                {
                  $data['cond_value1'] = $data['cond_value3'];
                }
                else
                {
                    $data['cond_value1'] = $data['cond_value2'];
                    $data['cond_value2'] = $data['cond_value3'];
                }
            }
            
            return array('cond_action' => $data['cond_action'],
                         'cond_action_value' => $data['cond_action_value'],
                         'cond_when' => $data['cond_when'],
                         'cond_in' => $data['cond_in'],
                         'cond_is' => $data['cond_is'],
                         'cond_is_type' => $data['cond_is_type'],
                         'cond_value1' => $data['cond_value1'],
                         'cond_value2' => $data['cond_value2'],
                         'ruleid' => $data['ruleid'],
                         'AccountID' => $GLOBALS['Auth']->getAccountID()
                        );
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function processCommtypeFromForm()
    {
        $ctArr = array();
        
        foreach($_POST['commtype'] as $commtype)
        {
            if($commtype != '_')
                $ctArr[] = $commtype;
            else
                $ctArr[] = $_POSt['commtype2'];
        }

        return $ctArr;
    }
    
    //--------------------------------------------------------------------------
    
    function processAddCampaign()
    {
        // protect against script injection
        $pcname = preg_replace('/[\'\"]/', '', $_POST['cname']);
        $pproducts = preg_replace('/[\'\"]/', '', $_POST['products']);    
        $pcookielifetime = preg_replace('/[^0-9]/', '', $_POST['cookielifetime']);
        $pclickapproval = preg_replace('/[^0-9]/', '', $_POST['clickapproval']);
        $psaleapproval = preg_replace('/[^0-9]/', '', $_POST['saleapproval']);
        $paffapproval = preg_replace('/[^0-9]/', '', $_POST['affapproval']);
        $pstatus = preg_replace('/[^0-9]/', '', $_POST['status']);
        $psignup_bonus = preg_replace('/[\'\"]/', '', $_POST['signup_bonus']);
        $pcommtype = preg_replace('/[\'\"]/', '', $_POST['commtype']);
        $pcommtype2 = preg_replace('/[\'\"]/', '', $_POST['commtype2']);
        $pbanner_url = preg_replace('/[\'\"]/', '', $_POST['banner_url']);
        $pdescription = preg_replace('/[\'\"]/', '', $_POST['description']);
        $pshortdescription = preg_replace('/[\'\"]/', '', $_POST['shortdescription']);
        
        // check correctness of the fields
        checkCorrectness($_POST['cname'], $pcname, L_G_PCNAME, CHECK_EMPTYALLOWED);
        
        if($_POST['cname'] != '' && $this->checkCampaignExists($_POST['cname']))
            QUnit_Messager::setErrorMessage(L_G_CNAMEEXISTS);
        
        checkCorrectness($_POST['cookielifetime'], $pcookielifetime, L_G_COOKIELIFETIME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['clickapproval'], $pclickapproval, L_G_TRANSCLICKAPPROVAL, CHECK_EMPTYALLOWED, CHECK_INARRAY, array(APPROVE_AUTOMATIC, APPROVE_MANUAL));
        checkCorrectness($_POST['saleapproval'], $psaleapproval, L_G_TRANSSALEAPPROVAL, CHECK_EMPTYALLOWED, CHECK_INARRAY, array(APPROVE_AUTOMATIC, APPROVE_MANUAL));
        checkCorrectness($_POST['affapproval'], $paffapproval, L_G_AFFILIATE_APPROVAL, CHECK_EMPTYALLOWED);
        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1')
        {
            checkCorrectness($_POST['signup_bonus'], $psignup_bonus, L_G_SIGNUP_BONUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
            checkCorrectness($_POST['status'], $pstatus, L_G_STATUS, CHECK_EMPTYALLOWED);
        }
        else
        {
            $pstatus = AFF_CAMP_PUBLIC;
            $psignup_bonus = 0;
        }
        
        checkCorrectness($_POST['products'], $pproducts, L_G_ALLOWEDPRODUCTS, CHECK_ALLOWED);
        checkCorrectness($_POST['banner_url'], $pbanner_url, L_G_COMPLETE_URL_BANNERS_IMAGE, CHECK_ALLOWED);
        checkCorrectness($_POST['description'], $pdescription, L_G_DESCRIPTION, CHECK_ALLOWED);
        checkCorrectness($_POST['shortdescription'], $pshortdescription, L_G_SHORTDESCRIPTION, CHECK_ALLOWED);

        if(!is_array($pcommtype) || count($pcommtype) < 1 )
        {
            QUnit_Messager::setErrorMessage(L_G_COMMISSIONTYPEMUSTBECHOSEN);
        }
        else
        {
            $pcommtype = Affiliate_Merchants_Views_CampaignManager::convertCommtypeToArray2($pcommtype, $pcommtype2);
        }

//        $ctype_bit_form = $this->CommTypeToBitForm($pcommtype);
        
//        if($pcommtype == '' || $ctype_bit_form === false)
//            QUnit_Messager::setErrorMessage(L_G_COMMISSIONTYPEMUSTBECHOSEN);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            $CampaignID = QCore_Sql_DBUnit::createUniqueID('wd_pa_campaigns', 'campaignid');
            $AffCategoryID = QCore_Sql_DBUnit::createUniqueID('wd_pa_campaigncategories', 'campcategoryid');
            
            $params = array('cname' => $pcname,
                            'commtype' => $pcommtype,
                            'campaignid' => $CampaignID,
                            'affcategoryid' => $AffCategoryID,
                            'products' => $pproducts,
                            'cookielifetime' => $pcookielifetime,
                            'clickapproval' => $pclickapproval,
                            'saleapproval' => $psaleapproval,
                            'affapproval' => $paffapproval,
                            'description' => $pdescription,
                            'shortdescription' => $pshortdescription,
                            'banner_url' => $pbanner_url,
                            'signup_bonus' => $psignup_bonus,
                            'status' => $pstatus
                           );
            
            $ret = Affiliate_Merchants_Bl_Campaign::insertAd($params);
            
            if(!$ret) return false;
            
            QUnit_Messager::setOkMessage(L_G_CAMPAIGNADDED);
                
            $this->showCampaigns();
                
            return true;
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function loadCampaignInfo()
    {
        $campaignid = preg_replace('/[\'\"]/', '', $_REQUEST['cid']);
        
        $params['campaignid'] = $campaignid;

        $data = Affiliate_Merchants_Bl_Campaign::loadAd($params);

        if(!$data) return false;

        $_POST['cid'] = $data['campaignid'];
        $_POST['cname'] = $data['name'];

        Affiliate_Merchants_Views_CampaignManager::convertCommtypeToArray($data['commtype']);

        $_POST['products'] = $data['products'];
        $_POST['description'] = $data['description'];
        $_POST['shortdescription'] = $data['shortdescription'];

        $data = Affiliate_Merchants_Bl_Settings::getCampaignInfo($params);

        $_POST['cookielifetime'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'cookielifetime'];
        $_POST['clickapproval'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'clickapproval'];
        $_POST['saleapproval'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'saleapproval'];
        $_POST['affapproval'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'affapproval'];
        $_POST['status'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'status'];
        $_POST['signup_bonus'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'signup_bonus'];
        $_POST['banner_url'] = $data[SETTINGTYPEPREFIX_AFF_CAMP.'banner_url'];

        // load settings of first commission category ('unassigned users')
        $data = Affiliate_Merchants_Bl_CampaignCategories::loadDefaultCommissionCategory($campaignid);

        if(is_array($data) && count($data) > 0)
            foreach($data as $k => $v)
                $_POST[$k] = $v;
        
        return true;
    }

    //--------------------------------------------------------------------------

    function convertCommtypeToArray($rsCommType)
    {
        $allowedTypes = $GLOBALS['Auth']->getAllowedCommissionTypes();
        $commtype = array();

        $_POST['commtype'] = array();
        foreach($allowedTypes as $commType)
        {
            if((int)$commType & (int)$rsCommType)
            {
                if($commType == TRANSTYPE_LEAD || $commType == TRANSTYPE_SALE)
                {
                    $_POST['commtype'][] = '_';
                    $_POST['commtype2'] = $commType;
                }
                
                $_POST['commtype'][] = $commType;
            }
        }
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormEditCampaign()
    {     
        
        if($_REQUEST['sheet'] == '')
        
            $_REQUEST['sheet'] = 'commissions';

//        if($_POST['commited'] != 'yes')
//        {
            if(!$this->loadCampaignInfo())
                return false;
//        }

        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'edit';
        
        $tabs = array(
            array('commissions' , "<a href=\"javascript:changeSheet('edit', 'commissions');\">".L_G_COMMISSIONS."</a>"),
            array('specialcommissions' , "<a href=\"javascript:changeSheet('edit', 'specialcommissions');\">".L_G_SPECIAL_COMMISSIONS."</a>"),
            array('campsettings' , "<a href=\"javascript:changeSheet('edit', 'campsettings');\">".L_G_CAMPSETTINGS."</a>"),
            array('performance_rules' , "<a href=\"javascript:changeSheet('edit', 'performance_rules');\">".L_G_PERFORMANCE_RULES."</a>"),
        );
        
        $selectedTab = $_REQUEST['sheet'];
        
        $this->assign('a_tabs', $tabs);
        $this->assign('a_selectedTab', $selectedTab);
        
        switch($_REQUEST['sheet'])
        {
            case 'commissions': return $this->drawFormEditCampaignCommissions();
            case 'specialcommissions': return $this->drawFormEditCampaignSpecialCommissions();
            case 'campsettings': return $this->drawFormEditCampaignAffSettings();
            case 'performance_rules': return $this->drawFormEditCampaignPerformanceRules();
        }          
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormEditCampaignCommissions()
    {
        $_POST['header'] = L_G_COMMISSIONS;
        
        // fetch template of sub section
        $this->initTemporaryTE();
        $content = $this->temporaryFetch('commissions');
        
        $this->assign('a_tabcontent', $content);
        $this->addContent('ads');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormEditCampaignSpecialCommissions()
    {
        $_POST['header'] = L_G_SPECIAL_COMMISSIONS;
        
        $campCategories = QUnit_Global::newobj('Affiliate_Merchants_Views_CampCategoriesManager');
        $campCategories->init();
        $campCategories->showCategories($_POST['cid']);    
        
        $this->assign('a_tabcontent', $campCategories->temp_content);
//        $this->clearTempContent();
        
        $this->addContent('ads');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormEditCampaignAffSettings()
    {
        // fetch template of sub section
        $this->initTemporaryTE();
        $content = $this->temporaryFetch('camp_campsettings');

        $this->assign('a_tabcontent', $content);
        
        $_POST['header'] = L_G_AFFSETTINGS;
        
        $this->addContent('ads');
        
        return true;    
    }
    
    //--------------------------------------------------------------------------

    function drawFormEditCampaignPerformanceRules()
    {
        // fetch template of sub section
        $this->initTemporaryTE();

        $params = array('AccountID' => $GLOBALS['Auth']->getAccountID(),
                        'CampaignID' => $_POST['cid'],
                        'ruleid' => ($_POST['editrid'] != '' ? $_POST['editrid'] : $_POST['rid'])
                       );

        Affiliate_Merchants_Bl_Rules::loadRuleToPost($params);

        $camp_params = array('AccountID' => $GLOBALS['Auth']->getAccountID(),
                             'CampaignID' => $_POST['cid']
                            );

        $special_campaigns = Affiliate_Merchants_Views_CampCategoriesManager::getCampCategoriesForRulesAsArray($camp_params);
        $this->temporaryAssign('a_campaigns', $special_campaigns);

        $params = array('AccountID' => $GLOBALS['Auth']->getAccountID(),
                        'CampaignID' => $_POST['cid']
                       );

        $rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params);

        if($rules === false) $rules = array();

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rules);
        $this->temporaryAssign('a_list_data', $list_data);

        $this->temporaryAssign('a_numrows', count($rules));

        $content = $this->temporaryFetch('cm_performance_rules');

        $this->assign('a_tabcontent', $content);

        $_POST['header'] = L_G_PERFORMANCE_RULES;
        
        $this->addContent('ads');
        
        return true;    
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormAddCampaign()
    {
		$merchants = Affiliate_Merchants_Bl_Merchants::getMerchants();
        $this->assign('merchants', Affiliate_Merchants_Bl_Merchants::getMerchants());             
        
        if(!isset($_POST['action']))
        $_POST['action'] = 'add';
        
        $_POST['postaction'] = 'addcampaign';  
        
        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADDCAMPAIGN;
        
        if(!isset($_POST['cookielifetime']))
            $_POST['cookielifetime'] = '0';
        
        if(!isset($_POST['signup_bonus']))
            $_POST['signup_bonus'] = '0';
        
        $this->assign('a_count_allowed_types', $GLOBALS['Auth']->getCountOfAllowedCommissionTypes());
        
        $this->addContent('ad_edit');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function showCampaigns()
    {
        $orderby = '';
        $a = array("name", "dateinserted", "commtype", "weburl", "campaignid");
        
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = "order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            
            $orderby = "order by name asc";
            
        }
        
        $where = "where deleted=0 and accountid="._q($GLOBALS['Auth']->getAccountID()) . " AND campaign_type = " . _q('ADVERTISEMENT');

        if($_REQUEST['alphabetFilter'] != '' && $_REQUEST['alphabetFilter'] != 'All') {
        	$where .= ' AND name like "' . $_REQUEST['alphabetFilter'] .'%" ';
        }
        
        if($_REQUEST['filtered'] == 1)
        {
            $_REQUEST['f_cname'] = preg_replace('/[\'\"]/', '', $_REQUEST['f_cname']);
            $_REQUEST['f_weburl'] = preg_replace('/[\'\"]/', '', $_REQUEST['f_weburl']);
            
            if($_REQUEST['f_cname'] != '')
            {
                $where .= " and (name like '%"._q_noendtags($_REQUEST['f_cname'])."%')";
            }
            if($_REQUEST['f_weburl'] != '')
            {
                $where .= " and (weburl like '%"._q_noendtags($_REQUEST['f_weburl'])."%')";
            }
            if($_REQUEST['f_ctype'] != '')
            {
                $f_ctype_for_list = '';

                if(is_array($_REQUEST['f_ctype']) && count($_REQUEST['f_ctype']) > 0)
                {
                    foreach($_REQUEST['f_ctype'] as $ctype)
                    {
                        $f_ctype_for_list = (int)$f_ctype_for_list | (int)$ctype;
                    }
                }
//                $commtypes = '('.implode(',', $_REQUEST['f_ctype']).')';
//                $commtypes = preg_replace('/[\'\"]/', '', $commtypes);
                
//                $where .= " and (commtype in ".$commtypes.")";
            }
        }
        else
        {
            if($_REQUEST['f_ctype'] == '') $_REQUEST['f_ctype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
        }
        
        $sql = "select * from wd_pa_campaigns $where $orderby";
        
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        $this->addContent('ad_filter');

        $data = array();
        $bannercount = Affiliate_Merchants_Views_BannerManager::getCountBannersAsArray();
        $campaignCommissions = Affiliate_Merchants_Views_CampaignManager::getCommissionsAsArray();
        $campaignParams = Affiliate_Merchants_Views_CampaignManager::getParamsAsArray();

        while(!$rs->EOF)
        {
            if($f_ctype_for_list != '' && !((int)$f_ctype_for_list & (int)$rs->fields['commtype']))
            {
                $rs->MoveNext();
                continue;
            }

            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['name'] = $rs->fields['name'];
            $temp['dateinserted'] = $rs->fields['dateinserted'];
            $temp['commtype'] = $rs->fields['commtype'];
            
            $temp['cpmcommission'] = $campaignCommissions[$rs->fields['campaignid']]['cpmcommission'];
            $temp['clickcommission'] = $campaignCommissions[$rs->fields['campaignid']]['clickcommission'];
            $temp['salecommission'] = $campaignCommissions[$rs->fields['campaignid']]['salecommission'];
            $temp['salecommtype'] = $campaignCommissions[$rs->fields['campaignid']]['salecommtype'];
            $temp['recurringcommission'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommission'];
            $temp['recurringcommtype'] = $campaignCommissions[$rs->fields['campaignid']]['recurringcommtype'];
            $temp['recurringdatetype'] = $campaignCommissions[$rs->fields['campaignid']]['recurringdatetype'];
            $temp['status'] = $campaignParams[$rs->fields['campaignid']]['Aff_camp_status'];
            
            $temp['bannercount'] = ($bannercount[$rs->fields['campaignid']] != '' ? $bannercount[$rs->fields['campaignid']] : '0');
            $data[] = $temp;
            
            $rs->MoveNext();
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($data);
        
        $this->assign('a_list_data', $list_data);
        $this->assign('a_numrows', count($data));

        $temp_perm['add'] = $this->checkPermissions('add');
        $temp_perm['view_banner'] = $this->checkPermissions('view_banner');
        $temp_perm['edit'] = $this->checkPermissions('edit');
        $temp_perm['delete'] = $this->checkPermissions('delete');

        $this->assign('a_action_permission', $temp_perm);
        
        $this->addContent('ad_list');
    }
    
    //--------------------------------------------------------------------------
    
    function checkCampaignExists($name, $cid = '')
    {
        $sql = 'select * from wd_pa_campaigns '.
        'where deleted=0 and name='._q($name).
        '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        if($cid != '') $sql .= ' and campaignid<>'._q($cid);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        if($rs->EOF) return false;
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function campaignExists($camid)
    {
        $pcamid = preg_replace('/[\'\"]/', '', $camid);
        
        $sql = 'select * from wd_pa_campaigns '.
        'where deleted=0 and campaignid='._q($pcamid).
        '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        if($rs->EOF)
        return false;
        
        return true;
    }    
    
    //--------------------------------------------------------------------------
    
    function getAdvertisementsAsArray()
    {
        $sql = 'select * from wd_pa_campaigns c where c.deleted=0 and accountid='._q($GLOBALS['Auth']->getAccountID()).' AND campaign_type = ' . _q('ADVERTISEMENT') . ' order by name';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $camps = array();
        
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['name'] = $rs->fields['name'];
            $temp['commtype'] = $rs->fields['commtype'];
            $camps[$rs->fields['campaignid']] = $temp;
            
            $rs->MoveNext();
        }
        
        return $camps;
    }
    
    //--------------------------------------------------------------------------
    
    function getCommissionsAsArray()
    {
        $sql = 'select cc.* from wd_pa_campaigncategories cc, wd_pa_campaigns c '.
               'where c.deleted=0 and c.campaignid=cc.campaignid and cc.deleted=0 '.
               '  and c.accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and cc.name='._q(UNASSIGNED_USERS).
               ' order by cc.campaignid, cc.campcategoryid';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $campaignCategories = array();
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['campaignid'] = $rs->fields['campaignid'];
            $temp['campcategoryid'] = $rs->fields['campcategoryid'];
            $temp['name'] = $rs->fields['name'];
            $temp['cpmcommission'] = $rs->fields['cpmcommission'];
            $temp['clickcommission'] = $rs->fields['clickcommission'];
            $temp['salecommission'] = $rs->fields['salecommission'];
            $temp['salecommtype'] = $rs->fields['salecommtype'];
            $temp['recurringcommission'] = $rs->fields['recurringcommission'];       
            $temp['recurringcommtype'] = $rs->fields['recurringcommtype'];       
            $temp['recurringdatetype'] = $rs->fields['recurringdatetype'];       
            
            if(!isset($campaignCategories[$temp['campaignid']]))
            {
                $campaignCategories[$temp['campaignid']] = $temp;
            }
            
            $rs->MoveNext();
        }

        return $campaignCategories;
    }

    //--------------------------------------------------------------------------
    
    function getParamsAsArray()
    {
        $sql = 'select id1, code, value from wd_g_settings where rtype='.SETTINGTYPE_AFF_CAMP.
               ' and accountid='._q($GLOBALS['Auth']->getAccountID());

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $campaignParams = array();
        while(!$rs->EOF)
        {
            $campaignParams[$rs->fields['id1']][$rs->fields['code']] = $rs->fields['value'];
           
            $rs->MoveNext();
        }

        return $campaignParams;        
    }
    
    //--------------------------------------------------------------------------
    
    function drawCommissionField($data, $optionLike = false)
    {
        if($optionLike)
        {
            // draw commission category name
            print '&nbsp;'.($data['name'] == UNASSIGNED_USERS && defined($data['name']) ? constant($data['name']) : $data['name']).', ';
        }
        
        // draw commission type
        $somedrawn = false;
        if($data['commtype'] & TRANSTYPE_CPM)
        {
            print '&nbsp;<b>'.L_G_TYPECPM.'</b>: '.Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['cpmcommission']));
            $somedrawn = true;
        }
        
        print ($somedrawn ? '&nbsp;'.($optionLike ? ', ' : '<br>') : '');
        
        if($data['commtype'] & TRANSTYPE_CLICK)
        {
            print '&nbsp;<b>'.L_G_TYPECLICK.'</b>: ';
            
            if($data['clickcommission'] != '' && $data['clickcommission'] != '0')
            {
                print Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['clickcommission']));
            }
            else
            {
                print '-';
            }
            
            $somedrawn = true;
        }
        
        print ($somedrawn ? '&nbsp;'.($optionLike ? ', ' : '<br>') : '');
        
        if(($data['commtype'] & TRANSTYPE_SALE) || ($data['commtype'] & TRANSTYPE_LEAD))
        {
            print '&nbsp;<b>'.($data['commtype'] & TRANSTYPE_SALE ? L_G_TYPESALE : L_G_TYPELEAD).'</b>: ';
            
            if($data['salecommission'] != '' && $data['salecommission'] != '0')
            {
                // draw normal commissions
                if($data['salecommtype'] == '%')
                {
                    print _rnd($data['salecommission']).' %';
                }
                else
                {
                    print Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['salecommission']));
                }
                
                print ' / ';
                // draw recurring commissions
                if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1) 
                {
                    if($data['recurringcommission'] != '' && $data['recurringcommission'] != '0')
                    {
                        if($data['recurringcommtype'] == '%')
                        {
                            print _rnd($data['recurringcommission']).' %';
                        }
                        else
                        {
                            print Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['recurringcommission']));
                        }
                        
                        print ' '.L_G_SMALLRECURRING.' ';
                        
                        switch($data['recurringdatetype'])
                        {
                            case RECURRINGTYPE_WEEKLY: print L_G_WEEKLY; break;
                            case RECURRINGTYPE_MONTHLY: print L_G_MONTHLY; break;
                            case RECURRINGTYPE_QUARTERLY: print L_G_QUARTERLY; break;
                            case RECURRINGTYPE_BIANNUALLY: print L_G_BIANNUALLY; break;
                            case RECURRINGTYPE_YEARLY: print L_G_YEARLY; break;
                        }
                    }
                    else
                    {
                        print '-';
                    }
                }
            }
            else
            {
                print '-';
            }
            $somedrawn = true;
        }
    }
    
    //--------------------------------------------------------------------------

    function drawCommissionOption($data)
    {
        Affiliate_Merchants_Views_CampaignManager::drawCommissionField($data, true);
    }
    
    //--------------------------------------------------------------------------
    
    function CommTypeToBitForm($commTypes)
    {
        $ctype_bit_form = '';

        if(is_array($commTypes) && count($commTypes) > 0)
        {
            foreach($commTypes as $ctype)
            {
                $ctype_bit_form = (int)$ctype_bit_form | (int)$ctype;
            }
            
            return $ctype_bit_form;
        }
        
        return false;
    }
}
?>
