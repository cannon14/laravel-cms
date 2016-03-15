<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Tracker');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Timeslot');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Page');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Keyword');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactions');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');
QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampCategoriesManager');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Merchants_Views_TransactionManager extends QUnit_UI_ListPage
{
    var $campCategory;

    //--------------------------------------------------------------------------    

    function initPermissions()
    {
        $this->modulePermissions['approvetrans'] = 'aff_trans_transactions_approvedecline';
        $this->modulePermissions['denytrans'] = 'aff_trans_transactions_approvedecline';
        $this->modulePermissions['create'] = 'aff_trans_transactions_modify';
        $this->modulePermissions['edit'] = 'aff_trans_transactions_modify';
        $this->modulePermissions['suppress'] = 'aff_trans_transactions_approvedecline';
        $this->modulePermissions['approve'] = 'aff_trans_transactions_approvedecline';
        $this->modulePermissions['delete'] = 'aff_trans_transactions_modify';
        $this->modulePermissions['view'] = 'aff_trans_transactions_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'approvetrans':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                    break;
                
                case 'denytrans':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                    break;
                
                case 'create':
                    if($this->processCreateTransaction())
                        return;
                    break;

                case 'update':
                    if($this->processUpdateTransaction())
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
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
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
                
                case 'create':
                    if($this->drawFormCreateTransaction())
                        return;
                    break;
                
                case 'edit':
                    if($this->drawFormEditTransaction())
                        return;
                    break;
            }
        }

        if($_REQUEST['action'] == 'exportcsv')
            $this->showTransactions(true);
        else
            $this->showTransactions(false);      
    }
    
    
    function getCampaingsForFilter()
    {    
        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_campaings', $list_data1);
    }
	function getCIDForFilter()
    {    
        $cids = Affiliate_Merchants_Bl_Tracker::getTrackersAsArray();
        $list_data3 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data3->setTemplateRS($cids);
        $this->assign('cid_list_data1', $list_data3);
    }
    /*function getDIDForFilter()
    {
    	$dids = Affiliate_Merchants_Bl_Keyword::getKeywordsAsArray();
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($dids);
        $this->assign('did_list_data1', $list_data4);
    }*/
	function getEIDForFilter()
    {
    	$eids = Affiliate_Merchants_Bl_Timeslot::getTimeslotsAsArray();
        $list_data5 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data5->setTemplateRS($eids);
        $this->assign('eid_list_data1', $list_data5);
    }
    function getFIDForFilter()
    {
    	$fids = Affiliate_Merchants_Bl_Page::getPagesAsArray();
        $list_data6 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data6->setTemplateRS($fids);
        $this->assign('fid_list_data1', $list_data6);
    }	
	
	
	
	//--------------------------------------------------------------------------
    
    function drawFormEditTransaction()
    {
        if($_POST['commited'] != 'yes')
        {
            $params = array('AccountID' => $GLOBALS['Auth']->getAccountID());

            Affiliate_Merchants_Bl_Transactions::loadTransactionInfo($params);
        }
    
        $_POST['header'] = L_G_EDIT_TRANSACTION;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'update';

        $users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($users);
        $this->assign('a_list_data', $list_data);

        $this->addContent('transactions_edit');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function drawFormCreateTransaction()
    {
        $_POST['commtype'] = TRANSTYPE_CLICKPERSALE;

        $campaigns = Affiliate_Merchants_Views_CampaignManager::getCampaignsAsArray();
        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($campaigns);
        $this->assign('a_list_data1', $list_data1);

        $users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();
        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($users);
        $this->assign('a_list_data2', $list_data2);
        
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
        
        $this->addContent('trans_create');
        
        return true;
    }
    
        //--------------------------------------------------------------------------
    
    function processUpdateTransaction()
    {
        // protect against script injection
        $rstatus = preg_replace('/[^0-9]/', '', $_POST['rstatus']);
        $transtype = preg_replace('/[^0-9]/', '', $_POST['transtype']);
        $transkind = preg_replace('/[^0-9]/', '', $_POST['transkind']);
        $payoutstatus = preg_replace('/[^0-9]/', '', $_POST['payoutstatus']);
        $totalcost = preg_replace('/[\'\"]/', '', $_POST['totalcost']);
        $refererurl = preg_replace('/[\'\"]/', '', $_POST['refererurl']);
        $affiliate = preg_replace('/[\'\"]/', '', $_POST['affiliate']);
        $parenttrans = preg_replace('/[\'\"]/', '', $_POST['parenttrans']);
        $commission = preg_replace('/[\'\"]/', '', $_POST['commission']);
        $ip = preg_replace('/[\'\"]/', '', $_POST['ip']);
        $productid = preg_replace('/[\'\"]/', '', $_POST['productid']);
        $data1 = preg_replace('/[\'\"]/', '', $_POST['data1']);
        $data2 = preg_replace('/[\'\"]/', '', $_POST['data2']);
        $data3 = preg_replace('/[\'\"]/', '', $_POST['data3']);
        $TransID = preg_replace('/[\'\"]/', '', $_POST['tid']);

        // check correctness of the fields
        checkCorrectness($_POST['rstatus'], $rstatus, L_G_STATUS, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['transtype'], $transtype, L_G_TRANSTYPE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['transkind'], $transkind, L_G_TRANSKIND, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['payoutstatus'], $payoutstatus, L_G_PAYOUT_STATUS, CHECK_ALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['totalcost'], $totalcost, L_G_TOTAL_COST, CHECK_ALLOWED);
        checkCorrectness($_POST['refererurl'], $refererurl, L_G_REFERRER_URL, CHECK_ALLOWED);
        checkCorrectness($_POST['affiliate'], $affiliate, L_G_AFFILIATE, CHECK_EMPTYALLOWED);

        checkCorrectness($_POST['parenttrans'], $parenttrans, L_G_PARENTTRANS, CHECK_ALLOWED);
        if($parenttrans != '')
        {
            if($transkind <= TRANSKIND_SECONDTIER)
                QUnit_Messager::setErrorMessage(L_G_CANNOTCHOOSEPARENTTRANS);
            else if(Affiliate_Merchants_Bl_Transactions::checkTransactionExists($parenttrans, $GLOBALS['Auth']->getAccountID()))
                QUnit_Messager::setErrorMessage(L_G_TRANSACTIONDOESNOTEXISTS);
        }

        checkCorrectness($_POST['commission'], $commission, L_G_COMMISSIONS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['ip'], $ip, L_G_IP, CHECK_ALLOWED);
        checkCorrectness($_POST['productid'], $productid, L_G_PRODUCTID, CHECK_ALLOWED);
        checkCorrectness($_POST['data1'].' '.$_POST['data2'].' '.$_POST['data3'], $data1.' '.$data2.' '.$data3, L_G_EXTRA_FIELD, CHECK_ALLOWED);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            $params = array('rstatus' => $rstatus,
                            'transtype' => $transtype,
                            'transkind' => $transkind,
                            'payoutstatus' => $payoutstatus,
                            'totalcost' => $totalcost,
                            'refererurl' => $refererurl,
                            'affiliate' => $affiliate,
                            'parenttrans' => $parenttrans,
                            'commission' => $commission,
                            'ip' => $ip,
                            'productid' => $productid,
                            'data1' => $data1,
                            'data2' => $data2,
                            'data3' => $data3,
                            'TransID' => $TransID,
                            'AccountID' => $GLOBALS['Auth']->getAccountID()
                           );

            if(Affiliate_Merchants_Bl_Transactions::updateTransaction($params))
                QUnit_Messager::setOkMessage(L_G_TRANSACTION_EDITED);

            $this->redirect('Affiliate_Merchants_Views_TransactionManager&type=all');
//            $this->closeWindow('Affiliate_Merchants_Views_TransactionManager&type=all');
//            $this->addContent('closewindow');
  
            return true;
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function processCreateTransaction()
    {
		
        // protect against script injection
        $userid = preg_replace('/[\'\"]/', '', $_POST['userid']);
        $campaignid = preg_replace('/[\'\"]/', '', $_POST['campaignid']);
        $transtype = preg_replace('/[\'\"]/', '', $_POST['transtype']);
        $status = preg_replace('/[^0-9]/', '', $_POST['rstatus']);
        //$totalcost = preg_replace('/[^0-9\.]/', '', $_POST['totalcost']);
        $orderid = preg_replace('/[\'\"]/', '', $_POST['orderid']);
        $productid = preg_replace('/[\'\"]/', '', $_POST['productid']);
        //$commission = preg_replace('/[\'\"]/', '', $_POST['commission']);
       //$createtype = preg_replace('/[\'\"]/', '', $_POST['createtype']);
		$quantity = preg_replace('/[\'\"]/', '', $_POST['quantity']);
        $accountid = $GLOBALS['Auth']->getAccountID();
		
        // check correctness of the fields
        checkCorrectness($_POST['userid'], $userid, L_G_AFFILIATE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['campaignid'], $campaignid, L_G_CAMPAIGN, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['transtype'], $transtype, L_G_TYPE, CHECK_EMPTYALLOWED);
        //checkCorrectness($_POST['totalcost'], $totalcost, L_G_TOTALCOST, CHECK_ALLOWED, CHECK_NUMBER);
        //checkCorrectness($_POST['createtype'], $createtype, L_G_TYPEOFCREATECOMMISSION, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['quantity'], $quantity, L_G_QUANTITY, CHECK_NUMBER);
		
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return;
        }
		
		/**if($createtype == 'manual')
        {
            checkCorrectness($_POST['rstatus'], $status, L_G_STATUS, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['commission'], $commission, L_G_COMMISSION, CHECK_EMPTYALLOWED, CHECK_NUMBER);
        }
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return;
        }

        else
        {
            if($createtype == 'manual')
                $ret = $this->createManualCommission($userid, $campaignid, $transtype, $totalcost, $orderid, $productid, $status, $commission);
            else
                $ret = $this->createAutomaticCommission($userid, $campaignid, $transtype, $totalcost, $orderid, $productid);
            
            if($ret) {
                QUnit_Messager::setOkMessage(L_G_COMMISSIONCREATED);
                $this->closeWindow('Affiliate_Merchants_Views_TransactionManager');
                $this->addContent('closewindow');
            } else {
                return false;  
            }
            
            return true;
        }
        **/
        
        $sql = "SELECT campcategoryid FROM wd_pa_campaigncategories WHERE campaignid = " . _q($campaignid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        $campaignid = $rs->fields['campcategoryid'];
        
		$sql = "INSERT into wd_pa_transactions (transid, campcategoryid, transtype, rstatus, orderid, productid, dateinserted, accountid, quantity, affiliateid) " .
		" VALUES (" . _q(QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid")) . "," . _q($campaignid) . "," . _q($transtype) . "," . _q(1) . "," . _q($orderid) ."," . _q($productid) . "," . _q(date("Y-m-d H:i:s")) . "," . _q($accountid) . "," . _q($quantity) . "," . _q($userid) . ")";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if($rs){
			QUnit_Messager::setOkMessage($quantity . " click(s) successfully created.");
		}
		
		$this->closeWindow('Affiliate_Merchants_Views_TransactionManager&type=all');
		$this->addContent('closewindow');
		
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function createManualCommission($userid, $campaignid, $transtype, $totalcost, $orderid, $productid, $status, $commission)
    {
        //---------------------------------------
        // check commission category for this user
        $sql = 'select cc.* '.
               'from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($campaignid).
               '  and cc.campcategoryid=ac.campcategoryid '.
               '  and affiliateid='._q($userid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        return false;
        
        if($rs->EOF)
        {
            // get basic commission category for this campaign
            $sql = 'select * from wd_pa_campaigncategories where deleted=0 and campaignid='._q($campaignid).' and deleted=0 order by campcategoryid asc';
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
            return false;          
        }
        
        $campcategoryid = $rs->fields['campcategoryid'];
        
        // save changes of user to db
        $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
        $sql = "insert into wd_pa_transactions(transid, affiliateid, accountid, campcategoryid, dateinserted, orderid, productid, totalcost, transtype, transkind, rstatus, commission)".
        "values("._q($TransID).","._q($userid).","._q($GLOBALS['Auth']->getAccountID()).","._q($campcategoryid).",".sqlNow().", ".myquotes($orderid).", ".myquotes($productid).",".myquotes($totalcost).","._q($transtype).",".TRANSKIND_NORMAL.","._q($status).",".myquotes($commission).")";
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    
        else
        {
            if($status == AFFSTATUS_APPROVED)
            {
                $params = array('users' => array($userid),
                                'AccountID' => $GLOBALS['Auth']->getAccountID(),
                                'decimal_places' => $GLOBALS['Auth']->getSetting('Aff_round_numbers')
                               );
        
                if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params)) !== false)
                    Affiliate_Merchants_Bl_Rules::checkPerformanceRules($params, $rules);
            }

            $ntfSettings = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $userid);
            
            // check whether to send notification email to user
            if($ntfSettings['Aff_email_affonsale'] == 1)
            {
                $params = array();
                $params['id'] = $TransID;
                $params['commission'] = $commission;
                $params['totalcost'] = $totalcost;
                $params['orderid'] = $orderid;
                $params['productid'] = $productid;
                $params['date'] = date("Y-m-d h:j:s");
                $params['userid'] = $userid;
                $params['rstatus'] = $status;
                $params['ip'] = '';
                $params['referrer'] = '';

                $lang = $ntfSettings['Aff_aff_notificationlang'];

                $emaildata = QCore_EmailTemplates::getFilledEmailMessage($params['id'], 'AFF_EMAIL_AF_NTF_SLE', $lang, $params);
                if($emaildata != false)
                {
                    $email = $GLOBALS['Auth']->getUsernameForUser($userid, $GLOBALS['Auth']->getAccountID());
                    
                    $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $userid,
                            'email' => $email
                    );
                    
                    if(!QCore_Bl_Communications::sendEmail($params)) {
                        $tempErrorMsg = "Sale registration: There was a problem sending affiliate notification email about sale transaction ID '".$params['id']."'";
                        QCore_History::DebugMsg(WLOG_ERROR, $tempErrorMsg, __FILE__, __LINE__);
                        QUnit_Messager::setErrorMessage($tempErrorMsg);
                    }
                    else {
                        QCore_History::DebugMsg(WLOG_ERROR, "Sale registration affiliate notification email about sale transaction ID '".$params['id']."' was succesfully generated and sent to '$email'", __FILE__, __LINE__);
                    }
                }
                else
                {
                    QCore_History::DebugMsg(WLOG_ERROR, "Sale registration:  There was a problem generating affiliate notification email about sale transaction ID '".$params['id']."' from template", __FILE__, __LINE__);
                    QUnit_Messager::setErrorMessage(L_G_EMAILTEMPERR);
                }
            }
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------

    function createAutomaticCommission($userid, $campaignid, $transtype, $totalcost, $orderid, $productid)
    {
        if($transtype == TRANSTYPE_CLICK)
        {
            $clickReg = new Affiliate_Scripts_Bl_ClickRegistrator();
            
            // check if this user and campaign exist
            if(!$clickReg->checkUserExists($userid))
            {
                QCore_History::DebugMsg(WLOG_ERROR, "Click registration: Affiliate with ID: $userid doesn't exist", __FILE__, __LINE__);
                return;
            }
            
            $clickReg->BannerID = 0;
            $clickReg->CampaignID = $campaignid;
            
            if(!$clickReg->checkCampaignExists())
            {
                QCore_History::DebugMsg(WLOG_ERROR, "Click registration: Campaign with ID: $campaignid doesn't exist", __FILE__, __LINE__);
                return;
            }
            
            if(!$clickReg->checkUserInCampaign())
            {
                QCore_History::DebugMsg(WLOG_ERROR, "Click registration: Affiliate ID: $userid doesn't belong to the campaign ID: $campaignid", __FILE__, __LINE__);
                return;
            }
            
            // saving transaction to DB
            return $clickReg->saveClick();            
        }
        else  // TRANSTYPE_SALE
        {
            $saleReg = new Affiliate_Scripts_Bl_SaleRegistrator();

            $saleReg->initData($userid, $campaignid);

            return $saleReg->registerSale($totalcost, $orderid, $productid);
        }
    }
    
    //--------------------------------------------------------------------------
    
    function processDelete()
    {
        if(($transIDs = $this->returnUIDs()) == false)
            return false;
            
        $params = array();
        $params['transids'] = $transIDs;
        
        Affiliate_Merchants_Bl_Transactions::delete($params);
        return false;
        
        $transid = preg_replace('/[\'\"]/', '', $_REQUEST['tid']);
        $sql = 'delete from wd_pa_transactions '.
               'where transid='._q($transid).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        // delete also possible recurring commissions
        $sql = 'update wd_pa_recurringcommissions set deleted=1 where originaltransid='._q($transid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }       
        return false;
    }
    
    //--------------------------------------------------------------------------

    function returnUIDs()
    {
        if($_POST['massaction'] != '')
        {
            $transIDs = $_POST['itemschecked'];
        }
        else
        {
            $transIDs = array($_REQUEST['tid']);
        }
        
        return $transIDs;
    }
    
    //--------------------------------------------------------------------------
    
    function processChangeState($state)
    {
        if(($transIDs = $this->returnUIDs()) == false)
            return false;
        
        $params = array();
        $params['transids'] = $transIDs;
        $params['state'] = $state;
        
        Affiliate_Merchants_Bl_Transactions::changeState($params);
            
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function showTransactions($exportToCsv)
    {
        $temp_perm['view'] = $this->checkPermissions('view');
        $temp_perm['create'] = $this->checkPermissions('create');

        $this->getCampaingsForFilter();
        $this->getCIDForFilter();
        //$this->getDIDForFilter();
        $this->getEIDForFilter();
		$this->getFIDForFilter();
		
		$this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy($orderby, $where);
        
        $this->getUsersForFilter();
        $this->campCategory = Affiliate_Merchants_Views_CampCategoriesManager::getCampCategoriesAsArray();

        if($exportToCsv)
        {
            // prepare export file first
            $this->prepareExportFile($orderby, $where);
        }

        $recs = $this->getRecords($orderby, $where);
        $this->initViews();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($recs);
        
        $this->assign('a_list_data', $list_data);
        $this->assign('a_curyear', date("Y"));
        
        $this->pageLimitsAssign();

        $this->addContent('tm_list');        
    }

    //--------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $usersRs = Affiliate_Merchants_Bl_Affiliate::getUsersAsRs();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);
        
        $this->assign('a_list_users', $list_data);
    }
    
    //--------------------------------------------------------------------------

    function createWhereOrderBy(&$orderby, &$where)
    {
        
		$orderby = '';
        $where = '';
        
        $a = array(
            'transid', 
            'commission', 
            'totalcost', 
            'orderid', 
            'productid', 
            'dateinserted', 
            'transtype', 
            'transkind', 
            'userid', 
            'rstatus', 
            'payoutstatus', 
            'refererurl', 
            'ip',
            'channel',
            'episode',
            'timeslot',
            'exit',
        );
        
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = " order by t.dateinserted desc";
        }
        

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'tm_') === 0 && !isset($_REQUEST[$k]))
            {
                $_REQUEST[$k] = $v;
            }
            if($k == 'numrows' && $_REQUEST[$k] == '')
            {
                $_REQUEST[$k] = $v;
            }
        }
        
        $showAllPending = false;
        if($_REQUEST['tmdl_status'] == 'allpending')
        {
            $showAllPending = true;
            
            // it was called from main profile, display all pending transactions
            $_REQUEST['tm_status'] = AFFSTATUS_NOTAPPROVED;
            $_REQUEST['tm_userid'] = '_';
            $_REQUEST['tm_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
        }
            
        
        if(!$showAllPending)
        {
            //--------------------------------------
            // get default settings for unset variables
            if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
            if($_REQUEST['tm_userid'] == '') $_REQUEST['tm_userid'] = '_';
            if($_REQUEST['tm_transtype'] == '') $_REQUEST['tm_transtype'] = $GLOBALS['Auth']->getAllowedCommissionTypes();
            if($_REQUEST['tm_status'] == '') $_REQUEST['tm_status'] = '_';
            if($_REQUEST['tm_day1'] == '') $_REQUEST['tm_day1'] = date("j");
            if($_REQUEST['tm_month1'] == '') $_REQUEST['tm_month1'] = date("n");
            if($_REQUEST['tm_year1'] == '') $_REQUEST['tm_year1'] = date("Y");
            if($_REQUEST['tm_day2'] == '') $_REQUEST['tm_day2'] = date("j");
            if($_REQUEST['tm_month2'] == '') $_REQUEST['tm_month2'] = date("n");
            if($_REQUEST['tm_year2'] == '') $_REQUEST['tm_year2'] = date("Y");
            
            //--------------------------------------
            // put settings into session
            $_SESSION['numrows'] = $_REQUEST['numrows'];
            $_SESSION['tm_userid'] = $_REQUEST['tm_userid'];
            $_SESSION['tm_transtype'] = $_REQUEST['tm_transtype'];
            $_SESSION['tm_status'] = $_REQUEST['tm_status'];
            $_SESSION['tm_orderid'] = $_REQUEST['tm_orderid'];
            $_SESSION['tm_day1'] = $_REQUEST['tm_day1'];
            $_SESSION['tm_month1'] = $_REQUEST['tm_month1'];
            $_SESSION['tm_year1'] = $_REQUEST['tm_year1'];
            $_SESSION['tm_day2'] = $_REQUEST['tm_day2'];
            $_SESSION['tm_month2'] = $_REQUEST['tm_month2'];
            $_SESSION['tm_year2'] = $_REQUEST['tm_year2'];
            $_SESSION['tm_channel'] = $_REQUEST['tm_channel'];
            //$_SESSION['tm_episode'] = $_REQUEST['tm_episode'];
            $_SESSION['tm_timeslot'] = $_REQUEST['tm_timeslot'];
            $_SESSION['tm_exit'] = $_REQUEST['tm_exit'];            
        }
        
        $puserid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_userid']);
        $porderid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_orderid']);
        $pstatus = preg_replace('/[^0-9]/', '', $_REQUEST['tm_status']);
        
        $where = " where t.affiliateid=a.userid and a.accountid="._q($GLOBALS['Auth']->getAccountID())." and a.deleted=0 and a.rstatus in (".AFFSTATUS_APPROVED.",".AFFSTATUS_NOTAPPROVED.") ";
        
        if(!$showAllPending)
        {        
            
            	$where .= " and ((t.dateinserted >= "._q($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1'] . " 00:00:00") .")".
                	      " and (t.dateinserted <= "._q($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".$_REQUEST['tm_day2']." 23:59:59") ."))";
						 
        }
        
        if($puserid != '_' && $puserid != '')
        {
            $where .= " and t.affiliateid="._q($puserid);
        }
        
        if($porderid != '')
        {
            $where .= " and orderid like '%"._q_noendtags($porderid)."%'";
        }

        if(is_array($_REQUEST['tm_transtype']) && count($_REQUEST['tm_transtype'])>0)
        {
            $where .= " and transtype in (".implode(',', $_REQUEST['tm_transtype']).")";
        }
        
        if($_REQUEST['tm_channel'] != '_' && $_REQUEST['tm_channel'] != '')
        {            
            $where .= " and t.channel like '%".addslashes($_REQUEST['tm_channel'])."%'";
        }
        if($_REQUEST['tm_episode'] != '_' && $_REQUEST['tm_episode'] != '')
        {            
            $where .= " and t.episode like '%".addslashes($_REQUEST['tm_episode'])."%'";
        }
        if($_REQUEST['tm_timeslot'] != '_' && $_REQUEST['tm_timeslot'] != '')
        {            
            $where .= " and t.timeslot like '%".addslashes($_REQUEST['tm_timeslot'])."%'";
        }
        if($_REQUEST['tm_exit'] != '_' && $_REQUEST['tm_exit'] != '')
        {            
            $where .= " and t.exit like '%".addslashes($_REQUEST['tm_exit'])."%'";
        }        

        if($pstatus != '_' && $pstatus != '')
        {
            $where .= " and t.rstatus="._q($pstatus);
        }
        
        $where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();

        return true;
    }
    
    //--------------------------------------------------------------------------

    function prepareExportFile($orderby, $where)
    {
        // prepare file for export
        $fname = 't_'.date("Y_m_d").'_'.substr(md5(uniqid(rand(),1)), 0, 6).'.csv';
        $fdirname = $GLOBALS['Auth']->getSetting('Aff_export_dir').$fname;
        
        $exportFile = @fopen($fdirname, "wb");
        if($exportFile == FALSE)
        {
            showMsg(L_G_CANNOTWRITETOEXPORTDIR, 'error');
            return false;
        }

        $str = csvFormat(L_G_TRANSID);
        $str .= ','.csvFormat(L_G_CAMOUNT);
        $str .= ','.csvFormat(L_G_TOTALCOST);
        $str .= ','.csvFormat(L_G_ORDERID);
        $str .= ','.csvFormat(L_G_PRODUCTID);
        $str .= ','.csvFormat(L_G_CREATED);
        $str .= ','.csvFormat(L_G_DATEAPPROVED);
        $str .= ','.csvFormat(L_G_PCNAME);        
        $str .= ','.csvFormat(L_G_TYPE);
        $str .= ','.csvFormat(L_G_AFFILIATE);
        $str .= ','.csvFormat(L_G_STATUS);
        $str .= ','.csvFormat(L_G_PAID);
        $str .= ','.csvFormat(L_G_DATEPAYOUT);
        $str .= ','.csvFormat(L_G_IP);
        $str .= ','.csvFormat(L_G_REFERER);
        $str .= ','.csvFormat(L_G_DATA1);
        $str .= ','.csvFormat(L_G_DATA2);
        $str .= ','.csvFormat(L_G_DATA3);
        $str .= ','.csvFormat(L_G_CHANNEL);
        $str .= ','.csvFormat(L_G_EPISODE);
        $str .= ','.csvFormat(L_G_TIMESLOT);
        $str .= ','.csvFormat(L_G_EXIT);
        
        $str .= ','.csvFormat("Process Date");
        
        fwrite($exportFile, $str."\r\n");
        
        $sql = "select a.userid, a.name, a.surname, t.transid, t.totalcost, t.orderid,".
               " t.productid, t.dateinserted, t.rstatus, t.transtype,".
               " t.transkind, t.payoutstatus, t.dateapproved, t.commission,".
               " t.refererurl, t.ip, t.campcategoryid, t.data1, t.data2, t.data3, t.datepayout, ".
               " t.channel, t.episode, t.timeslot, t.exit ".
               "from wd_pa_transactions t, wd_g_users a";

        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {
            $str = csvFormat($rs->fields['transid']);
            $str .= ','.csvFormat($rs->fields['commission']);
            $str .= ','.csvFormat($rs->fields['totalcost']);
            $str .= ','.csvFormat($rs->fields['orderid']);
            $str .= ','.csvFormat($rs->fields['productid']);
            $str .= ','.csvFormat($rs->fields['dateinserted']);
            $str .= ','.csvFormat($rs->fields['dateapproved']);
            $str .= ','.csvFormat($this->campCategory[$rs->fields['campcategoryid']]);

            if($rs->fields['transkind'] > TRANSKIND_SECONDTIER)
                $transtype = ($rs->fields['transkind'] - TRANSKIND_SECONDTIER).' - '.L_G_TIER.' ';
            
            $transtype = $GLOBALS['Auth']->getCommissionTypeString($rs->fields['transtype']);
            $str .= ','.csvFormat($transtype);


            $str .= ','.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);

            if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $rstatus = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $rstatus = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $rstatus = L_G_SUPPRESSED;

            $str .= ','.csvFormat($rstatus);


            $str .= ','.csvFormat(($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO));
            $str .= ','.csvFormat($rs->fields['datepayout']);
            $str .= ','.csvFormat($rs->fields['ip']);
            $str .= ','.csvFormat($rs->fields['refererurl']);
            $str .= ','.csvFormat($rs->fields['data1']);
            $str .= ','.csvFormat($rs->fields['data2']);
            $str .= ','.csvFormat($rs->fields['data3']);
            $str .= ','.csvFormat($rs->fields['channel']);
            $str .= ','.csvFormat($rs->fields['episode']);
            $str .= ','.csvFormat($rs->fields['timeslot']);            
            $str .= ','.csvFormat($rs->fields['exit']); 
            
            $str .= ','.csvFormat(date("Y-m-d H:i:s"));           
            
            fwrite($exportFile, $str."\r\n");        
            
            $rs->MoveNext();
        }
        
        fclose($exportFile);

        $this->assign('a_exportFileName', $fname);
        
        return true;
        
    }
    
    //--------------------------------------------------------------------------

    function getRecords($orderby, $where)
    {
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from wd_pa_transactions t, wd_g_users a';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //------------------------------------------------
        // get records
        $sql = "select a.userid, a.name, a.surname, t.* ".
               "from wd_pa_transactions t, wd_g_users a";

        //echo $sql.$where.$orderby;
		$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;
    }
    
    //--------------------------------------------------------------------------
    
    /** returns list of columns in list view */
    function getAvailableColumns()
    {
        return array(
            'transid' =>            	array(L_G_TRANSID, 'transid'),
            'commission' =>         	array('Commission', 'commission'),
			'totalcost' =>          	array(L_G_TOTALCOST, 'totalcost'),
            'bannerid' =>            	array('Banner ID', 'bannerid'),
			'orderid' =>            	array(L_G_ORDERID, 'orderid'),
            'productid' =>          	array(L_G_PRODUCTID, 'productid'),
            'dateinserted' =>       	array(L_G_CREATED, 't.dateinserted'),
            'dateapproved' =>       	array(L_G_DATEAPPROVED, 't.dateapproved'),
            'campcategoryid' =>     	array(L_G_PCNAME, ''),
            'transtype' =>          	array(L_G_TYPE, 'transtype'),
            'userid' =>             	array(L_G_AFFILIATE, 'userid'),
            'rstatus' =>            	array(L_G_STATUS, 't.rstatus'),
            'payoutstatus' =>       	array(L_G_PAID, 't.payoutstatus'),
            'datepayout' =>         	array(L_G_DATEPAYOUT, 't.datepayout'),
            'ip' =>                 	array(L_G_IP, 'ip'),
            'refererurl' =>         	array(L_G_REFERER, 'refererurl'),
            'data1' =>              	array(L_G_DATA1, 'data1'),
            'data2' =>              	array(L_G_DATA2, 'data2'),
            'data3' =>              	array(L_G_DATA3, 'data3'),
            'channel' =>         		array(L_G_CHANNEL, 'channel'),
            'episode' =>         		array(L_G_EPISODE, 'episode'),
            'timeslot' =>         		array(L_G_TIMESLOT, 'timeslot'),
            'exit' =>         			array(L_G_EXIT, 'exit'),            
            'actions' =>            	array(L_G_ACTIONS, ''),
            'sid' =>            		array(L_G_SID, 'sid'),
            'provideractionname' => 	array(L_G_PROVIDERACTIONNAME, 'provideractionname'),
            'providerorderid' =>    	array(L_G_PROVIDERORDERID, 'providerorderid'),
            'providertype' =>       	array(L_G_PROVIDERTYPE, 'providertype'),
            'providereventdate' => 		array(L_G_PROVIDEREVENTDATEC, 'providereventdate'),
            'providerprocessdate' =>	array(L_G_PROVIDERPROCESSDATE, 'providerprocessdate'),
            'merchantname' =>           array(L_G_MERCHANTNAME, 'merchantname'),
            'merchantid' =>            	array(L_G_MERCHANTID, 'merchantid'),
            'merchantsales' =>          array(L_G_MERCHANTSALES, 'merchantsales'),
            'quantity' =>            	array(L_G_QUANTITY, 'quantity'),
            'providerchannel' =>        array(L_G_PROVIDERCHANNEL, 'providerchannel'),
            'estimatedrevenue' =>       array('Estimated Revenue', 'estimatedrevenue'),
			'dateestimated' =>          array(L_G_DATEESTIMATED, 'dateestimated'),
            'estimateddatafilename' =>  array(L_G_ESTIMATEDDATAFILENAME, 'estimateddatafilename'),
            'actualdatafilename' =>     array(L_G_ACTUALDATAFILENAME, 'actualdatafilename'),
            'providerstatus' =>         array(L_G_PROVIDERSTATUS, 'providerstatus'),
            'providercorrected' =>      array(L_G_PROVIDERCORRECTED, 'providercorrected'),
            'providerwebsiteid' =>      array(L_G_PROVIDERWEBSITEID, 'providerwebsiteid'),
            'providerwebsitename' =>    array(L_G_PROVIDERWEBSITENAME, 'providerwebsitename'),
            'provideractionid' =>       array(L_G_PROVIDERACTIONID, 'provideractionid'),
            'dateactual' =>            	array(L_G_DATEACTUAL, 'dateactual'),
        	'modifiedby' =>            	array("Created By", 'modifiedby'),
			'reftrans' =>            	array("Reference TransID", 'reftrans'),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'trans_list';
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {
        // create default view
        $viewColumns = array(
            'transid',
            'commission',
            'totalcost',
            'orderid',
            'productid',
            'dateinserted',
            'campcategoryid',
            'transtype',
            'userid',
            'rstatus',
            'payoutstatus',
            'actions',
            'ip',
            'refererurl',
            'channel',
            'episode',
            'timeslot',
            'exit',
			'quantity'            
        );
        
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

    function printListRow($row)
    {
        $view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }

        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['transid'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
                case 'transid': print '<td class=listresult>&nbsp;'.$row['transid'].'&nbsp;</td>';
                        break;
                        
                case 'commission': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'.($row['commission'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['commission']) : '').'&nbsp;</td>';
                        break;
                        
                case 'totalcost': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'.($row['totalcost'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['totalcost']) : '').'&nbsp;</td>';
                        break;
                        
                case 'orderid': print '<td class=listresult nowrap>&nbsp;'.$row['orderid'].'&nbsp;</td>';
                        break;
                        
                case 'productid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['productid'].'&nbsp;</td>';
                        break;

                case 'dateinserted': print '<td class=listresult align=right nowrap>&nbsp;'.$row['dateinserted'].'&nbsp;</td>';
                        break;

                case 'dateapproved': print '<td class=listresult align=right nowrap>&nbsp;'.$row['dateapproved'].'&nbsp;</td>';
                        break;

                case 'datepayout': print '<td class=listresult align=right nowrap>&nbsp;'.$row['datepayout'].'&nbsp;</td>';
                        break;

                case 'productid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['productid'].'&nbsp;</td>';
                        break;

                case 'campcategoryid': print '<td class=listresult align=right nowrap>&nbsp;'.$this->campCategory[$row['campcategoryid']].'&nbsp;</td>';
                        break;

                case 'transtype':
                        print '<td class=listresult align=right nowrap>&nbsp;';
                        
                        if($row['transkind'] > TRANSKIND_SECONDTIER)
                            print ($row['transkind'] - TRANSKIND_SECONDTIER).' - '.L_G_TIER.' ';
                        
                        print $GLOBALS['Auth']->getCommissionTypeString($row['transtype']);

                        print '&nbsp;</td>';
                        break;

                        
                case 'rstatus': 
                        print '<td class=listresult align=right nowrap>&nbsp;';
                        
                        if($row['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
                        else if($row['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
                        else if($row['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED;
                        
                        print '&nbsp;</td>';
                        break;

                case 'payoutstatus': print '<td class=listresult nowrap>&nbsp;'.($row['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO).'&nbsp;</td>';
                        break;

                case 'ip': print '<td class=listresult nowrap>&nbsp;'.$row['ip'].'&nbsp;</td>';
                        break;

                case 'refererurl': print '<td class=listresultnocenter align=left nowrap>&nbsp;'.$row['refererurl'].'&nbsp;</td>';
                        break;
                        
                case 'userid': print '<td class=listresult nowrap>&nbsp;'.$row['userid'].': '.$row['name'].' '.$row['surname'].'&nbsp;</td>';
                        break;

                case 'data1': print '<td class=listresult>&nbsp;'.$row['data1'].'&nbsp;</td>';
                        break;
                        
                case 'data2': print '<td class=listresult>&nbsp;'.$row['data2'].'&nbsp;</td>';
                        break;

                case 'data3': print '<td class=listresult>&nbsp;'.$row['data3'].'&nbsp;</td>';                
                        break;
                        
                case 'channel': print '<td class=listresult align=right nowrap>&nbsp;'.$row['channel'].'&nbsp;</td>';
                        break;

                case 'episode': print '<td class=listresult align=right nowrap>&nbsp;'.$row['episode'].'&nbsp;</td>';
                        break;

                case 'timeslot': print '<td class=listresult align=right nowrap>&nbsp;'.$row['timeslot'].'&nbsp;</td>';
                        break;
                case 'exit': print '<td class=listresult align=right nowrap>&nbsp;'.$row['exit'].'&nbsp;</td>';
                break;                        
                        
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
       
                                <? if($this->checkPermissions('approve')) { ?>
                                  <? if($row['rstatus'] != AFFSTATUS_APPROVED) { ?>
                                      <option value="javascript:ChangeState('<?=$row['transid']?>','approve');"><?=L_G_APPROVE?></a>
                                  <? } ?>
                                  <? if($row['rstatus'] != AFFSTATUS_SUPPRESSED) { ?>
                                      <option value="javascript:ChangeState('<?=$row['transid']?>','suppress');"><?=L_G_SUPPRESS?></a>
                                <?   }
                                   }
                                   if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:Delete('<?=$row['transid']?>');"><?=L_G_DELETE?></a>
                                <? } ?>
                            </select>
                        </td>
<?
                        break;
                case 'sid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['sid'].'&nbsp;</td>';
                        break;
                case 'provideractionname': print '<td class=listresult align=right nowrap>&nbsp;'.$row['provideractionname'].'&nbsp;</td>';
                        break;
                case 'providerorderid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providerorderid'].'&nbsp;</td>';
                        break;
                case 'providertype': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providertype'].'&nbsp;</td>';
                        break;
                case 'providereventdate': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providereventdate'].'&nbsp;</td>';
                        break;
                case 'providerprocessdate': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providerprocessdate'].'&nbsp;</td>';
                        break;
                case 'merchantname': print '<td class=listresult align=right nowrap>&nbsp;'.$row['merchantname'].'&nbsp;</td>';
                        break;
                case 'merchantid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['merchantid'].'&nbsp;</td>';
                        break;
                case 'merchantsales': print '<td class=listresult align=right nowrap>&nbsp;'.$row['merchantsales'].'&nbsp;</td>';
                        break;
                case 'quantity': print '<td class=listresult align=right nowrap>&nbsp;'.$row['quantity'].'&nbsp;</td>';
                        break;
                case 'providerchannel': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providerchannel'].'&nbsp;</td>';
                        break;
                case 'estimatedrevenue': print '<td class=listresult align=right nowrap>&nbsp;'.$row['estimatedrevenue'].'&nbsp;</td>';
                        break;
                case 'dateestimated': print '<td class=listresult align=right nowrap>&nbsp;'.$row['dateestimated'].'&nbsp;</td>';
                        break;
                case 'estimateddatafilename': print '<td class=listresult align=right nowrap>&nbsp;'.$row['estimateddatafilename'].'&nbsp;</td>';
                        break;
                case 'actualdatafilename': print '<td class=listresult align=right nowrap>&nbsp;'.$row['actualdatafilename'].'&nbsp;</td>';
                        break;
                case 'providerstatus': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providerstatus'].'&nbsp;</td>';
                        break;
                case 'providercorrected': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providercorrected'].'&nbsp;</td>';
                        break;
                case 'providerwebsiteid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providerwebsiteid'].'&nbsp;</td>';
                        break;
                case 'providerwebsitename': print '<td class=listresult align=right nowrap>&nbsp;'.$row['providerwebsitename'].'&nbsp;</td>';
                        break;
                case 'provideractionid': print '<td class=listresult align=right nowrap>&nbsp;'.$row['provideractionid'].'&nbsp;</td>';
                        break;
                case 'dateactual': print '<td class=listresult align=right nowrap>&nbsp;'.$row['dateactual'].'&nbsp;</td>';
                        break;

                default: 
                        print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.' '.$column.'</font>&nbsp;</td>';
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
          <option value=""><?=L_G_CHOOSEACTION?></option>
          <? if($this->checkPermissions('approve')) { ?>
               <option value="suppress"><?=L_G_SUPPRESS?></a>
          <? }
             if($this->checkPermissions('approve')) { ?>
               <option value="approve"><?=L_G_APPROVE?></a>
          <? }
             if($this->checkPermissions('delete')) { ?>
               <option value="delete"><?=L_G_DELETE?></a>
          <? } ?>
        </select>
        &nbsp;&nbsp;
        <input type=submit value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }
}
?>
