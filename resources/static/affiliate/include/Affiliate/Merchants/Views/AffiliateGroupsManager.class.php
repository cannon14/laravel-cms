<?
//============================================================================
// RAPIDO TECHNOLOGIES ADDITION
//============================================================================

QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Affiliates_Bl_Settings');
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_AffiliateGroups');
class Affiliate_Merchants_Views_AffiliateGroupsManager extends QUnit_UI_ListPage
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
        if(($groupIDs = $this->returnGIDs()) == false)
            return false;
            
        $params = array();
        $params['groupids'] = $groupIDs;
        
        Affiliate_Merchants_Bl_AffiliateGroups::delete($params);
        $this->getTreeView();
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
        
		$params['groupname'] = $_REQUEST['groupname'];
        $params['parent'] = $_REQUEST['parent'];
		$params['gid'] = $_REQUEST['gid'];
        
		
		
        $protectedParams = Affiliate_Merchants_Bl_AffiliateGroups::checkData($params);

        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            if(Affiliate_Merchants_Bl_AffiliateGroups::update($protectedParams))
                QUnit_Messager::setOkMessage(L_G_AFFILIATEGROUPEDITED);

            $this->closeWindow('Affiliate_Merchants_Views_AffiliateGroupsManager');
            $this->addContent('closewindow');

            return true;
        }
    }
	
	function processAddMemebers(){
        $params = array();

		$params['gid'] = $_REQUEST['gid'];
		$params['affiliateids'] = $_REQUEST['assignedAffiliates'];

		Affiliate_Merchants_Bl_AffiliateGroups::addMembers($params);
		
        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
                QUnit_Messager::setOkMessage('Memebership changes successfully committed.');

            $this->closeWindow('Affiliate_Merchants_Views_AffiliateGroupsManager');
            $this->addContent('closewindow');

            return true;
        }
	}

    //--------------------------------------------------------------------------
  
    function processAddGroup()
    {
        $params = array();
        $params['type'] = 'add';
        $params['groupname'] = $_REQUEST['groupname'];
        $params['groupparentid'] = $_REQUEST['parent'];
		//echo $params['groupparentid'];
		$protectedParams = Affiliate_Merchants_Bl_AffiliateGroups::checkData($params);

        if(QUnit_Messager::getErrorMessage() != '')
        {
            return false;
        }
        else
        {
            if(Affiliate_Merchants_Bl_AffiliateGroups::insert($protectedParams))
                QUnit_Messager::setOkMessage(L_G_AFFILIATEGROUPADDED);
            
            $this->closeWindow('Affiliate_Merchants_Views_AffiliateGroupsManager');
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
        
        $GroupData = $this->getRecords($orderby, $where, $transdata, $userInfo);
        
        $this->initViews();
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($GroupData);
        $this->assign('a_list_data', $list_data);

        $this->pageLimitsAssign();

        $this->addContent('affgroups_list');
    }
    //--------------------------------------------------------------------------

    function getRecords($orderby, $where, $transdata, $userInfo)
    {
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from wd_g_affiliategroups a';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        //------------------------------------------------
        // get records
        $sql = 'select a.*, '.sqlShortDate('a.dateinserted').' as joined from wd_g_affiliategroups a ';
        
		//echo $sql.$where.$orderby . "<br><br><br>";
		
		$rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $GroupData = array();

        // prepare the data
        while(!$rs->EOF)
        {
            $GroupData[$rs->fields['groupid']]['groupid'] = $rs->fields['groupid'];
            $GroupData[$rs->fields['groupid']]['name'] = $rs->fields['name'];
            $GroupData[$rs->fields['groupid']]['joined'] = $rs->fields['joined'];
			$GroupData[$rs->fields['groupid']]['parentgroupid'] = $rs->fields['parentgroupid'];
            $UserData[$rs->fields['userid']]['name'] = $rs->fields['name'];
            $UserData[$rs->fields['userid']]['surname'] = $rs->fields['surname'];
            $UserData[$rs->fields['userid']]['paid'] = $transdata[$rs->fields['userid']]['paid'];
            $UserData[$rs->fields['userid']]['pending'] = $transdata[$rs->fields['userid']]['pending'];
            $UserData[$rs->fields['userid']]['approved'] = $transdata[$rs->fields['userid']]['approved'];
            $UserData[$rs->fields['userid']]['reversed'] = $transdata[$rs->fields['userid']]['reversed'];      
            $UserData[$rs->fields['userid']]['parentuserid'] = $rs->fields['parentuserid'];
            $UserData[$rs->fields['userid']]['company_name'] = $rs->fields['company_name'];
            $UserData[$rs->fields['userid']]['weburl'] = $rs->fields['weburl'];
            $UserData[$rs->fields['userid']]['street'] = $rs->fields['street'];
            $UserData[$rs->fields['userid']]['city'] = $rs->fields['city'];
            $UserData[$rs->fields['userid']]['state'] = $rs->fields['state'];
            $UserData[$rs->fields['userid']]['country'] = $rs->fields['country'];
            $UserData[$rs->fields['userid']]['zipcode'] = $rs->fields['zipcode'];
            $UserData[$rs->fields['userid']]['phone'] = $rs->fields['phone'];
            $UserData[$rs->fields['userid']]['fax'] = $rs->fields['fax'];
            $UserData[$rs->fields['userid']]['tax_ssn'] = $rs->fields['tax_ssn'];
            $UserData[$rs->fields['userid']]['payoptid'] = $rs->fields['payoptid'];
            $UserData[$rs->fields['userid']]['actions'] = $rs->fields['actions'];

            if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $UserData[$rs->fields['userid']]['rstatus'] = L_G_SUPPRESSED;

            $rs->MoveNext();      
        }
        
        // fill parent affiliate name, fill payout option name
        $UserDataShort = QCore_Bl_Users::getUsersShort($GLOBALS['Auth']->getAccountID());
        $PayOpt = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID());

        if(is_array($UserData))
        {
            foreach($UserData as $user)
            {
                if($user['parentuserid'] == '' || $user['parentuserid'] == '0')
                    $UserData[$user['userid']]['parentuserid'] = L_G_NONE2;
                else
                    $UserData[$user['userid']]['parentuserid'] .= ': '.$UserDataShort[$UserData[$user['userid']]['parentuserid']]['name'].' '.$UserDataShort[$UserData[$user['userid']]['parentuserid']]['surname'];

                if($user['payoptid'] == '' || $user['payoptid'] == '0')
                    $UserData[$user['userid']]['payoptid'] = L_G_NONE2;
                else
                {
                    $UserData[$user['userid']]['payoptid'] = 
                            (defined($PayOpt[$UserData[$user['userid']]['payoptid']]['langid']) ? 
                            constant($PayOpt[$UserData[$user['userid']]['payoptid']]['langid']) : 
                            $PayOpt[$UserData[$user['userid']]['payoptid']]['name']);
                }
            }
        }

        //------------------------------------------------
        // get other user's data
        //$UserData = $this->getOtherUserData($UserData);

        if($_REQUEST['sortby'] != '' &&  in_array($_REQUEST['sortby'], array('paid', 'pending', 'approved', 'reversed')))
        {
            if($_REQUEST['sortorder'] == '' || !in_array($_REQUEST['sortorder'], array('asc','desc')))
                $_REQUEST['sortorder'] = 'asc';

            $GLOBALS['uasort_by'] = $_REQUEST['sortby'];
            $GLOBALS['uasort_order'] = $_REQUEST['sortorder'];

            uasort($UserData, 'cmp_sort');
        }
        
        return $GroupData;
    }

    function showAssigned()
    {
        $orderby = '';

        $a = array('a.userid', 'a.name', 'a.surname', 'camp_name',
                   'c.dateinserted', 'ac.rstatus');

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder']; 
        else
            $orderby = ' order by a.username'; 

        $where = ' where a.accountid='._q($GLOBALS['Auth']->getAccountID()).
                 '   and a.userid=ac.affiliateid'.
                 '   and ac.campaignid=c.campaignid'.
                 '   and a.rstatus='._q(AFFSTATUS_APPROVED);

        $params = array('where' => $where);

        $camp_cats = Affiliate_Merchants_Bl_AffiliateCampaigns::getCampCats($params);

        if($camp_cats == false) return false;

        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'aa_') === 0 && !isset($_REQUEST[$k]))
                $_REQUEST[$k] = $v;
        }
       
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['aa_status'] == '') $_REQUEST['aa_status'] = '_';
        if($_REQUEST['aa_prod_cat'] == '') $_REQUEST['aa_prod_cat'] = '_';
        
        //--------------------------------------
        // put settings into session
        $_SESSION['aa_prod_cat'] = $_REQUEST['aa_prod_cat'];
        $_SESSION['aa_status'] = $_REQUEST['aa_status'];

        if($_REQUEST['aa_status'] != '_')
            $where .= ' and ac.rstatus='._q($_REQUEST['aa_status']);
        if($_REQUEST['aa_prod_cat'] != '_')
            $where .= ' and c.campaignid='._q($_REQUEST['aa_prod_cat']);

        $sql = 'select a.userid, a.name, a.surname, c.name as camp_name '.
               '      ,c.dateinserted, ac.rstatus, ac.affcampid '.
               'from wd_g_users a, wd_pa_campaigns c, wd_pa_affiliatescampaigns ac';

        $rs = QCore_Sql_DBUnit::execute($sql.' '.$where.' '.$orderby, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($camp_cats);

        $this->assign('a_list_data', $list_data);

        $this->addContent('appl_aff_filter');

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($rs);

        $this->assign('a_list_data', $list_data);
        $this->assign('a_numrows', $rs->PO_RecordCount('wd_g_users a, wd_pa_campaigns c, wd_pa_affiliatescampaigns ac', $where));

        $this->addContent('appl_aff_show');
    }
	
	//--------------------------------------------------------------------------

    function drawFormAddGroupMembers()
    {

		
		$_POST['action'] = 'view';
		$_POST['postaction'] = 'addMemebers'; 
		
		$groupid = preg_replace('/[\'\"]/', '', $_REQUEST['gid']);
		
		$_POST['header'] = Affiliate_Merchants_Bl_AffiliateGroups::getGroupName($groupid) . ' -- Add/Remove Members';
		
		$_POST['gid'] = $groupid;

		$_POST['membersarray'] = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersAsArray($groupid);
		$_POST['nonmembersarray'] = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateNonMembersAsArray($_POST['membersarray']);
		
		$this->addContent('group_addaffiliates');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormEditGroup()
    {
        if($_POST['commited'] != 'yes')
        {
            $this->loadGroupInfo();
        }

        $_POST['header'] = L_G_EDITAFFILIATEGROUP;
		$_POST['gid'] = $_REQUEST['gid'];
        $_POST['action'] = 'edit';
        $_POST['postaction'] = 'editGroup';  

        $this->drawFormAddGroup();

        return true;
    }
  
    //--------------------------------------------------------------------------

    function drawFormAddGroup()
    {
        $_POST['parentarray'] = Affiliate_Merchants_Bl_AffiliateGroups::getParentSelector($_REQUEST['gid']);
		if(!isset($_POST['action']))
            $_POST['action'] = 'add';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'addGroup';  
        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADDAFFILIATEGROUP;

        $this->addContent('group_edit');

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
            'groupid' =>         	array("Group ID", 'a.groupid'),
            'name' =>       		array("Name", 'a.name'),
            'dateinserted' =>   	array(L_G_JOINED, 'a.dateinserted'),
            'parentgroupid' =>   	array("Group Parent", 'a.parentgroupid'),
			'actions' =>            array(L_G_ACTIONS, ''),
        );
    }
    
    //--------------------------------------------------------------------------
    
	function getTreeView(){
		$_POST['treeview'] = Affiliate_Merchants_Bl_AffiliateGroups::getTreeView();
	}
	
	//--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'affgroup_list';
    }
    
    //--------------------------------------------------------------------------

    function initViews()
    {
        // create default view
        $viewColumns = array(
            'name',
			'groupid',
            'dateinserted',
            'parentgroupid',
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
            'a.name',
            'a.dateinserted', 
            'a.groupid',
            'a.parentgroupid'
        );

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a)) {
            $orderby = ' order by '.$_REQUEST['sortby'].' '.$_REQUEST['sortorder'];
        }
        else {
            $orderby = ' order by a.dateinserted desc'; 
        }
        
        $where = ' where a.deleted=0 ';
        //         '   and a.rtype='._q(USERTYPE_USER).
        //         '   and accountid='._q($GLOBALS['Auth']->getAccountID());

        if($_REQUEST['fromprofile'] == 1)
        {
            // it is called from profile
            $_REQUEST['filtered'] = 1;
            $_REQUEST['um_name'] = '';
            $_REQUEST['um_surname'] = '';
            $_REQUEST['um_aid'] = '';
            $_REQUEST['um_status'] = $_REQUEST['umprof_status'];
            if($_REQUEST['um_status'] == '') $_REQUEST['um_status'] = '_';
            
        }
        else
        {
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
            $_SESSION['um_name'] = $_REQUEST['um_name'];
            $_SESSION['um_surname'] = $_REQUEST['um_surname'];
            $_SESSION['um_aid'] = $_REQUEST['um_aid'];
            $_SESSION['um_status'] = $_REQUEST['um_status'];
        }
        
        $name = preg_replace('/[\'\"]/', '', $_REQUEST['um_name']);
        $surname = preg_replace('/[\'\"]/', '', $_REQUEST['um_surname']);
        $aid = preg_replace('/[\'\"]/', '', $_REQUEST['um_aid']);
        $status = preg_replace('/[^0-9]/', '', $_REQUEST['um_status']);
        
        if($name != '')
        {
            $where .= ' and (a.name like \'%'._q_noendtags($name).'%\')';
        }
        
        if($gid != '')
        {
            $where .= ' and (a.groupid like \'%'._q_noendtags($aid).'%\')';
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
        
        print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['groupid'].'"></td>';
        
        foreach($view->columns as $column)
        {

            switch($column)
            {
                case 'name': print '<td class=listresult nowrap>&nbsp;'.$row['name'].'&nbsp;</td>';
                        break;
				
				case 'groupid': print '<td class=listresult>&nbsp;'.$row['groupid'].'&nbsp;</td>';
                        break;
                
                case 'dateinserted': print '<td class=listresult nowrap>&nbsp;'.$row['joined'].'&nbsp;</td>';
                        break;
                        
                case 'parentgroupid': print '<td class=listresult nowrap>&nbsp;'.$row['parentgroupid'].'&nbsp;</td>';
                        break;
                
                case 'actions':
?>                
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:addMembers('<?=$row['groupid']?>');">Assign Affiliates</option>
                                <? } ?>
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editGroup('<?=$row['groupid']?>');"><?=L_G_EDIT?></option>
                                <? } ?>
                     			<? if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:Delete('<?=$row['groupid']?>');"><?=L_G_DELETE?></option>
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
		Affiliate_Merchants_Bl_AffiliateGroups::loadGroupInfoToPost($groupid);
	}


}  
?>
