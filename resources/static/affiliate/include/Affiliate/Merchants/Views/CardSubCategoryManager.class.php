<?
//============================================================================
// Patrick J. Mizer
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Cards');


class Affiliate_Merchants_Views_CardSubCategoryManager extends QUnit_UI_ListPage
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
            switch($_POST['postaction'])
            {

               case 'edit':
                    if($this->processUpdateCat())
                    	
                        return;
    
                    break;	
					
				case 'create':
                    if($this->processCreateCat())
                        return;
                    break;				
            }
        }
        else if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {                
                				
                case 'delete':
                    if($this->processDelete())
                        return;
                    break;
                case 'edit':
                	if($this->drawFormEditCat());
                        return;
                    break;
                case 'create':
                	if($this->DrawFormCreateCat());
                        return;
                    break;	                    				
            }
        }        

        if($_REQUEST['action'] == 'exportcsv')
            $this->showTransactions(true);
        else
            $this->showTransactions(false);      
    }

	
	
	function drawFormEditCat(){
		$this->loadCatInfo();
		$_POST['action'] = $_REQUEST['action'];
		$_POST['eid'] = $_REQUEST['eid'];
		$this->addContent('cat_create');
		
		return true;
	}
	function drawFormCreateCat(){
		$_POST['action'] = $_REQUEST['action'];
		$this->addContent('cat_create');
		
		return true;
	}	

    //--------------------------------------------------------------------------        
    
    function processUpdateCat()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
		
		//$_REQUEST['pageName'] = preg_replace('/[\'\"]/', '', $_REQUEST['categoryName']);
		//checkCorrectness($_REQUEST['pageName'], $_REQUEST['pageName'], L_G_CATEGORYNAME, CHECK_EMPTYALLOWED);			
		
		$id = $_REQUEST['eid'];
		
		$params = array(
			'catTitle' => $_REQUEST['catTitle'],
			'catDescription' => $_REQUEST['catDescription'],
			'catImage' => $_REQUEST['catImage'],
			'catImageAltText' => $_REQUEST['catImageAltText'],
			
		);
		
        Affiliate_Merchants_Bl_Cards::updateCard($id, $params);
        
        QUnit_Messager::setOkMessage("Card Sub Category Successfully Updated");     
        
        return false;
    }
	
    function processCreateCat()
    {   
		
		$params = array(
			'catTitle' => $_REQUEST['catTitle'],
			'catDescription' => $_REQUEST['catDescription'],
			'catImage' => $_REQUEST['catImage'],
			'catImageAltText' => $_REQUEST['catImageAltText'],
			'subCat' => 1,
		);
		
		$id = Affiliate_Merchants_Bl_Cards::addCard($params);
		
		$params = array( "cardShortName" => "SubCat"
		);
		
		Affiliate_Merchants_Bl_Cards::addDefaultVersion($id, $params);
		
		QUnit_Messager::setOkMessage("Card Sub Category Successfully Created");
    
        return false;
    }
     	
    
    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
    
		$sql = "UPDATE rt_cards SET deleted = 1 WHERE id in " . $sqlEIDs;
       	echo $sql;
       	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function showTransactions($exportToCsv)
    {
        $temp_perm['view'] = $this->checkPermissions('view');
        $temp_perm['create'] = $this->checkPermissions('create');

        $this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy($orderby, $where);
        
        
        //$this->campCategory = Affiliate_Merchants_Views_CampCategoriesManager::getCampCategoriesAsArray();
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

        $this->addContent('cat_list');        
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
        $sql = "select * from rt_cards";
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
			'catTitle' =>	array("Category Title", 'catTitle'),
			'dateCreated' =>	array(L_G_DATEINSERTED, 'dateCreated'),
			'dateUpdated' =>	array(L_G_DATEUPDATED, 'dateUpdated'),
			'actions' =>		array(L_G_ACTIONS, ''),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'pages_list';
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
            $orderby = " order by cardTitle ASC";
        }
		
		$where = " WHERE subCat = 1 AND deleted != 1 ";

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
		//$arrowString = '&nbsp;<a href=index.php?md=Affiliate_Merchants_Views_PageManager&action=up&order=' . $row['order'].  '&id=' . $row['siteId']. '><img src="../templates/standard/images/sort_up.gif"></a>&nbsp;&nbsp; ' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_Merchants_Views_SiteManager&action=down&order=' . $row['order']. '&id=' . $row['siteId']. '><img src="../templates/standard/images/sort_down.gif"></a>';
		//if($row['order'] == 1)
		//	$arrowString = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_Merchants_Views_SiteManager&action=down&order=' . $row['order'].  '&id=' . $row['siteId']. '><img src="../templates/standard/images/sort_down.gif"></a>';
		
        
		print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['id'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
				case 'catTitle': print '<td class=listresult align=right nowrap>&nbsp;' . $row['catTitle'] . '&nbsp;</td>';
                        break;
				case 'dateCreated': print '<td class=listresult align=right nowrap>&nbsp;'. $row['dateCreated'] . '&nbsp;</td>';
                        break;
				case 'dateUpdated': print '<td class=listresult align=right nowrap>&nbsp;'. $row['dateUpdated'] . '&nbsp;</td>';
                        break;
																																													
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editSite('<?=$row['id']?>');"><?=L_G_EDIT?></a>
                                <? } ?>
                       
                                <?if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:deleteSite('<?=$row['id']?>');"><?=L_G_DELETE?></a>
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

    }  
    
    
    function loadCatInfo(){
       $eid = preg_replace('/[\'\"]/', '', $_REQUEST['eid']);
		
		$rs = Affiliate_Merchants_Bl_Cards::getCard($eid, -1);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
        $_POST['catTitle'] = $rs->fields['catTitle'];
        $_POST['catDescription'] = $rs->fields['catDescription'];
        $_POST['catImage'] = $rs->fields['catImage'];
        $_POST['catImageAltText'] = $rs->fields['catImageAltText'];            	
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
