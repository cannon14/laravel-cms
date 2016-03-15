<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExpenseParser');
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

class Affiliate_Merchants_Views_ExpensesErrorsManager extends QUnit_UI_ListPage
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
        $this->addContent('expenses_errors_edit');
        
        return true;
    }
	
	function drawResubmitExpense(){

        $line_array[] = $_POST['purchasedate'];
        $line_array[] = $_POST['expensedate'];
        $line_array[] = $_POST['endexpensedate'];
        $line_array[] = $_POST['totalexpense'];
        $line_array[] = $_POST['bannerid'];
        $line_array[] = $_POST['userid'];
        $line_array[] = $_POST['campcategoryid'];
        $line_array[] = $_POST['tracker'];
        $line_array[] = $_POST['keyword'];
        $line_array[] = $_POST['timeslot'];
        $line_array[] = $_POST['page'];
		$line_array[] = $_POST['quantity'];				
				
		$eacc = new Affiliate_Merchants_Bl_ExpenseParser();
		$error = $eacc->insert_line($line_array);
		
		$this->processDelete();
		if($error > 0){	
			QUnit_Messager::setErrorMessage("Error resubmitting expense.");
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesErrorsManager');
			$this->addContent('closewindow');
            return true;
		}else{
			QUnit_Messager::setOkMessage("Expense successfully resubmitted.");
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesErrorsManager');
			$this->addContent('closewindow');
            return true;
		}
	}  
    

    //--------------------------------------------------------------------------        
    
    function processUpdateExpense()
    {   
		
        $eid = $_REQUEST['eid'];
		$userid = $_REQUEST['userid'];
		$campcategoryid = $_REQUEST['campaignid'];
		$purchasedate = $_REQUEST['exp_date1'];
		$expensedate = $_REQUEST['exp_date2'];
		$endexpensedate = $_REQUEST['exp_date3'];
		$totalexpense = $_REQUEST['totalexpense'];
		$channel = $_REQUEST['channel'];
		$episode = $_REQUEST['episode'];
		$timeslot = $_REQUEST['timeslot'];
		$quantity = $_REQUEST['quantity'];
		
		if(date($expensedate) > date($endexpensedate) ){
			QUnit_Messager::setErrorMessage("End expense date must come after expense date!");
		}
		
		checkCorrectness($_REQUEST['totalexpense'], $totalexpense, L_G_TOTALEXPENSE, CHECK_NUMBER);
		checkCorrectness($_REQUEST['quantity'], $quantity, L_G_QUANTITY, CHECK_NUMBER);
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
			$this->closeWindow('Affiliate_Merchants_Views_ExpensesErrorsManager');
			$this->addContent('closewindow');
            return true;
        }		
		
        // save changes of user to db
        $expID = QCore_Sql_DBUnit::createUniqueID('wd_pa_expenses', 'expenseid');
        $sql = "update wd_pa_expenses_errors set ".
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
		$this->closeWindow('Affiliate_Merchants_Views_ExpensesErrorsManager');
        $this->addContent('closewindow');

              
        return true;
    }    
    
    
    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
        
		$sql = 'delete from wd_pa_expenses_errors '.
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

        $this->addContent('expenses_errors_list');        
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
        $sql = 'select count(*) as count from wd_pa_expenses_errors e ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //------------------------------------------------
        // get records
        $sql = "select * from wd_pa_expenses_errors e";
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
            'errordate' =>		array(L_G_ERRORDATE, 'errordate'),
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
            $orderby = " order by e.errordate desc";
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
                
        $where = " where e.expenseid != '' ";
		
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
        
        //if($_REQUEST['exp_campaign'] != '_' && $_REQUEST['exp_campaign'] != '')
        //{            
        //    $where .= " and c.campaignid="._q($_REQUEST['exp_campaign']);                
        //}
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
                case 'errordate': print '<td class=listresult align=right nowrap>&nbsp;'.displayDate($row['errordate']).'&nbsp;</td>';
                        break;
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
                                	 <option value="javascript:resubmitExpense('<?=$row['expenseid']?>');">Resubmit Expense</a>
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
        "e.expenseid, e.purchasedate, e.expensedate, e.endexpensedate, ".
        "e.totalexpense, e.bannerid, e.affiliateid, ".
        "e.campcategoryid, e.channel, e.episode, e.timeslot, e.exit ".
        "from wd_pa_expenses e, wd_g_users a, wd_pa_campaigncategories c";

        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {
            $str = csvFormat($rs->fields['expenseid']);
            $str .= ';'.csvFormat($rs->fields['purchasedate']);
            $str .= ';'.csvFormat($rs->fields['expensedate']);
            $str .= ';'.csvFormat($rs->fields['endexpensedate']);
            $str .= ';'.csvFormat($rs->fields['totalexpense']);
            $str .= ';'.csvFormat($rs->fields['bannerid']);
            $str .= ';'.csvFormat($rs->fields['name'].' '.$rs->fields['surname']);
            $str .= ';'.csvFormat($this->campCategory[$rs->fields['campcategoryid']]);


            if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $rstatus = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $rstatus = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $rstatus = L_G_SUPPRESSED;

            $str .= ';'.csvFormat($rstatus);

            $str .= ';'.csvFormat(($rs->fields['payoutstatus'] == AFFSTATUS_APPROVED ? L_G_YES : L_G_NO));
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
    function loadExpenseInfo()
    {
        $eid = preg_replace('/[\'\"]/', '', $_REQUEST['eid']);

        $sql = 'select * from wd_pa_expenses_errors '.
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
        $_POST['campcategoryid'] = $rs->fields['campcategoryid'];
        
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
}
?>
