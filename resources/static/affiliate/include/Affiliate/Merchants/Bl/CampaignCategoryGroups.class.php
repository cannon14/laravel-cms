<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Merchants_Bl_CampaignCategoryGroups
{
	var $resultArray;
    //--------------------------------------------------------------------------

    
    
    //--------------------------------------------------------------------------

    function delete($params)
    {
        $groupIDs = $params['groupids'];
        if(!is_array($groupIDs) || count($groupIDs) < 1)
            return false;
		
		foreach($groupIDs as $id){
				$this->resultArray = null;
				Affiliate_Merchants_Bl_CampaignCategoryGroups::getChildren($gid);
				if(is_array($this->resultArray))
					$groupIDs += $this->resultArray;
		}	
			
        $chunkedGroupIDs = array_chunk($groupIDs, WD_MAX_PROCESSED_IDS);
        
		
        
		foreach($chunkedGroupIDs as $groupIDsArray)
        {
            $groupIDSql = "('".implode("','", $groupIDsArray)."')";
            
			$sql = 'update wd_pa_campaigntypes set deleted=1 '.
                   ' where typeid in ' . $groupIDSql . ' or parenttypeid in ' . $groupIDSql;
            
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			
			if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
			
        }
		QUnit_Messager::setOkMessage(implode(", ", $groupIDsArray) . " successfully deleted."); 

        return true;
    }
    
    //--------------------------------------------------------------------------

    function checkData($params)
    {
         // protect against script injection
        $params['refid'] = preg_replace('/[^0-9a-zA-Z_-]/', '', $params['refid']);
        $params['groupname'] = preg_replace('/[\'\"]/', '', $params['groupname']);
        $params['groupparentid'] = preg_replace('/[\'\"]/', '', $params['groupparentid']);
        

        // check correctness of the fields
        checkCorrectness($_POST['groupname'], $params['groupname'], L_G_AFFILIATEGROUP, CHECK_EMPTYALLOWED);
      
        if($_POST['groupname'] != '' && Affiliate_Merchants_Bl_CampaignCategoryGroups::checkGroupExists($_POST['groupname'], $params['typeid'], $GLOBALS['Auth']->getAccountID()))
			QUnit_Messager::setErrorMessage(L_G_AGNAMEEXISTS);

        
        // check if there is not the cross link of affiliates, such as A -> B, and B -> A
        //if(Affiliate_Merchants_Bl_Affiliate::checkUserCrossLink($params['parentuserid'], array($params['userid'], $params['parentuserid'])))
        //{
        //    QUnit_Messager::setErrorMessage(L_G_MERCHPARENTAFFILIATECREATESCHAIN);
        //}
        
        return $params;
    }
    
    //------------------------------------------------------------------------

    function checkGroupExists($groupid)
    {
        $sql = 'select * from wd_pa_campaigntypes '.
               'where deleted=0 '.
               '  and typeid='._q($groupid);
               

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        

        if($rs->EOF)
            return false;

        return true;
    }
	
	//------------------------------------------------------------------------
	
	function addMembers($params){
		$sql = "DELETE FROM wd_pa_campaigntypemap WHERE campaigntypeid = " . _q($params['gid']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if(is_array($params['affiliateids']))
			foreach($params['affiliateids'] as $id){
				$sql = "INSERT INTO wd_pa_campaigntypemap (campaignid, campaigntypeid) VALUES (" . _q($id) . ", " . _q($params['gid']) .")";
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			}
	}

    //------------------------------------------------------------------------

    function insert($params)
    {
        // save user to db
        $UserID = QCore_Sql_DBUnit::createUniqueID('wd_pa_campaigntypes', 'typeid');
        $sql = 'insert into wd_pa_campaigntypes(typeid, typename, dateinserted, deleted, ' .
        	   'parenttypeid, displayorder, description) '.
               ' values('._q($UserID).','._q($params['groupname']).','.sqlNow().
			   ',0 ,'._q($params['groupparentid']).',0, ' . _q($params['description']) .')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    
            
        return true;
    }
    
    
    function update($params)
    {
        $sql = 'update wd_pa_campaigntypes '.
                   'set typename='._q($params['groupname']).
                   ', parenttypeid='._q($params['parent']) . ', description=' . _q($params['description']);
                   

        $sql .= ' where typeid='._q($params['gid']);

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
		if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }
    
    //--------------------------------------------------------------------------
    
	function getParentSelector($gid = null){
		$sql = "SELECT * FROM wd_pa_campaigntypes " .
			   " WHERE deleted = 0 AND typeid <> " . _q($gid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$parentArray = array();
		while(!$rs->EOF){
			$parentArray[$rs->fields['typeid']] = $rs->fields['typename'];
			$rs->MoveNext();
		}	   
		
		return $parentArray;
	}
	
	
	//--------------------------------------------------------------------------
	
    function loadGroupInfoToPost($userid)
    {
        $sql = 'select * from wd_pa_campaigntypes '.
               'where deleted=0 '.
               '  and typeid='._q($userid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $_POST['name'] = $rs->fields['typename'];
        $_POST['parentid'] = $rs->fields['parenttypeid'];
		$_POST['gid'] = $rs->fields['typeid'];
		$_POST['description'] = $rs->fields['description'];

        return true;
    }
	
	
	
	//--------------------------------------------------------------------------

    function getGroupsAsArray()
    {
        
		$sql = 'select * from wd_pa_campaigntypes '.
               'where deleted=0 ORDER BY typename ASC';
        
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $group = array();
        while(!$rs->EOF)
        {
            $temp = array();
			
            $temp['typeid'] = $rs->fields['typeid'];
            $temp['typename'] = $rs->fields['typename'];
            $temp['dateinserted'] = $rs->fields['dateinserted'];
            $temp['parentgroupid'] = $rs->fields['parentgroupId'];
            $temp['displayorder'] = $rs->fields['displayorder'];
            $temp['description'] = $rs->fields['description'];
            

            array_push($group, $temp);

            $rs->MoveNext();
        }
		
		return $group;
        /**
		 if(count($group) <= 0) {
            return array();
        }
        
        $group_str = '';
        foreach($group as $k => $v)
        {
            $group_str .= '\''.$k.'\',';
        }
        $group_str = substr($group_str, 0, -1);

        $sql = 'select affiliateid,groupid'.
               'from wd_g_affiliategroupmap '.
               'where groupid in ('.$group_str.')';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        

        while(!$rs->EOF)
        {
            //$group[$rs->fields['groupid']]['affiliates'] = 
            array_push($group[$rs->fields['groupid']]['affiliates'],$rs->fields['affiliateid']);
            $rs->MoveNext();
        }

        return $group;
        **/
    }
	
	function getAffiliateMembersAsArray($groupid){
		$sql = "SELECT u.name, u.campaignid, g.* FROM wd_pa_campaigns as u, wd_pa_campaigntypemap as g " .
				" WHERE g.campaigntypeid = " . _q($groupid) . " AND u.campaign_type = 'PRODUCT' AND  g.campaignid = u.campaignid ORDER BY u.name ASC";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$memberArray = array();

		while(!$rs->EOF){
			$memberArray[$rs->fields['campaignid']] = $rs->fields['name'];
			$rs->MoveNext();
		}		
		
		return $memberArray;
	}
	
	function getAffiliateNonMembersAsArray($params){
		foreach($params as $id=>$name)
			$Ids[] = $id;

		$sql = "SELECT * FROM wd_pa_campaigns ";
		if(is_array($Ids)){
			$sqlIds = "('" . implode("','", $Ids) . "')";
			$sql .= " WHERE campaignid NOT IN " . $sqlIds;
		} else {
			$sql .= " WHERE 1 = 1 ";
		}
		$sql .= " AND campaign_type='PRODUCT' ORDER BY name ASC";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$nonMemberArray = array();
		
		while(!$rs->EOF){
			$nonMemberArray[$rs->fields['campaignid']] = $rs->fields['name'];
			$rs->MoveNext();
		}
		return $nonMemberArray;		
	}
	
	function addCampaign($affiliateid, $groupid){
		$sql = "INSERT INTO wd_pa_campaigntypemapmap (campaignid, campaigntypeid) " .
				" VALUES (" . _q($affiliateid) . ", " . _q($groupid) . ")";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
		return true;
	}
	function getTreeView(){
		$spooler = "";
		$spoolerEnd = "";
		$sql = "SELECT * FROM wd_pa_campaigntypes WHERE deleted = 0 ORDER BY typename ASC";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		while(!$rs->EOF){
			$spooler.= "d.add("._q($rs->fields['typeid'])."," . _q($rs->fields['parenttypeid']). "," . _q(preg_replace('/[\'\"]/', '', $rs->fields['typename'])) . ",'index_popup.php?md=Affiliate_Merchants_Views_CampaignCategoryGroupsManager&action=addMembers&gid=" . $rs->fields['typeid'] . "', " . _q($rs->fields['typename']) . ", '_blank')\n";
			$groupid  = $rs->fields['typeid'];
			$affiliates = Affiliate_Merchants_Bl_CampaignCategoryGroups::getAffiliateMembersAsArray($groupid);
		if(is_array($affiliates)){
				foreach($affiliates as $id=>$name){
					$name = preg_replace('/[\'\"]/', "", $name);
					$spoolerEnd.= "d.add("._q($id)."," . _q($rs->fields['typeid']). "," . _q($name) . ",'index_popup.php?md=Affiliate_Merchants_Views_CampaignCategoryGroupsManager&action=addMembers&gid=" . $rs->fields['typeid'] . "', " . _q($name) . ", '_blank', 'templates/standard/images/img/page.gif')\n";
				}
			}
			
			$rs->MoveNext();
		}
		$spooler .= $spoolerEnd;
		
		return $spooler;
	}
	
	function getGroupName($gid){
		$sql = "SELECT typename FROM wd_pa_campaigntypes WHERE deleted = 0 AND typeid=" . _q($gid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return $rs->fields['typename'];
	}
	
	function getCampaignMembersForSQL($gid){
		$sql = "SELECT campaignid FROM wd_pa_campaigntypemap WHERE campaigntypeid=" . _q($gid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		while(!$rs->EOF){
			$result[] = $rs->fields['campaignid'];
			$rs->MoveNext();
		}
		$this->resultArray = null;
		Affiliate_Merchants_Bl_CampaignCategoryGroups::getChildren($gid);
		//QUnit_Messager::setOkMessage(implode(", ", $this->resultArray));
		
		//get children
		if(is_array($this->resultArray)){
			$sql = "SELECT campaignid FROM wd_pa_campaigntypemap WHERE  campaigntypeid in ('" . implode("','", $this->resultArray) . "')";
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			while(!$rs->EOF){
				$result[] = $rs->fields['campaignid'];
				$rs->MoveNext();
			}
		}
		return $result;
	}
	
	function getChildren($node){
		$levelChildren = array();
		$sql = "SELECT typeid FROM wd_pa_campaigntypes WHERE deleted=0 AND parenttypeid <> null AND parenttypeid = " . _q($node);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		while(!$rs->EOF){
			$levelChildren[] = $rs->fields['typeid'];
			$this->resultArray[] = $rs->fields['typeid'];
			$rs->MoveNext(); 
		}
		// base case
		if(!is_array($levelChildren)){
			return $this->resultArray;
		}
		foreach($levelChildren as $child){
			Affiliate_Merchants_Bl_CampaignCategoryGroups::getChildren($child);
		}
			
	}

 
}
?>
