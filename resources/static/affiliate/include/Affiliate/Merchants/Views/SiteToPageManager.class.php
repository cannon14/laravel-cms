<?
//============================================================================
// Patrick J. Mizer
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Bl_SLLists');
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Sites');

class Affiliate_Merchants_Views_SiteToPageManager extends QUnit_UI_ListPage
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
		
        if(!empty($_REQUEST['sortableListsSubmitted']))
        {
			
			$orderArray = Affiliate_Merchants_Bl_SLLists::getOrderArray($_REQUEST['assignedListOrder'],'assignedList');
			foreach($orderArray as $item) {
				$sql[] = "INSERT INTO rt_pagecategorymap (rank, categoryId, cardpageId) VALUES (" . _q($item['order']) . ", " . _q($_REQUEST['siteId']) . ","  . _q($item['element']) . ")";
			}
			$this->updateOrder($sql);
		}
		
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {                
				case 'assignAll':
					if($this->assignAll())
						return;
					break;
				case 'removeAll':
					if($this->removeAll())
						return;
					break;		
				case 'addPage':
					if($this->processAddPage())
						return;
					break;	
				case 'removePage':
					if($this->processRemovePage())
						return;
					break;		
            }
        }        

        if($_REQUEST['action'] == 'exportcsv')
            $this->showTransactions(true);
        else{
			$_POST['siteId'] = $_REQUEST['siteId'];
			$this->showTransactions(false);      
        }
    }
    
	function processAddPage(){
		$sql = "SELECT MAX(rank) FROM rt_pagecategorymap WHERE categoryId = " . _q($_REQUEST['categoryId']);
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$max = $rs->fields['MAX(rank)'];
		if($max == '')
			$max = 0;
		$sql = "DELETE FROM rt_pagecategorymap WHERE cardpageId=" . _q($_REQUEST['pageID']) . " AND categoryId=" . _q($_REQUEST['categoryId']);
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = "INSERT INTO rt_pagecategorymap (rank, categoryId, cardpageId) VALUES (" . _q(($max+1)) . ", " . _q($_REQUEST['categoryId']) . ","  . _q($_REQUEST['pageID']) . ")";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$this->redirect('Affiliate_Merchants_Views_SiteToPageManager&type=all&siteId='.$_REQUEST['categoryId']);

	}    
	
	function processRemovePage(){
		$sql = "SELECT * FROM rt_pagecategorymap WHERE categoryId=" . _q($_REQUEST['categoryId']) . " AND cardpageId != " . _q($_REQUEST['cardpageId']) . " ORDER BY rank";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = "DELETE FROM rt_pagecategorymap WHERE categoryId=" . _q($_REQUEST['categoryId']);
		
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$count = 1;
		while(!$rs->EOF){
			$sql = "INSERT INTO rt_pagecategorymap (rank, categoryId, cardpageId) VALUES (" . _q($count) . ", " . _q($rs->fields['categoryId']) . ","  . _q($rs->fields['cardpageId']) . ")";
			
			QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			$count ++;
			$rs->MoveNext();
		}
		$this->redirect('Affiliate_Merchants_Views_SiteToPageManager&type=all&siteId='.$_REQUEST['categoryId']);
	}	

	
	function removeAll(){
		$sql = "DELETE from rt_pagecategorymap where categoryId = " . _q($_REQUEST['siteId']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return false;
	}
	
	function assignAll(){
		$sql = "DELETE from rt_pagecategorymap where categoryId = " . _q($_REQUEST['siteId']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = "SELECT cardpageId from rt_cardpages where deleted != 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$count = 1;
		while(!$rs->EOF){
			$sql = "INSERT INTO rt_pagecategorymap (rank, categoryId, cardpageId) VALUES (" . _q($count) . ", " . _q($_REQUEST['siteId']) . ","  . _q($rs->fields['categoryId']) . ")";
			QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			$rs->MoveNext();
		}
		return false;
	}
	
	function updateOrder($sql){
		$deletesql = "DELETE from rt_pagecategorymap where categoryId = " . _q($_REQUEST['siteId']);
		
		$rs = QCore_Sql_DBUnit::execute($deletesql, __FILE__, __LINE__);
		if($sql != ''){
			foreach($sql as $currentSql){
				//echo $currentSql . "<br>";
				$rs = QCore_Sql_DBUnit::execute($currentSql, __FILE__, __LINE__);
			}
		}
	}
    
    //--------------------------------------------------------------------------
    
    function showTransactions($exportToCsv)
    {
		
        $assigned = $this->getAssignedRecords();
		$unassigned = $this->getUnassignedRecords();
		
		$_POST['rs_assigned'] = $assigned;
		$_POST['rs_unassigned'] = $unassigned;
		$_POST['categoryName'] = $assigned->fields['categoryName'];
		$this->addContent('assigncategories_list'); 
        

		
    }    

	function getUnassignedRecords()
    {
        
        //------------------------------------------------
        // get records
        $rs = $this->getAssignedRecords();
		while(!$rs->EOF){
			$assigned[] = $rs->fields['cardpageId'];
			$rs->MoveNext();
		}
		if(count($assigned) > 0){
			$sqlIds = "('" . implode("','", $assigned) . "')";
		}else
			$sqlIds = "('')";
		$sql = "select * from rt_cardpages as c where c.type =0 AND !(c.cardpageId in " . $sqlIds . ") and c.deleted != 1";  
		//echo "SQL: ".$sql;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;
    }

	function getAssignedRecords()
    {
        
        //------------------------------------------------
        // get records
        $sql = "select * from rt_pagedetails as d, rt_cardpages as s, rt_pagecategorymap as m, rt_categories as c where s.type = 0 AND (d.deleted != 1 AND s.deleted != 1) AND d.pageDetailVersion = -1 AND (d.cardpageId =  s.cardpageId) AND m.categoryId =" . _q($_REQUEST['siteId']) . " and (m.cardpageId=s.cardpageId) and (m.categoryId=c.categoryId) and s.deleted != 1 ORDER BY m.rank ASC";
		//echo "<br>SQL: ".$sql;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'sites_list';
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
}
?>
