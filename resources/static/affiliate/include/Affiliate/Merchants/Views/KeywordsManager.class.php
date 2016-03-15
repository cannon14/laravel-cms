<?
//============================================================================
// RAPIDO TECHNOLOGIES ADDITION
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Keywords');

class Affiliate_Merchants_Views_KeywordsManager extends QUnit_UI_ListPage
{
    function initPermissions()
    {
//        $this->modulePermissions['delete'] = 'aff_aff_affiliates_modify';
//        $this->modulePermissions['add'] = 'aff_aff_affiliates_modify';
//        $this->modulePermissions['view'] = 'aff_aff_affiliates_view';
//        $this->modulePermissions['edit'] = 'aff_aff_affiliates_modify';
//        $this->modulePermissions['viewassigned'] = 'aff_aff_affiliates_modify';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            
            switch($_POST['massaction'])
            {
                
                case 'delete':
               	    if($this->processDelete()) {
               	    	if ($this->showView())
           	            	return;
               	    }
                break;
                
            }
        }

        if(!empty($_REQUEST['action']))
        {
			
            switch($_REQUEST['action'])
            {
            	case 'search':
                	$this->drawFormSearch();
            		break;
            		
				case 'batchAdd':
                	$this->drawFormBatchAdd();
                	return;
                break;
            		
            	case 'batchDelete':
                	//$this->drawFormBatchDelete();
                	return;
            		break;
                	
                case 'edit':
                	$this->drawFormEditKeyword();
                	return;
	                break;
	
                case 'delete':
               	    $this->processDelete();
       	        break;
       	        
       	        case 'processEdit':
               	    if($this->processEditKeyword()) {
						return;
               	    }
       	        break;
       	        
       	        case 'processBatchAdd':
               	    if($this->processBatchAdd()) {
						return;
               	    }
       	        break;
   	        }
        }

        /*if($this->showView())
        	return;*/
        	
        if($_REQUEST['action'] == 'exportcsv')
            $this->showView(true);
        else
            $this->showView(false);
        	 
	}
    
    
    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processDelete()
    {           
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
		
		return Affiliate_Merchants_Bl_Keywords::deleteType($EIDs);
    }
	
	//--------------------------------------------------------------------------

    function processEditKeyword()
    {
    	$keyword_text_id = $_POST['keyword_text_id'];
		$keyword_text = preg_replace('/[\'\"]/', '', $_POST['keyword_text']);
		$deleted = $_POST['deleted'];
		$types = $_POST['types'];
		
		$keyword = array();
		$keyword['deleted'] = $deleted;
		$keyword['keyword_text_id'] = $keyword_text_id;
		$keyword['keyword_text'] = $keyword_text;
		Affiliate_Merchants_Bl_Keywords::updateKeyword($keyword);
		
		if($deleted)
		{
			Affiliate_Merchants_Bl_Keywords::delete(array($keyword_text_id));
		}
		
		if((isset($types)) && (!$deleted))
		{
			$form_types = array();
			
			foreach($types as $type)
			{
				//save list of types for later use
				$form_types[] = $type;
				
				$keyword_id = Affiliate_Merchants_Bl_Keywords::checkKeywordTypeExists($type, $keyword_text_id);
				
				if($keyword_id)
				{
					//exists, activate type
					Affiliate_Merchants_Bl_Keywords::activateKeywordType($keyword_id);
				}
				else
				{
					//type doesn't exist for that keyword - add type
					$params = array();
					$params['keyword_text_id'] = $keyword_text_id;
					$params['keyword_type'] = $type;
					$params['insert_time'] = $params['update_time'] = date('Y-m-d h:i:s');
					$params['deleted'] = 0;
					
					Affiliate_Merchants_Bl_Keywords::insertType($params);
				}
			}
			
			
			$db_types = Affiliate_Merchants_Bl_Keywords::getKeywordTypesAsArray($keyword_text_id);
			
			foreach($db_types as $db)
			{
				$type_found = false;
				
				foreach($form_types as $form)
				{
					if($db['keyword_type'] == $form)
					{	
						$type_found = true;
					}
				}
				
				if(!$type_found)
					Affiliate_Merchants_Bl_Keywords::deleteType(array($db['keyword_id']));
			}
		}
		
		$this->closeWindow('Affiliate_Merchants_Views_KeywordsManager');
		$this->addContent('tracking_closewindow');
		return true;
    }
	
	//--------------------------------------------------------------------------
	
	function processBatchAdd()
	{
		$keywords = (strstr($_REQUEST['keywords'], "\n") ? explode("\n", $_REQUEST['keywords']) : array($_REQUEST['keywords']));
		$types = $_REQUEST['types'];
		
		//to hold IDs so we can show them again after processing 
		$keywordTypeIds = array();
		
		foreach($keywords as $term)
		{
			$term = trim($term);
			
			//remove user error from adding blank lines in batchAdd text area
			if(($term != '') && ($term != null))
			{
				//see if term already in db
				$keyword_text_id = Affiliate_Merchants_Bl_Keywords::checkKeywordExists($term);
				
				if($keyword_text_id)
				{
					Affiliate_Merchants_Bl_Keywords::activateKeyword($keyword_text_id);
					
					foreach($types as $type)
					{
						//if type exists, but deleted, activate it
						$keyword_id = Affiliate_Merchants_Bl_Keywords::checkKeywordTypeExists($type, $keyword_text_id);
						
						if($keyword_id)
						{
							//exists, activate type
							Affiliate_Merchants_Bl_Keywords::activateKeywordType($keyword_id);
							
							$keywordTypeIds[] = $keyword_id;
						}
						else
						{
							//type doesn't exist for that keyword - add type
							$params = array();
							$params['keyword_text_id'] = $keyword_text_id;
							$params['keyword_type'] = $type;
							$params['update_time'] = $params['insert_time'] = date('Y-m-d h:i:s');
							$params['deleted'] = 0;
							
							Affiliate_Merchants_Bl_Keywords::insertType($params);
							
							$keywordTypeIds[] = Affiliate_Merchants_Bl_Keywords::getLastTypeEntered();
						}
					}
				}
				else
				{
					//keyword doesn't exist - add it
					$data = array();
					$data['keyword_text'] = $term;
					$data['insert_time'] = date('Y-m-d h:i:s');
					$data['deleted'] = 0;
					
					//insert returns new id
					$keyword_text_id = Affiliate_Merchants_Bl_Keywords::insert($data);
					
					if($keyword_text_id)
					{
						//keyword added successfully. Now add types.
						foreach($types as $type)
						{
							$params = array();
							$params['keyword_text_id'] = $keyword_text_id;
							$params['keyword_type'] = $type;
							$params['update_time'] = $params['insert_time'] = date('Y-m-d h:i:s');
							$params['deleted'] = 0;
							
							Affiliate_Merchants_Bl_Keywords::insertType($params);
							
							$keywordTypeIds[] = Affiliate_Merchants_Bl_Keywords::getLastTypeEntered();
						}
					}
				}
			}
		}
		
		
		
		$this->closeWindow('Affiliate_Merchants_Views_KeywordsManager');
		$this->addContent('tracking_closewindow');
		return true;
	}
    

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================
    function showView($exportToCsv)
    {
//        $temp_perm['add'] = $this->checkPermissions('add');
//        $temp_perm['view'] = $this->checkPermissions('view');

//        $this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy($orderby, $where);
		
		if($exportToCsv)
        {
            // prepare export file first
            $this->prepareExportFile($orderby, $where);
        }
		
        $TrackingData = $this->getRecords($orderby, $where);
        
        $this->initViews();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($TrackingData);
        $this->assign('a_list_data', $list_data);

        $this->pageLimitsAssign();

        $this->addContent('keywords_list');
        
    }
    //--------------------------------------------------------------------------

    function getRecords($orderby, $where)
    {
        $TrackingData = array();

    	// init paging
		$sql = 'Select count(*) as count' .
				' From ' . KEYWORD_TEXT_TABLE . ' AS kt LEFT JOIN '. KEYWORDS_TABLE . ' AS k Using (keyword_text_id) ';
		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

		// get records
		$sql = 'Select *' .
				' From ' . KEYWORD_TEXT_TABLE . ' AS kt LEFT JOIN '. KEYWORDS_TABLE . ' AS k Using (keyword_text_id) ';
				
		//$sql = 'Select keyword_text_id, keyword_text, deleted From ' . KEYWORD_TEXT_TABLE . ' ';

		$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
		
		if(!$rs) {
    		QUnit_Messager::setErrorMessage(L_G_DBERROR);
    		return false;
		}
//println($sql.$where);
		// prepare the data
		while(!$rs->EOF) {
    		$TrackingData[$rs->fields['keyword_id']]['keyword_id'] = $rs->fields['keyword_id'];
    		$TrackingData[$rs->fields['keyword_id']]['keyword_text_id'] = $rs->fields['keyword_text_id'];
    		$TrackingData[$rs->fields['keyword_id']]['keyword_text'] = $rs->fields['keyword_text'];
			$TrackingData[$rs->fields['keyword_id']]['keyword_type'] = $rs->fields['keyword_type'];
			$TrackingData[$rs->fields['keyword_id']]['deleted'] = $rs->fields['deleted'];
            $rs->MoveNext();      
		}
        
        return $TrackingData;
    }

    //--------------------------------------------------------------------------

    function drawFormEditKeyword()
    {
        if($_POST['commited'] != 'yes') $this->loadKeywordInfo($_REQUEST['keyword_text_id']);

		$_POST['keyword_text_id'] = $_REQUEST['keyword_text_id'];
        $_POST['header'] = L_G_RT_EDITKEYWORD;
        $_POST['action'] = 'processEdit';
        $_POST['postaction'] = 'processEdit';  

        $this->addContent('keywords_edit');
        return true;
    }
  
    //--------------------------------------------------------------------------

    function drawFormBatchAdd()
    {
        if(!isset($_POST['postaction'])) $_POST['postaction'] = 'processBatchAdd';  
		if(!isset($_POST['action'])) $_POST['action'] = 'processBatchAdd';
        if(!isset($_POST['header'])) $_POST['header'] = L_G_RT_ADDKEYWORD;

        $this->addContent('keywords_add');
        return true;
    }

    //==========================================================================
    // OTHER FUNCTIONS
    //==========================================================================

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

        $str = csvFormat('Keyword ID');
        $str .= ','.csvFormat('Keyword');
        $str .= ','.csvFormat('Type');
        
        fwrite($exportFile, $str."\r\n");
        
        $sql = 'Select *' .
				' From ' . KEYWORD_TEXT_TABLE . ' AS kt LEFT JOIN '. KEYWORDS_TABLE . ' AS k Using (keyword_text_id) ';

        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        
        while(!$rs->EOF)
        {
            $str = csvFormat($rs->fields['keyword_id']);
            $str .= ','.csvFormat($rs->fields['keyword_text']);
            $str .= ','.csvFormat($rs->fields['keyword_type']);
            
            fwrite($exportFile, $str."\r\n");        
            
            $rs->MoveNext();
        }
        
        fclose($exportFile);

        $this->assign('a_exportFileName', $fname);
        
        return true;
    }
	

   //--------------------------------------------------------------------------
    
    /** returns list of columns in list view */
    function getAvailableColumns()
    {
        $a = array();
        
		$a = array(
    		'keyword_id' =>         	array("Keyword ID", 'keyword_id'),
    		'keyword_text' =>       		array("Keyword", 'keyword_text'),
    		'keyword_type' =>       		array("Type", 'keyword_type'),
    		'deleted' =>   			array("Status", ''),
			'actions' =>            array(L_G_ACTIONS, ''),
	        );
        
        return $a;
    }
    
	//--------------------------------------------------------------------------

    function getListViewName()
    {
        return "keywords_list";
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {
    	$viewColumns = array();
    	
		$viewColumns = array(
					'keyword_id',
		    		'keyword_text',
		    		'keyword_type',
		    		'deleted',
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

    function createWhereOrderBy(&$orderby, &$where)
    {
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 50;
        
        $orderby = '';
        $where = '';
        
        $a = array();
		$a = array( 
    		'keyword_id',
    		'keyword_text',
    		'keyword_type',
    		'deleted', 
    	);
        
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['searchType'] = $_REQUEST['searchType'];
        $_SESSION['keyword_text'] = $_REQUEST['keyword_text'];
        $_SESSION['searchDates'] = $_REQUEST['searchDates'];
        
        switch($_REQUEST['status'])
        {
        	case 'all':
        		$where .= ' WHERE 1=1 ';
        		$_SESSION['status'] = 'all';
        		break;
        	
        	case 'deleted':
        		$where .= ' WHERE k.deleted=1';
        		$_SESSION['status'] = 'deleted';
        		break;
        	
        	case null:
        		$where .= ' WHERE k.deleted=0';
        		$_SESSION['status'] = 'active';
        		break;
        		
        	default: $where .= ' WHERE k.deleted=0';
        		$_SESSION['status'] = 'active';
        }
        
        if(($_REQUEST['keyword_text'] != null) && ($_REQUEST['searchType'] != null))
        {
        	switch($_REQUEST['searchType'])
        	{
        		case "begins":
        				$where .= ' AND (keyword_text LIKE ' . _q($_REQUEST['keyword_text'] . '%') .')';
        			break;
        			
        		case "contains":
		        		$where .= ' AND (keyword_text LIKE ' . _q('%' . $_REQUEST['keyword_text'] . '%') .')';
        			break;
        			
        		default: $where .= ' AND keyword_text=' . _q($_REQUEST['keyword_text']);
        	}
        }
        
        if($_REQUEST['beginDay'] && $_REQUEST['beginMonth'] && $_REQUEST['beginYear'] && $_REQUEST['searchDates'])
        {
			if(!$_REQUEST['endDay'] || !$_REQUEST['endMonth'] || !$_REQUEST['endYear'])
			{
				$_REQUEST['endDay'] = date("j");
				$_REQUEST['endMonth'] = date("n");
				$_REQUEST['endYear'] = date("Y");
			}

			$where .= ' AND DATE(k.update_time)>=DATE("'.$_REQUEST['beginYear'].'-'.$_REQUEST['beginMonth'].'-'.$_REQUEST['beginDay'].'") AND DATE(k.update_time)<=DATE("'.$_REQUEST['endYear'].'-'.$_REQUEST['endMonth'].'-'.$_REQUEST['endDay'].'")';
        }
		
		if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a)) {
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        }
        else {
            $orderby = ' order by keyword_text asc'; 
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
        
        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['keyword_id'].'"></td>';
        
        foreach($view->columns as $column)
        {

            switch($column)
            {
                case 'keyword_id': print '<td class=listresult nowrap>&nbsp;'.$row['keyword_id'].'&nbsp;</td>';
                        break;
				
				case 'keyword_text': print '<td class=listresult>&nbsp;'.$row['keyword_text'].'&nbsp;</td>';
                        break;
                
                case 'keyword_type': print '<td class=listresult>&nbsp;'.$row['keyword_type'].'&nbsp;</td>';
                        break;
                
				case 'deleted': print '<td class=listresult>&nbsp;'. ($row['deleted']? 'Deleted':'Active') .'&nbsp;</td>';
                        break;
                        
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <option value="javascript:editKeyword('<?=$row['keyword_text_id']?>');"><?=L_G_EDIT?></option>
                                <option value="javascript:Delete('<?=$row['keyword_id']?>');"><?=L_G_DELETE?></option>                      
                            </select>
                        </td>
<?
                        break;
                
                default: 
                        print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.'</font>&nbsp;</td>';
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
          <option value="-"><?=L_G_CHOOSEACTION?></option>
          <? if($this->checkPermissions('delete')) { ?>
               <option value="delete"><?=L_G_DELETE?></option>
          <? } ?>
        </select>
        &nbsp;&nbsp;
        <input type=submit class=formbutton value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }
    
    function loadKeywordInfo($keyword_text_id)
     {
     	$sql = 'SELECT keyword_text, deleted from ' . KEYWORD_TEXT_TABLE . 
     			' WHERE keyword_text_id=' . _q($keyword_text_id);
     	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
     	if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
     	$_POST['keyword_text'] = $rs->fields['keyword_text'];
        $_POST['deleted'] = $rs->fields['deleted'];
		
		
		
        $sql = 'SELECT keyword_type from ' . KEYWORDS_TABLE .
               ' WHERE deleted=0 AND keyword_text_id=' . _q($keyword_text_id);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
		$types = array();
		
		while(!$rs->EOF)
		{
			if(!isset($keyword_text)) $keyword_text = $rs->fields['keyword_text'];
			
			$types[] = trim($rs->fields['keyword_type']);
			$rs->MoveNext();
		}
        
        $_POST['types'] = $types;
        
        return true;
    }
    
    function returnEIDs()
    {
        if($_POST['massaction'] != '')
        {
            $eIDs = $_POST['itemschecked'];
        }
        else
        {
            $eIDs = array($_REQUEST['keyword_id']);
        }
        
        return $eIDs;
    }
}  
?>