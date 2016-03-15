<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampCategoriesManager');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Tracker');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Page');
//QUnit_Global::includeClass('Affiliate_Merchants_Bl_Keyword');
QUnit_Global::includeClass('QCore_Bl_Communications');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadExpense');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExpensesUploadErrors');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Keywords');

class Affiliate_Merchants_Views_ExpensesUploadErrorsManager extends QUnit_UI_ListPage
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
                
                case 'edit':
					$this->loadExpenseInfo();
                    if($this->drawFormEditExpense())
                        return;
                    break;
				case 'resubmit':
					$this->loadExpenseInfo();
                    if($this->drawResubmitExpense())
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

    
    function drawFormEditExpense()
    {
            if($_POST['exp_day1'] == '') $_REQUEST['exp_day1'] = date("j");
            if($_POST['exp_month1'] == '') $_POST['exp_month1'] = date("n");
            if($_POST['exp_year1'] == '') $_POST['exp_year1'] = date("Y");
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
        		'		AND accountid='._q($GLOBALS['Auth']->getAccountID());
        
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
        $this->addContent('expenses_upload_errors_edit');
        
        return true;
    }
	
	function drawResubmitExpense()
	{
		$line_array['expense_id'] = $_POST['eid'];
        $line_array['purchase_time'] = $_POST['purchasedate'];
        $line_array['expense_start'] = $_POST['expensedate'];
        $line_array['expense_end'] = $_POST['endexpensedate'];
        $line_array['total_expense'] = $_POST['totalexpense'];
        $line_array['affiliate_id'] = $_POST['userid'];
        $line_array['extcampaign_id'] = $_POST['tracker'];
        $line_array['keyword_id'] = $_POST['keyword'];
		$line_array['quantity'] = $_POST['quantity'];				

		
		$eacc = new Affiliate_Merchants_Bl_ExpensesUploadErrors();
		$error = $eacc->insert_line($line_array);
		
		if($error > 0)
		{	
			QUnit_Messager::setErrorMessage("Error resubmitting expense.");
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesUploadErrorsManager');
			$this->addContent('closewindow');
            return true;
		}
		else
		{
			$this->processDelete();
			
			QUnit_Messager::setOkMessage("Expense successfully resubmitted.");
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesUploadErrorsManager');
			$this->addContent('closewindow');
            return true;
		}
	}  
    
    
    function processUpdateExpense()
    {   
		
        $eid = $_REQUEST['eid'];
		$userid = $_REQUEST['userid'];
		$purchasedate = $_REQUEST['exp_date1'];
		$expensedate = $_REQUEST['exp_date2'];
		$endexpensedate = $_REQUEST['exp_date3'];
		$totalexpense = $_REQUEST['totalexpense'];
		$extcampaign_id = $_REQUEST['exp_extcampaign_id'];
		$keyword_id = $_REQUEST['keyword_id'];
		$quantity = $_REQUEST['quantity'];
		
		if(date($expensedate) > date($endexpensedate) ){
			QUnit_Messager::setErrorMessage("End expense date must come after expense date!");
		}
		
		checkCorrectness($_REQUEST['totalexpense'], $totalexpense, L_G_TOTALEXPENSE, CHECK_NUMBER);
		checkCorrectness($_REQUEST['quantity'], $quantity, L_G_QUANTITY, CHECK_NUMBER);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesUploadErrorsManager');
			$this->addContent('closewindow');
            return true;
        }		
		
        // save changes of user to db
        $expID = QCore_Sql_DBUnit::createUniqueID(EXPENSE_TABLE, 'expense_id');
        $sql = "update " . EXPENSE_UPLOAD_ERROR_TABLE . " set ".
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
		$this->closeWindow('Affiliate_Merchants_Views_ExpensesUploadErrorsManager');
        $this->addContent('closewindow');

              
        return true;
    }    
    
    
    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
        
		$sql = 'delete from '. EXPENSE_UPLOAD_ERROR_TABLE .
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

        $this->addContent('expenses_upload_errors_list');        
    }    

    //--------------------------------------------------------------------------

    function getUsersForFilter()
    {
        $sql = 'Select e.affiliate_id, u.name, u.surname, u.username, u.userid' .
        		' From ' . EXPENSE_UPLOAD_ERROR_TABLE . ' AS e Inner Join ' . USERS_TABLE . ' AS u ON e.affiliate_id = u.userid' .
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
    			'From rt_trackers AS t Inner Join ' . EXPENSE_UPLOAD_ERROR_TABLE . ' AS e ON t.trackerId = e.extcampaign_id ' .
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
    			'From ' . EXPENSE_UPLOAD_ERROR_TABLE . ' AS e Inner Join rt_keywords AS k ON k.keywordId = e.keyword_id ' .
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
        $sql = 'select count(*) as count from ' . EXPENSE_UPLOAD_ERROR_TABLE . ' e LEFT JOIN ' . USERS_TABLE . ' u on e.affiliate_id=u.userid WHERE 1=1 ';
        
        //$sql = 'select count(*) as count from ' . EXPENSE_UPLOAD_ERROR_TABLE . ' e, ' . USERS_TABLE . ' u ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //println($sql.$where);
        
        //------------------------------------------------
        // get records
        $sql = "select e.expense_id, e.purchase_time, e.expense_start, e.expense_end, e.total_expense, e.affiliate_id, e.extcampaign_id, " .
        		"e.keyword_id,  e.quantity, e.error_time, u.name, u.surname, u.userid " . 
        		"FROM " . EXPENSE_UPLOAD_ERROR_TABLE . " e LEFT JOIN ". USERS_TABLE . " u ON e.affiliate_id=u.userid WHERE 1=1";
        		
        /*$sql = "select e.expense_id, e.purchase_time, e.expense_start, e.expense_end, e.total_expense, e.affiliate_id, e.extcampaign_id, e.keyword_id,  e.quantity, e.error_time, u.name, u.surname, u.userid " . 
        		"FROM " . EXPENSE_UPLOAD_ERROR_TABLE . " e, ". USERS_TABLE . " u ";*/

		//println("SQL: ".$sql.$where.$orderby);
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
            'error_time' =>		array(L_G_ERRORDATE, 'error_time'),
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
        return 'expenses_errrors_list';
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
            $orderby = " order by e.error_time desc";
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
                case 'error_time': print '<td class=listresult align=right nowrap>&nbsp;'.displayDate($row['error_time']).'&nbsp;</td>';
                        break;
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
                                	 <option value="javascript:resubmitExpense('<?=$row['expense_id']?>');">Resubmit Expense</a>
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
		<?if($this->checkPermissions('delete')) { ?>
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
            $str .= ';'.csvFormat($col[0]);
        }
        $str = ltrim($str, ";");
                
        fwrite($exportFile, $str."\r\n");
        
        $sql = "select a.userid, a.name, a.surname, ".
        "c.campaignid, ".
        "e.expense_id, e.purchase_time, e.expense_start, e.expense_end, ".
        "e.total_expense, e.affiliate_id, ".
        "e.extcampaign_id, e.keyword_id ".
        "from " . EXPENSE_TABLE . " e, " . USERS_TABLE . " a, wd_pa_campaigncategories c";

        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {
            $str = csvFormat($rs->fields['expense_id']);
            $str .= ';'.csvFormat($rs->fields['purchase_time']);
            $str .= ';'.csvFormat($rs->fields['expense_start']);
            $str .= ';'.csvFormat($rs->fields['expense_end']);
            $str .= ';'.csvFormat($rs->fields['total_expense']);
            $str .= ';'.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);

            if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $rstatus = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $rstatus = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $rstatus = L_G_SUPPRESSED;

            $str .= ';'.csvFormat($rstatus);

            $str .= ';'.csvFormat(($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO));
            $str .= ';'.csvFormat($rs->fields['extcampaign_id']);
            $str .= ';'.csvFormat($rs->fields['keyword_id']);
            
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

        $sql = 'select * from '. EXPENSE_UPLOAD_ERROR_TABLE .
               ' where expense_id='._q($eid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

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
}
?>
