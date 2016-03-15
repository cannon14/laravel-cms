<?
//============================================================================
// Patrick J. Mizer
//============================================================================
require('../../include/QUnit/Graphics/FCKeditor/FCKeditor.php');

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Pages');


class Affiliate_Merchants_Views_PageManager extends QUnit_UI_ListPage
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
    	$_POST['type'] = $_REQUEST['type'];
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
                case 'createVersion':
                    if($this->processCreateVersion())
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
					$this->loadDetailInfo();
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
                case 'editVersion':
                	if($this->processSwitchVersion($_REQUEST['versionId']));
                	$this->drawFormEditPage();
                        return;
                    break;
                case 'createVersion':
                	if($this->DrawFormCreateVersion($_REQUEST['eid']));
                        return;
                    break;	                    				
            }
        }        

        if($_REQUEST['action'] == 'exportcsv')
            $this->showTransactions(true);
        else
            $this->showTransactions(false);      
    }
	
	function processSwitchVersion($version){
		$this->loadPageInfo();
		$this->loadDetailInfo($version);
	}
	
	function processActivate($value){
		$id = $_REQUEST['eid'];
		$sql = "UPDATE rt_cardpages set active = " . _q($value) . " where cardpageId=" . _q($id);
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return false;
	}
	
	function drawFormCreateVersion($cardpageId){
	    $rs = Affiliate_Merchants_Bl_Pages:: getUnusedVersions($cardpageId);
		$_POST['pageDetailVersion'] = "<SELECT name='version'>\n";
		while(!$rs->EOF){
			$_POST['pageDetailVersion'] .= "<option value='".$rs->fields['siteId']."'>".$rs->fields['siteTitle']. "</option>\n";
			$rs->MoveNext();	
		}
		$_POST['pageDetailVersion'] .= "</SELECT>\n";	
		
		$sBasePath =  "../../include/QUnit/Graphics/FCKeditor/";

		$oFCKeditor = new FCKeditor('pageLearnMore') ;
		$oFCKeditor->Value = $_POST['pageLearnMore'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject'] = $oFCKeditor;		
		
		$oFCKeditor2 = new FCKeditor('pageDisclaimer') ;
		$oFCKeditor2->Value = $_POST['pageDisclaimer'];
		$oFCKeditor2->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor2;	
		
		$oFCKeditor3 = new FCKeditor('pageSeeAlso') ;
		$oFCKeditor3->Value = $_POST['pageSeeAlso'];
		$oFCKeditor3->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor3;	
		
		$this->loadPageInfo();
		$_POST['action'] = "createVersion";
		$this->addContent('page_create');
		
		
		return true;	
	}
	
	function drawFormEditPage(){
		$rs = $this->getVersions($_POST['cardpageId']);
		$_POST['selectExisitngVersion'] = "<SELECT name='version' OnChange=\"performAction(this);\">\n";
		$_POST['selectExisitngVersion'] .= "<option value=\"javascript:editVersion(-1, " . $_POST['cardpageId'] . ")\">Default</option>\n";
		while(!$rs->EOF){
			$selected = "";
			if($rs->fields['pageDetailVersion'] == $_REQUEST['versionId'])
				$selected = "selected";
			if($rs->fields['pageDetailVersion'] > 0)
        		$_POST['selectExisitngVersion'] .= "<option " . $selected ." value=\"javascript:editVersion(" . $rs->fields['pageDetailVersion'] . ", " . $_POST['cardpageId'] . ")\">" . $rs->fields['pageDetailLabel'] . "</option>\n";
        	$rs->MoveNext();
        }
		
		$_POST['selectExisitngVersion'] .= "</select>\n";		
		
		
		$sBasePath =  "../../include/QUnit/Graphics/FCKeditor/";

		$oFCKeditor = new FCKeditor('pageLearnMore') ;
		$oFCKeditor->Value = $_POST['pageLearnMore'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject'] = $oFCKeditor;	
		
		$oFCKeditor2 = new FCKeditor('pageDisclaimer') ;
		$oFCKeditor2->Value = $_POST['pageDisclaimer'];
		$oFCKeditor2->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor2;	
		
		$oFCKeditor3 = new FCKeditor('pageSeeAlso') ;
		$oFCKeditor3->Value = $_POST['pageSeeAlso'];
		$oFCKeditor3->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor3;	
		
		$_POST['action'] = "update";
		$_POST['postaction'] = "update";
		
		if($_REQUEST['versionId'] == "")
			$_REQUEST['versionId'] = -1;
		
		$this->addContent('page_create');
		

		
		return true;
	}
	function drawFormCreatePage(){
		$sBasePath =  "../../include/QUnit/Graphics/FCKeditor/";

		$oFCKeditor = new FCKeditor('pageLearnMore') ;
		$oFCKeditor->Value = $_POST['pageLearnMore'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor('pageDisclaimer') ;
		$oFCKeditor->Value = $_POST['pageDisclaimer'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;	
		
		$oFCKeditor = new FCKeditor('pageSeeAlso') ;
		$oFCKeditor->Value = $_POST['pageSeeAlso'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;	
		
		
		
		$_POST['action'] = "create";
		$_POST['postaction'] = "create";
		$this->addContent('page_create');
		return true;
	}	

    //--------------------------------------------------------------------------        
    
    function processUpdatePage()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
		
		//$_REQUEST['pageName'] = preg_replace('/[\'\"]/', '', $_REQUEST['categoryName']);
		//checkCorrectness($_REQUEST['pageName'], $_REQUEST['pageName'], L_G_CATEGORYNAME, CHECK_EMPTYALLOWED);			
		
		$params = array(
			'pageName' => $_REQUEST['pageName'],
			'active' => $_REQUEST['active'],
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {

            return false;
        }
		
        // save changes of user to db
        Affiliate_Merchants_Bl_Pages::updatePage($_REQUEST['eid'], $params);
		if($_POST['createNewVersion'] == "true"){
			$label = Affiliate_Merchants_Bl_Pages::getSiteLabel($_REQUEST['pageDetailVersion']);
    	}
		$temp = explode(".", $_REQUEST['pageLink']);
		if(is_array($temp)){
			$_REQUEST['pageLink'] = $temp[0];	
		}
		
		$params = array(
			'pageIntroDescription' => $_REQUEST['pageIntroDescription'],
			'pageDescription' => $_REQUEST['pageDescription'],
			'pageMeta' => $_REQUEST['pageMeta'],
			'pageTitle' => $_REQUEST['pageTitle'],
			'pageHeaderImage' => $_REQUEST['pageHeaderImage'],
			'pageLearnMore' => $_REQUEST['pageLearnMore'],
			'pageSpecialOfferImageAltText' => $_REQUEST['pageSpecialOfferImageAltText'],
			'pageSpecialOfferImage' => $_REQUEST['pageSpecialOfferImage'],
			'pageSpecialOfferLink' => $_REQUEST['pageSpecialOfferLink'],
			'pageHeaderImageAltText' => $_REQUEST['pageHeaderImageAltText'],
			'pageSmallImage' => $_REQUEST['pageSmallImage'],
			'pageSmallImageAltText' => $_REQUEST['pageSmallImageAltText'],
			'pageDetailVersion' => $_REQUEST['pageDetailVersion'],
			'fid' => $_REQUEST['fid'],
			'pageLink' => $_REQUEST['pageLink'],
			'pageHeaderString' => $_REQUEST['pageHeaderString'],
			'primaryNavString' => $_REQUEST['primaryNavString'],
			'secondaryNavString' => $_REQUEST['secondaryNavString'],
			'flagTopPick' => $_REQUEST['flagTopPick'],
			'topPickAltText' => $_REQUEST['topPickAltText'],
			'pageDisclaimer' => $_REQUEST['pageDisclaimer'],
			'pageSeeAlso' => $_REQUEST['pageSeeAlso'],
			'siteMapTitle' => $_REQUEST['siteMapTitle'],
			'siteMapDescription' => $_REQUEST['siteMapDescription'],			
			
		);   
		Affiliate_Merchants_Bl_Pages::updateVersion($_REQUEST['eid'], $params);
		QUnit_Messager::setOkMessage("Page Successfully Updated");

		
              
        return false;
    }
	
    function processCreatePage()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		//$_REQUEST['pageName'] = preg_replace('/[\'\"]/', '', $_REQUEST['categoryName']);
		//checkCorrectness($_REQUEST['pageName'], $_REQUEST['pageName'], L_G_CATEGORYNAME, CHECK_EMPTYALLOWED);	
			
		$params = array(
			'pageName' => $_REQUEST['pageName'],
			'active' => $_REQUEST['active'],
			'type' => $_REQUEST['type'],
			
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
			
            return false;
        }		
		
        $pageid = Affiliate_Merchants_Bl_Pages::addPage($params);
        
        $temp = explode(".", $_REQUEST['pageLink']);
		if(is_array($temp)){
			$_REQUEST['pageLink'] = $temp[0];	
		}
        
        $params = array(        
			'cardPageId' => $pageid,
			'pageDescription' => $_REQUEST['pageDescription'],			
			'pageDetailVersion' => '-1',
			'pageIntroDescription' => $_REQUEST['pageIntroDescription'],
			'pageMeta' => $_REQUEST['pageMeta'],
			'pageTitle' => $_REQUEST['pageTitle'],
			'pageHeaderImage' => $_REQUEST['pageHeaderImage'],
			'pageLearnMore' => $_REQUEST['pageLearnMore'],
			'pageSpecialOfferImageAltText' => $_REQUEST['pageSpecialOfferImageAltText'],
			'pageSpecialOfferImage' => $_REQUEST['pageSpecialOfferImage'],
			'pageSpecialOfferLink' => $_REQUEST['pageSpecialOfferLink'],
			'pageHeaderImageAltText' => $_REQUEST['pageHeaderImageAltText'],
			'pageSmallImage' => $_REQUEST['pageSmallImage'],
			'pageSmallImageAltText' => $_REQUEST['pageSmallImageAltText'],
			'fid' => $_REQUEST['fid'],
			'pageLink' => $_REQUEST['pageLink'],
			'pageHeaderString' => $_REQUEST['pageHeaderString'],
			'primaryNavString' => $_REQUEST['primaryNavString'],
			'secondaryNavString' => $_REQUEST['secondaryNavString'],
			'flagTopPick' => $_REQUEST['flagTopPick'],
			'topPickAltText' => $_REQUEST['topPickAltText'],
			'pageDetailLabel' => "Default",
			'pageDisclaimer' => $_REQUEST['pageDisclaimer'],
			'pageSeeAlso' => $_REQUEST['pageSeeAlso'],
			'siteMapTitle' => $_REQUEST['siteMapTitle'],
			'siteMapDescription' => $_REQUEST['siteMapDescription'],
			
		);
		
		Affiliate_Merchants_Bl_Pages::addVersion($params);
		
		QUnit_Messager::setOkMessage("Page Successfully Created");
		

              
        return false;
    }
    
    function processCreateVersion()
    {   
        $label = Affiliate_Merchants_Bl_Pages::getSiteLabel($_REQUEST['version']);
        
        $temp = explode(".", $_REQUEST['pageLink']);
		if(is_array($temp)){
			$_REQUEST['pageLink'] = $temp[0];	
		}
        
        $params = array(        
			'cardPageId' => $_REQUEST['eid'],
			'pageDetailVersion' => $_REQUEST['version'],
			'pageIntroDescription' => $_REQUEST['pageIntroDescription'],
			'pageMeta' => $_REQUEST['pageMeta'],
			'pageTitle' => $_REQUEST['pageTitle'],
			'pageHeaderImage' => $_REQUEST['pageHeaderImage'],
			'pageLearnMore' => $_REQUEST['pageLearnMore'],
			'pageSpecialOfferImageAltText' => $_REQUEST['pageSpecialOfferImageAltText'],
			'pageSpecialOfferImage' => $_REQUEST['pageSpecialOfferImage'],
			'pageSpecialOfferLink' => $_REQUEST['pageSpecialOfferLink'],			
			'pageHeaderImageAltText' => $_REQUEST['pageHeaderImageAltText'],
			'pageSmallImage' => $_REQUEST['pageSmallImage'],
			'pageSmallImageAltText' => $_REQUEST['pageSmallImageAltText'],
			'pageDetailLabel'=> $label,
			'fid' => $_REQUEST['fid'],
			'pageLink' => $_REQUEST['pageLink'],
			'pageHeaderString' => $_REQUEST['pageHeaderString'],
			'primaryNavString' => $_REQUEST['primaryNavString'],
			'secondaryNavString' => $_REQUEST['secondaryNavString'],
			'flagTopPick' => $_REQUEST['flagTopPick'],
			'topPickAltText' => $_REQUEST['topPickAltText'],
			'pageDisclaimer' => $_REQUEST['pageDisclaimer'],
			'pageSeeAlso' => $_REQUEST['pageSeeAlso'],
			'siteMapTitle' => $_REQUEST['siteMapTitle'],
			'siteMapDescription' => $_REQUEST['siteMapDescription'],
		);
		
		Affiliate_Merchants_Bl_Pages::addVersion($params);
		
		QUnit_Messager::setOkMessage("Version Successfully Created");
              
        return false;
    }     
    
	function getVersions($pageId){
		$sql = "SELECT * FROM rt_pagedetails WHERE cardpageId = " . _q($pageId) . " AND deleted != 1 ORDER BY pageDetailLabel ASC";
		//echo $sql;
		return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}	
    
    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
    
		Affiliate_Merchants_Bl_Pages::deletePages($sqlEIDs);
      
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

        $this->addContent('pages_list');        
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
        $sql = 'select count(*) as count from rt_cardpages ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //------------------------------------------------
        // get records
        $sql = "select * from rt_cardpages";
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
			//'categoryId' =>	array(L_G_CATEGORYID, 'categoryId'),
			'pageName' => 		array(L_G_PAGENAME, 'pageName'),
			//'pageId' =>		array(L_G_PAGEID, 'pageId'),
			'dateCreated' =>	array(L_G_DATEINSERTED, 'dateCreated'),
			'dateUpdated' =>	array(L_G_DATEUPDATED, 'dateUpdated'),
            'active' =>         array(L_G_ACTIVE, 'active'),
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
            $orderby = " order by pageName ASC";
        }
		
		$where = " WHERE deleted != 1 ";
		
		if($_REQUEST['type'] == 1)
			$where .= " AND type = 1";
		else
			$where .= " AND type = 0";

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
		
        
		print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['cardpageId'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
				case 'pageName': print '<td class=listresult align=right nowrap>&nbsp;' . $row['pageName'] . '&nbsp;</td>';
                        break;
				case 'dateCreated': print '<td class=listresult align=right nowrap>&nbsp;'. $row['dateCreated'] . '&nbsp;</td>';
                        break;
				case 'dateUpdated': print '<td class=listresult align=right nowrap>&nbsp;'. $row['dateUpdated'] . '&nbsp;</td>';
                        break;
				case 'pageName': print '<td class=listresult align=right nowrap>&nbsp;'. $row['categoryName'] . '&nbsp;</td>';
                        break;
				case 'active': if($row['active'] == 1)
									$active = "ACTIVE";
								else
									$active = "NOT ACTIVE";
						print '<td class=listresult align=right nowrap>&nbsp;'.$active.'&nbsp;</td>';
                        break;
				case 'cardpageId': print '<td class=listresult align=right nowrap>&nbsp;'. $row['categoryId'] . '&nbsp;</td>';
                        break;																																																	
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                 <? if($_REQUEST['type'] == 0) { ?>
                                 <option value="javascript:manageCards('<?=$row['cardpageId']?>', '<?=$row['type']?>');">Assign / Order Cards</a>
                                 <? } ?>
                                 <? if($_REQUEST['type'] == 1) { ?>
                                 <option value="javascript:manageCards('<?=$row['cardpageId']?>', '<?=$row['type']?>');">Assign / Order Articles</a>
                                 <? } ?>                                
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editSite('<?=$row['cardpageId']?>', '<?=$row['type']?>');"><?=L_G_EDIT?></a>
                                <? } ?>
                       
                                <?if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:deleteSite('<?=$row['cardpageId']?>', '<?=$row['type']?>');"><?=L_G_DELETE?></a>
                                <? } ?>
				                <?if($row['active'] == 1) { ?>
                                     <option value="javascript:deactivateSite('<?=$row['cardpageId']?>', '<?=$row['type']?>');"><?=L_G_DEACTIVATE?></a>
                                <? }else if($row['active'] == 0) { ?>
                                     <option value="javascript:activateSite('<?=$row['cardpageId']?>', '<?=$row['type']?>');"><?=L_G_ACTIVATE?></a>
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
    
    
    function loadPageInfo(){
       $eid = preg_replace('/[\'\"]/', '', $_REQUEST['eid']);

		$rs = Affiliate_Merchants_Bl_Pages::getPage($eid, -1);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
        
        $_POST['cardpageId'] = $rs->fields['cardpageId'];
        $_POST['pageName'] = $rs->fields['pageName'];
        
            	
    }
    function loadDetailInfo($versionId = -1)
    {
        $eid = preg_replace('/[\'\"]/', '', $_REQUEST['eid']);

		$rs = Affiliate_Merchants_Bl_Pages::getPage($eid, $versionId);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }


		$_POST['pageDescription'] =  $rs->fields['pageDescription'];
        $_POST['dateInserted'] = $rs->fields['dateInserted'];
		$_POST['active'] = $rs->fields['active'];
		$_POST['pageIntroDescription'] = $rs->fields['pageIntroDescription'];
		$_POST['pageMeta'] = $rs->fields['pageMeta'];
		$_POST['pageTitle'] = $rs->fields['pageTitle'];
		$_POST['pageHeaderImage'] = $rs->fields['pageHeaderImage'];
		$_POST['pageLearnMore'] = $rs->fields['pageLearnMore'];
		$_POST['pageSpecialOfferImageAltText'] = $rs->fields['pageSpecialOfferImageAltText'];
		$_POST['pageSpecialOfferImage'] = $rs->fields['pageSpecialOfferImage'];
		$_POST['pageSpecialOfferLink'] = $rs->fields['pageSpecialOfferLink'];
		$_POST['pageHeaderImageAltText'] = $rs->fields['pageHeaderImageAltText'];
		$_POST['pageSmallImage'] = $rs->fields['pageSmallImage'];
		$_POST['pageSmallImageAltText'] = $rs->fields['pageSmallImageAltText'];
		$_POST['pageDetailVersion'] = $rs->fields['pageDetailVersion'];
		$_POST['pageDetailLabel'] = $rs->fields['pageDetailLabel'];
		$_POST['fid'] = $rs->fields['fid'];
		$_POST['pageLink'] = $rs->fields['pageLink'];		
		$_POST['pageHeaderString'] = $rs->fields['pageHeaderString'];	
		$_POST['primaryNavString'] = $rs->fields['primaryNavString'];	
		$_POST['secondaryNavString'] = $rs->fields['secondaryNavString'];	
		$_POST['flagTopPick'] = $rs->fields['flagTopPick'];	
		$_POST['topPickAltText'] = $rs->fields['topPickAltText'];
		$_POST['pageDisclaimer'] = $rs->fields['pageDisclaimer'];
		$_POST['pageSeeAlso'] = $rs->fields['pageSeeAlso'];
		$_POST['siteMapDescription'] = $rs->fields['siteMapDescription'];
		$_POST['siteMapTitle'] = $rs->fields['siteMapTitle'];
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
