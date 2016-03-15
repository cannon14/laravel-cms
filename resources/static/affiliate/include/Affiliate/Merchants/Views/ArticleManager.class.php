<?
//============================================================================
// Patrick J. Mizer
//============================================================================

require('../../include/QUnit/Graphics/FCKeditor/FCKeditor.php');

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Articles');


class Affiliate_Merchants_Views_ArticleManager extends QUnit_UI_ListPage
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

               case 'update':
                    if($this->processUpdatePage())
                        return;
                    break;
					
				case 'create':
                    if($this->processCreatePage())
                        return;
                    break;				
            }
        }
        else if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {                
                
                case 'edit':
					$this->loadPageInfo();
                    if($this->drawFormEditPage())
                        return;
                    break;
				case 'create':
                    if($this->drawFormCreatePage())
                        return;
                    break;					
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
		$sql = "UPDATE rt_articles set active = " . _q($value) . " where articleId=" . _q($id);
		echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return false;
	}
	
	function drawFormEditPage(){
		$sBasePath =  "../../include/QUnit/Graphics/FCKeditor/";

		$oFCKeditor = new FCKeditor('articleBody') ;
		$oFCKeditor->Value = $_POST['articleBody'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject'] = $oFCKeditor;

		$_POST['action'] = "update";
		$this->addContent('article_create');
		return true;
	}
	function drawFormCreatePage(){
		
		$sBasePath =  "../../include/QUnit/Graphics/FCKeditor/";

		$oFCKeditor = new FCKeditor('articleBody') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->
		$_POST['editorObject'] = $oFCKeditor;
		
		$_POST['action'] = "create";
		$this->addContent('article_create');
		return true;
	}	

    //--------------------------------------------------------------------------        
    
    function processUpdatePage()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
		
		$_REQUEST['articleTitle'] = preg_replace('/[\'\"]/', '', $_REQUEST['articleTitle']);
		checkCorrectness($_REQUEST['articleTitle'], $_REQUEST['articleTitle'], "Article Title", CHECK_EMPTYALLOWED);	
				
		$params = array(
			'articleTitle' => $_REQUEST['articleTitle'],
			'articleIntroText' => $_REQUEST['articleIntroText'],
			'articleBody' => $_REQUEST['articleBody'],
			'active' => $_REQUEST['active'],
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
			
            return false;
        }		
		
        // save changes of user to db
        Affiliate_Merchants_Bl_Articles::updateArticle($_REQUEST['eid'], $params);
                
		QUnit_Messager::setOkMessage("Article Successfully Saved");

              
        return false;
    }
	
    function processCreatePage()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		$_REQUEST['articleTitle'] = preg_replace('/[\'\"]/', '', $_REQUEST['articleTitle']);
		checkCorrectness($_REQUEST['articleTitle'], $_REQUEST['articleTitle'], "Article Title", CHECK_EMPTYALLOWED);	
			
		$params = array(
			'articleTitle' => $_REQUEST['articleTitle'],
			'articleIntroText' => $_REQUEST['articleIntroText'],
			'articleBody' => $_REQUEST['articleBody'],
			'active' => $_REQUEST['active'],
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {

            return false;
        }		
		
        // save changes of user to db
        Affiliate_Merchants_Bl_Articles::addArticle($params);
                
		QUnit_Messager::setOkMessage("Article Successfully Saved");
              
        return false;
    } 	  
    
    
    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
    
		Affiliate_Merchants_Bl_Articles::deleteArticle($sqlEIDs);
      
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

        $this->addContent('articles_list');        
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
        $sql = 'select count(*) as count from rt_articles ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //------------------------------------------------
        // get records
        $sql = "select * from rt_articles";
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
			'articleTitle' => 	array("Title", 'articleTitle'),
			//'pageId' =>		array(L_G_PAGEID, 'pageId'),
			'dateCreated' =>    array(L_G_DATEINSERTED, 'dateCreated'),
			'dateUpdated' =>    array(L_G_DATEUPDATED, 'dateUpdated'),     
			'active' =>         array(L_G_ACTIVE, 'active'),
			'actions' =>        array(L_G_ACTIONS, ''),
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
            $orderby = " order by articleTitle ASC";
        }
		
		$where = " WHERE subCat = 0 AND deleted != 1 ";

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
		
        
		print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['articleId'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
				case 'articleTitle': print '<td class=listresult align=right nowrap>&nbsp;' . $row['articleTitle'] . '&nbsp;</td>';
                        break;
				case 'dateCreated': print '<td class=listresult align=right nowrap>&nbsp;'. $row['dateCreated'] . '&nbsp;</td>';
                        break;
				case 'dateUpdated': print '<td class=listresult align=right nowrap>&nbsp;'. $row['dateUpdated'] . '&nbsp;</td>';
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
                                     <option value="javascript:editSite('<?=$row['articleId']?>');"><?=L_G_EDIT?></a>
                                <? } ?>
                       
                                <?if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:deleteSite('<?=$row['articleId']?>');"><?=L_G_DELETE?></a>
                                <? } ?>
				                <?if($row['active'] == 1) { ?>
                                     <option value="javascript:deactivateSite('<?=$row['articleId']?>');"><?=L_G_DEACTIVATE?></a>
                                <? }else if($row['active'] == 0) { ?>
                                     <option value="javascript:activateSite('<?=$row['articleId']?>');"><?=L_G_ACTIVATE?></a>
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
    function loadPageInfo()
    {
        $eid = preg_replace('/[\'\"]/', '', $_REQUEST['eid']);

		$rs = Affiliate_Merchants_Bl_Articles::getArticle($eid);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

		$_POST['articleId'] = $rs->fields['articleId'];
        $_POST['articleTitle'] = $rs->fields['articleTitle'];
		$_POST['articleIntroText'] =  $rs->fields['articleIntroText'];
        $_POST['articleBody'] =  $rs->fields['articleBody'];
        //$_POST['dateInserted'] = $rs->fields['dateInserted'];
		$_POST['active'] = $rs->fields['active'];
		
		//$_POST['layout'] = $rs->fields['layout'];
		//$_POST['publishPath'] = $rs->fields['publishPath'];
		//$_POST['hostname'] = $rs->fields['hostname'];
		//$_POST['dateCreated'] = $rs->fields['dateCreated'];
		//$_POST['dateUpdated'] = $rs->fields['dateUpdated'];
		//$_POST['active'] = $rs->fields['active'];  
		
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
