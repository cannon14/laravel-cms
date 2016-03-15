<?
//============================================================================
// RAPIDO TECHNOLOGIES ADDITION
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Affiliates_Bl_Settings');
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CampaignRateGroups');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rate');

class Affiliate_Merchants_Views_CampaignRateGroupsManager extends QUnit_UI_ListPage
{
    function initPermissions()
    {
        $this->modulePermissions['delete'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['add'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['view'] = 'aff_aff_affiliates_view';
        $this->modulePermissions['edit'] = 'aff_aff_affiliates_modify';
        $this->modulePermissions['viewassigned'] = 'aff_aff_affiliates_modify';
    }

    //--------------------------------------------------------------------------

    function process()
    {
        $this->getTreeView();
        
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
            	case 'assignRate':
                    if($this->processAddGroupRate())
                        return;
                break;
            	
                case 'addGroup':
                    if($this->processAddGroup())
                        return;
                break;

                case 'editGroup':
                    if($this->processEditGroup())
                        return;
                break;
				
                case 'addMembers':
                    if($this->processAddMemebers())
                        return;
                break;				

            }
            
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
			
                case 'add':
                    if($this->drawFormAddGroup())
                        return;
                break;
				
				case 'addRate':
                    if($this->drawFormAddGroupRate())
                        return;
                break;
                
                case 'addMembers':
                    if($this->drawFormAddGroupMembers())
                        return;
                break;

                case 'edit':
                    if($this->drawFormEditGroup())
                        return;
                break;

                case 'delete':
                    if($this->processDelete())
                        return;
                break;
				
				case 'activate':
                    if($this->processActivate())
                        return;
                break;
            }
        }
    
        if($_REQUEST['action'] == 'viewAssign')
            $this->showGroups(true);
        else
            $this->showGroups(false);
    }
    


    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processDelete()
    {
        if(($ids = $this->returnGIDs()) == false)
            return false;
        
        Affiliate_Merchants_Bl_CampaignRateGroups::delete($ids);
        $this->getTreeView();
		return false;
    }

	//--------------------------------------------------------------------------

    function processActivate()
    {
        if(($ids = $this->returnGIDs()) == false)
            return false;
        
        Affiliate_Merchants_Bl_CampaignRateGroups::activate($ids);
        
		return false;
    }

	//--------------------------------------------------------------------------

    function returnGIDs()
    {
        if($_POST['massaction'] != '')
        {
            $groupIDs = $_POST['itemschecked'];
        }
        else
        {
            $groupIDs = array($_REQUEST['gid']);
        }
        
        return $groupIDs;
    }
	
    //--------------------------------------------------------------------------

    function processEditGroup()
    {
        $params = array();
        $params['type'] = 'edit';
        
		$params['group_name'] = $_REQUEST['group_name'];
        $params['description'] = $_REQUEST['description'];
		$params['campaign_rate_group_id'] = $_REQUEST['campaign_rate_group_id'];
		
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            if(Affiliate_Merchants_Bl_CampaignRateGroups::update($params))
                QUnit_Messager::setOkMessage("Change in Campaign Rate Group was successfully saved.");

            $this->closeWindow('Affiliate_Merchants_Views_CampaignRateGroupsManager');
            $this->addContent('closewindow');

            return true;
        }
    }

	function processAddMemebers()
	{
		$params = array();

		$params['gid'] = $_REQUEST['gid'];
		$params['campaign_ids'] = $_REQUEST['assignedCampaigns'];

		Affiliate_Merchants_Bl_CampaignRateGroups::addMembers($params);
		
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
        	QUnit_Messager::setOkMessage('Group changes successfully committed.');

            $this->closeWindow('Affiliate_Merchants_Views_CampaignRateGroupsManager');
            $this->addContent('closewindow');

            return true;
        }
	}
	
	function processAddGroupRate()
	{
		$params = array();

        $params['rate'] = $_REQUEST['rate'];
		$params['comment'] = $_REQUEST['comment'];
		$params['active'] = 1;
		
		//if no start date, set it to today
		if($_REQUEST['day1'] == '') $_REQUEST['day1'] = date("j");
        if($_REQUEST['month1'] == '') $_REQUEST['month1'] = date("n");
        if($_REQUEST['year1'] == '') $_REQUEST['year1'] = date("Y");
        
        $params['rate_start_date'] = $_REQUEST['year1']. "-" .$_REQUEST['month1']. "-" .$_REQUEST['day1'];
        
		if(($_REQUEST['day2'] > 0) && ($_REQUEST['month2'] > 0) && ($_REQUEST['year2'] > 0))
		{
			$_SESSION['day2'] = $_REQUEST['day2'];
	        $_SESSION['month2'] = $_REQUEST['month2'];
	        $_SESSION['year2'] = $_REQUEST['year2'];
			
			$params['rate_end_date'] = $_REQUEST['year2']. "-" .$_REQUEST['month2']. "-" .$_REQUEST['day2'];
		}else{
		
			$params['rate_end_date'] = '0000-00-00';
		}
		
		if($params['rate_end_date'] != '0000-00-00' && mktime(0, 0, 0, $_REQUEST['month1'], $_REQUEST['day1'], $_REQUEST['year1']) > mktime(0, 0, 0, $_REQUEST['month2'], $_REQUEST['day2'], $_REQUEST['year2']))
		{
        	QUnit_Messager::setErrorMessage('Your start date must be before your end date');
    		return false;
		}
		
		
		//get campaigns in group
		$campaigns = Affiliate_Merchants_Bl_CampaignRateGroups::getCampaignGroupMembersAsArray($_REQUEST['gid']);
		
		$errorFlag = false;
		
		foreach($campaigns as $id=>$name)
		{
			$params['campaign_id'] = $id;
			$rs = Affiliate_Merchants_Bl_Rate::insertRate($params);
			
			if (!$rs)
			{
	    		QUnit_Messager::setErrorMessage(L_G_DBERROR . ' Product: '. $name);
	    		$errorFlag = true;
			}
		}
		
		
		if ($errorFlag)
		{
    		return false;
    		
		} else {
        	QUnit_Messager::setOkMessage("Product rates successfully added.");
    		
    		$this->closeWindow('Affiliate_Merchants_Views_CampaignRateGroupsManager');
    		$this->addContent('tracking_closewindow');
    		return true;
		}
	}

    //--------------------------------------------------------------------------
  
    function processAddGroup()
    {
        $params = array();
        $params['group_name'] = $_REQUEST['group_name'];
        $params['description'] = $_REQUEST['description'];
        
        if(Affiliate_Merchants_Bl_CampaignRateGroups::checkGroupExists($_REQUEST['group_name']))
        {
        	QUnit_Messager::setErrorMessage("A group with that name already exists! Please select a new name or use the existing group.");
        	return false;
        }
        
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            if(Affiliate_Merchants_Bl_CampaignRateGroups::insert($params))
                QUnit_Messager::setOkMessage(L_G_CAMPAIGN_GROUP_ADDED);
            
            $this->closeWindow('Affiliate_Merchants_Views_CampaignRateGroupsManager');
            $this->addContent('closewindow');
        }

        return true;
    }
    

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================
    function showGroups($exportToCsv)
    {
        $temp_perm['add'] = $this->checkPermissions('add');
        $temp_perm['view'] = $this->checkPermissions('view');

        $this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy($orderby, $where);

        
        if($exportToCsv)
        {
            // prepare export file first
            //$this->prepareExportFile($orderby, $where, $transdata, $userInfo);
        }
        
        $GroupData = $this->getRecords($orderby, $where);
        
        $this->initViews();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($GroupData);
        $this->assign('a_list_data', $list_data);

        $this->pageLimitsAssign();

        $this->addContent('campaign_rate_groups_list');
    }
    //--------------------------------------------------------------------------

    function getRecords($orderby, $where)
    {
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from ' .TABLE_CAMPAIGN_RATE_GROUPS. ' cg ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        //------------------------------------------------
        // get records
        $sql = 'select * from ' .TABLE_CAMPAIGN_RATE_GROUPS. ' cg ';
        
		//echo $sql.$where.$orderby . "<br><br><br>";
		
		$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        return $rs;
    }
	
	//--------------------------------------------------------------------------

    function drawFormAddGroupMembers()
    {
		$_POST['action'] = 'view';
		$_POST['postaction'] = 'addMemebers'; 
		
		$groupid = preg_replace('/[\'\"]/', '', $_REQUEST['gid']);
		
		$_POST['header'] = Affiliate_Merchants_Bl_CampaignRateGroups::getGroupName($groupid) . ' -- Add/Remove Group Products';
		
		$_POST['gid'] = $groupid;

		$_POST['membersarray'] = Affiliate_Merchants_Bl_CampaignRateGroups::getCampaignGroupMembersAsArray($groupid);
		$_POST['nonmembersarray'] = Affiliate_Merchants_Bl_CampaignRateGroups::getCampaignGroupNonMembersAsArray();
		
		$this->addContent('campaign_rate_group_addcampaigns');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormEditGroup()
    {
        if($_POST['commited'] != 'yes')
        {
            $this->loadGroupInfo();
        }

        $_POST['header'] = "Edit Rate Group";
		$_POST['gid'] = $_REQUEST['gid'];
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'editGroup';  

        $this->drawFormAddGroup();

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormAddGroup()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'addGroup';  
        if(!isset($_POST['header']))
            $_POST['header'] = 'Add Rate Group';

        $this->addContent('campaign_rate_group_edit');

        return true;
    }
    
    //--------------------------------------------------------------------------

    function drawFormAddGroupRate()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'addRate';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'assignRate';  
        if(!isset($_POST['header']))
            $_POST['header'] = 'Assign Group Rate';
		
		$_POST['gid'] = $_REQUEST['gid'];
		
        $this->addContent('campaign_group_rate_edit');

        return true;
    }
	
    //==========================================================================
    // OTHER FUNCTIONS
    //==========================================================================

   //--------------------------------------------------------------------------
    
    /** returns list of columns in list view */
    function getAvailableColumns()
    {
        return array(
            'campaign_rate_group_id' =>		array("Group ID", 'cg.campaign_rate_group_id'),
            'group_name' =>       			array("Group Name", 'cg.group_name'),
            'insert_time' =>   				array("Created", 'cg.insert_time'),
            'description' =>   				array("Description", 'cg.description'),
			'deleted' =>            		array("Status", 'cg.deleted'),
			'actions' =>            		array(L_G_ACTIONS, ''),
        );
    }
    
    //--------------------------------------------------------------------------
    
	function getTreeView(){
		$_POST['treeview'] = Affiliate_Merchants_Bl_CampaignRateGroups::getTreeView();
	}
	
    //--------------------------------------------------------------------------
    
    function getListViewName()
    {
        return 'campaign_rate_group_list';
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {
        // create default view
        $viewColumns = array(
            'campaign_rate_group_id',
			'group_name',
            'insert_time',
            'description',
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
        $orderby = '';
        $where = '';
        
        $a = array( 
            'cg.campaign_rate_group_id',
			'cg.group_name',
            'cg.insert_time', 
            'cg.description',
            'cg.deleted'
        );

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a)) {
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        }
        else {
            $orderby = ' order by cg.insert_time desc'; 
        }
        
        $deleted = ( $_REQUEST['deleted']==-1 ? '1=1' : 'cg.deleted='._q($_REQUEST['deleted']) );
        $where = ' where ' . $deleted;


        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'um_') === 0 && !isset($_REQUEST[$k]))
            $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        if(empty($_REQUEST['numrows'])) $_REQUEST['numrows'] = 20;
        if($_REQUEST['um_status'] == '') $_REQUEST['um_status'] = '_';
        
        //--------------------------------------
        // put settings into session
        $_SESSION['numrows'] = $_REQUEST['numrows'];
        $_SESSION['deleted'] = $_REQUEST['deleted'];
        /*$_SESSION['um_name'] = $_REQUEST['um_name'];
        $_SESSION['um_surname'] = $_REQUEST['um_surname'];
        $_SESSION['um_aid'] = $_REQUEST['um_aid'];
        $_SESSION['um_status'] = $_REQUEST['um_status'];
        
        $name = preg_replace('/[\'\"]/', '', $_REQUEST['um_name']);
        $surname = preg_replace('/[\'\"]/', '', $_REQUEST['um_surname']);
        $aid = preg_replace('/[\'\"]/', '', $_REQUEST['um_aid']);
        $status = preg_replace('/[^0-9]/', '', $_REQUEST['um_status']);
        */
/*        
        if($name != '')
        {
            $where .= ' and (cg.name like \'%'._q_noendtags($name).'%\')';
        }
*/        
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
        
        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['campaign_rate_group_id'].'"></td>';
        
        foreach($view->columns as $column)
        {

            switch($column)
            {
                case 'campaign_rate_group_id': print '<td class=listresult nowrap>&nbsp;'.$row['campaign_rate_group_id'].'&nbsp;</td>';
                        break;
				
				case 'group_name': print '<td class=listresult>&nbsp;'.$row['group_name'].'&nbsp;</td>';
                        break;
                
                case 'insert_time': print '<td class=listresult nowrap>&nbsp;'.$row['insert_time'].'&nbsp;</td>';
                        break;
                        
                case 'description': print '<td class=listresult nowrap>&nbsp;'.$row['description'].'&nbsp;</td>';
                        break;
                        
				case 'deleted': print '<td class=listresult nowrap>&nbsp;'.($row['deleted']==0? 'Active' : 'Deleted').'&nbsp;</td>';
                        break;
                
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <? if(($this->checkPermissions('edit')) && ($row['deleted'] == 0)) { ?>
                                     <option value="javascript:addRate('<?=$row['campaign_rate_group_id']?>');">Assign Group Rate</option>
                                <? } ?>
                                <? if(($this->checkPermissions('edit')) && ($row['deleted'] == 0)) { ?>
                                     <option value="javascript:addMembers('<?=$row['campaign_rate_group_id']?>');">Manage Products</option>
                                <? } ?>
                                <? if(($this->checkPermissions('edit')) && ($row['deleted'] == 0)) { ?>
                                     <option value="javascript:editGroup('<?=$row['campaign_rate_group_id']?>');"><?=L_G_EDIT?></option>
                                <? } ?>
                     			<? if(($this->checkPermissions('edit')) && ($row['deleted'] == 1)) { ?>
                                     <option value="javascript:Activate('<?=$row['campaign_rate_group_id']?>');">Activate</option>
                                <? } ?>
                                <? if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:Delete('<?=$row['campaign_rate_group_id']?>');"><?=L_G_DELETE?></option>
                                <? } ?>
                         
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

	function loadGroupInfo()
    {
		$groupid = preg_replace('/[\'\"]/', '', $_REQUEST['gid']);
		Affiliate_Merchants_Bl_CampaignRateGroups::loadGroupInfoToPost($groupid);
	}

}  
?>
