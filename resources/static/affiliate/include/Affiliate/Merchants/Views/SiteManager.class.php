<?
//============================================================================
// Patrick J. Mizer
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Sites');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Pages');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Cards');
if (isset($_REQUEST['layout'])) QUnit_Global::includeClass('crm_layouts_'.$_REQUEST['layout']);

class Affiliate_Merchants_Views_SiteManager extends QUnit_UI_ListPage
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
                    if($this->processUpdateSite())
                        return;
                    break;
					
				case 'create':
                    if($this->processCreateSite())
                        return;
                    break;				
            }
        }
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {             
                
                case 'edit':
					$this->loadSiteInfo();
                    if($this->drawFormEditSite())
                        return;
                    break;
				case 'create':
                    if($this->drawFormCreateSite())
                        return;
                    break;
                case 'build':
                    if($this->processBuild())
                        return;
                    break;										
                case 'delete':
                    if($this->processDelete())
                        return;
                    break;
				case 'up':
				    if($this->processUp())
                        return;
                    break;	
				case 'down':
				    if($this->processDown())
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
	
	function processBuild(){
		$id = $_REQUEST['eid'];
		$constr = "crm_layouts_".$_REQUEST['layout'];
		$build = new $constr($id);	
		$build->_buildSite();
	}
	
	function processActivate($value){
		$id = $_REQUEST['eid'];
		$sql = "UPDATE rt_sites set active = " . _q($value) . " where siteId=" . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return false;
	}

	function drawFormEditSite(){
		
		$this->addContent('site_edit');
		return true;
	}
	function drawFormCreateSite(){
		
		$this->addContent('site_create');
		return true;
	}
	

    //--------------------------------------------------------------------------        
    
    function processUpdateSite()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
		
		$_REQUEST['siteTitle'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteTitle']);
		$_REQUEST['siteName'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteName']);
		$_REQUEST['layout'] = preg_replace('/[\'\"]/', '', $_REQUEST['layout']);
		$_REQUEST['publishPath'] = preg_replace('/[\'\"]/', '', $_REQUEST['publishPath']);
		$_REQUEST['hostname'] = preg_replace('/[\'\"]/', '', $_REQUEST['hostname']);
		$_REQUEST['siteDescription'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteDescription']);
		$_REQUEST['applyLogo'] = preg_replace('/[\'\"]/', '', $_REQUEST['applyLogo']);
		$_REQUEST['ftpSite'] = preg_replace('/[\'\"]/', '', $_REQUEST['ftpSite']);		
			
		checkCorrectness($_REQUEST['siteName'], $_REQUEST['siteName'], L_G_SITENAME, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['siteTitle'], $_REQUEST['siteTitle'], L_G_SITETITLE, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['layout'], $_REQUEST['layout'], L_G_LAYOUT, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['publishPath'], $_REQUEST['publishPath'], L_G_SITETITLE, CHECK_EMPTYALLOWED);		
		checkCorrectness($_REQUEST['hostname'], $_REQUEST['hostname'], L_G_HOSTNAME, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['applyLogo'], $_REQUEST['applyLogo'], L_G_APPLYLOGO, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['ftpSite'], $_REQUEST['ftpSite'], L_G_FTPSITE, CHECK_EMPTYALLOWED);	
			
		$params = array(
			'siteName' => $_REQUEST['siteName'],
			'siteDescription' => $_REQUEST['siteDescription'],
			'layout' => $_REQUEST['layout'],
			'publishPath' => $_REQUEST['publishPath'],
			'active' => $_REQUEST['active'],
			'siteTitle' => $_REQUEST['siteTitle'],
			'hostname' => $_REQUEST['hostname'],
			'ftpSite' => $_REQUEST['ftpSite'],
			'applyLogo' => $_REQUEST['applyLogo'],
			
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
			$this->closeWindow('Affiliate_Merchants_Views_SiteManager');
            return false;
        }		
		
        Affiliate_Merchants_Bl_Sites::updateSite($_REQUEST['eid'], $params);
                
		QUnit_Messager::setOkMessage("Site Successfully Updated");
		$this->closeWindow('Affiliate_Merchants_Views_SiteManager');
              
        return false;
    }
	
    function processCreateSite()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		$_REQUEST['siteTitle'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteTitle']);
		$_REQUEST['siteName'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteName']);
		$_REQUEST['layout'] = preg_replace('/[\'\"]/', '', $_REQUEST['layout']);
		$_REQUEST['publishPath'] = preg_replace('/[\'\"]/', '', $_REQUEST['publishPath']);
		$_REQUEST['hostname'] = preg_replace('/[\'\"]/', '', $_REQUEST['hostname']);
		$_REQUEST['siteDescription'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteDescription']);
		$_REQUEST['applyLogo'] = preg_replace('/[\'\"]/', '', $_REQUEST['applyLogo']);
		$_REQUEST['ftpSite'] = preg_replace('/[\'\"]/', '', $_REQUEST['ftpSite']);
			
				
		checkCorrectness($_REQUEST['siteName'], $_REQUEST['siteName'], L_G_SITENAME, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['siteTitle'], $_REQUEST['siteTitle'], L_G_SITETITLE, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['layout'], $_REQUEST['layout'], L_G_LAYOUT, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['publishPath'], $_REQUEST['publishPath'], L_G_SITETITLE, CHECK_EMPTYALLOWED);		
		checkCorrectness($_REQUEST['hostname'], $_REQUEST['hostname'], L_G_HOSTNAME, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['applyLogo'], $_REQUEST['applyLogo'], L_G_APPLYLOGO, CHECK_EMPTYALLOWED);	
		checkCorrectness($_REQUEST['ftpSite'], $_REQUEST['ftpSite'], L_G_FTPSITE, CHECK_EMPTYALLOWED);	
		
		$params = array(
			'siteTitle' => $_REQUEST['siteTitle'],
			'siteName' => $_REQUEST['siteName'],
			'layout' => $_REQUEST['layout'],
			'publishPath' => $_REQUEST['publishPath'],
			'hostname' => $_REQUEST['hostname'],
			'active' => $_REQUEST['active'],
			'siteDescription' => $_REQUEST['siteDescription'],
			'applyLogo' => $_REQUEST['applyLogo'],
			'ftpSite' => $_REQUEST['ftpSite'],
		);
		
        
        if(QUnit_Messager::getErrorMessage() != '')
        {

            return false;
        }		
		
        // save changes of user to db
        Affiliate_Merchants_Bl_Sites::addSite($params);
                
		QUnit_Messager::setOkMessage("Site Successfully Created");


              
        return false;
    } 	  
    
    
    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
        
		Affiliate_Merchants_Bl_Sites::deleteSites($sqlEIDs);  
		   
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

        $this->addContent('sites_list');        
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
        $sql = 'select count(*) as count from rt_sites ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));
        
        //------------------------------------------------
        // get records
        $sql = "select * from rt_sites";
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
			//'order' =>         array(L_G_ORDER, 'affiliateid'),
			//'siteId' =>		array(L_G_SITEID, 'siteId'),
			'siteName' =>            array(L_G_SITENAME, 'siteName'),
            'siteTitle' =>         array(L_G_SITETITLE, 'siteTitle'),
            //'siteDescription' =>         array(L_G_SITEDESCRIPTION, 'siteDescription'),
            'applyLogo' =>         array(L_G_APPLYLOGO, 'applyLogo'),
			'layout' =>         array(L_G_LAYOUT, 'endexpensedate'),
			'ftpSite' =>         array(L_G_FTPSITE, 'ftpSite'),
            'publishPath' =>         array(L_G_PUBLISHPATH, 'totalexpense'),
            'hostname' =>         array(L_G_HOSTNAME, 'bannerid'),
            'dateCreated' =>         array(L_G_DATEINSERTED, 'campcategoryid'),
			'dateLastBuilt' =>         array(L_G_DATELASTBUILT, 'dateLastBuilt'),
            'dateUpdated' =>         array(L_G_DATEUPDATED, 'channel'),
            'active' =>         array(L_G_ACTIVE, 'active'),
			'actions' =>           array(L_G_ACTIONS, ''),
        );
    }
    
    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'sites_list';
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
            $orderby = " order by siteName ASC";
        }
		
		$where = " WHERE deleted != 1 ";

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
		$arrowString = '&nbsp;<a href=index.php?md=Affiliate_Merchants_Views_SiteManager&action=up&order=' . $row['order'].  '&id=' . $row['siteId']. '><img src="../templates/standard/images/sort_up.gif"></a>&nbsp;&nbsp; ' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_Merchants_Views_SiteManager&action=down&order=' . $row['order']. '&id=' . $row['siteId']. '><img src="../templates/standard/images/sort_down.gif"></a>';
		if($row['order'] == 1)
			$arrowString = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_Merchants_Views_SiteManager&action=down&order=' . $row['order'].  '&id=' . $row['siteId']. '><img src="../templates/standard/images/sort_down.gif"></a>';
		
        
		print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['siteId'].'"></td>';
        
        foreach($view->columns as $column)
        {
            switch($column)
            {
				case 'order': print '<td class=listresult align=right nowrap>' . $arrowString . '</td>';
                        break;
				case 'dateCreated': print '<td class=listresult align=right nowrap>&nbsp;'. $row['dateCreated'] .'&nbsp;</td>';
                        break;
				case 'dateLastBuilt': print '<td class=listresult align=right nowrap>&nbsp;'. $row['dateLastBuilt'] .'&nbsp;</td>';
                        break;		
				case 'ftpSite': print '<td class=listresult align=right nowrap>&nbsp;'. $row['ftpSite'] .'&nbsp;</td>';
                        break;
				case 'applyLogo': print '<td class=listresult align=right nowrap>&nbsp;'. $row['applyLogo'] .'&nbsp;</td>';
                        break;												
                case 'dateUpdated': print '<td class=listresult align=right nowrap>&nbsp;'. $row['dateUpdated'] . '&nbsp;</td>';
                        break;						
				case 'siteId': print '<td class=listresult align=right nowrap>&nbsp;'.$row['siteId'].'&nbsp;</td>';
                        break;
				case 'siteName': print '<td class=listresult align=right nowrap>&nbsp;'.$row['siteName'].'&nbsp;</td>';
                        break;
				case 'siteTitle': print '<td class=listresult align=right nowrap>&nbsp;'.$row['siteTitle'].'&nbsp;</td>';
                        break;	
				case 'siteDescription': print '<td class=listresult align=right nowrap>&nbsp;'.$row['siteDescription'].'&nbsp;</td>';
                        break;		
				case 'layout': print '<td class=listresult align=right nowrap>&nbsp;'.$row['layout'].'&nbsp;</td>';
                        break;
				case 'publishPath': print '<td class=listresult align=right nowrap>&nbsp;'.$row['publishPath'].'&nbsp;</td>';
                        break;	
				case 'hostname': print '<td class=listresult align=right nowrap>&nbsp;'.$row['hostname'].'&nbsp;</td>';
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
                                <option value="-">----------------------</option>
                        
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editSite('<?=$row['siteId']?>');"><?=L_G_EDIT?></a>
                                <? } ?>
                       
                                <?if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:deleteSite('<?=$row['siteId']?>');"><?=L_G_DELETE?></a>
                                <? } ?>
				                <?if($row['active'] == 1) { ?>
                                     <option value="javascript:deactivateSite('<?=$row['siteId']?>');"><?=L_G_DEACTIVATE?></a>
                                <? }else if($row['active'] == 0) { ?>
                                     <option value="javascript:activateSite('<?=$row['siteId']?>');"><?=L_G_ACTIVATE?></a>
                                <? } ?>
				                <?if($row['layout'] != "") { ?>
									<option value="javascript:buildSite('<?=$row['siteId']?>','<?=$row['layout']?>');">Build</a>
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
    function loadSiteInfo()
    {
        $eid = preg_replace('/[\'\"]/', '', $_REQUEST['eid']);

		$rs = Affiliate_Merchants_Bl_Sites::getSite($eid);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

        
		$_POST['order'] = $rs->fields['order'];
		$_POST['siteId'] = $rs->fields['siteId'];
		$_POST['siteName'] = $rs->fields['siteName'];
        $_POST['siteTitle'] = $rs->fields['siteTitle'];
        $_POST['siteDescription'] = $rs->fields['siteDescription'];
		$_POST['layout'] = $rs->fields['layout'];
		$_POST['publishPath'] = $rs->fields['publishPath'];
		$_POST['hostname'] = $rs->fields['hostname'];
		$_POST['dateCreated'] = $rs->fields['dateCreated'];
		$_POST['dateUpdated'] = $rs->fields['dateUpdated'];
		$_POST['active'] = $rs->fields['active'];
		$_POST['ftpSite'] = $rs->fields['ftpSite'];
		$_POST['applyLogo'] = $rs->fields['applyLogo'];
		  
		
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
