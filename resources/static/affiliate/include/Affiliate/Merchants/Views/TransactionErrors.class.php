<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactions');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampaignManager');
QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampCategoriesManager');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Merchants_Views_TransactionErrors extends QUnit_UI_ListPage
{
    var $campCategory;
    var $tacc;

    //--------------------------------------------------------------------------    

    function initPermissions()
    {
    	$this->tacc = new Affiliate_Merchants_Bl_Transactions();
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
                case 'update':
                    if($this->processUpdateTransaction())
                        return;
                    break;
            }
            
            switch($_POST['massaction'])
            {
                case 'override':
                    if($this->processOverride())
                        return;
                break;
                
                case 'delete':
                    if($this->processDelete())
                        return;
                break;
                
                case 'new':
                    if($this->processCreateNew())
                        return;
                break;
                
                case 'resubmit':
                    if($this->processResubmit())
                        return;
                break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
				
                case 'trace':
                	
                    if($this->drawTransHistory($_REQUEST['reftrans']));
                        return;
                    break;  	
									
                case 'delete':
                    if($this->processDelete())
                        return;
                    break;         
                
                case 'resubmit':
                    if($this->processResubmit($_REQUEST['tid']))
                        return;
                    break;              
                
                case 'difftrans':
                    if($this->processDiffTrans($_REQUEST['tid']))
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
    
    //--------------------------------------------------------------------------
    
    function drawFormEditTransaction()
    {
        if($_POST['commited'] != 'yes')
        {
            $params = array('AccountID' => $GLOBALS['Auth']->getAccountID());

           
            $this->tacc->loadTransactionInfoError($params);
        }
    
    	$sql = "SELECT * FROM wd_pa_transactions WHERE transid = " . _q($_POST['tid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        $_POST['actual_totalcost'] = $rs->fields['totalcost'];
        $_POST['actual_estimatedrevenue'] = $rs->fields['estimatedrevenue'];
        $_POST['actual_providerprocessdate'] = $rs->fields['providerprocessdate'];
        $_POST['actual_dateapproved'] = $rs->fields['dateapproved'];
        
        $_POST['header'] = L_G_EDIT_TRANSACTION;
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'update';

        $users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($users);
        $this->assign('a_list_data', $list_data);

        $this->addContent('errors_edit');
        
        return true;
    }
	
	function drawTransHistory($reftrans){
    	$tacc = new Affiliate_Merchants_Bl_Transactions();
    	$_POST['trace_table'] = $tacc->traceTransaction($reftrans);
    
    	$this->addContent('query_tool_trace');
    }
    
    //--------------------------------------------------------------------------
    
    
    function processUpdateTransaction()
    {
    	
        // protect against script injection
        //$transid = preg_replace('/[^0-9]/', '', $_POST['transid']);
        

        	
        $providerprocessdate = $_POST['providerprocessdate'];
        	


        $dateapproved = $_POST['dateapproved'];

        $totalcost = $_POST['totalcost'];
        $estimatedrevenue = $_POST['estimatedrevenue'];
        $id = $_POST['id'];
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
        	
            $params = array(
                            'estimatedrevenue' => $estimatedrevenue,
                            'providerprocessdate' => $providerprocessdate,
                            'dateapproved' => $dateapproved,
                            'totalcost' => $totalcost,
                            'id' => $id,
                           );
			
            if($this->tacc->updateTransactionError($params))
                QUnit_Messager::setOkMessage(L_G_TRANSACTION_EDITED);

            $this->redirect('Affiliate_Merchants_Views_TransactionErrors&type=all');
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
        $totalcost = preg_replace('/[^0-9\.]/', '', $_POST['totalcost']);
        $orderid = preg_replace('/[\'\"]/', '', $_POST['orderid']);
        $productid = preg_replace('/[\'\"]/', '', $_POST['productid']);
        $commission = preg_replace('/[\'\"]/', '', $_POST['commission']);
        $createtype = preg_replace('/[\'\"]/', '', $_POST['createtype']);
        
        // check correctness of the fields
        checkCorrectness($_POST['userid'], $userid, L_G_AFFILIATE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['campaignid'], $campaignid, L_G_CAMPAIGN, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['transtype'], $transtype, L_G_TYPE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['totalcost'], $totalcost, L_G_TOTALCOST, CHECK_ALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['createtype'], $createtype, L_G_TYPEOFCREATECOMMISSION, CHECK_EMPTYALLOWED);
        
        if($createtype == 'manual')
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
        if(($IDs = $this->returnUIDs()) == false){
            return false;
        }
            
        $params = array();
        $params['ids'] = $IDs;
        
        
        $this->tacc->delete_invalid($params, true);
        
        //Affiliate_Merchants_Bl_Transactions::delete_invalid($params);
        
        return false;
        
    }
    
    function processResubmit()
    {
        if(($IDs = $this->returnUIDs()) == false)
            return false;   
        
        foreach($IDs as $id)
        	$this->tacc->resubmit_errored_transaction($id);
        
        return false;
        
    }
    
    function processDiffTrans($id, $neg = true)
    {
        $sql = "SELECT transid FROM wd_pa_transactions_errors WHERE id = " . _q($id);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        $sql = "SELECT commission FROM wd_pa_transactions WHERE transtype = '4' AND reftrans=" . _q($rs->fields['transid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        $amount = $rs->fields['commission'];
        if($neg)
        	$amount *= -1;
        $this->tacc->insert_commission_adjustment($amount, $id);
        
        return false;
    }    
    
    function processOverride()
    {
        if(($IDs = $this->returnUIDs()) == false)
            return false;
            
        $params = array();
        $params['ids'] = $IDs;
        
        foreach($IDs as $id)
        	$this->tacc->override_transaction($id);
     
        return false;
    }

    function processCreateNew()
    {
        if(($IDs = $this->returnUIDs()) == false)
            return false;
            
        $params = array();
        $params['ids'] = $IDs;
        
        
        $this->tacc->insert_sales_from_errored_transactions($params);
     
        return false;
    }    
    
    //--------------------------------------------------------------------------

    function returnUIDs()
    {
        if($_POST['massaction'] != '')
        {

            $IDs = $_POST['itemschecked'];
        }
        else
        {

            $IDs = array($_REQUEST['tid']);
        }
        
        return $IDs;
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

        $this->addContent('transaction_errors');        
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
            'errordate',
            'errorcode',
            'estimatedrevenue',
            'totalcost',
            'providerprocessdate',
            'dateapproved',
            
        );
        
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = " order by t.".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = " order by t.errordate desc";
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
            if($_REQUEST['logtype'] == '') $_REQUEST['logtype'] = '_';
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
            $_SESSION['tm_episode'] = $_REQUEST['tm_episode'];
            $_SESSION['tm_timeslot'] = $_REQUEST['tm_timeslot'];
            $_SESSION['tm_exit'] = $_REQUEST['tm_exit'];  
            $_SESSION['logtype'] = $_REQUEST['logtype'];       
        	
        }
        
        $puserid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_userid']);
        $porderid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_orderid']);
        $pstatus = preg_replace('/[^0-9]/', '', $_REQUEST['tm_status']);
        
        $where = " where a.rstatus in (".AFFSTATUS_APPROVED.",".AFFSTATUS_NOTAPPROVED.")";

        
        if(!$showAllPending)
        {        
            $where .= " and (t.errordate >= " . _q($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1']).")".
                      " and (t.errordate <= " ._q($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".($_REQUEST['tm_day2'] + 1)).")";
        }
        
        if($puserid != '_' && $puserid != '')
        {
            $where .= " and t.affiliateid="._q($puserid);
        }
        

        if($_REQUEST['logtype'] == "error")
        {
            $where .= " and t.errorcode >= -1 ";
        }else if($_REQUEST['logtype'] == "variance")
        	 $where .= " and t.errorcode < -1 ";
          
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
        $str .= ';'.csvFormat(L_G_CAMOUNT);
        $str .= ';'.csvFormat(L_G_TOTALCOST);
        $str .= ';'.csvFormat(L_G_ORDERID);
        $str .= ';'.csvFormat(L_G_PRODUCTID);
        $str .= ';'.csvFormat(L_G_CREATED);
        $str .= ';'.csvFormat(L_G_DATEAPPROVED);
        $str .= ';'.csvFormat(L_G_PCNAME);        
        $str .= ';'.csvFormat(L_G_TYPE);
        $str .= ';'.csvFormat(L_G_AFFILIATE);
        $str .= ';'.csvFormat(L_G_STATUS);
        $str .= ';'.csvFormat(L_G_PAID);
        $str .= ';'.csvFormat(L_G_DATEPAYOUT);
        $str .= ';'.csvFormat(L_G_IP);
        $str .= ';'.csvFormat(L_G_REFERER);
        $str .= ';'.csvFormat(L_G_DATA1);
        $str .= ';'.csvFormat(L_G_DATA2);
        $str .= ';'.csvFormat(L_G_DATA3);
        $str .= ';'.csvFormat(L_G_CHANNEL);
        $str .= ';'.csvFormat(L_G_EPISODE);
        $str .= ';'.csvFormat(L_G_TIMESLOT);
        $str .= ';'.csvFormat(L_G_EXIT);
        
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
            $str .= ';'.csvFormat($rs->fields['commission']);
            $str .= ';'.csvFormat($rs->fields['totalcost']);
            $str .= ';'.csvFormat($rs->fields['orderid']);
            $str .= ';'.csvFormat($rs->fields['productid']);
            $str .= ';'.csvFormat($rs->fields['dateinserted']);
            $str .= ';'.csvFormat($rs->fields['dateapproved']);
            $str .= ';'.csvFormat($this->campCategory[$rs->fields['campcategoryid']]);

            if($rs->fields['transkind'] > TRANSKIND_SECONDTIER)
                $transtype = ($rs->fields['transkind'] - TRANSKIND_SECONDTIER).' - '.L_G_TIER.' ';
            
            $transtype .= $GLOBALS['Auth']->getCommissionTypeString($rs->fields['transtype']);
            $str .= ';'.csvFormat($transtype);


            $str .= ';'.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);

            if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $rstatus = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $rstatus = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $rstatus = L_G_SUPPRESSED;

            $str .= ';'.csvFormat($rstatus);


            $str .= ';'.csvFormat(($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO));
            $str .= ';'.csvFormat($rs->fields['datepayout']);
            $str .= ';'.csvFormat($rs->fields['ip']);
            $str .= ';'.csvFormat($rs->fields['refererurl']);
            $str .= ';'.csvFormat($rs->fields['data1']);
            $str .= ';'.csvFormat($rs->fields['data2']);
            $str .= ';'.csvFormat($rs->fields['data3']);
            $str .= ';'.csvFormat($rs->fields['channel']);
            $str .= ';'.csvFormat($rs->fields['episode']);
            $str .= ';'.csvFormat($rs->fields['timeslot']);            
            $str .= ';'.csvFormat($rs->fields['exit']);            
            
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
        $sql = 'select count(*) as count from wd_pa_transactions_errors';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql));
        //echo "sql: " . $sql . "<br>Count: " . $this->getTotalNumberOfRecords($sql) . "<br>";
        
        
        //------------------------------------------------
        // get records
        $sql = "select t.*, a.rstatus From wd_pa_transactions_errors as t, wd_g_users as a ";
        $where.= " group by id";
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
            'transid' =>            array('Transaction ID', 'transid'),
            'id' =>					array('Error ID', 'id'),
			'errorcode' =>			array('Error Code', 'errorcode'),
            'errordate' =>			array('Error Date', 'errordate'),
            'dateapproved' =>		array('Proposed Date Approved', 'dateapproved'),
			'totalcost' => 			array('Proposed Actual Revenue', 'totalcost'),
			//'old_totalcost' => 			array('Current Actual Revenue', 'old_totalcost'),
			'providerprocessdate' => array('Proposed Process Date', 'providerprocessdate'),
			'estimatedrevenue' =>	array('Proposed Estimated Revenue', 'estimatedrevenue'),
            //'old_estimatedrevenue' =>	array('Current Estimated Revenue', 'old_estimatedrevenue'),
            //'affiliateid' =>		array('', 'affiliateid'),
            //'old_commission' =>         array('Current Commission', 'commission'),
            //'totalcost' =>          array(L_G_TOTALCOST, 'totalcost'),
            //'orderid' =>            array(L_G_ORDERID, 'orderid'),
            //'productid' =>          array(L_G_PRODUCTID, 'productid'),
            //'dateinserted' =>       array(L_G_CREATED, 't.dateinserted'),
            //'dateapproved' =>       array(L_G_DATEAPPROVED, 't.dateapproved'),
            'campcategoryid' =>     array(L_G_PCNAME, ''),
            //'transtype' =>          array(L_G_TYPE, 'transtype'),
            //'userid' =>             array(L_G_AFFILIATE, 'userid'),
            //'rstatus' =>            array(L_G_STATUS, 't.rstatus'),
            //'payoutstatus' =>       array(L_G_PAID, 't.payoutstatus'),
            //'datepayout' =>         array(L_G_DATEPAYOUT, 't.datepayout'),
            //'ip' =>                 array(L_G_IP, 'ip'),
            //'refererurl' =>         array(L_G_REFERER, 'refererurl'),
            //'data1' =>              array(L_G_DATA1, 'data1'),
            //'data2' =>              array(L_G_DATA2, 'data2'),
            //'data3' =>              array(L_G_DATA3, 'data3'),
            //'channel' =>         array(L_G_CHANNEL, 'channel'),
            ///'episode' =>         array(L_G_EPISODE, 'episode'),
            //'timeslot' =>         array(L_G_TIMESLOT, 'timeslot'),
            //'exit' =>         array(L_G_EXIT, 'exit'),            
            'actions' =>            array(L_G_ACTIONS, ''),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'trans_error_list';
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {
        // create default view
        $viewColumns = array(
            'transid',
            'id',
            'errorcode',
            'errordate',
            //'old_commission',
            'estimatedrevenue',
            //'old_estimatedrevenue',
			'providerprocessdate',
			'totalcost',
			//'old_totalcost',
			'dateapproved',
			'actions'
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
        $error_codes = array(// variance errors
        					 -3 => "estimate less than actual",
        					 -2 => "estimate greater than actual",
        					 //parse errors
        					 -1 => "no transid",
        					  1 => "transid does not exist",
        					  2 => "missing required fields",
        					  3 => "duplicate estimate",
        					  4 => "estimate attempted on actual value",
        					  5 => "duplicate actual",
        					  6 => "transid has 2 or more possible matches");
        $view = $this->getView();
        
        
        $transid = $row['transid'];
        
        
        if($transid != ""){
        	$sql = "SELECT * FROM wd_pa_transactions WHERE transtype='4' AND reftrans = " . _q($transid);
        	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        }
        
        
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }

        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['id'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
                case 'transid': print '<td class=listresult>&nbsp;'.$row['transid'].'&nbsp;</td>';
                        break;
                
                case 'id': print '<td class=listresult>&nbsp;'.$row['id'].'&nbsp;</td>';
                        break;
                
                case 'errorcode': print '<td class=listresult>&nbsp;'.$error_codes[$row['errorcode']].'&nbsp;</td>';
                        break;

                case 'errordate': print '<td class=listresult>&nbsp;'.$row['errordate'].'&nbsp;</td>';
                        break;
                
            	case 'dateapproved': print '<td class=listresult>&nbsp;'.$row['dateapproved'].'&nbsp;</td>';
						break;
            	
            	case 'totalcost': print '<td class=listresult>&nbsp;'.$row['totalcost'].'</td>';
						break;	
            	
            	//case 'old_totalcost': print '<td class=listresult>&nbsp;'.$rs->fields['totalcost'].'</td>';
				//		break;							
				
				case 'providerprocessdate': print '<td class=listresult>&nbsp;'.$row['providerprocessdate'].'&nbsp;</td>';
						break;					
				
				case 'estimatedrevenue' : print '<td class=listresult>&nbsp;'.$row['estimatedrevenue'] . '</td>';
						break;			

				//case 'old_estimatedrevenue' : print '<td class=listresult>&nbsp;'.$rs->fields['estimatedrevenue'] . '</td>';
				//		break;	
			                    
                case 'commission': print '<td class=listresultnocenter align="right" nowrap>&nbsp;' . $row['commission'] . '&nbsp;</td>';
                        break;
                        
                //case 'old_commission': print '<td class=listresultnocenter align="right" nowrap>&nbsp;' . $rs->fields['commission'] . '&nbsp;</td>';
                //       break;        
                        
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
                                <option value="-">--------------------------------------</option>
                                <option value="javascript:traceTransaction('<?=$row['transid']?>');">View Transaction History</a>
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editTransaction('<?=$row['id']?>');"><?=L_G_EDIT?></a>
                                <? } ?>
                                      <option value="javascript:ReSubmit('<?=$row['id']?>');">Resubmit</a>
									<?if($row['totalcost'] < 1 && $rs->fields['estimatedrevenue'] > 0 && $rs->fields['commission'] > 0){ ?>
									  <option value="javascript:DiffTrans('<?=$row['id']?>');">Zero out commission.</a>
								  <? } ?>
                                  <?
                                   if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:Delete('<?=$row['id']?>');"><?=L_G_DELETE?></a>
                                <? } ?>
                            </select>
                        </td>
<?
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
               <option value="new">Create New Sale</a>
               <option value="resubmit">Resubmit Transaction</a>
               <option value="override">Override Transaction</a>
              <!-- <option value="approve"></a> !--> 
               <option value="delete"><?=L_G_DELETE?> Transaction</a>
        </select>
        &nbsp;&nbsp;
        <input type=submit value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }
}
?>
