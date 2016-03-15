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
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Tracker');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Timeslot');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Page');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Keyword');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Merchants_Views_ExpensesManager extends QUnit_UI_ListPage
{
    var $campCategory;

    //--------------------------------------------------------------------------    

    function initPermissions()
    {
//        $this->modulePermissions['approvetrans'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['denytrans'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['create'] = 'aff_trans_transactions_modify';
//        $this->modulePermissions['edit'] = 'aff_trans_transactions_modify';
//        $this->modulePermissions['suppress'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['approve'] = 'aff_trans_transactions_approvedecline';
//        $this->modulePermissions['delete'] = 'aff_trans_transactions_modify';
//        $this->modulePermissions['view'] = 'aff_trans_transactions_view';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
			switch($_POST['massaction'])
            {    
                case 'delete':
                    if($this->processDelete())
                        return;
                break;
			}
            switch($_POST['postaction'])
            {
               case 'create':
                    if($this->processCreateExpense())
                        return;
                    break;
               case 'update':
                    if($this->processUpdateExpense())
                        return;
                    break;
            }
        }
		

				
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {                
                case 'create':
                    if($this->drawFormCreateExpense())
                        return;
                    break;
                
                case 'edit':
					$this->loadExpenseInfo();
                    if($this->drawFormEditExpense())
                        return;
                    break;
                case 'delete':
                    if($this->processDelete())
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
    
    function drawFormCreateExpense()
    {
            if($_REQUEST['p_day'] == '') $_REQUEST['p_day'] = date("j");
            if($_REQUEST['p_month'] == '') $_REQUEST['p_month'] = date("n");
            if($_REQUEST['p_year'] == '') $_REQUEST['p_year'] = date("Y");
            if($_REQUEST['p_hour'] == '') $_REQUEST['p_hour'] = date("G");
            if($_REQUEST['p_min'] == '') $_REQUEST['p_min'] = strftime("%M", time());
            if($_REQUEST['p_sec'] == '') $_REQUEST['p_sec'] = strftime("%S", time());
		
			if($_REQUEST['exp_day1'] == '') $_REQUEST['exp_day1'] = date("j");
            if($_REQUEST['exp_month1'] == '') $_REQUEST['exp_month1'] = date("n");
            if($_REQUEST['exp_year1'] == '') $_REQUEST['exp_year1'] = date("Y");
            if($_REQUEST['exp_hour1'] == '') $_REQUEST['exp_hour1'] = date("G");
            if($_REQUEST['exp_min1'] == '') $_REQUEST['exp_min1'] = strftime("%M", time());
            if($_REQUEST['exp_sec1'] == '') $_REQUEST['exp_sec1'] = strftime("%S", time());
            if($_REQUEST['exp_day2'] == '') $_REQUEST['exp_day2'] = date("j");
            if($_REQUEST['exp_month2'] == '') $_REQUEST['exp_month2'] = date("n");
            if($_REQUEST['exp_year2'] == '') $_REQUEST['exp_year2'] = date("Y");        
            if($_REQUEST['exp_hour2'] == '') $_REQUEST['exp_hour2'] = date("G");
            if($_REQUEST['exp_min2'] == '') $_REQUEST['exp_min2'] = strftime("%M", time());
            if($_REQUEST['exp_sec2'] == '') $_REQUEST['exp_sec2'] = strftime("%S", time());
        
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
        
        $dids = Affiliate_Merchants_Bl_Keyword::getKeywordsAsArray();
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($dids);
        $this->assign('did_list_data1', $list_data4);
        
        $eids = Affiliate_Merchants_Bl_Timeslot::getTimeslotsAsArray();
        $list_data5 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data5->setTemplateRS($eids);
        $this->assign('eid_list_data1', $list_data5);
        
        $this->assign('a_curyear', date("Y"));
        $this->addContent('expenses_create');
        
        return true;
    }
    
    function drawFormEditExpense()
    {
			$begin = explode("-", $_POST['expensedate']);
			$bYear = $begin[0];
			$bMonth = 0 + $begin[1];
			$bDayArray = explode(" ", $begin[2]);
			$bDay = 0 + $bDayArray[0];
			$bTimeArray = explode(":", $bDayArray[1]);
			$bHour = 0 + $bTimeArray[0];
			$bMinute = 0 + $bTimeArray[1];
			$bSecond = 0 + $bTimeArray[2];
			
			$end = explode("-", $_POST['endexpensedate']);
			$eYear = $end[0];
			$eMonth = 0 + $end[1];
			$eDayArray = explode(" ", $end[2]);
			$eDay = 0 + $eDayArray[0];
			$eTimeArray = explode(":", $eDayArray[1]);
			$eHour = 0 + $eTimeArray[0];
			$eMinute = 0 + $eTimeArray[1];	
			$eSecond = 0 + $eTimeArray[2];
			
			$purchase = explode("-", $_POST['purchasedate']);
			$pYear = $purchase[0];
			$pMonth = 0 + $purchase[1];
			$pDayArray = explode(" ", $purchase[2]);
			$pDay = 0 + $pDayArray[0];
			$pTimeArray = explode(":", $pDayArray[1]);
			$pHour = 0 + $pTimeArray[0];
			$pMinute = 0 + $pTimeArray[1];	
			$pSecond = 0 + $pTimeArray[2];
			
			$_REQUEST['exp_day1'] = $bDay;
			$_REQUEST['exp_month1'] = $bMonth;
			$_REQUEST['exp_year1'] = $bYear;
			$_REQUEST['exp_hour1'] = $bHour;
			$_REQUEST['exp_min1'] = $bMinute;
			$_REQUEST['exp_sec1'] = $bSecond;
			
			$_REQUEST['exp_day2'] = $eDay;
			$_REQUEST['exp_month2'] = $eMonth;
			$_REQUEST['exp_year2'] = $eYear;
			$_REQUEST['exp_hour2'] = $eHour;
			$_REQUEST['exp_min2'] = $eMinute;
			$_REQUEST['exp_sec2'] = $eSecond;
			
			$_REQUEST['p_day'] = $pDay;
			$_REQUEST['p_month'] = $pMonth;
			$_REQUEST['p_year'] = $pYear;
			$_REQUEST['p_hour'] = $pHour;
			$_REQUEST['p_min'] = $pMinute;
			$_REQUEST['p_sec'] = $pSecond;
		
			
			//if($_POST['exp_day1'] == '') $_REQUEST['exp_day1'] = date("j");
            //if($_POST['exp_month1'] == '') $_POST['exp_month1'] = date("n");
            //if($_POST['exp_year1'] == '') $_POST['exp_year1'] = date("Y");
            //if($_REQUEST['exp_hour1'] == '') $_REQUEST['exp_hour1'] = date("G");
            //if($_REQUEST['exp_min1'] == '') $_REQUEST['exp_min1'] = strftime("%M", time());
            //if($_REQUEST['exp_sec1'] == '') $_REQUEST['exp_sec1'] = strftime("%S", time());
            //if($_REQUEST['exp_day2'] == '') $_REQUEST['exp_day2'] = date("j");
            //if($_REQUEST['exp_month2'] == '') $_REQUEST['exp_month2'] = date("n");
            //if($_REQUEST['exp_year2'] == '') $_REQUEST['exp_year2'] = date("Y");        
            //if($_REQUEST['exp_hour2'] == '') $_REQUEST['exp_hour2'] = date("G");
            //if($_REQUEST['exp_min2'] == '') $_REQUEST['exp_min2'] = strftime("%M", time());
            //if($_REQUEST['exp_sec2'] == '') $_REQUEST['exp_sec2'] = strftime("%S", time());
        
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
        
        $dids = Affiliate_Merchants_Bl_Keyword::getKeywordsAsArray();
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($dids);
        $this->assign('did_list_data1', $list_data4);
        
        $eids = Affiliate_Merchants_Bl_Timeslot::getTimeslotsAsArray();
        $list_data5 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data5->setTemplateRS($eids);
        $this->assign('eid_list_data1', $list_data5);
        
        $this->assign('a_curyear', date("Y"));
        $this->addContent('expenses_edit');
        
        return true;
    }     
    
    //--------------------------------------------------------------------------
    
    function processCreateExpense()
    {
		// create date check.
        // protect against script injection
        $userid = preg_replace('/[\'\"]/', '', $_POST['userid']);
        $campaignid = preg_replace('/[\'\"]/', '', $_POST['campaignid']);
        $totalexpense = preg_replace('/[^0-9\.]/', '', $_POST['totalexpense']);
        $channel = preg_replace('/[\'\"]/', '', $_POST['channel']);
        $episode = preg_replace('/[\'\"]/', '', $_POST['episode']);
        $timeslot = preg_replace('/[\'\"]/', '', $_POST['timeslot']);
		$quantity = preg_replace('/[\'\"]/', '', $_POST['quantity']);
        $purchasedate = $_POST['p_year']."-".$_POST['p_month']."-".$_POST['p_day']." ".
                        $_POST['p_hour'].":".$_POST['p_min'].":".$_POST['p_sec'];
        $expensedate = $_POST['exp_year1']."-".$_POST['exp_month1']."-".$_POST['exp_day1']." ".
                        $_POST['exp_hour1'].":".$_POST['exp_min1'].":".$_POST['exp_sec1'];
        $endexpensedate = $_POST['exp_year2']."-".$_POST['exp_month2']."-".$_POST['exp_day2']." ".
                        $_POST['exp_hour2'].":".$_POST['exp_min2'].":".$_POST['exp_sec2'];

		
		$begin = explode("-", $expensedate);
		$bYear = $begin[0];
		$bMonth = 0 + $begin[1];
		$bDayArray = explode(" ", $begin[2]);
		$bDay = 0 + $bDayArray[0];
		$bTimeArray = explode(":", $bDayArray[1]);
		$bHour = 0 + $bTimeArray[0];
		$bMinute = 0 + $bTimeArray[1];
		$bSecond = 0 + $bTimeArray[2];
			
		$end = explode("-", $endexpensedate);
		$eYear = $end[0];
		$eMonth = 0 + $end[1];
		$eDayArray = explode(" ", $end[2]);
		$eDay = 0 + $eDayArray[0];
		$eTimeArray = explode(":", $eDayArray[1]);
		$eHour = 0 + $eTimeArray[0];
		$eMinute = 0 + $eTimeArray[1];	
		$eSecond = 0 + $eTimeArray[2];				
						
		$date1 = mktime($bHour, $bMinute, $bSecond, $begin[1], $begin[2], $begin[0]);
		$date2 = mktime($eHour,$eMinute,$eSecond,$end[1], $end[2], $end[0]); 				
			
		if($date1 > $date2){
			QUnit_Messager::setErrorMessage("End expense date must come after expense date!");
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesManager');
			$this->addContent('closewindow');
			return true;
		}
						
		// check correctness of the fields
        checkCorrectness($_POST['userid'], $userid, L_G_AFFILIATE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['campaignid'], $campaignid, L_G_CAMPAIGN, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['totalexpense'], $totalexpense, L_G_TOTALEXPENSE, CHECK_ALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['quantity'], $quantity, L_G_QUANTITY, CHECK_NUMBER);      
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return;
        }
        else
        {
            $ret = $this->createExpense($userid, $campaignid, $purchasedate, $expensedate, $endexpensedate, $totalexpense, $channel, $episode, $timeslot, $quantity);
            
            if($ret)
                QUnit_Messager::setOkMessage(L_G_EXPENSECREATED);
            else
                return false;
  
            $this->closeWindow('Affiliate_Merchants_Views_ExpensesManager');
            $this->addContent('closewindow');            
            return true;
        }
        
        return false;
    }

    //--------------------------------------------------------------------------        
    
    function createExpense($userid, $campaignid, $purchasedate, $expensedate, $endexpensedate, $totalexpense, $channel, $episode, $timeslot, $quantity)
    {
        //---------------------------------------
        // check commission category for this user
		
		
		$sql = 'select cc.* '.
               'from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($campaignid).
               '  and cc.campcategoryid=ac.campcategoryid '.
               '  and ac.affiliateid='._q($userid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
       
		if(!$rs)
        return false;
        
        if($rs->fields['campcategoryid'] == null)
        {
			
            // get basic commission category for this campaign
            $sql = 'select * from wd_pa_campaigncategories where deleted=0 and campaignid='._q($campaignid).' and deleted=0 order by campcategoryid asc';
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
			if (!$rs || $rs->EOF)
            return false;          
        }
        
		
        $campcategoryid = $rs->fields['campcategoryid'];
        
        // save changes of user to db
        $expID = QCore_Sql_DBUnit::createUniqueID('wd_pa_expenses', 'expenseid');
        $sql = "insert into wd_pa_expenses(expenseid, affiliateid, campcategoryid, purchasedate, expensedate, endexpensedate, totalexpense, channel, episode, timeslot, quantity)".
        "values("._q($expID).","._q($userid).","._q($campcategoryid).","._q($purchasedate).","._q($expensedate).","._q($endexpensedate).", ".myquotes($totalexpense).","._q($channel).","._q($episode).","._q($timeslot). "," . _q($quantity)  . ")";
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);        
        if (!$ret)        
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }  
        return true;
    } 
    
    function processUpdateExpense()
    {   
		
        $eid = $_REQUEST['eid'];
		$userid = $_REQUEST['userid'];
		$campcategoryid = $_REQUEST['campaignid'];
		$totalexpense = $_REQUEST['totalexpense'];
		$channel = $_REQUEST['channel'];
		$episode = $_REQUEST['episode'];
		$timeslot = $_REQUEST['timeslot'];
		$quantity = $_REQUEST['quantity'];
		
		$purchasedate = $_POST['p_year']."-".$_POST['p_month']."-".$_POST['p_day']." ".
                        $_POST['p_hour'].":".$_POST['p_min'].":".$_POST['p_sec'];
        $expensedate = $_POST['exp_year1']."-".$_POST['exp_month1']."-".$_POST['exp_day1']." ".
                        $_POST['exp_hour1'].":".$_POST['exp_min1'].":".$_POST['exp_sec1'];
        $endexpensedate = $_POST['exp_year2']."-".$_POST['exp_month2']."-".$_POST['exp_day2']." ".
                        $_POST['exp_hour2'].":".$_POST['exp_min2'].":".$_POST['exp_sec2'];
		
		
						
		$begin = explode("-", $expensedate);
		$bYear = $begin[0];
		$bMonth = 0 + $begin[1];
		$bDayArray = explode(" ", $begin[2]);
		$bDay = 0 + $bDayArray[0];
		$bTimeArray = explode(":", $bDayArray[1]);
		$bHour = 0 + $bTimeArray[0];
		$bMinute = 0 + $bTimeArray[1];
		$bSecond = 0 + $bTimeArray[2];
			
		$end = explode("-", $endexpensedate);
		$eYear = $end[0];
		$eMonth = 0 + $end[1];
		$eDayArray = explode(" ", $end[2]);
		$eDay = 0 + $eDayArray[0];
		$eTimeArray = explode(":", $eDayArray[1]);
		$eHour = 0 + $eTimeArray[0];
		$eMinute = 0 + $eTimeArray[1];	
		$eSecond = 0 + $eTimeArray[2];				
						
		$date1 = mktime($bHour, $bMinute, $bSecond, $begin[1], $begin[2], $begin[0]);
		$date2 = mktime($eHour,$eMinute,$eSecond,$end[1], $end[2], $end[0]); 				
				
		if($date1 > $date2){
			QUnit_Messager::setErrorMessage("End expense date must come after expense date!");
		}
		
		checkCorrectness($_REQUEST['totalexpense'], $totalexpense, L_G_TOTALEXPENSE, CHECK_NUMBER);
		checkCorrectness($_REQUEST['quantity'], $quantity, L_G_QUANTITY, CHECK_NUMBER);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesManager');
			$this->addContent('closewindow');
            return true;
        }
		
		$campaignid = $campcategoryid;
		
		$sql = 'select cc.* '.
               'from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc '.
               'where cc.campaignid='._q($campaignid).
               '  and cc.campcategoryid=ac.campcategoryid '.
               '  and ac.affiliateid='._q($userid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
       
		if(!$rs)
        return false;
        
        if($rs->fields['campcategoryid'] == null)
        {
            // get basic commission category for this campaign
            $sql = 'select * from wd_pa_campaigncategories where deleted=0 and campaignid='._q($campaignid).' and deleted=0 order by campcategoryid asc';
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
			if (!$rs || $rs->EOF)
            return false;          
        }
        
		
        $campcategoryid = $rs->fields['campcategoryid'];	
		
        // save changes of user to db
        $expID = QCore_Sql_DBUnit::createUniqueID('wd_pa_expenses', 'expenseid');
        $sql = "update wd_pa_expenses set ".
               "affiliateid = "._q($userid).", ".
               "campcategoryid = "._q($campcategoryid).", ".
               "purchasedate = " ._q($purchasedate).", ".
               "expensedate = " ._q($expensedate).", ".
               "endexpensedate = " ._q($endexpensedate).", ".
               "totalexpense = " .myquotes($totalexpense).", ".
               "channel = " ._q($channel).", ".
               "episode = " ._q($episode).", ".
               "timeslot = "._q($timeslot).", ".
			   "quantity = "._q($quantity).
			   " where expenseid = "._q($eid);
       
		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);        
        if (!$ret)        
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
		QUnit_Messager::setOkMessage("Expense Successfully Updated");
		$this->closeWindow('Affiliate_Merchants_Views_ExpensesManager');
        $this->addContent('closewindow');

              
        return true;
    }    
    
    
    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
        
		$sql = 'delete from wd_pa_expenses '.
               'where expenseid in ' . $sqlEIDs;
		//QUnit_Messager::setOkMessage($sql);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }       
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
        $this->getCampaingsForFilter();
        $this->getCIDForFilter();
        $this->getDIDForFilter();
        $this->getEIDForFilter();
        
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

        $this->addContent('expenses_list');        
    }    

    //--------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $usersRs = Affiliate_Merchants_Bl_Affiliate::getUsersAsRs();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);
        
        $this->assign('a_list_users', $list_data);
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
    function getDIDForFilter()
    {
    	$dids = Affiliate_Merchants_Bl_Keyword::getKeywordsAsArray();
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($dids);
        $this->assign('did_list_data1', $list_data4);
    }
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

    function getRecords($orderby, $where)
    {
		
		if($_REQUEST['runQuery'] == 'false'){
			$_POST['runQuery'] = 'false';
			return;
		}
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from wd_pa_expenses e, wd_g_users a, wd_pa_campaigncategories c ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //------------------------------------------------
        // get records
        $sql = "select a.userid, a.name, a.surname, ".
                "c.campaignid, ".
                "e.quantity, e.expenseid, e.purchasedate, e.expensedate, e.endexpensedate, ".
                "e.totalexpense, e.bannerid, e.affiliateid, ".
                "e.campcategoryid, e.channel, e.episode, e.timeslot, e.exit ".
                "from wd_pa_expenses e, wd_g_users a, wd_pa_campaigncategories c";
		//echo "SQL: ".$sql.$where.$orderby;
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
            'expenseid' =>            array(L_G_EXPENSEID, 'expenseid'),
            'purchasedate' =>         array(L_G_PURCHASEDATE, 'purchasedate'),
            'expensedate' =>         array(L_G_EXPENSEDATE, 'expensedate'),
            'endexpensedate' =>         array(L_G_ENDEXPENSEDATE, 'endexpensedate'),
            'totalexpense' =>         array(L_G_TOTALEXPENSE, 'totalexpense'),
            'bannerid' =>         array(L_G_BANNERID, 'bannerid'),
            'affiliateid' =>         array(L_G_AFFILIATEID, 'affiliateid'),
            'campcategoryid' =>         array(L_G_CAMPCATEGORY, 'campcategoryid'),
            'channel' =>         array(L_G_CHANNEL, 'channel'),
            'episode' =>         array(L_G_EPISODE, 'episode'),
            'timeslot' =>         array(L_G_TIMESLOT, 'timeslot'),
            'exit' =>         array(L_G_EXIT, 'exit'),
			'quantity' =>		array(L_G_QUANTITY, 'quantity'),
			'actions' =>           array(L_G_ACTIONS, ''),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'expenses_list';
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {        
        $this->createDefaultView(array_keys($this->getAvailableColumns()));
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
        
        $a = array_keys($this->getAvailableColumns());
        
        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = " order by e.purchasedate desc";
        }
        

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'exp_') === 0 && !isset($_REQUEST[$k]))
            {
                $_REQUEST[$k] = $v;
            }
            if($k == 'numrows' && $_REQUEST[$k] == '')
            {
                $_REQUEST[$k] = $v;
            }
        }
                
            //--------------------------------------
            // get default settings for unset variables
            if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
            if($_REQUEST['exp_affiliateid'] == '') $_REQUEST['exp_affiliateid'] = '_';
            if($_REQUEST['date'] == '') $_REQUEST['date'] = 'all';
            if($_REQUEST['exp_day1'] == '') $_REQUEST['exp_day1'] = date("j");
            if($_REQUEST['exp_month1'] == '') $_REQUEST['exp_month1'] = date("n");
            if($_REQUEST['exp_year1'] == '') $_REQUEST['exp_year1'] = date("Y");
            if($_REQUEST['exp_day2'] == '') $_REQUEST['exp_day2'] = date("j");
            if($_REQUEST['exp_month2'] == '') $_REQUEST['exp_month2'] = date("n");
            if($_REQUEST['exp_year2'] == '') $_REQUEST['exp_year2'] = date("Y");
            //if($_REQUEST['exp_day3'] == '') $_REQUEST['exp_day3'] = date("j");
            //if($_REQUEST['exp_month3'] == '') $_REQUEST['exp_month3'] = date("n");
            //if($_REQUEST['exp_year3'] == '') $_REQUEST['exp_year3'] = date("Y");
            //if($_REQUEST['exp_day4'] == '') $_REQUEST['exp_day4'] = date("j");
            //if($_REQUEST['exp_month4'] == '') $_REQUEST['exp_month4'] = date("n");
            //if($_REQUEST['exp_year4'] == '') $_REQUEST['exp_year4'] = date("Y");
            
            //--------------------------------------
            // put settings into session
            $_SESSION['numrows'] = $_REQUEST['numrows'];
            $_SESSION['exp_affiliateid'] = $_REQUEST['exp_affiliateid'];
            $_SESSION['exp_date'] = $_REQUEST['date'];
            $_SESSION['exp_day1'] = $_REQUEST['exp_day1'];
            $_SESSION['exp_month1'] = $_REQUEST['exp_month1'];
            $_SESSION['exp_year1'] = $_REQUEST['exp_year1'];
            $_SESSION['exp_day2'] = $_REQUEST['exp_day2'];
            $_SESSION['exp_month2'] = $_REQUEST['exp_month2'];
            $_SESSION['exp_year2'] = $_REQUEST['exp_year2'];
            //$_SESSION['exp_day3'] = $_REQUEST['exp_day3'];
            //$_SESSION['exp_month3'] = $_REQUEST['exp_month3'];
            //$_SESSION['exp_year3'] = $_REQUEST['exp_year3'];
            //$_SESSION['exp_day4'] = $_REQUEST['exp_day4'];
            //$_SESSION['exp_month4'] = $_REQUEST['exp_month4'];
            //$_SESSION['exp_year4'] = $_REQUEST['exp_year4'];
            $_SESSION['exp_channel'] = $_REQUEST['exp_channel'];
            $_SESSION['exp_episode'] = $_REQUEST['exp_episode'];
            $_SESSION['exp_timeslot'] = $_REQUEST['exp_timeslot'];
            $_SESSION['exp_exit'] = $_REQUEST['exp_exit'];
                
        $where = " where e.affiliateid=a.userid and a.accountid="._q($GLOBALS['Auth']->getAccountID())." and a.rstatus in (".AFFSTATUS_APPROVED.",".AFFSTATUS_NOTAPPROVED.") and e.campcategoryid=c.campcategoryid";
		
		if ($_REQUEST['date'] != 'all'){
		
			$where .= " and (".sqlToDays($_REQUEST['date'])." >= ".sqlToDays($_REQUEST['exp_year1']."-".$_REQUEST['exp_month1']."-".$_REQUEST['exp_day1']).")".
                      " and (".sqlToDays($_REQUEST['date'])." <= ".sqlToDays($_REQUEST['exp_year2']."-".$_REQUEST['exp_month2']."-".$_REQUEST['exp_day2']).")";
		}
       // $where .= " and (".sqlToDays('e.purchasedate')." >= ".sqlToDays($_REQUEST['exp_year1']."-".$_REQUEST['exp_month1']."-".$_REQUEST['exp_day1']).")".
       //               " and (".sqlToDays('e.purchasedate')." <= ".sqlToDays($_REQUEST['exp_year2']."-".$_REQUEST['exp_month2']."-".$_REQUEST['exp_day2']).")";
       // $where .= " and (".sqlToDays('e.expensedate')." >= ".sqlToDays($_REQUEST['exp_year3']."-".$_REQUEST['exp_month3']."-".$_REQUEST['exp_day3']).")".
       //               " and (".sqlToDays('e.expensedate')." <= ".sqlToDays($_REQUEST['exp_year4']."-".$_REQUEST['exp_month4']."-".$_REQUEST['exp_day4']).")";
        
        $puserid = preg_replace('/[\'\"]/', '', $_REQUEST['exp_affiliateid']);
        
        if($puserid != '_' && $puserid != '')
        {            
            $where .= " and e.affiliateid="._q($puserid);
        }
        
        if($_REQUEST['exp_channel'] != '_' && $_REQUEST['exp_channel'] != '')
        {            
            $where .= " and e.channel like '%".addslashes($_REQUEST['exp_channel'])."%'";
        }
        if($_REQUEST['exp_episode'] != '_' && $_REQUEST['exp_episode'] != '')
        {            
            $where .= " and e.episode like '%".addslashes($_REQUEST['exp_episode'])."%'";
        }
        if($_REQUEST['exp_timeslot'] != '_' && $_REQUEST['exp_timeslot'] != '')
        {            
            $where .= " and e.timeslot like '%".addslashes($_REQUEST['exp_timeslot'])."%'";
        }
        if($_REQUEST['exp_exit'] != '_' && $_REQUEST['exp_exit'] != '')
        {            
            $where .= " and e.exit like '%".addslashes($_REQUEST['exp_exit'])."%'";
        }
        
        if($_REQUEST['exp_campaign'] != '_' && $_REQUEST['exp_campaign'] != '')
        {            
            $where .= " and c.campaignid="._q($_REQUEST['exp_campaign']);                
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
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }

        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['expenseid'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
                case 'quantity': print '<td class=listresult>&nbsp;'.$row['quantity'].'&nbsp;</td>';
                        break;				
                case 'expenseid': print '<td class=listresult>&nbsp;'.$row['expenseid'].'&nbsp;</td>';
                        break;

                case 'bannerid': print '<td class=listresult>&nbsp;'.$row['bannerid'].'&nbsp;</td>';
                        break;
                                                
                case 'totalexpense': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'.($row['totalexpense'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['totalexpense']) : '').'&nbsp;</td>';
                        break;
                        
                case 'purchasedate': print '<td class=listresult align=right nowrap>&nbsp;'.displayDate($row['purchasedate']).'&nbsp;</td>';
                        break;

                case 'expensedate': print '<td class=listresult align=right nowrap>&nbsp;'.displayDate($row['expensedate']).'&nbsp;</td>';
                        break;

                case 'endexpensedate': print '<td class=listresult align=right nowrap>&nbsp;'.displayDate($row['endexpensedate']).'&nbsp;</td>';
                        break;

                case 'campcategoryid': print '<td class=listresult align=right nowrap>&nbsp;'.$this->campCategory[$row['campcategoryid']].'&nbsp;</td>';
                        break;
                        
                case 'rstatus': 
                        print '<td class=listresult align=right nowrap>&nbsp;';
                        
                        if($row['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
                        else if($row['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
                        else if($row['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED;
                        
                        print '&nbsp;</td>';
                        break;
                        
                case 'affiliateid': print '<td class=listresult nowrap>&nbsp;'.$row['userid'].': '.$row['name'].' '.$row['surname'].'&nbsp;</td>';
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
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editExpense('<?=$row['expenseid']?>');"><?=L_G_EDIT?></a>
                                <? } ?>
                                <? if($this->checkPermissions('approve') && 0) { ?>
                                  <? if($row['rstatus'] != AFFSTATUS_APPROVED) { ?>
                                      <option value="javascript:ChangeState('<?=$row['expenseid']?>','approve');"><?=L_G_APPROVE?></a>
                                  <? } ?>
                                  <? if($row['rstatus'] != AFFSTATUS_SUPPRESSED) { ?>
                                      <option value="javascript:ChangeState('<?=$row['expenseid']?>','suppress');"><?=L_G_SUPPRESS?></a>
                                <?   }
                                   }
                                   if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:deleteExpense('<?=$row['expenseid']?>');"><?=L_G_DELETE?></a>
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
           <?  if($this->checkPermissions('delete')) { ?>
               <option value="delete"><?=L_G_DELETE?></a>
          <? } ?>
        </select>
        &nbsp;&nbsp;
        <input type=submit value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }    
    
    //--------------------------------------------------------------------------

    function prepareExportFile($orderby, $where)
    {
        // prepare file for export
        $fname = 'exp_'.date("Y_m_d").'_'.substr(md5(uniqid(rand(),1)), 0, 6).'.csv';
        $fdirname = $GLOBALS['Auth']->getSetting('Aff_export_dir').$fname;
        
        $exportFile = @fopen($fdirname, "wb");
        if($exportFile == FALSE)
        {
            showMsg(L_G_CANNOTWRITETOEXPORTDIR, 'error');
            return false;
        }

        foreach($this->getAvailableColumns() as $key => $col) {
            if($col != 'Actions')	
				$str .= ','.csvFormat($col[0]);
        }
        $str = ltrim($str, ",");
                
        fwrite($exportFile, $str."\r\n");
        
        $sql = "select a.userid, a.name, a.surname, ".
        "c.campaignid, ".
        "e.expenseid, e.purchasedate, e.expensedate, e.endexpensedate, ".
        "e.totalexpense, e.bannerid, e.affiliateid, ".
        "e.campcategoryid, e.channel, e.episode, e.timeslot, e.exit, e.quantity ".
        "from wd_pa_expenses e, wd_g_users a, wd_pa_campaigncategories c";

        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {
            $str = csvFormat($rs->fields['expenseid']);
            $str .= ','.csvFormat($rs->fields['purchasedate']);
            $str .= ','.csvFormat($rs->fields['expensedate']);
            $str .= ','.csvFormat($rs->fields['endexpensedate']);
            $str .= ','.csvFormat($rs->fields['totalexpense']);
            $str .= ','.csvFormat($rs->fields['bannerid']);
            $str .= ','.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);
            $str .= ','.csvFormat($this->campCategory[$rs->fields['campcategoryid']]);
			


            if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $rstatus = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $rstatus = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $rstatus = L_G_SUPPRESSED;

            $str .= ','.csvFormat($rstatus);

            $str .= ','.csvFormat(($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO));
            $str .= ','.csvFormat($rs->fields['channel']);
            $str .= ','.csvFormat($rs->fields['episode']);
            $str .= ','.csvFormat($rs->fields['timeslot']);            
            $str .= ','.csvFormat($rs->fields['exit']);
            $str .= ','.csvFormat($rs->fields['quantity']);
            fwrite($exportFile, $str."\r\n");        
            
            $rs->MoveNext();
        }
        
        fclose($exportFile);

        $this->assign('a_exportFileName', $fname);
        
        return true;
        
    }  
    function loadExpenseInfo()
    {
        $eid = preg_replace('/[\'\"]/', '', $_REQUEST['eid']);

        $sql = 'select * from wd_pa_expenses '.
               'where expenseid='._q($eid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

        $_POST['eid'] = $rs->fields['expenseid'];
        $_POST['purchasedate'] = $rs->fields['purchasedate'];
        $_POST['expensedate'] = $rs->fields['expensedate'];
        $_POST['endexpensedate'] = $rs->fields['endexpensedate'];
        $_POST['totalexpense'] = $rs->fields['totalexpense'];
        $_POST['bannerid'] = $rs->fields['bannerid'];
        
        $_POST['userid'] = $rs->fields['affiliateid'];
        
		$sql = 'select * from wd_pa_campaigncategories where deleted=0 and campcategoryid='._q($rs->fields['campcategoryid']).' and deleted=0 order by campcategoryid asc';

		$rscc = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$_POST['campcategoryid'] = $rscc->fields['campaignid'];
		

		
		
        $_POST['tracker'] = $rs->fields['channel'];
        $_POST['keyword'] = $rs->fields['episode'];
        $_POST['timeslot'] = $rs->fields['timeslot'];
        $_POST['page'] = $rs->fields['exit'];
		$_POST['quantity'] = $rs->fields['quantity'];
    }
	
    function returnEIDs()
    {
        if($_POST['massaction'] != '')
        {
            $eIDs = $_POST['itemschecked'];
        }
        else
        {
            $eIDs = array($_REQUEST['eid']);
        }
        
        return $eIDs;
    }
	
	function ammortizedExpensesOverYear($where, $month, $year){
		// will return ammortized amount per month.
		$leap = 28;
		if($year % 4 == 0)
			$leap = 29;
			
		$numdays = array(null, 31, $leap, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		
		$y1 = $year;
		$m1 = $month;
		$d1 = 1;
		$d2 = 31;
		$beginRange = date($y1."-".$m1."-".$d1);
		$endRange = date($y1."-".$m1."-".$d2);
		$sql = "SELECT e.* " . $where . " and e.expense_start <= " . _q($endRange) . " AND " . "e.expense_end >= " . _q($beginRange);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$totalExpenseCost = 0;
		
		while(!$rs->EOF){
			
			$begin = explode("-", $rs->fields['expense_start']);
			$bYear = $begin[0];
			$bMonth = 0 + $begin[1];
			$bDayArray = explode(" ", $begin[2]);
			$bDay = 0 + $bDayArray[0];
			$bTimeArray = explode(":", $bDayArray[1]);
			$bHour = 0 + $bTimeArray[0];
			$bMinute = 0 + $bTimeArray[1];
			
			$end = explode("-", $rs->fields['expense_end']);
			$eYear = $end[0];
			$eMonth = 0 + $end[1];
			$eDayArray = explode(" ", $end[2]);
			$eDay = 0 + $eDayArray[0];
			$eTimeArray = explode(":", $eDayArray[1]);
			$eHour = 0 + $eTimeArray[0];
			$eMinute = 0 + $eTimeArray[1];
			
			$date1 = mktime(0, 0, 0, $begin[1], $begin[2], $begin[0]);
			$date2 = mktime(0,0,0,$end[1], $end[2], $end[0]); 
			//echo $rs->fields['expense_end'] . " - " . $rs->fields['expense_start'] . "<br>";
			//echo $date2. " - " . $date1 . "<br>";
			$difference = $date2-$date1;
			if($difference <= 0){
					$totalExpenseCost += $rs->fields['total_expense'];
			}else{
				$totalDays = $difference/60/60/24;
				//echo "Total Days: " . $totalDays. "<br>";
				$costPerDay = $rs->fields['total_expense'] / $totalDays;
				//echo "<br>DEBUG - Total cost per Day: " . $costPerDay . "<br>";
				if($month == $bMonth){
					//echo "DEBUG - Found Expense with Begin month on " . $month . "<br>";			
				
					if($totalDays <=  ($numdays[$bMonth] - $bDay))
						$totalExpenseCost += ($totalDays) * $costPerDay;
					else
						$totalExpenseCost += ($numdays[$bMonth] - $bDay) * $costPerDay;
				
					//echo "DEBUG - adding " . ($numdays[$bMonth] - $bDay) * $costPerDay . " to month's expenses";
				}
				else if($month == $eMonth){
					//echo "DEBUG - Found Expense with End month on " . $month . "<br>";				
					$totalExpenseCost += (($eDay)) * $costPerDay;
				
					//echo "DEBUG - adding " . ($eDay ) * $costPerDay . " to month's expenses";
				}
				else{
					//echo "DEBUG - Found Expense with neither begin or end month on " . $month . "<br>";
					$totalExpenseCost += ($numdays[$bMonth]) * $costPerDay;
					//echo "DEBUG - adding " . ($numdays[$bMonth]) * $costPerDay . " to month's expenses";
				}
			}
			
			$rs->MoveNext();
		}
		return $totalExpenseCost;
	}
	
	function ammortizedExpensesOverMonth($where, $day, $month, $year){

		$y1 = $year;
		$m1 = $month;
		$d1 = $day;
		$d2 = $day;
		$beginRange = date($y1."-".$m1."-".$d1. " 00:00:00");
		$endRange = date($y1."-".$m1."-".$d2 . " 23:59:59");
		$sql = "SELECT e.* " . $where . " and e.expense_start <= " . _q($endRange) . " AND " . "e.expense_end >= " . _q($beginRange);
		//echo $sql . "<br>";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		
		$totalExpenseCost = 0;
		
		while(!$rs->EOF){

			$begin = explode("-", $rs->fields['expense_start']);
			$bYear = $begin[0];
			$bMonth = 0 + $begin[1];
			$bDayArray = explode(" ", $begin[2]);
			$bDay = 0 + $bDayArray[0];
			$bTimeArray = explode(":", $bDayArray[1]);
			$bHour = 0 + $bTimeArray[0];
			$bMinute = 0 + $bTimeArray[1];
			
			$end = explode("-", $rs->fields['expense_end']);
			$eYear = $end[0];
			$eMonth = 0 + $end[1];
			$eDayArray = explode(" ", $end[2]);
			$eDay = 0 + $eDayArray[0];
			$eTimeArray = explode(":", $eDayArray[1]);
			$eHour = 0 + $eTimeArray[0];
			$eMinute = 0 + $eTimeArray[1];	
		
			$date1 = mktime($bHour, $bMinute, 0, $begin[1], $begin[2], $begin[0]);
			$date2 = mktime($eHour,$eMinute,0,$end[1], $end[2], $end[0]); 
			
			//echo $rs->fields['expense_end'] . " " . $rs->fields['expense_end'];
			
			$difference = $date2-$date1; 
			if($difference <= 0){
				$totalExpenseCost += $rs->fields['total_expense'];
			}else{
				$totalHours = $difference/60/60;
				//echo "TotalHours: " . $totalHours. "<br>";
				$costPerHour = $rs->fields['total_expense'] / $totalHours;
				//echo "<br>DEBUG - Total cost per Hour: " . $costPerHour . "<br>";
				if(($day == $bDay) && ($month == $bMonth) && ($day == $eDay)){
						$totalExpenseCost += ($eHour - $bHour) * $costPerHour;
				
					//echo "DEBUG - adding " . ($eHour - $bHour) * $costPerHour . " to day's expenses<br>";	
				}else if(($day == $bDay) && ($month == $bMonth)){
					//echo "DEBUG - Found Expense with Begin day on " . $day . "<br>";			
					//if($totalDays <=  ($numdays[$bMonth] - $bDay))
						//$totalExpenseCost += ($totalDays) * $costPerDay;
						$totalExpenseCost += (24 - $bHour) * $costPerHour;
				
					//echo "DEBUG - adding " . (24 - $bHour) * $costPerHour . " to day's expenses<br>";
				}
				else if(($day == $eDay) && ($month == $eMonth)){
					//echo "DEBUG - Found Expense with End day on " . $day . "<br>";				
					$totalExpenseCost += (($eHour)) * $costPerHour;
				
					//echo "DEBUG - adding " . ($eHour) * $costPerHour . " to day's expenses";
				}
				else{
					//echo "DEBUG - Found Expense with neither begin or end day on " . $day . "<br>";
					$totalExpenseCost += (24) * $costPerHour;
					//echo "DEBUG - adding " . (24) * $costPerHour . " to day's expenses";
				}
			}
			
			$rs->MoveNext();
		}
		return $totalExpenseCost;
	}
	
	function ammortizedExpensesOverDay($where, $hour, $day, $month, $year){
		$y1 = $year;
		$m1 = $month;
		$d1 = $day;
		$d2 = $day;
		$h1 = $hour;
		$beginRange = date($y1."-".$m1."-".$d1. " " .$h1.":00:00");
		$endRange = date($y1."-".$m1."-".$d2." " .$h1.":59:59");
		$sql = "SELECT e.* " . $where . " and e.expense_start <= " . _q($endRange) . " AND " . "e.expense_end >= " . _q($beginRange);
		//echo $sql . "<br>";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		
		$totalExpenseCost = 0;
		
		while(!$rs->EOF){
			
			$begin = explode("-", $rs->fields['expense_start']);
			$bYear = $begin[0];
			$bMonth = 0 + $begin[1];
			$bDayArray = explode(" ", $begin[2]);
			$bDay = 0 + $bDayArray[0];
			$bTimeArray = explode(":", $bDayArray[1]);
			$bHour = 0 + $bTimeArray[0];
			$bMinute = 0 + $bTimeArray[1];
			
			$end = explode("-", $rs->fields['expense_end']);
			$eYear = $end[0];
			$eMonth = 0 + $end[1];
			$eDayArray = explode(" ", $end[2]);
			$eDay = 0 + $eDayArray[0];
			$eTimeArray = explode(":", $eDayArray[1]);
			$eHour = 0 + $eTimeArray[0];
			$eMinute = 0 + $eTimeArray[1];	
		
			$date1 = mktime($bHour, $bMinute, 0, $begin[1], $begin[2], $begin[0]);
			$date2 = mktime($eHour,$eMinute,0,$end[1], $end[2], $end[0]); 
			
			$difference = $date2-$date1; 
			if($difference <= 0){
				$totalExpenseCost += $rs->fields['total_expense'];
			}else{
				$totalMins = $difference/60;
				//echo "TotalMins: " . $totalMins. "<br>";
				$costPerMin = $rs->fields['total_expense'] / $totalMins;
				//echo "<br>DEBUG - Total cost per Hour: " . $costPerMin . "<br>";
				if(($day == $bDay) && ($month == $bMonth) && ($hour == $bHour)){
					//echo "DEBUG - Found Expense with Begin hour at " . $hour . "<br>";			
				
					//if($totalDays <=  ($numdays[$bMonth] - $bDay))
					//	$totalExpenseCost += ($totalDays) * $costPerDay;
						$totalExpenseCost += (60 - $bMinute) * $costPerMin;
					
					//echo "DEBUG - adding " . (60 - $bMinute) * $costPerMin . " to hour's expenses";
				}
				else if(($day == $eDay) && ($month == $eMonth) && ($hour == $eHour)){
					//echo "DEBUG - Found Expense with End hour at " . $hour . "<br>";				
					$totalExpenseCost += (($eMinute)) * $costPerMin;
					
					//echo "DEBUG - adding " . ($eMinute) * $costPerMin . " to hour's expenses";
				}
				else{
					//echo "DEBUG - Found Expense with neither begin or end hour on " . $hour . "<br>";
					$totalExpenseCost += (60) * $costPerMin;
					//echo "DEBUG - adding " . (60) * $costPerMin . " to hour's expenses";
				}
			}
			$rs->MoveNext();
		}
		return $totalExpenseCost;
	}
}
?>
