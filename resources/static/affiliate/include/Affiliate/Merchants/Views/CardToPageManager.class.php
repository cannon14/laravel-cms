<?
//============================================================================
// Patrick J. Mizer
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Bl_SLLists');
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Pages');

class Affiliate_Merchants_Views_CardToPageManager extends QUnit_UI_ListPage
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
		
        if(!empty($_REQUEST['sortableListsSubmitted']))
        {
			
			$orderArray = Affiliate_Merchants_Bl_SLLists::getOrderArray($_REQUEST['assignedListOrder'],'assignedList');
			foreach($orderArray as $item) {
				$sql[] = "INSERT INTO rt_cardpagemap (rank, cardpageId, cardId) VALUES (" . _q($item['order']) . ", " . _q($_REQUEST['siteId']) . ","  . _q($item['element']) . ")";
			}
			$this->updateOrder($sql);
		}
		
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {  
                case 'addPage':
                    if($this->processAddPage())
                        return;
                    break;            	              
                case 'addCard':
                    if($this->processAddCard())
                        return;
                    break;
                case 'removeCard':
                    if($this->processRemoveCard())
                        return;
                    break;					

            }
        }        

        if($_REQUEST['action'] == 'exportcsv')
            $this->showTransactions(true);
        else{
			$_POST['categoryId'] = $_REQUEST['categoryId'];
			$this->showTransactions(false);      
        }
    }
    
	function processAddPage(){
		$sql = "SELECT MAX(rank) FROM rt_cardpagemap WHERE cardpageId = " . _q($_REQUEST['siteId']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$max = $rs->fields['MAX(rank)'];
		if($max == '')
			$max = 0;
		$sql = "DELETE FROM rt_cardpagemap WHERE cardId=" . _q($_REQUEST['cardId']) . " AND cardpageId=" . _q($_REQUEST['siteId']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = "INSERT INTO rt_cardpagemap (rank, cardpageId, cardId, pageInsert) VALUES (" . _q(($max+1)) . ", " . _q($_REQUEST['siteId']) . ","  . _q($_REQUEST['cardId']) . "," . _q(1) .")";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
	}

	
	function processAddCard(){
		$sql = "SELECT MAX(rank) FROM rt_cardpagemap WHERE cardpageId = " . _q($_REQUEST['siteId']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$max = $rs->fields['MAX(rank)'];
		if($max == '')
			$max = 0;
		$sql = "DELETE FROM rt_cardpagemap WHERE cardId=" . _q($_REQUEST['cardId']) . " AND cardpageId=" . _q($_REQUEST['siteId']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = "INSERT INTO rt_cardpagemap (rank, cardpageId, cardId) VALUES (" . _q(($max+1)) . ", " . _q($_REQUEST['siteId']) . ","  . _q($_REQUEST['cardId']) . ")";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
	}
	
	function processRemoveCard(){
		$sql = "SELECT * FROM rt_cardpagemap WHERE cardpageId=" . _q($_REQUEST['siteId']) . " AND cardId!= " . _q($_REQUEST['cardId']) . " ORDER BY rank";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = "DELETE FROM rt_cardpagemap WHERE cardpageId=" . _q($_REQUEST['siteId']);
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$count = 1;
		while(!$rs->EOF){
			$sql = "INSERT INTO rt_cardpagemap (rank, cardpageId, cardId) VALUES (" . _q($count) . ", " . _q($rs->fields['cardpageId']) . ","  . _q($rs->fields['cardId']) . ")";
			QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			$count ++;
			$rs->MoveNext();
		}
		
	}
	
	function updateOrder($sql){
		$deletesql = "DELETE from rt_cardpagemap where cardpageId = " . _q($_REQUEST['siteId']);
		
		$rs = QCore_Sql_DBUnit::execute($deletesql, __FILE__, __LINE__);
		if($sql != ''){
			foreach($sql as $currentSql)
				$rs = QCore_Sql_DBUnit::execute($currentSql, __FILE__, __LINE__);
		}
	}
	

    //--------------------------------------------------------------------------
    
    function showTransactions($exportToCsv)
    {
		/**
        $temp_perm['view'] = $this->checkPermissions('view');
        $temp_perm['create'] = $this->checkPermissions('create');

        $this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy();
        
        
        $this->campCategory = Affiliate_Merchants_Views_CampCategoriesManager::getCampCategoriesAsArray();
        if($exportToCsv)
        {
            // prepare export file first
            $this->prepareExportFile($orderby, $where);
        }


		**/
		
        $assigned = $this->getAssignedRecords();
		$unassigned = $this->getUnassignedRecords();
		
		$_POST['rs_assigned'] = $assigned;
		$_POST['rs_unassigned'] = $unassigned;
		
		$assignedCats = $this->getAssignedSubCats();
		$unassignedCats = $this->getUnassignedSubCats();
		
		$_POST['rs_assignedCats'] = $assignedCats;
		$_POST['rs_unassignedCats'] = $unassignedCats;
				
		$_POST['categoryName'] = $assigned->fields['categoryName'];
		
		$_POST['pageInfo'] = $this->getPageInfo($_REQUEST['siteId']);
		//echo "Category Name: " . $assigned->fields['categoryName'];
		$this->addContent('assigncards_list');
		
        
		/**
		$this->initViews();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($assigned);
        
        $this->assign('a_list_data', $list_data);
		
		$this->assign('a_curyear', date("Y"));
        
        $this->pageLimitsAssign();

        $this->addContent('assignpages_list'); 
		**/ 
		
    }
    
    
	function getUnassignedSubCats()
    {
        //------------------------------------------------
        // get records
        $rs = $this->getAssignedRecords();
		while(!$rs->EOF){
			$assigned[] = $rs->fields['cardId'];
			$rs->MoveNext();
		}
		if(count($assigned) > 0){
			$sqlIds = "('" . implode("','", $assigned) . "')";
		}else
			$sqlIds = "('')";
		$sql = "select * from rt_cards as c WHERE  c.subCat = 1 AND c.id not in " . $sqlIds . " and c.deleted != 1";

		//echo "getUnassignedSubCats: " . $sql . "<br><br>";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;
    }
	function getAssignedSubCats()
    {	
    	
        //------------------------------------------------
        // get records
        		$sql = "select * from 
				rt_cardpages as p, rt_cardpagemap as m, rt_carddetails as cd, rt_cards as c 		
				where  c.subCat = 1 AND (c.id = cd.cardId) 		
				AND cd.cardDetailVersion = -1 		
				AND m.cardpageId = " . _q($_REQUEST['siteId']) . "		
				AND (m.cardpageId=p.cardpageId) 		
				AND (m.cardId=c.id) 		
				AND c.deleted != 1 	
				ORDER BY m.rank ";
		//echo "getAssignedSubCats: ". $sql . "<br><br>";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;       
    }     

	function getUnassignedRecords()
    {
        
        //------------------------------------------------
        // get records
        $rs = $this->getAssignedRecords();
		while(!$rs->EOF){
			$assigned[] = $rs->fields['cardId'];
			$rs->MoveNext();
		}
		if(count($assigned) > 0){
			$sqlIds = "('" . implode("','", $assigned) . "')";
		}else
			$sqlIds = "('')";
		$sql = "select * from rt_cards as c WHERE c.subCat = 0 AND c.cardId not in " . $sqlIds . " and c.deleted != 1";

		//echo "getUnassignedRecords: ".$sql . "<br><br>";
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
        		$sql = "select * from 
				rt_cardpages as p, rt_cardpagemap as m, rt_carddetails as cd, rt_cards as c 		
				where (c.cardId = cd.cardId) 		
				AND cd.cardDetailVersion = -1 		
				AND m.cardpageId = " . _q($_REQUEST['siteId']) . "		
				AND (m.cardpageId=p.cardpageId) 		
				AND (m.cardId=c.cardId) 		
				AND c.deleted != 1 	
				ORDER BY m.rank ";
		//echo "getAssignedRecords: ".$sql ."<br><br>";
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
    
    function getPageInfo($id){
    	return Affiliate_Merchants_Bl_Pages::getPage($id, -1);
    }
  
   
	  
}
?>
