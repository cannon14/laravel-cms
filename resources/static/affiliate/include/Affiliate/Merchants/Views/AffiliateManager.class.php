<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Bl_Users');
QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');
QUnit_Global::includeClass('Affiliate_Affiliates_Bl_Settings');
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_ForcedMatrix');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_PayoutOptions');
QUnit_Global::includeClass('Affiliate_Merchants_Views_Accounting');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');

class Affiliate_Merchants_Views_AffiliateManager extends QUnit_UI_ListPage
{
    function initPermissions()
    {
        $this->modulePermissions['adduser'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['edituser'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['changecommcat'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['swapuser'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['suppress'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['approve'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['delete'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['add'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['view'] = 'aff_aff_affiliates_view';
        $this->modulePermissions['edit'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['changecommcat'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['accounting'] = 'aff_aff_affiliates_view';
        $this->modulePermissions['showtree'] = 'aff_aff_affiliates_view';
        $this->modulePermissions['swap'] = 'aff_aff_affiliates_modify';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'adduser':
                    if($this->processAddUser())
                        return;
                break;

                case 'edituser':
                    if($this->processEditUser())
                        return;
                break;

                case 'changecommcat':
                    if($this->processChangeCommCat())
                        return;
                break;              

                case 'swapuser':
                    if($this->processSwapUser())
                        return;
                break;
                
                case 'inviteaffiliate':
                    if($this->processInviteAffiliate())
                        return;
                break;
            }
            
            switch($_POST['massaction'])
            {
                case 'suppress':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                break;
                
                case 'delete':
                    if($this->processDelete())
                        return;
                break;

                case 'invite':
                    if($this->drawInviteAffiliate())
                        return;
                break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'add':
                    if($this->drawFormAddUser())
                        return;
                break;

                case 'view':
                    if($this->drawFormViewUser())
                        return;
                break;

                case 'edit':
                    if($this->drawFormEditUser())
                        return;
                break;

                case 'delete':
                    if($this->processDelete())
                        return;
                break;

                case 'suppress':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                break;

                case 'approve':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                break;

                case 'changecommcat':
                    if($this->drawFormChangeCommCat())
                        return;
                break;

                case 'accounting':
                    if($this->drawFormAccounting())
                        return;
                break;

                case 'showtree':
                    if($this->drawTree())
                        return;
                break;

                case 'swap':
                    if($this->drawSwap())
                        return;
                break;
                
                case 'invite':
                    if($this->drawInviteAffiliate())
                        return;
                break;
            }
        }
    
        if($_REQUEST['action'] == 'exportcsv')
            $this->showGroups(true);
        else
            $this->showGroups(false);
    }

    //--------------------------------------------------------------------------

    function processDelete()
    {
        if(($userIDs = $this->returnUIDs()) == false)
            return false;
            
        $params = array();
        $params['userids'] = $userIDs;
        
        Affiliate_Merchants_Bl_Affiliate::delete($params);
        return false;
    }

    //--------------------------------------------------------------------------

    function returnUIDs()
    {
        if($_POST['massaction'] != '')
        {
            $userIDs = $_POST['itemschecked'];
        }
        else
        {
            $userIDs = array($_REQUEST['aid']);
        }
        
        if(AFF_DEMO == 1)
        {
            $userIDs = removeFromArray($userIDs, 2);
            
            if(count($userIDs) <1)
                return false;
        }
        
        return $userIDs;
    }
    
    //--------------------------------------------------------------------------

    function processChangeState($state)
    {
        if(($userIDs = $this->returnUIDs()) == false)
            return false;
        
        $params = array();
        $params['userids'] = $userIDs;

        if($state == AFFSTATUS_APPROVED)
            Affiliate_Merchants_Bl_Affiliate::approve($params);
        else
            Affiliate_Merchants_Bl_Affiliate::decline($params);
            
        return false;
    }

    //--------------------------------------------------------------------------

    function processEditUser()
    {
        $params = array();
        $params['type'] = 'edit';
        
        $protectedParams = Affiliate_Merchants_Bl_Affiliate::checkData($params);

        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            if(Affiliate_Merchants_Bl_Affiliate::update($protectedParams))
                QUnit_Messager::setOkMessage(L_G_AFFILIATEEDITED);

            $this->closeWindow('Affiliate_Merchants_Views_AffiliateManager');
            $this->addContent('closewindow');

            return true;
        }
    
        return false;
    }  

    //--------------------------------------------------------------------------
  
    function processAddUser()
    {
        $params = array();
        $params['type'] = 'edit';

        $protectedParams = Affiliate_Merchants_Bl_Affiliate::checkData($params);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            if(Affiliate_Merchants_Bl_Affiliate::insert($protectedParams))
                QUnit_Messager::setOkMessage(L_G_AFFILIATEADDED);
            
            $this->closeWindow('Affiliate_Merchants_Views_AffiliateManager');
            $this->addContent('closewindow');
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function processChangeCommCat()
    {
        // protect against script injection
        $UserID = preg_replace('/[\'\"]/', '', $_POST['aid']);

        $sql = 'select campaignid from wd_pa_affiliatescampaigns '.
               'where affiliateid='._q($UserID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $aff_categories = array();
        while(!$rs->EOF)
        {
            $aff_categories[] = $rs->fields['campaignid'];
            
            $rs->MoveNext();
        }
/*
        $sql = 'delete from wd_pa_affiliatescampaigns '.
               'where affiliateid='._q($UserID);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        } 
*/
        foreach($_POST as $key => $value)
        {
            if(strpos($key, 'affcategoryid') === false) continue;
            
            $CampaignID = substr($key, 13, 8);
            $CampCategoryID = $value;

            if($value == '') continue;
        
            if(is_array($aff_categories) && in_array($CampaignID, $aff_categories))
            {
                // update
                $sql = 'update wd_pa_affiliatescampaigns '.
                       'set campcategoryid='._q($CampCategoryID).
                       '   ,rstatus='._q(AFFSTATUS_APPROVED).
                       'where affiliateid='._q($UserID).
                       '  and campaignid='._q($CampaignID);
                $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    
                if(!$ret) {
                    QUnit_Messager::setErrorMessage(L_G_DBERROR);
                    return false;
                }
            }
            else
            {
                // insert
                $AffiliateCampaignID = QCore_Sql_DBUnit::createUniqueID('wd_pa_affiliatescampaigns', 'affcampid');
                $sql = 'insert into wd_pa_affiliatescampaigns '.
                       '(affcampid, affiliateid, campcategoryid, campaignid, rstatus) '.
                       'values('._q($AffiliateCampaignID).','._q($UserID).
                       ','._q($CampCategoryID).','._q($CampaignID).','._q(AFFSTATUS_APPROVED).')';
                $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    
                if(!$ret) {
                    QUnit_Messager::setErrorMessage(L_G_DBERROR);
                    return false;
                }
            }
        }

        $this->redirect('Affiliate_Merchants_Views_AffiliateManager');

        return true;
    }  

    //------------------------------------------------------------------------

    function processSwapUser()
    {
        $UserID1 = preg_replace('/[\'\"]/', '', $_POST['u1']);
        $UserID2 = preg_replace('/[\'\"]/', '', $_POST['u2']);
        
        if(Affiliate_Merchants_Bl_Affiliate::checkUserCrossLink($UserID1, array($UserID1, $UserID2), 1))
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOT_SWAP_DIRECT_CHILD);
            QUnit_Messager::setErrorMessage(L_G_SWAP_FAILED);
        }
        else if(Affiliate_Merchants_Bl_Affiliate::checkUserCrossLink($UserID2, array($UserID1, $UserID2), 1))
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOT_SWAP_DIRECT_CHILD);
            QUnit_Messager::setErrorMessage(L_G_SWAP_FAILED);
        }
        else
        {
            if(Affiliate_Merchants_Bl_ForcedMatrix::swapUsersParent($UserID1, $UserID2))
            {
                QUnit_Messager::setOkMessage(L_G_SWAP_OK);
                
                $this->closeWindow('Affiliate_Merchants_Views_AffiliateManager&action=showtree');
                $this->addContent('closewindow');
        
                return true;
            }
            else
                QUnit_Messager::setErrorMessage(L_G_SWAP_FAILED);
        }
        
        return false;
    }

    //------------------------------------------------------------------------

    function processInviteAffiliate()
    {
        if($_POST['do_nothing'] == '1' || $GLOBALS['Auth']->getSetting('Aff_join_campaign') != 1)
        {
            $this->redirect('Affiliate_Merchants_Views_AffiliateManager');
        }

        if($_POST['campaigncategories'] == '') return false;

        if(is_array($_POST['campaigncategories']) && count($_POST['campaigncategories']) < 1)
            return false;

        $userIDs = unserialize(str_replace('\\','', $_POST['uids']));
        
        $params = array();
        $params['userIDs'] = $userIDs;
        $params['campaignIDs'] = $_POST['campaigncategories'];
        $params['AccountID'] = $GLOBALS['Auth']->getAccountID();

        $ret = Affiliate_Merchants_Bl_Affiliate::insertAffiliatesCampaigns($params);

        if($ret) QUnit_Messager::setOkMessage(L_G_INVITE_AFFILIATES_OK);
        else QUnit_Messager::setErrorMessage(L_G_INVITE_AFFILIATES_FAILED);

        $this->closeWindow('Affiliate_Merchants_Views_AffiliateManager');
        $this->addContent('backbutton');
        
        return true;
    }
    
    //------------------------------------------------------------------------

    function drawFormAccounting()
    {
        $this->loadUserInfo();

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($this->loadUserAccounting());

        $this->assign('a_list_data', $list_data);

        $this->addContent('user_accounting');

        return true;
    }
  
    //--------------------------------------------------------------------------

    function loadUserAccounting()
    {
        $userid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);
        $sql = 'select accountingid, sum(commission) as commission '.
               'from wd_pa_transactions '.
               'where accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and rstatus='.AFFSTATUS_APPROVED.
               '  and payoutstatus='.AFFSTATUS_APPROVED.
               '  and affiliateid='._q($userid).
               ' group by accountingid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $data = array();
        $accounting = Affiliate_Merchants_Views_Accounting::getAccountingAsArray();
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['accountingid'] = $rs->fields['accountingid'];
            $temp['commission'] = $rs->fields['commission'];
            $temp['dateinserted'] = $accounting[$rs->fields['accountingid']]['dateinserted'];
            $temp['datefrom'] = $accounting[$rs->fields['accountingid']]['datefrom'];
            $temp['dateto'] = $accounting[$rs->fields['accountingid']]['dateto'];
            $temp['note'] = $accounting[$rs->fields['accountingid']]['note'];
            if($accounting[$rs->fields['accountingid']]['paypalfile'] != '')
                $temp['paypalfile'] = true;
            else
                $temp['paypalfile'] = false;

            if($accounting[$rs->fields['accountingid']]['mbfile'] != '')
                $temp['mbfile'] = true;
            else
                $temp['mbfile'] = false;

            if($accounting[$rs->fields['accountingid']]['wirefile'] != '')
                $temp['wirefile'] = true;
            else
                $temp['wirefile'] = false;          
            $data[] = $temp;

            $rs->MoveNext();
        }

        return $data;
    }

    //--------------------------------------------------------------------------

    function loadUserInfo()
    {
        $userid = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);
        
        Affiliate_Merchants_Bl_Affiliate::loadUserInfoToPost($userid);
    }

    //--------------------------------------------------------------------------

    function drawFormViewUser()
    {
        $this->loadUserInfo();

        $payout_methods = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($payout_methods);
        $this->assign('a_list_data1', $list_data1);

        $payout_fields = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $this->assign('a_list_data2', $payout_fields);

        $this->addContent('user_view');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormEditUser()
    {
        if($_POST['commited'] != 'yes')
        {
            $this->loadUserInfo();
        }

        $_POST['header'] = L_G_EDITAFFILIATE;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'edituser';  

        $this->drawFormAddUser();

        return true;
    }
  
    //--------------------------------------------------------------------------

    function drawFormAddUser()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'adduser';  

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADDAFFILIATE;

        if(!isset($_POST['minpayout']))
            $_POST['minpayout'] = '1000';

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($GLOBALS['countries']);
        $this->assign('a_list_data', $list_data);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS(QCore_Settings::getMinPayoutsAsArray());
        $this->assign('a_list_data2', $list_data2);

        $users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();
        $list_data3 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data3->setTemplateRS($users);
        $this->assign('a_list_data3', $list_data3);

        $payout_methods = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($payout_methods);
        $this->assign('a_list_data4', $list_data4);

        $payout_fields = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $this->assign('a_list_data5', $payout_fields);

        $this->addContent('user_edit');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormChangeCommCat()
    {
        if(!isset($_POST['action']))
        {
            $_POST['action'] = 'changecommcat';
        }
        if(!isset($_POST['postaction']))
        {
            $_POST['postaction'] = 'changecommcat';
        }

        $this->loadUserInfo();

        $UserID = preg_replace('/[\'\"]/', '', $_REQUEST['aid']);

        $campcategs = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();
        Affiliate_Merchants_Bl_CampaignCategories::getCategoriesAsArray($UserID, $campaignCategories, $AffiliateCategories);

        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1')
        {
            $params = array('accountid' => $GLOBALS['Auth']->getAccountID());
            $aff_campaign_settings = Affiliate_Affiliates_Bl_Settings::getAffCampaignSettings($params);
            $this->assign('a_CampaignData', $aff_campaign_settings);
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campcategs);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_campaignCategories', $campaignCategories);
        $this->assign('a_AffiliateCategories', $AffiliateCategories);

        $this->addContent('user_commcat');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawInviteAffiliate()
    {
        if($GLOBALS['Auth']->getSetting('Aff_join_campaign') != 1)
            return false;
    
        if($_POST['uids'] == '') {
            if(($userIDs = $this->returnUIDs()) == false)
                return false;
                
            $_POST['uids'] = serialize($userIDs);
        }
        
        $params = array('AccountID' => $GLOBALS['Auth']->getAccountID());
        
        $privateCampCategories = Affiliate_Merchants_Bl_CampaignCategories::getPrivateCategoriesShortAsArray($params);
       
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($privateCampCategories);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_count', (is_array($privateCampCategories) ? count($privateCampCategories) : 0));

        $_POST['header'] = L_G_INVITEAFFILIATE;
        $_POST['action'] = 'invite';
        $_POST['postaction'] = 'inviteaffiliate';  

        $this->addContent('user_invite');

        return true;
    }
    
    //--------------------------------------------------------------------------

    function showGroups($exportToCsv)
    {
        $temp_perm['add'] = $this->checkPermissions('add');
        $temp_perm['view'] = $this->checkPermissions('view');

        $this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy($orderby, $where);
		if ($_REQUEST['showAffiliateStats']){
        	$transdata = Affiliate_Scripts_Bl_SaleStatistics::getTransactionsSummaries(array());
		}
		else {
			$transdata = "";
		}
		
        $userInfo = Affiliate_Merchants_Bl_Settings::getAccountUsersSettings($GLOBALS['Auth']->getAccountID());
        
        if($exportToCsv)
        {
            // prepare export file first
            $this->prepareExportFile($orderby, $where, $transdata, $userInfo);
        }
        
        $UserData = $this->getRecords($orderby, $where, $transdata, $userInfo);
        
        $this->initViews();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($UserData);
        $this->assign('a_list_data', $list_data);

        $this->pageLimitsAssign();

        $this->addContent('um_list');
    }

    //--------------------------------------------------------------------------

    function getRecords($orderby, $where, $transdata, $userInfo)
    {
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from wd_g_users a';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        //------------------------------------------------
        // get records
        $sql = 'select a.*, '.sqlShortDate('a.dateinserted').' as joined from wd_g_users a ';
        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $UserData = array();

        // prepare the data
        while(!$rs->EOF)
        {
            $UserData[$rs->fields['userid']]['userid'] = $rs->fields['userid'];
            $UserData[$rs->fields['userid']]['refid'] = $rs->fields['refid'];
            $UserData[$rs->fields['userid']]['joined'] = $rs->fields['joined'];
            $UserData[$rs->fields['userid']]['username'] = $rs->fields['username'];
            $UserData[$rs->fields['userid']]['name'] = $rs->fields['name'];
            $UserData[$rs->fields['userid']]['surname'] = $rs->fields['surname'];
            $UserData[$rs->fields['userid']]['paid'] = $transdata[$rs->fields['userid']]['paid'];
            $UserData[$rs->fields['userid']]['pending'] = $transdata[$rs->fields['userid']]['pending'];
            $UserData[$rs->fields['userid']]['approved'] = $transdata[$rs->fields['userid']]['approved'];
            $UserData[$rs->fields['userid']]['reversed'] = $transdata[$rs->fields['userid']]['reversed'];      
            $UserData[$rs->fields['userid']]['parentuserid'] = $rs->fields['parentuserid'];
            $UserData[$rs->fields['userid']]['company_name'] = $rs->fields['company_name'];
            $UserData[$rs->fields['userid']]['weburl'] = $rs->fields['weburl'];
            $UserData[$rs->fields['userid']]['street'] = $rs->fields['street'];
            $UserData[$rs->fields['userid']]['city'] = $rs->fields['city'];
            $UserData[$rs->fields['userid']]['state'] = $rs->fields['state'];
            $UserData[$rs->fields['userid']]['country'] = $rs->fields['country'];
            $UserData[$rs->fields['userid']]['zipcode'] = $rs->fields['zipcode'];
            $UserData[$rs->fields['userid']]['phone'] = $rs->fields['phone'];
            $UserData[$rs->fields['userid']]['fax'] = $rs->fields['fax'];
            $UserData[$rs->fields['userid']]['tax_ssn'] = $rs->fields['tax_ssn'];
            $UserData[$rs->fields['userid']]['payoptid'] = $rs->fields['payoptid'];
            $UserData[$rs->fields['userid']]['actions'] = $rs->fields['actions'];

            if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_SUPPRESSED;

            $rs->MoveNext();      
        }
        
        // fill parent affiliate name, fill payout option name
        $UserDataShort = QCore_Bl_Users::getUsersShort($GLOBALS['Auth']->getAccountID());
        $PayOpt = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID());

        if(is_array($UserData))
        {
            foreach($UserData as $user)
            {
                if($user['parentuserid'] == '' || $user['parentuserid'] == '0')
                    $UserData[$user['userid']]['parentuserid'] = L_G_NONE2;
                else
                    $UserData[$user['userid']]['parentuserid'] .= ': '.$UserDataShort[$UserData[$user['userid']]['parentuserid']]['name'].' '.$UserDataShort[$UserData[$user['userid']]['parentuserid']]['surname'];

                if($user['payoptid'] == '' || $user['payoptid'] == '0')
                    $UserData[$user['userid']]['payoptid'] = L_G_NONE2;
                else
                {
                    $UserData[$user['userid']]['payoptid'] = 
                            (defined($PayOpt[$UserData[$user['userid']]['payoptid']]['langid']) ? 
                            constant($PayOpt[$UserData[$user['userid']]['payoptid']]['langid']) : 
                            $PayOpt[$UserData[$user['userid']]['payoptid']]['name']);
                }
            }
        }

        //------------------------------------------------
        // get other user's data
        $UserData = $this->getOtherUserData($UserData);

        if($_REQUEST['sortby'] != '' &&  in_array($_REQUEST['sortby'], array('paid', 'pending', 'approved', 'reversed')))
        {
            if($_REQUEST['sortorder'] == '' || !in_array($_REQUEST['sortorder'], array('asc','desc')))
                $_REQUEST['sortorder'] = 'asc';

            $GLOBALS['uasort_by'] = $_REQUEST['sortby'];
            $GLOBALS['uasort_order'] = $_REQUEST['sortorder'];

            uasort($UserData, 'cmp_sort');
        }
        
        return $UserData;
    }
    
    //--------------------------------------------------------------------------

    function getOtherUserData($UserData)
    {
        $loadSettings = array(
            'Aff_user_ip'
            );
                   
        $sql = 'select userid, code, value from wd_g_settings '.
               'where rtype='._q(SETTINGTYPE_USER).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and rtype='.SETTINGTYPE_USER.
               '  and code in (\''.implode('\',\'', $loadSettings).'\')'.
               ' order by userid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {
            if(isset($UserData[$rs->fields['userid']]))
            {
                $UserData[$rs->fields['userid']][$rs->fields['code']] = $rs->fields['value'];
            }

            $rs->MoveNext();
        }
        
        return $UserData;
    }
    
    //--------------------------------------------------------------------------

    function prepareExportFile($orderby, $where, $transdata, $userInfo)
    {
        $payout_fields_temp = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(),STATUS_ENABLED);

        // prepare file for export
        $fname = 'a_'.date('Y_m_d').'_'.substr(md5(uniqid(rand(),1)), 0, 6).'.csv';
        $fdirname = $GLOBALS['Auth']->getSetting('Aff_export_dir').$fname;

        $exportFile = @fopen($fdirname, "wb");
        if($exportFile == FALSE)
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTWRITETOEXPORTDIR.$GLOBALS['Auth']->getSetting('Aff_export_dir'));
            return false;
        }

        // write header
        $str = csvFormat(L_G_AFFILIATEID);
        $str .= ';'.csvFormat(L_G_REFID);
        $str .= ';'.csvFormat(L_G_NAME);
        $str .= ';'.csvFormat(L_G_COMPANYNAME);
        $str .= ';'.csvFormat(L_G_EMAIL);
        $str .= ';'.csvFormat(L_G_WEBURL);
        $str .= ';'.csvFormat(L_G_STREET);
        $str .= ';'.csvFormat(L_G_CITY);
        $str .= ';'.csvFormat(L_G_STATE);
        $str .= ';'.csvFormat(L_G_COUNTRY);
        $str .= ';'.csvFormat(L_G_ZIPCODE);
        $str .= ';'.csvFormat(L_G_PHONE);
        $str .= ';'.csvFormat(L_G_FAX);

        $str .= ';'.csvFormat(L_G_TAXSSN);
        $str .= ';'.csvFormat(L_G_PAID);
        $str .= ';'.csvFormat(L_G_PENDING);
        $str .= ';'.csvFormat(L_G_APPROVED);
        $str .= ';'.csvFormat(L_G_REVERSED);
        $str .= ';'.csvFormat(L_G_STATUS);

        $payout_fields = $payout_fields_temp;
        if(is_array($payout_fields)) {
            foreach($payout_fields as $fields) {
                if(is_array($fields)) {
                    foreach($fields as $field) {
                        $str .= ';'.csvFormat((defined($field['langid']) ? constant($field['langid']) : $field['name']));
                    }
                }
            }
        }

        //$str = utf2ascii($str);
        fwrite($exportFile, $str."\r\n");

        // write data
        $sql = 'select a.*, '.sqlShortDate('a.dateinserted').' as joined from wd_g_users a ';
        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {
            $str = csvFormat($rs->fields['userid']);
            $str .= ';'.csvFormat($rs->fields['refid']);
            $str .= ';'.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);
            $str .= ';'.csvFormat($rs->fields['company_name']);
            $str .= ';'.csvFormat($rs->fields['username']);
            $str .= ';'.csvFormat($rs->fields['weburl']);
            $str .= ';'.csvFormat($rs->fields['street']);
            $str .= ';'.csvFormat($rs->fields['city']);
            $str .= ';'.csvFormat($rs->fields['state']);
            $str .= ';'.csvFormat($rs->fields['country']);
            $str .= ';'.csvFormat($rs->fields['zipcode']);
            $str .= ';'.csvFormat($rs->fields['phone']);
            $str .= ';'.csvFormat($rs->fields['fax']);
            
            $str .= ';'.csvFormat($rs->fields['tax_ssn']);
            
            $str .= ";".$transdata[$rs->fields['userid']]['paid'];
            $str .= ";".$transdata[$rs->fields['userid']]['pending'];
            $str .= ";".$transdata[$rs->fields['userid']]['approved'];
            $str .= ";".$transdata[$rs->fields['userid']]['reversed'];
            
            if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $status = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $status = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $status = L_G_SUPPRESSED;
            
            $str .= ";".$status;

            $payout_fields = $payout_fields_temp;
            if(is_array($payout_fields)) {
                foreach($payout_fields as $fields) {
                    if(is_array($fields)) {
                        foreach($fields as $field) {
                            $str .= ';'.csvFormat($userInfo[$rs->fields['userid']]['Aff_payoptionfield_'.$field['payfieldid']]);
                        }
                    }
                }
            }


            //$str = utf2ascii($str);
            fwrite($exportFile, $str."\r\n");

            $rs->MoveNext();
        }

        fclose($exportFile);
        $this->assign('a_exportFileName', $fname);
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    /** returns list of columns in list view */
    function getAvailableColumns()
    {
        return array(
            'userid' =>         array(L_G_AFFILIATEID, 'a.userid'),
            'refid' =>          array(L_G_REFID, 'a.refid'),
            'username' =>       array(L_G_USERNAME, 'a.username'),
            'dateinserted' =>   array(L_G_JOINED, 'a.dateinserted'),
            'name' =>           array(L_G_NAME, 'a.name'),
            'surname' =>        array(L_G_SURNAME, 'a.surname'),
            'paid' =>           array(L_G_PAID, 'paid'),
            'pending' =>        array(L_G_PENDING, 'pending'),
            'approved' =>       array(L_G_APPROVED, 'approved'),
            'reversed' =>       array(L_G_REVERSED, 'reversed'),
            'parentuserid' =>   array(L_G_PARENT, 'a.parentuserid'),
            'rstatus' =>        array(L_G_STATUS, 'a.rstatus'),
            'company_name' =>   array(L_G_COMPANYNAME, 'a.company_name'),
            'weburl' =>         array(L_G_WEBURL, 'a.weburl'),
            'street' =>         array(L_G_STREET, 'a.street'),
            'city' =>           array(L_G_CITY, 'a.city'),
            'state' =>          array(L_G_STATE, 'a.state'),
            'country' =>        array(L_G_COUNTRY, 'a.country'),
            'zipcode' =>        array(L_G_ZIPCODE, 'a.zipcode'),
            'phone' =>          array(L_G_PHONE, 'a.phone'),
            'fax' =>            array(L_G_FAX, 'a.fax'),
            'tax_ssn' =>        array(L_G_TAXSSN, 'a.tax_ssn'),
            'payoptid' =>       array(L_G_PAYOUTMETHOD, ''),
            'ip' =>             array(L_G_IP, ''),
            'actions' =>        array(L_G_ACTIONS, ''),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'aff_list';
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {
        // create default view
        if ($_REQUEST['showAffiliateStats']){
        	
        	$viewColumns = array(
            // 'userid',
            'refid',
            'dateinserted',
            'name',
            'surname',
            'paid',
            'pending',
            'approved',
            'reversed',
            'parentuserid',
            'rstatus',
            'actions',
        	);
        }
        else {
           $viewColumns = array(
            // 'userid',
            'refid',
            'dateinserted',
            'name',
            'surname',
            'parentuserid',
            'rstatus',
            'actions',
        	);
        }
        $this->createDefaultView($viewColumns);
        
        $this->loadAvailableViews();
        
        $tplAvailableViews = array();
        foreach($this->availableViews as $objView)
        {
            $tplAvailableViews[$objView->dbid] = $objView->getName();
        }
        
        $this->assign('a_list_views', $this->tplAvailableViews);
        
        $this->applyView();
    }

    //--------------------------------------------------------------------------

    function createWhereOrderBy(&$orderby, &$where)
    {
        $orderby = '';
        $where = '';
        
        $a = array(
            'a.username', 
            'a.name', 
            'a.surname', 
            'a.dateinserted', 
            'a.userid', 
            'a.refid', 
            'a.rstatus',
            'a.parentuserid',
            'a.company_name',
            'a.weburl',
            'a.street',
            'a.city',
            'a.state',
            'a.country',
            'a.zipcode',
            'a.phone',
            'a.fax',
            'a.tax_ssn'
        );

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a)) {
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        }
        else {
            $orderby = ' order by a.dateinserted desc'; 
        }
        
        $where = ' where a.deleted=0 '.
                 '   and a.rtype='._q(USERTYPE_USER).
                 '   and accountid='._q($GLOBALS['Auth']->getAccountID()).
                 '   and a.userid in '.Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();

        if($_REQUEST['fromprofile'] == 1)
        {
            // it is called from profile
            $_REQUEST['filtered'] = 1;
            $_REQUEST['um_name'] = '';
            $_REQUEST['um_surname'] = '';
            $_REQUEST['um_aid'] = '';
            $_REQUEST['um_status'] = $_REQUEST['umprof_status'];
            if($_REQUEST['um_status'] == '') $_REQUEST['um_status'] = '_';
            
        }
        else
        {
            //--------------------------------------
            // try to load settings from session
            foreach($_SESSION as $k => $v)
            {
                if(strpos($k, 'um_') === 0 && !isset($_REQUEST[$k]))
                $_REQUEST[$k] = $v;
            }
            
            //--------------------------------------
            // get default settings for unset variables
            if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
            if($_REQUEST['um_status'] == '') $_REQUEST['um_status'] = '_';
            
            //--------------------------------------
            // put settings into session
            $_SESSION['numrows'] = $_REQUEST['numrows'];
            $_SESSION['um_name'] = $_REQUEST['um_name'];
            $_SESSION['um_surname'] = $_REQUEST['um_surname'];
            $_SESSION['um_aid'] = $_REQUEST['um_aid'];
            $_SESSION['um_status'] = $_REQUEST['um_status'];
        }
        
        $name = preg_replace('/[\'\"]/', '', $_REQUEST['um_name']);
        $surname = preg_replace('/[\'\"]/', '', $_REQUEST['um_surname']);
        $aid = preg_replace('/[\'\"]/', '', $_REQUEST['um_aid']);
        $status = preg_replace('/[^0-9]/', '', $_REQUEST['um_status']);
        
        if($name != '')
        {
            $where .= ' and (a.name like \'%'._q_noendtags($name).'%\')';
        }
        if($surname != '')
        {
            $where .= ' and (a.surname like \'%'._q_noendtags($surname).'%\')';
        }
        if($aid != '')
        {
            $where .= ' and (a.userid like \'%'._q_noendtags($aid).'%\')';
        }
        if($status != '')
        {
            $where .= ' and (a.rstatus ='._q($status).')';
        }
		
		//check for alphabet filter
		if(!isset($_REQUEST['alphabetFilter']))
        {
        	$where .= " and (name like 'A%')";
        	$_REQUEST['alphabetFilter'] = 'A';
        	
        } else if ($_REQUEST['alphabetFilter'] != 'All')
        {
            $where .= " and (name like '" .$_REQUEST['alphabetFilter']. "%')";
        }
		
		$where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
        return true;
    }
    
    //--------------------------------------------------------------------------

    function printListRow($row)
    {
        $view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</fonr></td>';
            return false;
        }
        
        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['userid'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
                case 'userid': print '<td class=listresult>&nbsp;'.$row['userid'].'&nbsp;</td>';
                        break;
                        
                case 'refid': print '<td class=listresult>&nbsp;'.$row['refid'].'&nbsp;</td>';
                        break;
                        
                case 'username': print '<td class=listresult>&nbsp;'.$row['username'].'&nbsp;</td>';
                        break;
                        
                case 'dateinserted': print '<td class=listresult nowrap>&nbsp;'.$row['joined'].'&nbsp;</td>';
                        break;
                        
                case 'name': print '<td class=listresult nowrap>&nbsp;'.$row['name'].'&nbsp;</td>';
                        break;
                        
                case 'surname': print '<td class=listresult nowrap>&nbsp;'.$row['surname'].'&nbsp;</td>';
                        break;
                        
                case 'paid': print '<td class=listresultnocenter align=right nowrap>&nbsp;'.Affiliate_Merchants_Bl_Settings::showCurrency($row['paid']).'&nbsp;</td>';
                        break;
                        
                case 'pending': print '<td class=listresultnocenter align=right nowrap>&nbsp;'.Affiliate_Merchants_Bl_Settings::showCurrency($row['pending']).'&nbsp;</td>';
                        break;
                        
                case 'approved': print '<td class=listresultnocenter align=right nowrap>&nbsp;'.Affiliate_Merchants_Bl_Settings::showCurrency($row['approved']).'&nbsp;</td>';
                        break;
                        
                case 'reversed': print '<td class=listresultnocenter align=right nowrap>&nbsp;'.Affiliate_Merchants_Bl_Settings::showCurrency($row['reversed']).'&nbsp;</td>';
                        break;
                        
                case 'parentuserid': print '<td class=listresult nowrap>&nbsp;'.$row['parentuserid'].'&nbsp;</td>';
                        break;
                        
                case 'rstatus': print '<td class=listresult nowrap>&nbsp;'.$row['rstatus'].'&nbsp;</td>';
                        break;
                        
                case 'company_name': print '<td class=listresult nowrap>&nbsp;'.$row['company_name'].'&nbsp;</td>';
                        break;
                        
                case 'weburl': print '<td class=listresult nowrap>&nbsp;'.$row['weburl'].'&nbsp;</td>';
                        break;
                        
                case 'street': print '<td class=listresult nowrap>&nbsp;'.$row['street'].'&nbsp;</td>';
                        break;
                        
                case 'city': print '<td class=listresult nowrap>&nbsp;'.$row['city'].'&nbsp;</td>';
                        break;
                        
                case 'state': print '<td class=listresult nowrap>&nbsp;'.$row['state'].'&nbsp;</td>';
                        break;
                        
                case 'country': print '<td class=listresult nowrap>&nbsp;'.$row['country'].'&nbsp;</td>';
                        break;
                        
                case 'zipcode': print '<td class=listresult nowrap>&nbsp;'.$row['zipcode'].'&nbsp;</td>';
                        break;
                        
                case 'phone': print '<td class=listresult nowrap>&nbsp;'.$row['phone'].'&nbsp;</td>';
                        break;
                        
                case 'fax': print '<td class=listresult nowrap>&nbsp;'.$row['fax'].'&nbsp;</td>';
                        break;
                        
                case 'tax_ssn': print '<td class=listresult nowrap>&nbsp;'.$row['tax_ssn'].'&nbsp;</td>';
                        break;

                case 'payoptid': print '<td class=listresult nowrap>&nbsp;'.$row['payoptid'].'&nbsp;</td>';
                        break;
                        
                case 'ip': print '<td class=listresult nowrap>&nbsp;'.$row['Aff_user_ip'].'&nbsp;</td>';
                        break;

                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <? if($this->checkPermissions('view')) { ?>
                                     <option value="javascript:viewUser('<?=$row['userid']?>');"><?=L_G_VIEWPROFILE?></option>
                                <? } ?>
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editUser('<?=$row['userid']?>');"><?=L_G_EDIT?></option>
                                <? } ?>
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:accountingDetails('<?=$row['userid']?>');"><?=L_G_ACCOUNTINGDETAILS?></option>
                                <? } ?>
                                <? if($this->checkPermissions('approve')) { ?>
                                  <? if($row['dbrstatus'] == AFFSTATUS_APPROVED) { ?>
                                       <option value="javascript:ChangeState('<?=$row['userid']?>','suppress');"><?=L_G_SUPPRESS?></option>
                                  <? } else if($row['dbrstatus'] == AFFSTATUS_SUPPRESSED) { ?>
                                       <option value="javascript:ChangeState('<?=$row['userid']?>','approve');"><?=L_G_APPROVE?></option>
                                  <? } else { ?>
                                       <option value="javascript:ChangeState('<?=$row['userid']?>','suppress');"><?=L_G_SUPPRESS?></option>
                                       <option value="javascript:ChangeState('<?=$row['userid']?>','approve');"><?=L_G_APPROVE?></option>
                                  <? } ?>
                                <? } ?>
                                <? if($this->checkPermissions('changecommcat')) { ?>
                                     <option value="javascript:ChangeCommCat('<?=$row['userid']?>');"><?=L_G_CHANGECOMMCATEGORY?></option>
                                <? } ?>
                                <? if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:Delete('<?=$row['userid']?>');"><?=L_G_DELETE?></option>
                                <? } ?>
                                <? if($this->checkPermissions('add') && $GLOBALS['Auth']->getSetting('Aff_join_campaign') == 1)  { ?>
                                     <option value="javascript:InviteIntoCampaign('<?=$row['userid']?>');"><?=L_G_INVITE?></option>
                                <? } ?>
                            </select>
                        </td>
<?
                        break;

                default: 
                        print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.'</font>&nbsp;</td>';
                        break;
            }
        }
    }
    
    //--------------------------------------------------------------------------

    function printMassAction()
    {
?>
      <td align=left>&nbsp;&nbsp;&nbsp;<?=L_G_SELECTED;?>&nbsp;
        <select name="massaction">
          <option value="-"><?=L_G_CHOOSEACTION?></option>
          <? if($this->checkPermissions('approve')) { ?>
               <option value="suppress"><?=L_G_SUPPRESS?></option>
          <? }
             if($this->checkPermissions('approve')) { ?>  
               <option value="approve"><?=L_G_APPROVE?></option>
          <? }
             if($this->checkPermissions('delete')) { ?>
               <option value="delete"><?=L_G_DELETE?></option>
          <? } 
             if($this->checkPermissions('add') && $GLOBALS['Auth']->getSetting('Aff_join_campaign') == 1) { ?>
               <option value="invite"><?=L_G_INVITE?></option>
          <? } ?>
        </select>
        &nbsp;&nbsp;
        <input type=submit class=formbutton value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }
    
    //--------------------------------------------------------------------------

    function drawTree()
    {
        $userTree = array();
        Affiliate_Merchants_Bl_Affiliate::getTreeOfUsers('', $userTree, '', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 20);

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($userTree);
        $this->assign('a_list_data', $list_data);

        $this->addContent('um_tree');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawSwap()
    {
        $_POST['u1'] = preg_replace('/[\'\"]/', '', $_REQUEST['u1']);
    
        $_POST['header'] = L_G_SWAP_USER;
        $_POST['action'] = 'swap';
        $_POST['postaction'] = 'swapuser';
    
        $users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();

        $this->assign('a_contact_user_data', $users[$_POST['u1']]['userid'].' : '.$users[$_POST['u1']]['name'].' '.$users[$_POST['u1']]['surname']);

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($users);
        $this->assign('a_list_data', $list_data);

        $this->addContent('um_swap');

        return true;
    }
}

?>
