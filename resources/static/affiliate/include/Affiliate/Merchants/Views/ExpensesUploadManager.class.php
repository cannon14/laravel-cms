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
QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampCategoriesManager');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Tracker');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Page');
//QUnit_Global::includeClass('Affiliate_Merchants_Bl_Keyword');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Keywords');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Merchants_Views_ExpensesUploadManager extends QUnit_UI_ListPage
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
        
        $sql = 'SELECT * FROM ' . USERS_TABLE . ' ' .
        		'		WHERE deleted=0 ' .
        		'		AND rtype='._q(USERTYPE_USER).' ' .
        		'		AND accountid='._q($GLOBALS['Auth']->getAccountID()) .
        		'		ORDER BY name';
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $user = array();
        while(!$rs->EOF)
        {
            $temp = array();

            $temp['userid'] = $rs->fields['userid'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['username'] = $rs->fields['username'];

            $users[$rs->fields['userid']] = $temp;

            $rs->MoveNext();
        }
        //$users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();
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
        $this->assign('a_curyear', date("Y"));
        $this->addContent('expenses_upload_create');
        
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

        $sql = 'SELECT * FROM ' . USERS_TABLE . ' ' .
        		'		WHERE deleted=0 ' .
        		'		AND rtype='._q(USERTYPE_USER).' ' .
        		'		AND accountid='._q($GLOBALS['Auth']->getAccountID()).
        		'		ORDER BY name';
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $user = array();
        while(!$rs->EOF)
        {
            $temp = array();

            $temp['userid'] = $rs->fields['userid'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['username'] = $rs->fields['username'];

            $users[$rs->fields['userid']] = $temp;

            $rs->MoveNext();
        }
        //$users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();
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
        $this->assign('a_curyear', date("Y"));
        $this->addContent('expenses_upload_edit');
        
        return true;
    }     
    
    //--------------------------------------------------------------------------
    
    function processCreateExpense()
    {
		// create date check.
        // protect against script injection
        $userid = preg_replace('/[\'\"]/', '', $_POST['userid']);
        $totalexpense = preg_replace('/[^0-9\.]/', '', $_POST['totalexpense']);
        $extcampaign_id = preg_replace('/[\'\"]/', '', $_POST['extcampaign_id']);
        $keyword_id = preg_replace('/[\'\"]/', '', $_POST['keyword_id']);
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
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesUploadManager');
			$this->addContent('closewindow');
			return true;
		}
						
		// check correctness of the fields
        checkCorrectness($_POST['userid'], $userid, L_G_AFFILIATE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['totalexpense'], $totalexpense, L_G_TOTALEXPENSE, CHECK_ALLOWED, CHECK_NUMBER);
        checkCorrectness($_POST['quantity'], $quantity, L_G_QUANTITY, CHECK_NUMBER);      
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return;
        }
        else
        {
            $ret = $this->createExpense($userid, $purchasedate, $expensedate, $endexpensedate, $totalexpense, $extcampaign_id, $keyword_id, $quantity);
            
            if($ret)
                QUnit_Messager::setOkMessage(L_G_EXPENSECREATED);
            else
                return false;
  
            $this->closeWindow('Affiliate_Merchants_Views_ExpensesUploadManager');
            $this->addContent('closewindow');            
            return true;
        }
        
        return false;
    }

    //--------------------------------------------------------------------------        
    
    function createExpense($userid, $purchasedate, $expensedate, $endexpensedate, $totalexpense, $extcampaign_id, $keyword_id, $quantity)
    {
        // save changes of user to db
        $expID = QCore_Sql_DBUnit::createUniqueID(EXPENSE_TABLE, 'expense_id');
        $sql = "insert into " . EXPENSE_UPLOAD_TABLE . " (expense_id, affiliate_id, purchase_time, expense_start, expense_end, total_expense, extcampaign_id, keyword_id, quantity)".
        "values("._q($expID).","._q($userid).","._q($purchasedate).","._q($expensedate).","._q($endexpensedate).", ".myquotes($totalexpense).","._q($extcampaign_id).","._q($keyword_id)."," . _q($quantity)  . ")";
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
		$totalexpense = $_REQUEST['totalexpense'];
		$extcampaign_id = $_REQUEST['extcampaign_id'];
		$keyword_id = $_REQUEST['keyword_id'];
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
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesUploadManager');
			$this->addContent('closewindow');
            return true;
        }
		
        // save changes of user to db
        $expID = QCore_Sql_DBUnit::createUniqueID(EXPENSE_TABLE, 'expense_id');
        $sql = "update " . EXPENSE_UPLOAD_TABLE . " set ".
               "affiliate_id = "._q($userid).", ".
               "purchase_time = " ._q($purchasedate).", ".
               "expense_start = " ._q($expensedate).", ".
               "expense_end = " ._q($endexpensedate).", ".
               "total_expense = " .myquotes($totalexpense).", ".
               "extcampaign_id = " ._q($extcampaign_id).", ".
               "keyword_id = " ._q($keyword_id).", ".
			   "quantity = "._q($quantity).
			   " where expense_id = "._q($eid);
       
		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);        
        if (!$ret)        
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
		QUnit_Messager::setOkMessage("Expense Successfully Updated");
		$this->closeWindow('Affiliate_Merchants_Views_ExpensesUploadManager');
        $this->addContent('closewindow');

              
        return true;
    }    
    
    
    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
        
		$sql = 'delete from '. EXPENSE_UPLOAD_TABLE .
               ' where expense_id in ' . $sqlEIDs;
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
        $this->getCIDForFilter();
        //$this->getDIDForFilter();
        
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

        $this->addContent('expenses_upload_list');        
    }    

    //--------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $sql = 'Select e.affiliate_id, u.name, u.surname, u.username, u.userid' .
        		' From ' . EXPENSE_UPLOAD_TABLE . ' AS e Inner Join ' . USERS_TABLE . ' AS u ON e.affiliate_id = u.userid' .
        		' Group By e.affiliate_id' .
        		' ORDER BY u.name';
        $usersRs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($usersRs);
        $this->assign('a_list_users', $list_data);
    }

	function getCIDForFilter()
    {
    	$sql = 'Select t.entryId, t.trackerName, t.deleted, t.trackerId ' .
    			'From rt_trackers AS t Inner Join ' . EXPENSE_UPLOAD_TABLE . ' AS e ON t.trackerId = e.extcampaign_id ' .
    			'Where t.deleted=0 Group By t.trackerId ' .
    			'Order By t.trackerId Asc';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
		$cids = array();
		
		while(!$rs->EOF)
        {
            $temp = array();
            $temp['trackerId'] = $rs->fields['trackerId'];
            $temp['name'] = $rs->fields['trackerName'];
            $temp['entryId'] = $rs->fields['entryId'];
            $cids[$rs->fields['trackerId']] = $temp;
            
            $rs->MoveNext();
        }
        
        $list_data3 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data3->setTemplateRS($cids);
        $this->assign('cid_list_data1', $list_data3);
    }
    /*function getDIDForFilter()
    {
    	$sql = 'Select k.entryId, k.keywordId, k.keyword ' .
    			'From ' . EXPENSE_UPLOAD_TABLE . ' AS e Inner Join rt_keywords AS k ON k.keywordId = e.keyword_id ' .
    			'Where k.deleted=0 Group By k.keywordId ' .
    			'Order By k.keywordId Asc ' .
    			'Limit 1000';
    	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
    	
    	if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        
        
        $dids = array();
        
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['keywordId'] = $rs->fields['keywordId'];
            $temp['name'] = $rs->fields['keyword'];
            $temp['entryId'] = $rs->fields['entryId'];
            $dids[$rs->fields['keywordId']] = $temp;
            
            $rs->MoveNext();
        }
        
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($dids);
        $this->assign('did_list_data1', $list_data4);
    }*/
    
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
        $sql = 'select count(*) as count from ' . EXPENSE_UPLOAD_TABLE . ' e LEFT JOIN ' . USERS_TABLE . ' a ON e.affiliate_id=a.userid ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        //------------------------------------------------
        // get records
        $sql = "select a.userid, a.name, a.surname, e.quantity, e.expense_id, e.purchase_time, e.expense_start, e.expense_end, ".
                "e.total_expense, e.affiliate_id, e.extcampaign_id, e.keyword_id ".
                "FROM " . EXPENSE_UPLOAD_TABLE . " e LEFT JOIN " . USERS_TABLE . " a ON e.affiliate_id=a.userid ";

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
            'expense_id' =>            array(L_G_EXPENSEID, 'expense_id'),
            'purchase_time' =>         array(L_G_PURCHASEDATE, 'purchase_time'),
            'expense_start' =>         array(L_G_EXPENSEDATE, 'expense_start'),
            'expense_end' =>         array(L_G_ENDEXPENSEDATE, 'expense_end'),
            'total_expense' =>         array(L_G_TOTALEXPENSE, 'total_expense'),
            'affiliate_id' =>         array(L_G_AFFILIATE, 'affiliate_id'),
            'extcampaign_id' =>         array(L_G_EXTCAMPAIGN, 'extcampaign_id'),
            'keyword_id' =>         array(L_G_EPISODE, 'keyword_id'),
			'quantity' =>		array(L_G_QUANTITY, 'quantity'),
			'actions' =>           array(L_G_ACTIONS, ''),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'expenses_upload_list';
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
            $orderby = " order by e.purchase_time desc";
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
        if($_REQUEST['exp_affiliate_id'] == '') $_REQUEST['exp_affiliate_id'] = '_';
        if($_REQUEST['date'] == '') $_REQUEST['date'] = 'all';
        if($_REQUEST['exp_day1'] == '') $_REQUEST['exp_day1'] = date("j");
        if($_REQUEST['exp_month1'] == '') $_REQUEST['exp_month1'] = date("n");
        if($_REQUEST['exp_year1'] == '') $_REQUEST['exp_year1'] = date("Y");
        if($_REQUEST['exp_day2'] == '') $_REQUEST['exp_day2'] = date("j");
        if($_REQUEST['exp_month2'] == '') $_REQUEST['exp_month2'] = date("n");
        if($_REQUEST['exp_year2'] == '') $_REQUEST['exp_year2'] = date("Y");
        
        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['exp_affiliate_id'] = $_REQUEST['exp_affiliate_id'];
        $_SESSION['exp_date'] = $_REQUEST['date'];
        $_SESSION['exp_day1'] = $_REQUEST['exp_day1'];
        $_SESSION['exp_month1'] = $_REQUEST['exp_month1'];
        $_SESSION['exp_year1'] = $_REQUEST['exp_year1'];
        $_SESSION['exp_day2'] = $_REQUEST['exp_day2'];
        $_SESSION['exp_month2'] = $_REQUEST['exp_month2'];
        $_SESSION['exp_year2'] = $_REQUEST['exp_year2'];
        $_SESSION['exp_extcampaign_id'] = $_REQUEST['exp_extcampaign_id'];
        $_SESSION['exp_keyword_id'] = $_REQUEST['exp_keyword_id'];
                
        $where = " WHERE 1=1";
        //$where = " WHERE and a.accountid="._q($GLOBALS['Auth']->getAccountID())." and a.rstatus in (".AFFSTATUS_APPROVED.",".AFFSTATUS_NOTAPPROVED.")";
		
		if ($_REQUEST['date'] != 'all'){
		
			$where .= " and (".sqlToDays($_REQUEST['date'])." >= ".sqlToDays($_REQUEST['exp_year1']."-".$_REQUEST['exp_month1']."-".$_REQUEST['exp_day1']).")".
                      " and (".sqlToDays($_REQUEST['date'])." <= ".sqlToDays($_REQUEST['exp_year2']."-".$_REQUEST['exp_month2']."-".$_REQUEST['exp_day2']).")";
		}
       // $where .= " and (".sqlToDays('e.purchase_time')." >= ".sqlToDays($_REQUEST['exp_year1']."-".$_REQUEST['exp_month1']."-".$_REQUEST['exp_day1']).")".
       //               " and (".sqlToDays('e.purchase_time')." <= ".sqlToDays($_REQUEST['exp_year2']."-".$_REQUEST['exp_month2']."-".$_REQUEST['exp_day2']).")";
       // $where .= " and (".sqlToDays('e.expense_start')." >= ".sqlToDays($_REQUEST['exp_year3']."-".$_REQUEST['exp_month3']."-".$_REQUEST['exp_day3']).")".
       //               " and (".sqlToDays('e.expense_start')." <= ".sqlToDays($_REQUEST['exp_year4']."-".$_REQUEST['exp_month4']."-".$_REQUEST['exp_day4']).")";
        
        $puserid = preg_replace('/[\'\"]/', '', $_REQUEST['exp_affiliate_id']);
        
        if($puserid != '_' && $puserid != '')
        {            
            $where .= " and e.affiliate_id="._q($puserid);
        }
        
        if($_REQUEST['exp_extcampaign_id'] != '_' && $_REQUEST['exp_extcampaign_id'] != '')
        {            
            $where .= " and e.extcampaign_id like '%".addslashes($_REQUEST['exp_extcampaign_id'])."%'";
        }
        if($_REQUEST['exp_keyword_id'] != '_' && $_REQUEST['exp_keyword_id'] != '')
        {            
            $where .= " and e.keyword_id = '".addslashes($_REQUEST['exp_keyword_id'])."'";
        }
        
        
        //$where .= " and a.userid in ".Affiliate_Merchants_Bl_Affiliate::getUserIdsForSql();
        
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

        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['expense_id'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
                case 'quantity': print '<td class=listresult>&nbsp;'.$row['quantity'].'&nbsp;</td>';
                        break;				
                case 'expense_id': print '<td class=listresult>&nbsp;'.$row['expense_id'].'&nbsp;</td>';
                        break;
                  
                case 'total_expense': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'.($row['total_expense'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['total_expense']) : '').'&nbsp;</td>';
                        break;
                        
                case 'purchase_time': print '<td class=listresult align=right nowrap>&nbsp;'.displayDate($row['purchase_time']).'&nbsp;</td>';
                        break;

                case 'expense_start': print '<td class=listresult align=right nowrap>&nbsp;'.displayDate($row['expense_start']).'&nbsp;</td>';
                        break;

                case 'expense_end': print '<td class=listresult align=right nowrap>&nbsp;'.displayDate($row['expense_end']).'&nbsp;</td>';
                        break;

                case 'rstatus': 
                        print '<td class=listresult align=right nowrap>&nbsp;';
                        
                        if($row['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
                        else if($row['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
                        else if($row['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED;
                        
                        print '&nbsp;</td>';
                        break;
                        
                case 'affiliate_id': print '<td class=listresult nowrap>&nbsp;'.$row['affiliate_id'].': '.$row['name'].' '.$row['surname'].'&nbsp;</td>';
                        break;
                        
                case 'extcampaign_id': print '<td class=listresult align=right nowrap>&nbsp;'.$row['extcampaign_id'].'&nbsp;</td>';
                        break;

                case 'keyword_id': print '<td class=listresult align=right nowrap>&nbsp;'.$row['keyword_id'].'&nbsp;</td>';
                        break;

                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editExpense('<?=$row['expense_id']?>');"><?=L_G_EDIT?></a>
                                <? } ?>
                                <? if($this->checkPermissions('approve') && 0) { ?>
                                  <? if($row['rstatus'] != AFFSTATUS_APPROVED) { ?>
                                      <option value="javascript:ChangeState('<?=$row['expense_id']?>','approve');"><?=L_G_APPROVE?></a>
                                  <? } ?>
                                  <? if($row['rstatus'] != AFFSTATUS_SUPPRESSED) { ?>
                                      <option value="javascript:ChangeState('<?=$row['expense_id']?>','suppress');"><?=L_G_SUPPRESS?></a>
                                <?   }
                                   }
                                   if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:deleteExpense('<?=$row['expense_id']?>');"><?=L_G_DELETE?></a>
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
        "e.expense_id, e.purchase_time, e.expense_start, e.expense_end, ".
        "e.total_expense, e.affiliate_id, ".
        "e.extcampaign_id, e.keyword_id, e.quantity ".
        "from " . EXPENSE_UPLOAD_TABLE . " e, " . USERS_TABLE . " a, wd_pa_campaigncategories c";

        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {
            $str = csvFormat($rs->fields['expense_id']);
            $str .= ','.csvFormat($rs->fields['purchase_time']);
            $str .= ','.csvFormat($rs->fields['expense_start']);
            $str .= ','.csvFormat($rs->fields['expense_end']);
            $str .= ','.csvFormat($rs->fields['total_expense']);
            $str .= ','.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);
            //$str .= ','.csvFormat($this->campCategory[$rs->fields['campcategoryid']]);
			


            if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $rstatus = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $rstatus = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $rstatus = L_G_SUPPRESSED;

            $str .= ','.csvFormat($rstatus);

            $str .= ','.csvFormat(($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO));
            $str .= ','.csvFormat($rs->fields['extcampaign_id']);
            $str .= ','.csvFormat($rs->fields['keyword_id']);
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

        $sql = 'select * from '. EXPENSE_UPLOAD_TABLE .
               ' where expense_id='._q($eid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		//println($sql);
        
        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
        
        $_POST['eid'] = $rs->fields['expense_id'];
        $_POST['purchasedate'] = $rs->fields['purchase_time'];
        $_POST['expensedate'] = $rs->fields['expense_start'];
        $_POST['endexpensedate'] = $rs->fields['expense_end'];
        $_POST['totalexpense'] = $rs->fields['total_expense'];
        
        $_POST['userid'] = $rs->fields['affiliate_id'];

		$_POST['tracker'] = $rs->fields['extcampaign_id'];
        $_POST['keyword_id'] = $rs->fields['keyword_id'];
		$_POST['quantity'] = $rs->fields['quantity'];
		
		$keyword_rs = Affiliate_Merchants_Bl_Keywords::loadKeywordInfo($rs->fields['keyword_id']);
		$_POST['keyword_text'] = $keyword_rs['keyword_text'];
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
