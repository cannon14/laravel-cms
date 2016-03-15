<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');

class Affiliate_Merchants_Bl_Campaign
{
    function load($params)
    {
        $sql = 'SELECT c.*, b.bannerid, b.destinationurl FROM wd_pa_campaigns AS c INNER JOIN wd_pa_banners AS b USING (campaignid) '.
               ' WHERE c.deleted=0 AND c.campaignid= '. _q($params['campaignid']).
               '  AND c.accountid='._q($GLOBALS['Auth']->getAccountID());
              
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
        
        if($rs->EOF)
            return array();
            
        return $rs->fields;   
            
    }
    
    function loadAd($params)
    {
        $sql = 'SELECT c.* FROM wd_pa_campaigns AS c '.
               ' WHERE c.deleted=0 AND c.campaignid= '. _q($params['campaignid']).
               '  AND c.accountid='._q($GLOBALS['Auth']->getAccountID());
              
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
        
        if($rs->EOF)
            return array();
            
        return $rs->fields;   
            
    }    
    
    function getAllCampaigns()
    {
    	$sql = 'SELECT * FROM wd_pa_campaigns WHERE deleted != 1 and accountid = ' 
    	. _q($GLOBALS['Auth']->getAccountID()) . ' ORDER BY name ASC';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }


        
        $ret = array();
        
        while(!$rs->EOF){
        	$ret[] = $rs->fields;
       		$rs->MoveNext(); 
        } 	
        
        return $ret;
    }
    
    function getAllProducts()
    {
    	$sql = 'SELECT c.*, b.bannerid, b.destinationurl FROM wd_pa_campaigns AS c LEFT JOIN wd_pa_banners AS b USING (campaignid) WHERE c.deleted != 1 and c.accountid = ' 
    	. _q($GLOBALS['Auth']->getAccountID()) . ' WHERE c.type = ' . _q('PRODUCT') . ' ORDER BY c.name ASC';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }


        
        $ret = array();
        
        while(!$rs->EOF){
        	$ret[] = $rs->fields;
       		$rs->MoveNext(); 
        } 	
        
        return $ret;
    }
    
    function getAllAdvertisements()
    {
		$sql = 'SELECT * FROM wd_pa_campaigns AS c WHERE c.deleted != 1 and c.accountid = ' 
    	. _q($GLOBALS['Auth']->getAccountID()) . ' WHERE c.type = ' . _q('ADVERTISEMENT') . ' ORDER BY c.name ASC';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }


        
        $ret = array();
        
        while(!$rs->EOF){
        	$ret[] = $rs->fields;
       		$rs->MoveNext(); 
        } 	
        
        return $ret;
    }       

    //--------------------------------------------------------------------------

    function updateSettings($params)
    {
        $setting_params = array('cookielifetime' => $params['cookielifetime'],
                                'clickapproval' => $params['clickapproval'],
                                'saleapproval' => $params['saleapproval'],
                                'affapproval' => $params['affapproval'],
                                'status' => $params['status'],
                                'signup_bonus' => $params['signup_bonus'],
                                'overwrite_cookie' => $params['overwrite_cookie']
                               );

        Affiliate_Merchants_Bl_Settings::updateCampaignInfo($params['cid'], $setting_params);

        return true;
    }

    //--------------------------------------------------------------------------

    function updateCampaign($params)
    {
        $sql = 'update wd_pa_campaigns '.
               'set name='._q($params['cname']).
               '   ,commtype='._q($params['commtype']).
               '   ,shortdescription='._q($params['shortdescription']).
               '   ,description='._q($params['description']) . ', merchant_id = ' . _q($params['merchant_id']);
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql .= ' ,products='._q($params['products']);
        $sql .= ' where campaignid='._q($params['campaignid']).
               '   and accountid='._q($GLOBALS['Auth']->getAccountID());
		
        //echo $sql;
        
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $setting_params = array('banner_url' => $params['banner_url']);

        Affiliate_Merchants_Bl_Settings::updateCampaignInfo($params['campaignid'], $setting_params);

        Affiliate_Merchants_Bl_Campaign::_updateDefaultBanner($params);
        
        return true;
    }
    
    function updateAd($params)
    {
        $sql = 'update wd_pa_campaigns '.
               'set name='._q($params['cname']).
               '   ,commtype='._q($params['commtype']).
               '   ,shortdescription='._q($params['shortdescription']).
               '   ,description='._q($params['description']) . ', merchant_id = ' . _q($params['merchant_id']);
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql .= ' ,products='._q($params['products']);
        $sql .= ' where campaignid='._q($params['campaignid']).
               '   and accountid='._q($GLOBALS['Auth']->getAccountID());
		
        //echo $sql;
        
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $setting_params = array('banner_url' => $params['banner_url']);

        Affiliate_Merchants_Bl_Settings::updateCampaignInfo($params['campaignid'], $setting_params);
        
        return true;
    }    

    //--------------------------------------------------------------------------

    function insert($params)
    {   
        $sql = 'insert into wd_pa_campaigns(campaignid, accountid, name';
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql.=',products';
        $sql.= ' ,dateinserted, commtype, description, shortdescription, merchant_id, campaign_type) values'.
               '('._q($params['campaignid']).','._q($GLOBALS['Auth']->getAccountID()).
               ','._q($params['cname']);
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql.=','._q($params['products']);
        $sql.=','.sqlNow().','._q($params['commtype']).','._q($params['description']).
              ','._q($params['shortdescription']).', '._q($params['merchant_id']).', '._q('PRODUCT').')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }    

        $setting_params = array('cookielifetime' => $params['cookielifetime'],
                                'clickapproval' => $params['clickapproval'],
                                'saleapproval' => $params['saleapproval'],
                                'affapproval' => $params['affapproval'],
                                'status' => $params['status'],
                                'signup_bonus' => $params['signup_bonus'],
                                'overwrite_cookie' => $params['overwrite_cookie'],
                                'banner_url' => $params['banner_url']
                               );

        Affiliate_Merchants_Bl_Settings::updateCampaignInfo($params['campaignid'], $setting_params);

        // add commission to first unassigned category
        $sql = 'insert into wd_pa_campaigncategories(campcategoryid, campaignid, name)'.
               'values('._q($params['affcategoryid']).','._q($params['campaignid']).
               ','._q(UNASSIGNED_USERS).')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$ret)
        {
            $sql = 'delete from wd_pa_campaigns '.
                   'where campaignid='._q($params['campaignid']).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            Affiliate_Merchants_Bl_Settings::deleteCampaignInfo($params['campaignid']);

            QUnit_Messager::setErrorMessage(L_G_DBERROR);

            return false;
        }
        
        Affiliate_Merchants_Bl_Campaign::_addDefaultBanner($params);

        return true;            
    }
    
    function insertAd($params)
    {
        $sql = 'insert into wd_pa_campaigns(campaignid, accountid, name';
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql.=',products';
        $sql.= ' ,dateinserted, commtype, description, shortdescription, merchant_id, campaign_type) values'.
               '('._q($params['campaignid']).','._q($GLOBALS['Auth']->getAccountID()).
               ','._q($params['cname']);
        if($GLOBALS['Auth']->getSetting('Aff_forcecommfromproductid') == 'yes')
            $sql.=','._q($params['products']);
        $sql.=','.sqlNow().','._q($params['commtype']).','._q($params['description']).
              ','._q($params['shortdescription']).', '._q($params['merchant_id']).', '._q('ADVERTISEMENT').')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }    

        $setting_params = array('cookielifetime' => $params['cookielifetime'],
                                'clickapproval' => $params['clickapproval'],
                                'saleapproval' => $params['saleapproval'],
                                'affapproval' => $params['affapproval'],
                                'status' => $params['status'],
                                'signup_bonus' => $params['signup_bonus'],
                                'overwrite_cookie' => $params['overwrite_cookie'],
                                'banner_url' => $params['banner_url']
                               );

        Affiliate_Merchants_Bl_Settings::updateCampaignInfo($params['campaignid'], $setting_params);

        // add commission to first unassigned category
        $sql = 'insert into wd_pa_campaigncategories(campcategoryid, campaignid, name)'.
               'values('._q($params['affcategoryid']).','._q($params['campaignid']).
               ','._q(UNASSIGNED_USERS).')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$ret)
        {
            $sql = 'delete from wd_pa_campaigns '.
                   'where campaignid='._q($params['campaignid']).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            Affiliate_Merchants_Bl_Settings::deleteCampaignInfo($params['campaignid']);

            QUnit_Messager::setErrorMessage(L_G_DBERROR);

            return false;
        }

        return true;            
    }    
    
   /**
    * Author:mz
    * Date:  1/8/08
    * Desc:  Handles inserting new epc data for a given banner id.
    */
   function insertNewEpcData($bannerid, $epc_rate_override, $use_override)
   {
      if(trim($epc_rate_override) == '')
      {
         $epc_rate_override = 0;
      }
      
      if(trim($use_override) == '')
      {
         $use_override = 0;
      }
      
      $sql = 
      "
      insert into product_epc(bannerid, sale_rate, sale_price, epc_rate, epc_rate_override, last_change_time, use_override, active)
      values ('$bannerid', 0, 0, 0, $epc_rate_override, now(), $use_override, 1)
      ";
        
      $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
      if(!$ret)
      {
         QUnit_Messager::setErrorMessage(L_G_EPC_INSERT_FAILED); 
         return false;        
      } 

      return true;            
   }    

    //--------------------------------------------------------------------------

    function delete($params)
    {
        $sql = 'update wd_pa_campaigns set deleted=1 '.
               'where campaignid='._q($params['campaignid']).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $ret = Affiliate_Merchants_Bl_Settings::deleteCampaignInfo($params['campaignid']);

        return $ret;
    }

    //------------------------------------------------------------------------------
    
    function getCampaignsInSet($set){
    	if(is_array($set)){
	    	$sql = 'SELECT * FROM wd_pa_campaigns '.
	    		   'WHERE deleted != 1 '.
	    		   'AND disabled != 1 '.
	    		   'AND campaignid IN ("'.implode('","',$set).'")';
	    	//	echo $sql;
	    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	}
    	return $rs;	
    }
   
    //------------------------------------------------------------------------------
    
    function getAllCampaignsWithExclude($exclude=array()){
    	$sql = 'SELECT * FROM wd_pa_campaigns '.
    		   'WHERE deleted != 1 '.
    		   'AND disabled != 1';
    		   
    	if(sizeof($exclude)>0)
    		$sql .= ' AND campaignid NOT IN ("'.implode('","',$exclude).'")';
    	//echo $sql.'<br>';
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	return $rs;	
    }
    
    //------------------------------------------------------------------------------
    
    function getCampaignsByCampaignType($camptypeid, $exclude=array()){
    	$sql = 'SELECT c.* FROM wd_pa_campaigns as c, wd_pa_campaigntypemap as ctm '.
    		   'WHERE deleted != 1 '.
    		   'AND disabled != 1 '.
    		   'AND c.campaignid=ctm.campaignid '.
    		   'AND ctm.campaigntypeid='._q($camptypeid);
    	if(sizeof($exclude)>0)
    		$sql .= ' AND c.campaignid NOT IN ("'.implode('","',$exclude).'")';

    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	return $rs;	
    }
    
    function _addDefaultBanner($params)
    {
    	 // old way.
    	 //$sql = "insert into wd_pa_banners(bannerid, campaignid, destinationurl, sourceurl, description, bannertype)".
         //          "values(".myquotes(QCore_Sql_DBUnit::createUniqueID('wd_pa_banners', 'bannerid')).",".myquotes($params['campaignid']).",".myquotes($params['desturl']).",".myquotes($params['sourceurl']).",".myquotes($params['description']).",".myquotes(BANNERTYPE_TEXT).")";	
    
    	$sql = "insert into wd_pa_banners(bannerid, campaignid, destinationurl, sourceurl, description, bannertype)".
         		"values(".myquotes($params['banner_id']).",".myquotes($params['campaignid']).",".myquotes($params['desturl']).",".myquotes($params['sourceurl']).",".myquotes($params['cname']).",".myquotes(BANNERTYPE_TEXT).")";	
    	//echo $sql;
    	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    } 
    
    function _updateDefaultBanner($params)
    {
    	 $sql = "update wd_pa_banners set description = " .myquotes($params['cname']).", destinationurl = ".myquotes($params['desturl']) . " WHERE campaignid = ".myquotes($params['campaignid']);
    
    	// echo $sql;
    	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    }          
}
?>
