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

class Affiliate_Merchants_Views_QueryTool extends QUnit_UI_ListPage
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
                
                case 'approve_payout':
                	
                	if($this->processApprovePayout())
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
                
                case 'payout':
                    if($this->drawFormApproveTransactionPayout())
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
                
                case 'suppress':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
                        return;
                    break;              
                
                case 'approve':
                    if($this->processChangeState(AFFSTATUS_APPROVED))
                        return;
                    break;
                    
                case 'approve_payout':
                    if($this->drawFormApproveTransactionPayout())
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
    
    //--------------------------------------------------------------------------

    
    function drawFormApproveTransactionPayout()
    {
    	if(($transIDs = $this->returnUIDs()) == false)
            return false;
            
        $trans_array = $transIDs;
        $trans_array= $this->getEstimatedRev($transIDs);
        $_POST['transarray'] = $trans_array;
        
        if(count($trans_array)  < 1){
        	QUnit_Messager::setErrorMessage("No valid transaction to assign actual revenue.");	
        	return;
        }
        	
    	
        if($_POST['commited'] != 'yes')
        {
            $params = array('AccountID' => $GLOBALS['Auth']->getAccountID());
            Affiliate_Merchants_Bl_Transactions::loadTransactionInfo($params);
        }
    
        $_POST['header'] = 'approve transactions';
        $_POST['action'] = 'approve';
        $_POST['postaction'] = 'update';

        $users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($users);
        $this->assign('a_list_data', $list_data);

        $this->addContent('query_tool_approve');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function drawTransHistory($reftrans){
    	$tacc = new Affiliate_Merchants_Bl_Transactions();
    	$_POST['trace_table'] = $tacc->traceTransaction($reftrans);
    
    	$this->addContent('query_tool_trace');
    }
    
    function getCampaignsAsArray()
    {
        $sql = 'select * FROM wd_pa_campaigns WHERE deleted=0';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
    
        $banners = array();
    
        while(!$rs->EOF)
        {
            $banners[$rs->fields['campaignid']] = $rs->fields['name'];
            $rs->MoveNext();
        }

        return $banners;    	
    }
    
    function getCampIdsFromCamp($camp)
    {
    	
    	// QUESTION: is the following select statement a NETFINITI addition and should not be here?
    	//$sql = "SELECT campcategoryid FROM wd_pa_affiliatescampaigns WHERE campaignid = " ._q($camp);
    	$sql = "SELECT campcategoryid FROM wd_pa_campaigncategories WHERE campaignid = " ._q($camp);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$res = array();
    	while($rs && !$rs->EOF){
    		$res[] = $rs->fields['campcategoryid'];
    		$rs->MoveNext();
    	}
    	return $res; 
    	//$rs->fields['campaignid'];
    }
    
    function getBannersAsArray()
    {
        $sql = 'select b.bannerid, c.name from wd_pa_banners as b, wd_pa_campaigns as c where b.deleted=0 and b.campaignid = c.campaignid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
    
        $banners = array();
    
        while(!$rs->EOF)
        {
            $banners[$rs->fields['bannerid']] = $rs->fields['bannerid'];
            $rs->MoveNext();
        }

        return $banners;
    }
    
        //--------------------------------------------------------------------------
    
    
    function processApprovePayout()
    {
    	foreach($_POST as $id=>$value){
    		
    		$temp = explode("_", $id);
    		
    		if($temp[0] == "totalcost"){
    			$TotalCostArray[$temp[1]] = $value; 
    			//echo $temp[1] . " " . $TotalCostArray[$temp[1]] . "<br>";
    		}
    		if($temp[0] == "dateapproved"){
    			if($value == "")
    				$value = $_POST['dateapproved_master'];
    			$DateArray[$temp[1]] = $value; 
    			//echo $temp[1] . " " . $DateArray[$temp[1]] . "<br>";
    		}

    	}
    	
    	foreach($TotalCostArray as $id=>$value){
    		$resultArray[$id] = array($value, $DateArray[$id]);	
    		//echo $id . " " . $value . " " . $DateArray[$id] . "<br>";
    	}
    	
    	foreach($resultArray as $id=>$values){
        	// protect against script injection
        	$TransID = $id;
        	$totalcost = $values[0];
        	$dateapproved = $values[1];

			//echo $TransID . " " . $totalcost . " " . $providerprocessdate . "<br>";

        	// check correctness of the fields
        	//checkCorrectness($_POST['totalcost'], $totalcost, L_G_TOTAL_COST);

        
        	if($parenttrans != '')
        	{
            	if($transkind <= TRANSKIND_SECONDTIER)
             	   QUnit_Messager::setErrorMessage(L_G_CANNOTCHOOSEPARENTTRANS);
           	 else if(Affiliate_Merchants_Bl_Transactions::checkTransactionExists($parenttrans, $GLOBALS['Auth']->getAccountID()))
            	    QUnit_Messager::setErrorMessage(L_G_TRANSACTIONDOESNOTEXISTS);
       		} 
        
            	$params = array('TransID' => $TransID,
							'totalcost' => $totalcost,
                            'AccountID' => $GLOBALS['Auth']->getAccountID(),
                           	'dateapproved' => $dateapproved,
                           );
				$tacc = new Affiliate_Merchants_Bl_Transactions();
            
            	if($tacc->approve_transaction_payout($params))
                	QUnit_Messager::setOkMessage("Transaction " . $TransID . " successfully updated.");

            	//$this->redirect('Affiliate_Merchants_Views_QueryTool&type=all');
            	//$this->closeWindow('Affiliate_Merchants_Views_TransactionManager&type=all');
            	//$this->addContent('closewindow');
  
    	}
        
    }    

    //--------------------------------------------------------------------------
    
    function processDelete()
    {
        if(($transIDs = $this->returnUIDs()) == false)
            return false;
        
		$tacc = new Affiliate_Merchants_Bl_Transactions();
		$tacc->delete_sales($transIDs);
		
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
    
    function showTransactions($exportToCsv)
    {
        $_POST['banner_array'] = $this->getBannersAsArray();
        $_POST['campaign_array'] = $this->getCampaignsAsArray();
        
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

        $this->addContent('query_list');        
    }

    //--------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $usersRs = Affiliate_Merchants_Bl_Affiliate::getUsersAsRs();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);
        
        $this->assign('a_list_users', $list_data);
    } 
    
    function getFilenamesForFilter(){
    	return;
		/**
		$sql = "SELECT distinct actualdatafilename FROM wd_pa_transactions WHERE transtype = '4'";
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	while(!$rs->EOF){
    		if(trim($rs->fields['actualdatafilename']) != null)
    			$actualfile_array[] = $rs->fields['actualdatafilename'];
    		$rs->MoveNext();	
    	}
    	$sql = "SELECT distinct estimateddatafilename FROM wd_pa_transactions WHERE transtype = '4'";
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	while(!$rs->EOF){
    	    if(trim($rs->fields['estimateddatafilename']) != null)
    			$estimatedfile_array[] = $rs->fields['estimateddatafilename'];
    		$rs->MoveNext();	
    	}
    	$_POST['actual_files'] = $actualfile_array;
    	$_POST['estimated_files'] = $estimatedfile_array;
    	**/
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
            'provideractionname',
            'providerorderid',
            'providertype',
            'providereventdate',
            'providerprocessdate',
            'merchantname',
            'merchantid',
            'merchantsales',
            'quantity', 
            'providerchannel',
            'estimatedrevenue', 
            'dateestimated', 
            'estimateddatafilename',
            'actualdatafilename',
            'providerstatus',
            'providercorrected',
            'providerwebsiteid',
            'providerwebsitename',
            'provideractionid',
            'dateactual',
            'bannerid',
            'payoutstatus',
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
            else if($k == 'numrows' && $_REQUEST[$k] == '')
            {
                $_REQUEST[$k] = $v;
            }
            else if($k == 'estimated_filename' && $_REQUEST[$k] == '')
            {
                $_REQUEST[$k] = $v;
            }
            else if($k == 'actual_filename' && $_REQUEST[$k] == '')
            {
                $_REQUEST[$k] = $v;
            }
            else if($k == 'transaction_type' && $_REQUEST[$k] == '')
            {
                $_REQUEST[$k] = $v;
            }
			else if($k == 'transactionid' && $_REQUEST[$k] == '')
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
            if($_REQUEST['tm_year2'] == '') $_REQUEST['tm_year2'] = date("Y");
			//if($_REQUEST['transaction_type'] == '') $_REQUEST['transaction_type'] = 4;
			
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
        	$_SESSION['po_status'] = $_REQUEST['po_status'];
        	$_SESSION['tm_campaign'] = $_REQUEST['tm_campaign']; 
        	$_SESSION['transaction_type'] = $_REQUEST['transaction_type']; 
        	//$_SESSION['actual_filename'] = $_REQUEST['actual_filename']; 
        	//$_SESSION['estimated_filename'] = $_REQUEST['estimated_filename']; 
			//$_SESSION['transactionid'] = $_REQUEST['transactionid']; 
        
        }
        
        $puserid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_userid']);
        $porderid = preg_replace('/[\'\"]/', '', $_REQUEST['tm_orderid']);
        $pstatus = preg_replace('/[^0-9]/', '', $_REQUEST['tm_status']);
        $payoutstatus = preg_replace('/[^0-9]/', '', $_REQUEST['po_status']);
        
        $where = " where t.affiliateid=a.userid and a.accountid="._q($GLOBALS['Auth']->getAccountID())." and a.deleted=0 and a.rstatus in (".AFFSTATUS_APPROVED.",".AFFSTATUS_NOTAPPROVED.") ";
        
        
        if(!$showAllPending)
        {
        	if($_REQUEST['date'] != 'all' && $_REQUEST['date'] != ''){        
            	$where .= " and ((".$_REQUEST['date']." >= "._q($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1']. " 00:00:00") .  ")" .
                	      " and (".$_REQUEST['date']." <= "._q($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".$_REQUEST['tm_day2'] . " 23:59:59") ."))";
						  
        	}
        }
        
        if($reftrans != '_' && $reftrans != ''){
        	$where .= " and (t.reftrans =". _q($reftrans) ." OR  t.transid =" . _q($reftrans) . ")";	
        }
        
        if($puserid != '_' && $puserid != '')
        {
            $where .= " and t.affiliateid="._q($puserid);
        }
        
        if($_REQUEST['tm_bannerid'] != '_' && $_REQUEST['tm_bannerid'] != '')
        {            
            $where .= " and t.bannerid = '".$_REQUEST['tm_bannerid']."'";
        }
        
		if($_REQUEST['transactionid'] != '_' && $_REQUEST['transactionid'] != '')
        {            
            $where .= " and (t.transid = ". _q($_REQUEST['transactionid']) . " OR t.reftrans = " . _q($_REQUEST['transactionid']) . ") ";
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
        
        if($payoutstatus != '_' && $payoutstatus != '')
        {
            $where .= " and t.payoutstatus="._q($payoutstatus);
        }
        
        if($_REQUEST['actual_filename'] != '_' && $_REQUEST['actual_filename']  != '')
        {
            $where .= " and t.actualdatafilename LIKE "._q($_REQUEST['actual_filename'] . "%");
			$orderby = " ORDER BY transtype DESC";
        }
        
                
        if($_REQUEST['estimated_filename'] != '_' && $_REQUEST['estimated_filename']  != '')
        {
            $where .= " and t.estimateddatafilename LIKE " ._q($_REQUEST['estimated_filename'] . "%") ;
			$orderby = " ORDER BY transtype DESC";
        }
		
		if($_REQUEST['transaction_type'] != '_' && $_REQUEST['transaction_type']  != '')
        {
            $where .= " and t.transtype= " ._q($_REQUEST['transaction_type']);
        }
        
       	if($_REQUEST['tm_campaign'] != '_' && $_REQUEST['tm_campaign']  != '')
        {
        	
        	$campcategories = $this->getCampIdsFromCamp($_REQUEST['tm_campaign']);
        	
        	//$campcategories[] = $_REQUEST['tm_campaign'];
            
            $where .= " and t.campcategoryid in " . "('" . implode("','", $campcategories) . "')";
        }

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

        $str = csvFormat("PROCESS DATE");
        $str .= ','.csvFormat(L_G_TRANSID);
        $str .= ','.csvFormat(L_G_CAMOUNT);
        $str .= ','.csvFormat(L_G_DATA1);
        
        /**
        
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
        
        $str .= ','.csvFormat(L_G_DATA2);
        $str .= ','.csvFormat(L_G_DATA3);
        $str .= ','.csvFormat(L_G_CHANNEL);
        $str .= ','.csvFormat(L_G_EPISODE);
        $str .= ','.csvFormat(L_G_TIMESLOT);
        $str .= ','.csvFormat(L_G_EXIT);

		$str .= ','.csvFormat('sid');
		$str .= ','.csvFormat('provideractionname');
		$str .= ','.csvFormat('providerorderid');   
		$str .= ','.csvFormat('providertype');  
		$str .= ','.csvFormat('providereventdate');
		$str .= ','.csvFormat('providerprocessdate');
		$str .= ','.csvFormat('merchantname');
		$str .= ','.csvFormat('merchantid');
		$str .= ','.csvFormat('merchantsales');
		$str .= ','.csvFormat('quantity');
		$str .= ','.csvFormat('providerchannel');
		$str .= ','.csvFormat('estimatedrevenue');
		$str .= ','.csvFormat('dateestimated');
		$str .= ','.csvFormat('dateactual');
		$str .= ','.csvFormat('estimateddatafilename');
		$str .= ','.csvFormat('actualdatafilename');
		$str .= ','.csvFormat('providerstatus');
		$str .= ','.csvFormat('providercorrected');
		$str .= ','.csvFormat('providerwebsiteid');      
        $str .= ','.csvFormat('providerwebsitename');
		$str .= ','.csvFormat('provideractionid');
		$str .= ','.csvFormat('modifiedby');
		$str .= ','.csvFormat('reftrans');		

        **/
        fwrite($exportFile, $str."\r\n");
        
        $sql = "select a.userid, a.name, a.surname, t.* " . 
                "from wd_pa_transactions t, wd_g_users a";

        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {

            $str = csvFormat(date("Y-m-d H:i:s"));
            $str .= ','.csvFormat($rs->fields['transid']);
            $str .= ','.csvFormat($rs->fields['commission']);
            $str .= ','.csvFormat($rs->fields['data1']);
            /**
            
            $str .= ','.csvFormat($rs->fields['totalcost']);
            $str .= ','.csvFormat($rs->fields['orderid']);
            $str .= ','.csvFormat($rs->fields['productid']);
            $str .= ','.csvFormat($rs->fields['dateinserted']);
            $str .= ','.csvFormat($rs->fields['dateapproved']);
            $str .= ','.csvFormat($this->campCategory[$rs->fields['campcategoryid']]);

            if($rs->fields['transkind'] > TRANSKIND_SECONDTIER)
                $transtype = ($rs->fields['transkind'] - TRANSKIND_SECONDTIER).' - '.L_G_TIER.' ';
            
			$transtypes = array();
			$transtypes[1] = 'click';
			$transtypes[4] = 'sale';
			$transtypes[99] = 'commission adjustment';
			$transtypes[95] = 'revenue adjustment';	
			$transtypes[100] = 'sale reversal';	
			$transtypes[101] = 'adjustedment reversal';				
			
            $transtype = $transtypes[$rs->fields['transtype']];
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
            
            $str .= ','.csvFormat($rs->fields['data2']);
            $str .= ','.csvFormat($rs->fields['data3']);
            $str .= ','.csvFormat($rs->fields['channel']);
            $str .= ','.csvFormat($rs->fields['episode']);
            $str .= ','.csvFormat($rs->fields['timeslot']);            
            $str .= ','.csvFormat($rs->fields['exit']);
			
			$str .= ','.csvFormat($rs->fields['sid']);
			$str .= ','.csvFormat($rs->fields['provideractionname']);
			$str .= ','.csvFormat($rs->fields['providerorderid']);   
			$str .= ','.csvFormat($rs->fields['providertype']);  
			$str .= ','.csvFormat($rs->fields['providereventdate']);
			$str .= ','.csvFormat($rs->fields['providerprocessdate']);
			$str .= ','.csvFormat($rs->fields['merchantname']);
			$str .= ','.csvFormat($rs->fields['merchantid']);
			$str .= ','.csvFormat($rs->fields['merchantsales']);
			$str .= ','.csvFormat($rs->fields['quantity']);
			$str .= ','.csvFormat($rs->fields['providerchannel']);
			$str .= ','.csvFormat($rs->fields['estimatedrevenue']);
			$str .= ','.csvFormat($rs->fields['dateestimated']);
			$str .= ','.csvFormat($rs->fields['dateactual']);
			$str .= ','.csvFormat($rs->fields['estimateddatafilename']);
			$str .= ','.csvFormat($rs->fields['actualdatafilename']);
			$str .= ','.csvFormat($rs->fields['providerstatus']);
			$str .= ','.csvFormat($rs->fields['providercorrected']);
			$str .= ','.csvFormat($rs->fields['providerwebsiteid']);      
            $str .= ','.csvFormat($rs->fields['providerwebsitename']);
			$str .= ','.csvFormat($rs->fields['provideractionid']);
			$str .= ','.csvFormat($rs->fields['modifiedby']);
			$str .= ','.csvFormat($rs->fields['reftrans']);
            **/
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
        if($_REQUEST['runQuery'] == 'false'){
			$_POST['runQuery'] = 'false';
			return;
		}
		
		//------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from wd_pa_transactions t, wd_g_users a';
        //echo "<b>" . $sql.$where . "</b><br><br>";
		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //------------------------------------------------
        // get records
        $sql = "select a.userid, a.name, a.surname, t.* ".
               "from wd_pa_transactions t, wd_g_users a";

		
        echo $sql.$where.$orderby;
        
        
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
            'transtype',
            'campcategoryid',
            'dateinserted',
            'commission',
            //'adjustedcommission',
            'estimatedrevenue',
            //'adjustedestimatedrevenue',
            'dateestimated',
			'totalcost',
			'dateactual',
            //'providerprocessdate', 
			'modifiedby',
            'reftrans',
			'quantity',
			'actions',
           
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
		$tacc = new Affiliate_Merchants_Bl_Transactions();
		
        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['transid'].'"></td>';
        
        foreach($view->columns as $column)
        {
			if($row['reversed'] == 1)
				$showred = "<font color='red'>";
			else
				$showred = "";
            switch($column)
            {
				case 'modifiedby' :  print '<td class=listresult>&nbsp;'. $showred . $row['modifiedby'] .  '&nbsp;</td>';
                        break;
            	//case 'adjustedcommission' :  print '<td class=listresult>&nbsp;'.($tacc->get_adjusted_commission($row['reftrans']) != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($tacc->get_adjusted_commission($row['reftrans'])) : '') . '&nbsp;</td>';
                        //break;
                //case 'adjustedestimatedrevenue' :  print '<td class=listresult>&nbsp;'.($tacc->get_adjusted_estimated_revenue($row['reftrans']) != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($tacc->get_adjusted_estimated_revenue($row['reftrans'])) : '') .  '&nbsp;</td>';
                        //break;
                
                case 'transid': print '<td class=listresult>&nbsp;' . $showred . $row['transid'].'</a>&nbsp;</td>';
                        break;
                        
                case 'commission': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'. $showred . ($row['commission'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['commission']) : '').'&nbsp;</td>';
                        break;
                        
                case 'totalcost': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'. $showred .($row['totalcost'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['totalcost']) : '').'&nbsp;</td>';
                        break;
                        
                case 'bannerid': print '<td class=listresult nowrap>&nbsp;'. $showred .$row['bannerid'].'&nbsp;</td>';
                        break;
                
                case 'orderid': print '<td class=listresult nowrap>&nbsp;'. $showred . $row['orderid'].'&nbsp;</td>';
                        break;
                        
                case 'productid': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['productid'].'&nbsp;</td>';
                        break;

                case 'dateinserted': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['dateinserted'].'&nbsp;</td>';
                        break;

                case 'dateapproved': print '<td class=listresult align=right nowrap>&nbsp;' . $showred . $row['dateapproved'].'&nbsp;</td>';
                        break;

                case 'datepayout': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['datepayout'].'&nbsp;</td>';
                        break;

                case 'productid': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['productid'].'&nbsp;</td>';
                        break;

                case 'campcategoryid': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $this->campCategory[$row['campcategoryid']].'&nbsp;</td>';
                        break;


                case 'transtype':
                        print '<td class=listresult align=right nowrap>&nbsp;' . $showred ;
                        
						switch($row['transtype']){
							case 1 : print 'Click';
							break;
							case 2 : print 'Lead';
							break;
							case 4 : print 'Sale';
							break;
							case 90 : print 'Bonus';
							break;
							case 99 : print 'Commission Adjustment';
							break;
							case 95 : print 'Revenue Adjustment'; 	
							break;
							case 100 : print 'Sale Reversal';
							break;
							case 101 : print 'Adjustment Reversal';
							break;	
							case 102 : print 'Void Sale';
							break;							
							default : print 'Other';
							break;
						}
                        
                        break;

                        
                case 'rstatus': 
                        print '<td class=listresult align=right nowrap>&nbsp;' . $showred ;
                        
                        if($row['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
                        else if($row['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
                        else if($row['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED;
                        
                        print '&nbsp;</td>';
                        break;

                case 'payoutstatus': print '<td class=listresult nowrap>&nbsp;'. $showred . ($row['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO).'&nbsp;</td>';
                        break;

                case 'ip': print '<td class=listresult nowrap>&nbsp;'. $showred . $row['ip'].'&nbsp;</td>';
                        break;

                case 'refererurl': print '<td class=listresultnocenter align=left nowrap>&nbsp;'. $showred . $row['refererurl'].'&nbsp;</td>';
                        break;
                        
                case 'userid': print '<td class=listresult nowrap>&nbsp;'. $showred . $row['userid'].': '.$row['name'].' '.$row['surname'].'&nbsp;</td>';
                        break;

                case 'data1': print '<td class=listresult>&nbsp;' . $showred . $row['data1'].'&nbsp;</td>';
                        break;
                        
                case 'data2': print '<td class=listresult>&nbsp;'. $showred . $row['data2'].'&nbsp;</td>';
                        break;

                case 'data3': print '<td class=listresult>&nbsp;'. $showred . $row['data3'].'&nbsp;</td>';                
                        break;
                        
                case 'channel': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['channel'].'&nbsp;</td>';
                        break;

                case 'episode': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['episode'].'&nbsp;</td>';
                        break;

                case 'timeslot': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['timeslot'].'&nbsp;</td>';
                        break;
                        
                case 'exit': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['exit'].'&nbsp;</td>';
                break;                        
                        
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">-------------------------------</option>
                                  <option value="javascript:traceTransaction('<?=$row['reftrans']?>');">View Transaction History</a>
                                  <? if($this->checkPermissions('edit') && $row['transtype'] == 1) { ?>
                                      <option value="javascript:editTransaction('<?=$row['transid']?>');"><?=L_G_EDIT?></a>
                                  <?} ?>
                                
                                <? if($row['transtype'] == 4 && $row['totalcost'] == 0) { ?>
                                      <option value="javascript:approvePayout('<?=$row['transid']?>');">Assign Actual Revenue</a>
                                  <?
                                   }
                                   if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:Delete('<?=$row['transid']?>');"><?=L_G_DELETE?></a>
                                <? } ?>
                            </select>
                        </td>
<?
                        break;
                case 'sid': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['sid'].'&nbsp;</td>';
                        break;
                case 'provideractionname': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['provideractionname'].'&nbsp;</td>';
                        break;
                case 'providerorderid': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['providerorderid'].'&nbsp;</td>';
                        break;
                case 'providertype': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['providertype'].'&nbsp;</td>';
                        break;
                case 'providereventdate': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['providereventdate'].'&nbsp;</td>';
                        break;
                case 'providerprocessdate': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['providerprocessdate'].'&nbsp;</td>';
                        break;
                case 'merchantname': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['merchantname'].'&nbsp;</td>';
                        break;
                case 'merchantid': print '<td class=listresult align=right nowrap>&nbsp;'. $showred .$row['merchantid'].'&nbsp;</td>';
                        break;
                case 'merchantsales': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['merchantsales'].'&nbsp;</td>';
                        break;
                case 'quantity': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['quantity'].'&nbsp;</td>';
                        break;
                case 'providerchannel': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['providerchannel'].'&nbsp;</td>';
                        break;
                case 'estimatedrevenue': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . ($row['estimatedrevenue'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['estimatedrevenue']) : '').'&nbsp;</td>';
                        break;
                case 'dateestimated': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['dateestimated'].'&nbsp;</td>';
                        break;
                case 'estimateddatafilename': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['estimateddatafilename'].'&nbsp;</td>';
                        break;
                case 'actualdatafilename': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['actualdatafilename'].'&nbsp;</td>';
                        break;
                case 'providerstatus': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['providerstatus'].'&nbsp;</td>';
                        break;
                case 'providercorrected': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['providercorrected'].'&nbsp;</td>';
                        break;
                case 'providerwebsiteid': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['providerwebsiteid'].'&nbsp;</td>';
                        break;
                case 'providerwebsitename': print '<td class=listresult align=right nowrap>&nbsp;'. $showred .$row['providerwebsitename'].'&nbsp;</td>';
                        break;
                case 'provideractionid': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['provideractionid'].'&nbsp;</td>';
                        break;
                case 'dateactual': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['dateactual'].'&nbsp;</td>';
                        break;
                case 'reftrans': print '<td class=listresult align=right nowrap>&nbsp;'. $showred . $row['reftrans'].'&nbsp;</td>';
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
          <option value="payout">Assign Actual Revenue</option>
          <? 
             if($this->checkPermissions('delete')) { ?>
               <option value="delete"><?=L_G_DELETE?></a>
          <? } ?>
        </select>
        &nbsp;&nbsp;
        <input type=submit value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }

    function getEstimatedRev($params){
      		$sql = "SELECT transid, estimatedrevenue, totalcost, transtype, reftrans FROM wd_pa_transactions WHERE transid in ('" . implode("','",$params) ."')";
    		//echo $sql;
    		$tacc = new Affiliate_Merchants_Bl_Transactions();
    		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    		while(!$rs->EOF){
    			if($rs->fields['transtype'] != 4){
    				QUnit_Messager::setErrorMessage($rs->fields['transid'] . " is not a sale.");	
    			}
    			else if($rs->fields['totalcost'] != 0 && $rs->fields['totalcost'] != null){
    				QUnit_Messager::setErrorMessage($rs->fields['transid'] . " already has an actual Actual value of " . $rs->fields['totalcost'] . " listed");	
    			}else if($tacc->get_adjusted_estimated_revenue($rs->fields['reftrans']) == 0 || $tacc->get_adjusted_estimated_revenue($rs->fields['reftrans']) == null){
    				QUnit_Messager::setErrorMessage($rs->fields['transid'] . " has an adjusted estimate value of " . $tacc->get_adjusted_estimated_revenue($rs->fields['reftrans']));	
    			}else
    				$result[$rs->fields['transid']] = $tacc->get_adjusted_estimated_revenue($rs->fields['reftrans']);
    			
    			$rs->MoveNext();	
    		}
    		return $result;
    }  
    
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
    
}
?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                