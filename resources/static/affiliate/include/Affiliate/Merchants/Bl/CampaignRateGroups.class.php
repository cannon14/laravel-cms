<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('QCore_Bl_Communications');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CampaignRateGroups');

class Affiliate_Merchants_Bl_CampaignRateGroups
{
	var $resultArray;

    function delete($params)
    {
        if(!is_array($params))
            return false;
		
        $groupIDSql = "('".implode("','", $params)."')";
        
		$sql = 'update ' .TABLE_CAMPAIGN_RATE_GROUPS. ' set deleted=1 '.
               ' where campaign_rate_group_id in ' . $groupIDSql;
        
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
		
		QUnit_Messager::setOkMessage(implode(", ", $params) . " successfully deleted."); 

        return true;
    }

    //--------------------------------------------------------------------------

    function activate($params)
    {
        if(!is_array($params))
            return false;
		
        $groupIDSql = "('".implode("','", $params)."')";
        
		$sql = 'update ' .TABLE_CAMPAIGN_RATE_GROUPS. ' set deleted=0 '.
               ' where campaign_rate_group_id in ' . $groupIDSql;
        
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
		
		QUnit_Messager::setOkMessage(implode(", ", $params) . " successfully activated."); 

        return true;
    }

    //--------------------------------------------------------------------------

    function checkGroupExists($group_name)
    {
        $sql = 'select * from ' .TABLE_CAMPAIGN_RATE_GROUPS.
               ' where group_name='._q($group_name);
               

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

	function addMembers($params)
	{
		$sql = "DELETE FROM " . TABLE_CAMPAIGN_RATE_GROUPS_MAP. " WHERE campaign_rate_group_id=" . _q($params['gid']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if(is_array($params['campaign_ids']))
			foreach($params['campaign_ids'] as $id){
				$sql = "INSERT INTO " . TABLE_CAMPAIGN_RATE_GROUPS_MAP. " (campaign_rate_group_id, campaignid) VALUES (" . _q($params['gid']) . ", " . _q($id) .")";
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			}
	}

    //------------------------------------------------------------------------

    function insert($params)
    {
        // save user to db
        $sql = 'insert into ' .TABLE_CAMPAIGN_RATE_GROUPS. '(campaign_rate_group_id, group_name, insert_time, description, deleted) '.
               ' values("",'._q($params['group_name']).','.sqlNow().','._q($params['description']).',0)';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    
            
        return true;
    }
    
    //--------------------------------------------------------------------------

    function update($params)
    {
        $sql = 'update '. TABLE_CAMPAIGN_RATE_GROUPS .
                   ' set group_name='._q($params['group_name']).
                   ', description='._q($params['description']);

        $sql .= ' where campaign_rate_group_id='._q($params['campaign_rate_group_id']);

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
		if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function loadGroupInfoToPost($userid)
    {
        $sql = 'select * from '. TABLE_CAMPAIGN_RATE_GROUPS .
               ' where campaign_rate_group_id='._q($userid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $_POST['group_name'] = $rs->fields['group_name'];
        $_POST['description'] = $rs->fields['description'];
		$_POST['campaign_rate_group_id'] = $rs->fields['campaign_rate_group_id'];

        return true;
    }
	
	//--------------------------------------------------------------------------
	
	function getTreeView(){
		$spooler = "";
		$spoolerEnd = "";
		
		//get status filter so tree matches table view
		$where = ( $_REQUEST['deleted']==-1 ? '' : ' where deleted='._q($_REQUEST['deleted']) );
        
		$sql = "SELECT * FROM " .TABLE_CAMPAIGN_RATE_GROUPS. $where . " ORDER BY group_name ASC";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		while(!$rs->EOF)
		{
			$spooler.= "d.add("._q($rs->fields['campaign_rate_group_id']).",''," . _q($rs->fields['group_name']) . ",'index_popup.php?md=Affiliate_Merchants_Views_CampaignRateGroupsManager&action=addMembers&gid=" . $rs->fields['campaign_rate_group_id'] . "', " . _q($rs->fields['group_name']) . ", '_blank')\n";
			
			$groupid  = $rs->fields['campaign_rate_group_id'];
			
			$affiliates = Affiliate_Merchants_Bl_CampaignRateGroups::getCampaignGroupMembersAsArray($groupid);
			
			if(is_array($affiliates)){
				foreach($affiliates as $id=>$name){
					
					$rate = Affiliate_Merchants_Bl_Rate::getProductCurrentRate($id);
					
					$rate = ($rate == "" ? "N/A" : '$ '. $rate);
					
					$name = preg_replace('/[\'\"]/', "", $name);
					$spoolerEnd.= "d.add("._q($id)."," . _q($groupid). "," . _q($name. " - ". $rate) . ",'index.php?md=Affiliate_Merchants_Views_RateMicroManager&mode=rate&rid=" .$id. "', " . _q($name) . ", '_blank', '/affiliate/merchants/templates/standard/images/img/page.gif')\n";
				}
			}
			
			$rs->MoveNext();
		}
		$spooler .= $spoolerEnd;
		
		return $spooler;
	}
	
	//--------------------------------------------------------------------------
	
	function getGroupName($gid){
		$sql = "SELECT group_name FROM " .TABLE_CAMPAIGN_RATE_GROUPS. " WHERE campaign_rate_group_id=" . _q($gid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return $rs->fields['group_name'];
	}
	
	//--------------------------------------------------------------------------
	
	function getCampaignGroupMembersAsArray($groupid)
	{
		$sql = "Select c.name, c.campaignid From campaign_rate_groups AS crg
				Left Join campaign_rate_groups_map AS crgm ON crg.campaign_rate_group_id = crgm.campaign_rate_group_id
				Left Join wd_pa_campaigns AS c ON crgm.campaignid=c.campaignid
				Where c.deleted != '1' AND crg.campaign_rate_group_id = " . _q($groupid);
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$memberArray = array();

		while(!$rs->EOF){
			$memberArray[$rs->fields['campaignid']] = $rs->fields['name'];
			$rs->MoveNext();
		}
		
		return $memberArray;
	}
	
	/**
	 * Get all campaigns that are not mapped to ANY CampaignRateGroups and that are also not deleted.
	 */
	function getCampaignGroupNonMembersAsArray()
	{
		$sql = "Select name, campaignid From wd_pa_campaigns
				Where campaignid NOT IN (" .
					"Select c.campaignid
					From campaign_rate_groups AS crg
					Left Join campaign_rate_groups_map AS crgm ON crg.campaign_rate_group_id = crgm.campaign_rate_group_id
					Left Join wd_pa_campaigns AS c ON crgm.campaignid=c.campaignid
					Where c.deleted != '1'".		
				") AND deleted != '1' ORDER BY name ASC";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$nonMemberArray = array();
		
		while(!$rs->EOF){
			$nonMemberArray[$rs->fields['campaignid']] = $rs->fields['name'];
			$rs->MoveNext();
		}
		return $nonMemberArray;		
	}
}
?>
