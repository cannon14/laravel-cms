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
QUnit_Global::includeClass('QUnit_Graphics_HtmlGraph');

class Affiliate_Merchants_Views_AdjustmentsLog extends QUnit_UI_ListPage
{

    var $tacc;
    var $adjustmentCategories = array(90, 95, 99, 100, 101);

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
    	$_POST['users'] = $this->getDistinctUsers();
    	$_POST['columns'] = $this->getDistinctColumns();
    	
        {
        	switch($_REQUEST['report']){
        		case 'affiliate':
        			$_POST['reportTable'] = $this->printAdjustmentStatsByAffiliate();
        			break;
        		case 'user':
        			$_POST['reportTable'] = $this->printAdjustmentStatsByUser();
        			break;	
        	}
        	
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
                
                case 'resubmit':
                    if($this->processChangeState(AFFSTATUS_SUPPRESSED))
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
    
    function processDelete()
    {
        if(($IDs = $this->returnUIDs()) == false){
            return false;
        }
            
        $params = array();
        $params['ids'] = $IDs;
        
        
        $sql = "delete from trans_edit_log where id in (" . implode(",", $IDs) . ")";
        //echo $sql;
        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        QUnit_Messager::setOkMessage("Id(s): " . implode(',', $IDs) . " successfully deleted.");
        return false;
        
    }

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

        $this->addContent('adjustments_log');        
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
        $adjustmentCatSQL = "('" . implode("','", $this->adjustmentCategories) . "')";
        
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
            $orderby = " order by dateinserted desc";
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
            if($_REQUEST['user'] == '') $_REQUEST['user'] = '_';
            if($_REQUEST['column'] == '') $_REQUEST['column'] = '_';
            if($_REQUEST['tm_day1'] == '') $_REQUEST['tm_day1'] = date("j");
            if($_REQUEST['tm_month1'] == '') $_REQUEST['tm_month1'] = date("n");
            if($_REQUEST['tm_year1'] == '') $_REQUEST['tm_year1'] = date("Y");
            if($_REQUEST['tm_day2'] == '') $_REQUEST['tm_day2'] = date("j");
            if($_REQUEST['tm_month2'] == '') $_REQUEST['tm_month2'] = date("n");
            if($_REQUEST['tm_year2'] == '') $_REQUEST['tm_year2'] = date("Y");
            
            //--------------------------------------
            // put settings into session
            $_SESSION['numrows'] = $_REQUEST['numrows'];
            $_SESSION['user'] = $_REQUEST['user'];
            $_SESSION['column'] = $_REQUEST['column'];
            $_SESSION['tm_day1'] = $_REQUEST['tm_day1'];
            $_SESSION['tm_month1'] = $_REQUEST['tm_month1'];
            $_SESSION['tm_year1'] = $_REQUEST['tm_year1'];
            $_SESSION['tm_day2'] = $_REQUEST['tm_day2'];
            $_SESSION['tm_month2'] = $_REQUEST['tm_month2'];
            $_SESSION['tm_year2'] = $_REQUEST['tm_year2'];
            $_SESSION['report'] = $REQUEST['report'];
        	
        }
        
        $user = preg_replace('/[\'\"]/', '', $_REQUEST['user']);
        $column = preg_replace('/[\'\"]/', '', $_REQUEST['column']);
        
        $where = " where transtype in  " . $adjustmentCatSQL;
        
        if(!$showAllPending)
        {        
            $where .= " and ((".sqlToDays('dateadjusted')." >= ".sqlToDays($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1']).")".
                      " and (".sqlToDays('dateadjusted')." <= ".sqlToDays($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".$_REQUEST['tm_day2']).") OR ";
        
        	$where .= " (".sqlToDays('dateadjusted')." >= ".sqlToDays($_REQUEST['tm_year1']."-".$_REQUEST['tm_month1']."-".$_REQUEST['tm_day1']).")".
                      " and (".sqlToDays('dateadjusted')." <= ".sqlToDays($_REQUEST['tm_year2']."-".$_REQUEST['tm_month2']."-".$_REQUEST['tm_day2'])."))";
        }
        
        if($user != '_' && $user != '')
        {
            $where .= " and modifiedby = "._q($user);
        }
        
        $_POST['daterange'] = $_REQUEST['tm_month1'] . " / " . $_REQUEST['tm_day1'] . " / " . $_REQUEST['tm_year1'] . " - " . $_REQUEST['tm_month2'] . " / " . $_REQUEST['tm_day2'] . " / " . $_REQUEST['tm_year2'];  
        return true;
    }
    
    function getRecords($orderby, $where)
    {
		
		if($_REQUEST['runQuery'] == 'false'){
			$_POST['runQuery'] = 'false';
			return;
		}
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from wd_pa_transactions';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        //echo "sql: " . $sql . "<br>Count: " . $this->getTotalNumberOfRecords($sql) . "<br>";
        
        
        //------------------------------------------------
        // get records
        $sql = "select * from wd_pa_transactions ";
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
            //'adjustedcommission' =>     array('Adjusted Commission', 'commission'),
            'commission' =>         	array('Commission Adjustment', 'commission'),
			//'totalcost' =>          	array(L_G_TOTALCOST, 'totalcost'),
            'bannerid' =>            	array('Banner ID', 'bannerid'),
			'orderid' =>            	array(L_G_ORDERID, 'orderid'),
            'productid' =>          	array(L_G_PRODUCTID, 'productid'),
            'dateinserted' =>       	array(L_G_CREATED, 't.dateinserted'),
            'dateapproved' =>       	array(L_G_DATEAPPROVED, 't.fapproved'),
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
            'estimatedrevenue' =>       array('Revenue Adjustment', 'estimatedrevenue'),
            //'adjustedestimatedrevenue' => array('Adjusted Estimated Revenue', 'adjustedestimatedrevenue'),
			'dateestimated' =>          array(L_G_DATEESTIMATED, 'dateestimated'),
            'estimateddatafilename' =>  array(L_G_ESTIMATEDDATAFILENAME, 'estimateddatafilename'),
            'actualdatafilename' =>     array(L_G_ACTUALDATAFILENAME, 'actualdatafilename'),
            'providerstatus' =>         array(L_G_PROVIDERSTATUS, 'providerstatus'),
            'providercorrected' =>      array(L_G_PROVIDERCORRECTED, 'providercorrected'),
            'providerwebsiteid' =>      array(L_G_PROVIDERWEBSITEID, 'providerwebsiteid'),
            'providerwebsitename' =>    array(L_G_PROVIDERWEBSITENAME, 'providerwebsitename'),
            'provideractionid' =>       array(L_G_PROVIDERACTIONID, 'provideractionid'),
            'dateactual' =>            	array(L_G_DATEACTUAL, 'dateactual'),
            'modifiedby' =>			    array('Modified By', 'modifiedby'),
        	'dateadjusted' =>			array('Date Adjusted', 'dateadjusted'),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'adjust_list';
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {
        // create default view
        $viewColumns = array(
            'transtype',
            'modifiedby',
			'dateadjusted',
			'transid',
            'campcategoryid',
			'dateinserted',
            'commission',
            'estimatedrevenue',           
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
    
    
    function printListHeader()
    {
        $view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }
        
        //print '<td class=listheader width="1%" nowrap><input type=button id=checkItemsButton value="[X]" OnClick="checkAllItems();"></td>';
        
        $availableColumns = $this->getAvailableColumns();

        foreach($view->columns as $column)
        {
            if(isset($availableColumns[$column]))
            {
                QUnit_Templates::printHeader($availableColumns[$column][0], $availableColumns[$column][1]);
            }
            else
            {
                QUnit_Templates::printHeader(L_G_UNKNOWN);
            }
        }
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

       
        foreach($view->columns as $column)
        {
            switch($column)
            {
                case 'dateadjusted': print '<td class=listresult>&nbsp;'.$row['dateadjusted'].'&nbsp;</td>';
                        break;            	
                case 'transid': print '<td class=listresult>&nbsp;'.$row['reftrans'].'&nbsp;</td>';
                        break;
				case 'modifiedby': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'.$row['modifiedby'] .'&nbsp;</td>';
                        break;
                                        				
				case 'commission': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'.($row['commission'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['commission']) : '').'&nbsp;</td>';
                        break;
                        
                case 'totalcost': print '<td class=listresultnocenter align="right" nowrap>&nbsp;'.($row['totalcost'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['totalcost']) : '').'&nbsp;</td>';
                        break;
                        
                case 'bannerid': print '<td class=listresult nowrap>&nbsp;'.$row['bannerid'].'&nbsp;</td>';
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
                case 'estimatedrevenue': print '<td class=listresult align=right nowrap>&nbsp;'.($row['estimatedrevenue'] != '' ? Affiliate_Merchants_Bl_Settings::showCurrency($row['estimatedrevenue']) : '').'&nbsp;</td>';
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

    }
    
    function getDistinctUsers(){
    	$sql = "SELECT DISTINCT modifiedby FROM wd_pa_transactions";	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$resultArray = array();
    	while(!$rs->EOF){
    		if(trim($rs->fields['modifiedby']) != "")
    			$resultArray[] = $rs->fields['modifiedby'];
    		$rs->MoveNext();	
    	}
    	return $resultArray;
    }
    function getDistinctColumns(){
    	$sql = "DESC wd_pa_transactions";	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$resultArray = array();
    	while(!$rs->EOF){
    		$resultArray[] = $rs->fields['Field'];
    		$rs->MoveNext();	
    	}
    	return $resultArray;
    }
    
   function printAdjustmentStatsByUser(){
    	$adjustmentCatSQL = "('" . implode("','", $this->adjustmentCategories) . "')";
    	$sql = "SELECT distinct modifiedby FROM wd_pa_transactions WHERE transtype in " . $adjustmentCatSQL;
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	
    	
    	while(!$rs->EOF){
    		$users[] = $rs->fields['modifiedby'];
    		$rs->MoveNext();	
    	}
    	
    	if (count($users) < 1)
    		return;
    	
    	foreach($users as $currentUser){

    		
    		$sql = "SELECT * FROM wd_pa_transactions WHERE transtype in " . $adjustmentCatSQL . " AND modifiedby = " . _q($currentUser);
    		//$sql .= " AND (action = 'estimatedrevenue' or action = 'totalcost' or action = 'commission')";
    		
    		//echo $sql.$wheredate;
    		$rs = QCore_Sql_DBUnit::execute($sql.$wheredate, __FILE__, __LINE__);
    		
    		
    		$userAdjusts = 0;
    		while(!$rs->EOF){
    			
    			$e_sum += abs($rs->fields['estimatedrevenue']);				
    			$c_sum += abs($rs->fields['commission']);
    			$userAdjusts ++;
    					
    			$rs->MoveNext();
    		}
    		
    		$aff_names[] = $currentUser;
    		$aff_values[] = $userAdjusts; 
			$c_diff_values[] = $c_sum;
   			$e_diff_values[] = $e_sum;
    		
    		$e_sum = 0;
    		$c_sum = 0;
  		
    	}
    	$graph = new BAR_GRAPH("hBar");
   		$graph->values = $aff_values;
   		$graph->labels = $aff_names;
   		$graph->barWidth = 12;
   		$gdata = $graph->create();
   		$this->assign('totaladjustment_graph', $gdata);
   		
   		$graph = new BAR_GRAPH("hBar");
   		$graph->values = $c_diff_values;
   		$graph->labels = $aff_names;
   		$graph->barWidth = 12;
   		$gdata = $graph->create();
   		$this->assign('totalcommission_graph', $gdata);
   		
   		$graph = new BAR_GRAPH("hBar");
   		$graph->values = $e_diff_values;
   		$graph->labels = $aff_names;
   		$graph->barWidth = 12;
   		$gdata = $graph->create();
   		$this->assign('totalestimate_graph', $gdata);
   		
   		$graph = new BAR_GRAPH("hBar");
   		$graph->values = $t_diff_values;
   		$graph->labels = $aff_names;
   		$graph->barWidth = 12;
   		$gdata = $graph->create();
   		$this->assign('totalcostestimate_graph', $gdata);
	    
    }
    
    function printAdjustmentStatsByAffiliate(){

    	$adjustmentCatSQL = "('" . implode("','", $this->adjustmentCategories) . "')";
    	$sql = "SELECT distinct l.affiliateid, u.username FROM wd_pa_transactions as l, wd_g_users as u WHERE u.userid = l.affiliateid AND transtype in " . $adjustmentCatSQL;
    	$rs = QCore_Sql_DBUnit::execute($sql , __FILE__, __LINE__);
    	
    	
    	
    	while(!$rs->EOF){
    		$affiliates[$rs->fields['affiliateid']] = $rs->fields['username'];
    		$rs->MoveNext();	
    	}
    	
    	if (count($affiliates) < 1)
    		return;
    	
    	foreach($affiliates as $currentAffiliate=>$username){
    		
    		
    		$sql = "SELECT * FROM wd_pa_transactions WHERE transtype in " . $adjustmentCatSQL . " AND affiliateid = " . _q($currentAffiliate);
    		
    		$rs = QCore_Sql_DBUnit::execute($sql.$wheredate, __FILE__, __LINE__);
    		
    		$e_sum = 0;
    		$c_sum = 0;
    		$affiliateAdjusts = 0;
    		while(!$rs->EOF){
				$e_sum = ($e_sum + abs($rs->fields['estimatedrevenue']));				
    			$c_sum = ($c_sum + abs($rs->fields['commission']));
    			$affiliateAdjusts ++;
    	
    			$rs->MoveNext();
    		}
    		
    	    
    		$aff_names[] = $username;
    		$aff_values[] = $affiliateAdjusts; 
			$c_diff_values[] = $c_sum;
   			$e_diff_values[] = $e_sum;
   			
    		$e_sum = 0;
    		$c_sum = 0;
  		
    	}
    	$graph = new BAR_GRAPH("hBar");
   		$graph->values = $aff_values;
   		$graph->labels = $aff_names;
   		$graph->barWidth = 12;
   		$gdata = $graph->create();
   		$this->assign('totaladjustment_graph', $gdata);
   		
   		$graph = new BAR_GRAPH("hBar");
   		$graph->values = $c_diff_values;
   		$graph->labels = $aff_names;
   		$graph->barWidth = 12;
   		$gdata = $graph->create();
   		$this->assign('totalcommission_graph', $gdata);
   		
   		$graph = new BAR_GRAPH("hBar");
   		$graph->values = $e_diff_values;
   		$graph->labels = $aff_names;
   		$graph->barWidth = 12;
   		$gdata = $graph->create();
   		$this->assign('totalestimate_graph', $gdata);
   		
   		$graph = new BAR_GRAPH("hBar");
   		$graph->values = $t_diff_values;
   		$graph->labels = $aff_names;
   		$graph->barWidth = 12;
   		$gdata = $graph->create();
   		$this->assign('totalcostestimate_graph', $gdata);
	    
    }
        
}
?>
