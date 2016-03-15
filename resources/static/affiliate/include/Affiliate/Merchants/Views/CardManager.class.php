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
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Sites');
QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');
QUnit_Global::includeClass('Affiliate_Merchants_Views_CampCategoriesManager');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Tracker');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Timeslot');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Page');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Keyword');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Cards');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Merchants_Views_CardManager extends QUnit_UI_ListPage
{

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
        }
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {                
                
                case 'delete':
                    if($this->processDelete())
                        return;
                    break;
				case 'activate':
				    if($this->processActivate($_REQUEST['active']))
                        return;
                    break;					
            }
        }        

        if($_REQUEST['action'] == 'exportcsv')
            $this->showTransactions(true);
        else
            $this->showTransactions(false);      
    }
	
	function processActivate($value){
		$id = $_REQUEST['eid'];
		 Affiliate_Merchants_Bl_Cards::activate($value, $id);
		return false;
	}
	
    function processCreateCard()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		$params = array(
            'cardId' =>  $_REQUEST['cardId'],
            'cardTitle' =>  $_REQUEST['siteTitle'],
            'cardDescription' => $_REQUEST['cardDescription'],
            'merchant' => $_REQUEST['merchant'],
            'introApr' => $_REQUEST['introApr'],
            'introAprPeriod' => $_REQUEST['introAprPeriod'],
            'annualFee' => $_REQUEST['annualFee'],
            'monthlyFee' =>  $_REQUEST['monthlyFee'],
            'balanceTransfers' =>   $_REQUEST['balanceTransfers'],
            'creditNeeded' =>     	$_REQUEST['creditNeeded'],
            'ratesAndFees' =>      $_REQUEST['ratesAndFees'],
            'rewards' =>         	$_REQUEST['rewards'],
            'cardBenefits' =>      $_REQUEST['cardBenefits'],
            'onlineServices' =>    $_REQUEST['onlineServices'],
            'footNotes' =>         $_REQUEST['footNotes'],
            'layout' =>         	$_REQUEST['layout'],
            'active' =>         	$_REQUEST['active'],
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
			$this->closeWindow('Affiliate_Merchants_Views_CardManager');
			$this->addContent('closewindow');
            return true;
        }		
		
        // save changes of user to db
        Affiliate_Merchants_Bl_Cards::addCard($params);
                
		QUnit_Messager::setOkMessage("Site Successfully Created");
		$this->closeWindow('Affiliate_Merchants_Views_CardManager');
        $this->addContent('closewindow');

              
        return true;
    } 	  

    //--------------------------------------------------------------------------        
    
    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
		Affiliate_Merchants_Bl_Cards::deleteCards($sqlEIDs);
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function showTransactions($exportToCsv)
    {
        $temp_perm['view'] = $this->checkPermissions('view');
        $temp_perm['create'] = $this->checkPermissions('create');

        $this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy($orderby, $where);
        
        
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

        $this->addContent('cards_list');        
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
        $sql = 'select count(*) as count from rt_cards ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //------------------------------------------------
        // get records
        $sql = "select *, ".sqlShortDate('dateCreated')." as dateC, ".sqlShortDate('dateUpdated')." as dateU from rt_cards";
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
            'cardId' =>         	array(L_G_CRM_CARDID, 'cardId'),
            'cardTitle' =>         	array(L_G_CRM_CARDTITLE, 'cardTitle'),
            'cardDescription' =>    array(L_G_CRM_CARDDESCR, 'cardDescription'),
            'merchant' =>         	array(L_G_CRM_MERCHANT, 'merchant'),
            'introApr' =>         	array(L_G_CRM_INTROAPR, 'introApr'),
            'introAprPeriod' =>     array(L_G_CRM_INTROAPRPERIOD, 'introAprPeriod'),
            'annualFee' =>         	array(L_G_CRM_ANNUALFEE, 'annualFee'),
            'monthlyFee' =>         array(L_G_CRM_MONTHLYFEE, 'monthlyFee'),
            'balanceTransfers' =>   array(L_G_CRM_BALANCETRANSFERS, 'balanceTransfers'),
            'creditNeeded' =>     	array(L_G_CRM_CREDITNEEDED, 'creditNeeded'),
            'ratesAndFees' =>       array(L_G_CRM_RATESANDFEES, 'ratesAndFees'),
            'rewards' =>         	array(L_G_CRM_REWARDS, 'rewards'),
            'cardBenefits' =>       array(L_G_CRM_CARDBENEFITS, 'cardBenefits'),
            'onlineServices' =>     array(L_G_CRM_ONLINESERVICES, 'onlineServices'),
            'footNotes' =>         	array(L_G_CRM_FOOTNOTES, 'footNotes'),
            'layout' =>         	array(L_G_CRM_LAYOUT, 'layout'),
            
            'dateCreated' =>        array(L_G_CRM_DATEINSERTED, 'dateC'),
            'dateUpdated' =>        array(L_G_CRM_DATEUPDATED, 'dateU'),
            'active' =>         	array(L_G_CRM_ACTIVE, 'active'),
			'actions' =>           	array(L_G_ACTIONS, ''),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'cards_list';
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {        
        // create default view
        $viewColumns = array(
            'cardId',
            'cardTitle',
            'merchant',
			'active',
			'dateCreated',
			'dateUpdated',
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
            $orderby = " order by rt_cards.cardTitle";
        }
		
		$where = " WHERE deleted != 1 AND subCat = 0 ";

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
		$arrowString = '&nbsp;<a href=index.php?md=Affiliate_Merchants_Views_CardManager&action=up&id=' . $row['cardId']. '><img src="../templates/standard/images/sort_up.gif"></a>&nbsp;&nbsp; ' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_Merchants_Views_CardManager&action=down&id=' . $row['cardId']. '><img src="../templates/standard/images/sort_down.gif"></a>';
		if($row['order'] == 1)
			$arrowString = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_Merchants_Views_CardManager&action=down&id=' . $row['cardId']. '><img src="../templates/standard/images/sort_down.gif"></a>';
		
        
		print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['id'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
				case 'cardId': print '<td class=listresult align=right nowrap>&nbsp;'.$row['cardId'].'&nbsp;</td>';
                        break;
				case 'cardTitle': print '<td class=listresult align=right nowrap>&nbsp;'.$row['cardTitle'].'&nbsp;</td>';
                        break;
				case 'cardDescription': print '<td class=listresult align=right>&nbsp;'.$row['cardDescription'].'&nbsp;</td>';
                        break;
				case 'merchant': print '<td class=listresult align=right nowrap>&nbsp;'.$row['merchant'].'&nbsp;</td>';
                        break;
				case 'introApr': print '<td class=listresult align=right nowrap>&nbsp;'.$row['introApr'].'&nbsp;</td>';
                        break;
				case 'introAprPeriod': print '<td class=listresult align=right nowrap>&nbsp;'.$row['introAprPeriod'].'&nbsp;</td>';
                        break;
				case 'regularApr': print '<td class=listresult align=right nowrap>&nbsp;'.$row['regularApr'].'&nbsp;</td>';
                        break;
				case 'annualFee': print '<td class=listresult align=right nowrap>&nbsp;'.$row['annualFee'].'&nbsp;</td>';
                        break;
				case 'monthlyFee': print '<td class=listresult align=right nowrap>&nbsp;'.$row['monthlyFee'].'&nbsp;</td>';
                        break;
				case 'balanceTransfers': print '<td class=listresult align=right nowrap>&nbsp;'.$row['balanceTransfers'].'&nbsp;</td>';
                        break;
				case 'creditNeeded': print '<td class=listresult align=right nowrap>&nbsp;'.$row['creditNeeded'].'&nbsp;</td>';
                        break;
				case 'ratesAndFees': print '<td class=listresult align=right nowrap>&nbsp;'.$row['ratesAndFees'].'&nbsp;</td>';
                        break;
				case 'rewards': print '<td class=listresult align=right nowrap>&nbsp;'.$row['rewards'].'&nbsp;</td>';
                        break;
				case 'cardBenefits': print '<td class=listresult align=right nowrap>&nbsp;'.$row['cardBenefits'].'&nbsp;</td>';
                        break;
				case 'onlineServices': print '<td class=listresult align=right nowrap>&nbsp;'.$row['onlineServices'].'&nbsp;</td>';
                        break;
				case 'footNotes': print '<td class=listresult align=right nowrap>&nbsp;'.$row['footNotes'].'&nbsp;</td>';
                        break;
				case 'layout': print '<td class=listresult align=right nowrap>&nbsp;'.$row['layout'].'&nbsp;</td>';
                        break;
				case 'dateCreated': print '<td class=listresult align=right nowrap>&nbsp;'.$row['dateC'].'&nbsp;</td>';
                        break;
                case 'dateUpdated': print '<td class=listresult align=right nowrap>&nbsp;'.$row['dateU'].'&nbsp;</td>';
                        break;						
				case 'active': if($row['active'] == 1)
									$active = "ACTIVE";
								else
									$active = "NOT ACTIVE";
						print '<td class=listresult align=right nowrap>&nbsp;'.$active.'&nbsp;</td>';
                        break;																																				
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editCard('<?=$row['id']?>');"><?=L_G_EDIT?></a>
                                <? } ?>
                       
                                <?if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:deleteCard('<?=$row['id']?>');"><?=L_G_DELETE?></a>
                                <? } ?>
				                <?if($row['active'] == 1) { ?>
                                     <option value="javascript:deactivateCard('<?=$row['id']?>');"><?=L_G_DEACTIVATE?></a>
                                <? }else if($row['active'] == 0) { ?>
                                     <option value="javascript:activateCard('<?=$row['id']?>');"><?=L_G_ACTIVATE?></a>
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
		/**
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
     **/
        
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
