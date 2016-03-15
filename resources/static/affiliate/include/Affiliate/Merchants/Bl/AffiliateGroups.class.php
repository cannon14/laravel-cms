<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Merchants_Bl_AffiliateGroups
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
				Affiliate_Merchants_Bl_AffiliateGroups::getChildren($gid);
				if(is_array($this->resultArray))
					$groupIDs += $this->resultArray;
		}	
			
        $chunkedGroupIDs = array_chunk($groupIDs, WD_MAX_PROCESSED_IDS);
        
		
        
		foreach($chunkedGroupIDs as $groupIDsArray)
        {
            $groupIDSql = "('".implode("','", $groupIDsArray)."')";
            
			$sql = 'update wd_g_affiliategroups set deleted=1 '.
                   ' where groupid in ' . $groupIDSql . ' or parentgroupid in ' . $groupIDSql;
            
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
      
        if($_POST['groupname'] != '' && Affiliate_Merchants_Bl_AffiliateGroups::checkGroupExists($_POST['groupname'], $params['groupid'], $GLOBALS['Auth']->getAccountID()))
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
        $sql = 'select * from wd_g_affiliategroups '.
               'where deleted=0 '.
               '  and groupid='._q($groupid);
               

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
		$sql = "DELETE FROM wd_g_affiliategroupmap WHERE affiliategroupid = " . _q($params['gid']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if(is_array($params['affiliateids']))
			foreach($params['affiliateids'] as $id){
				$sql = "INSERT INTO wd_g_affiliategroupmap (affiliateid, affiliategroupid) VALUES (" . _q($id) . ", " . _q($params['gid']) .")";
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			}
	}

    //------------------------------------------------------------------------

    function insert($params)
    {
        // save user to db
        $UserID = QCore_Sql_DBUnit::createUniqueID('wd_g_affiliategroups', 'groupid');
        $sql = 'insert into wd_g_affiliategroups(groupid, name, dateinserted, deleted, ' .
        	   'parentgroupid, displayorder) '.
               ' values('._q($UserID).','._q($params['groupname']).','.sqlNow().
			   ',0 ,'._q($params['groupparentid']).',0)';

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
        $sql = 'update wd_g_affiliategroups '.
                   'set name='._q($params['groupname']).
                   ', parentgroupid='._q($params['parent']);
                   

        $sql .= ' where groupid='._q($params['gid']);

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
		$sql = "SELECT * FROM wd_g_affiliategroups " .
			   " WHERE deleted = 0 AND groupid <> " . _q($gid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$parentArray = array();
		while(!$rs->EOF){
			$parentArray[$rs->fields['groupid']] = $rs->fields['name'];
			$rs->MoveNext();
		}	   
		
		return $parentArray;
	}
	
	
	//--------------------------------------------------------------------------
	
    function loadGroupInfoToPost($userid)
    {
        $sql = 'select * from wd_g_affiliategroups '.
               'where deleted=0 '.
               '  and groupid='._q($userid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $_POST['name'] = $rs->fields['name'];
        $_POST['parentid'] = $rs->fields['parentgroupid'];
		$_POST['gid'] = $rs->fields['groupid'];

        return true;
    }
	
	
	
	//--------------------------------------------------------------------------

    function getGroupsAsArray()
    {
        
		$sql = 'select * from wd_g_affiliategroups '.
               'where deleted=0 ORDER BY name ASC';
        
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
			
            $temp['groupid'] = $rs->fields['groupid'];
            $temp['name'] = $rs->fields['name'];
            $temp['dateinserted'] = $rs->fields['dateinserted'];
            $temp['parentgroupid'] = $rs->fields['parentgroupId'];
            $temp['displayorder'] = $rs->fields['displayorder'];
            

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
		$sql = "SELECT u.username, u.userid, g.* FROM wd_g_users as u, wd_g_affiliategroupmap as g " .
				" WHERE g.affiliategroupid = " . _q($groupid) . " AND g.affiliateid = u.userid ORDER BY u.username ASC";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$memberArray = array();

		while(!$rs->EOF){
			$memberArray[$rs->fields['userid']] = $rs->fields['username'];
			$rs->MoveNext();
		}		
		
		return $memberArray;
	}
	
	function getAffiliateNonMembersAsArray($params){
		foreach($params as $id=>$name)
			$Ids[] = $id;

		$sql = "SELECT * FROM wd_g_users WHERE rtype=4 ";
		if(is_array($Ids)){
			$sqlIds = "('" . implode("','", $Ids) . "')";
			$sql .= " AND userid NOT IN " . $sqlIds;
		}
		$sql .= " ORDER BY userid ASC";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$nonMemberArray = array();
		
		while(!$rs->EOF){
			$nonMemberArray[$rs->fields['userid']] = $rs->fields['username'];
			$rs->MoveNext();
		}
		return $nonMemberArray;		
	}
	
	function addAfilliate($affiliateid, $groupid){
		$sql = "INSERT INTO wd_g_affiliategroupmap (affiliateid, affiliategroupid) " .
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
		$sql = "SELECT * FROM wd_g_affiliategroups WHERE deleted = 0 ORDER BY name ASC";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		while(!$rs->EOF){
			$spooler.= "d.add("._q($rs->fields['groupid'])."," . _q($rs->fields['parentgroupid']). "," . _q($rs->fields['name']) . ",'index_popup.php?md=Affiliate_Merchants_Views_AffiliateGroupsManager&action=addMembers&gid=" . $rs->fields['groupid'] . "', " . _q($rs->fields['name']) . ", '_blank')\n";
			$groupid  = $rs->fields['groupid'];
			$affiliates = Affiliate_Merchants_Bl_AffiliateGroups::getAffiliateMembersAsArray($groupid);
			if(is_array($affiliates)){
				foreach($affiliates as $id=>$name){
					$name = preg_replace('/[\'\"]/', "", $name);
					$spoolerEnd.= "d.add("._q($id)."," . _q($rs->fields['groupid']). "," . _q($name) . ",'index_popup.php?md=Affiliate_Merchants_Views_AffiliateGroupsManager&action=addMembers&gid=" . $rs->fields['groupid'] . "', " . _q($name) . ", '_blank', 'templates/standard/images/img/page.gif')\n";
				}
			}
			
			$rs->MoveNext();
		}
		$spooler .= $spoolerEnd;
		
		return $spooler;
	}
	
	function getGroupName($gid){
		$sql = "SELECT name FROM wd_g_affiliategroups WHERE deleted = 0 AND groupid=" . _q($gid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return $rs->fields['name'];
	}
	
	function getAffiliateMembersForSQL($gid){
		$sql = "SELECT affiliateid FROM wd_g_affiliategroupmap WHERE affiliategroupid=" . _q($gid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		while(!$rs->EOF){
			$result[] = $rs->fields['affiliateid'];
			$rs->MoveNext();
		}
		
		$this->resultArray = null;
		Affiliate_Merchants_Bl_AffiliateGroups::getChildren($gid);
		//get children
		if(is_array($this->resultArray)){
			$sql = "SELECT affiliateid FROM wd_g_affiliategroupmap WHERE  affiliategroupid in ('" . implode("','", $this->resultArray) . "')";
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
		$sql = "SELECT groupid FROM wd_g_affiliategroups WHERE deleted='0' AND parentgroupid <> null AND parentgroupid = " . _q($node);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		while(!$rs->EOF){
			$levelChildren[] = $rs->fields['groupid'];
			$this->resultArray[] = $rs->fields['groupid'];
			$rs->MoveNext(); 
		}
		// base case
		if(!is_array($levelChildren)){
			return $this->resultArray;
		}
		foreach($levelChildren as $child){
			echo $child . "<br>";
			Affiliate_Merchants_Bl_AffiliateGroups::getChildren($child);
		}
			
	}		

 
}
?>
