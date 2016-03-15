<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_Registrator');

class Affiliate_Scripts_Bl_BannerViewer extends Affiliate_Scripts_Bl_Registrator
{
    var $className = 'Affiliate_Scripts_Bl_BannerViewer';
    var $BannerID = '';
    var $sourceURL = '';
    var $description = '';
    var $commissionType = '';
    
    //--------------------------------------------------------------------------
    
    function checkUserExists($userID)
    {
        
        $sql = 'select * from partner_affiliates '.
            'where deleted=0 '.
            ' and (affiliate_id='._q($userID).' or ref_id='._q($userID).')';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF)
            return false;
        
        $this->UserID = $rs->fields['affiliate_id'];
        $this->AccountID = $rs->fields['default1'];
        
        return true;
    }  
    
    //--------------------------------------------------------------------------
    
    function checkBannerExists($bannerID)
    {
	    if(!is_numeric($bannerID)) {
		    $errorMsg = "Show banner: Error getting last impression. Possible SQL Injection";
		    LogError($errorMsg, __FILE__, __LINE__);
		    return false;
	    }

        $this->BannerID = $bannerID;
        $this->sourceURL = $rs->fields['sourceurl'];
        $this->description = $rs->fields['description'];
        $this->bannerType = $rs->fields['bannertype'];
        $this->commissionType = $rs->fields['commtype'];
        $this->CampaignID = $rs->fields['campaignid'];

        $this->saveImpression($bannerID);
    }    
    
    //--------------------------------------------------------------------------
    
    function saveImpression($bannerID)
    {
        
        $hourDate = date('Y-m-d H:').substr(date('i'), 0,1)."0:00";
        
        // get impression record for this hour
        $sql = "select impressionid, all_imps_count, unique_imps_count from impressions ".
            "where bannerid="._q($bannerID)." and affiliateid="._q($this->UserID).
            "  and dateimpression="._q($hourDate).
            "  and accountid="._q($this->AccountID).
            "  and commissiongiven=0".
            "  and data1="._q($this->extraData1);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {    
            $errorMsg = "Show banner: Error getting last impression";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        
        if($rs->EOF)
        {
            // insert record
            $impressionID = QCore_Sql_DBUnit::createUniqueID('wd_pa_impressions', 'impressionid');
            $sql = "insert into impressions(impressionid,dateimpression,".
                "accountid,bannerid,affiliateid,all_imps_count,unique_imps_count, commissiongiven, data1)".
                "values("._q($impressionID).","._q($hourDate).
                ","._q($this->AccountID).","._q($bannerID).
                ","._q($this->UserID).",1,1,0,"._q($this->extraData1).")";

            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$ret)
            {
                $errorMsg = "Show banner: Error saving impression";
                LogError($errorMsg, __FILE__, __LINE__);
                return false;
            }
        }
        else
        {
            $allImps = $rs->fields['all_imps_count'] + 1;
            $uniqueImps = $rs->fields['unique_imps_count'];
            $ipmId = $rs->fields['impressionid'];
            
            if($_COOKIE[COOKIE_NAME.'imp'] == '') {
                $uniqueImps++;
            }
            
            // update record
            $sql = "update impressions ".
                " set all_imps_count="._q($allImps).
                ", unique_imps_count="._q($uniqueImps).
                " where impressionid="._q($ipmId);

            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$ret)
            {
                $errorMsg = "Show banner: Error saving impression";
                LogError($errorMsg, __FILE__, __LINE__);
                return false;
            }
        }
        
        setcookie(COOKIE_NAME.'imp', time(), time() + 3650*86400, '/');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function redirect()
    {
        if($this->bannerType == BANNERTYPE_IMAGE) 
        {
            if($this->sourceURL == '' || $this->sourceURL == false)
                QCore_History::writeHistory(WLOG_DEBUG, "Banner viewer: banner source URL is empty", __FILE__, __LINE__);
            
            header("HTTP/1.1 301 Moved Permanently");
			header("Content-type: image/gif");       
            if(!@readfile($this->sourceURL))
            {
                QCore_History::writeHistory(WLOG_DEBUG, "Banner viewer: readfile returned false, file '".$this->sourceURL."'", __FILE__, __LINE__);
                
                // banner showing failed
                // try different way of displaying the banner
                header("HTTP/1.1 301 Moved Permanently");
				Header('Location: '.$this->sourceURL);
            }
            
            //Header('Location: '.$this->sourceURL);
        }
        
        // for text banners only register impression
    }
    
    //--------------------------------------------------------------------------

    function updateCPMCommission()
    {
        // get impression records that don't have commissions yet
        $sql = "select sum(i.all_imps_count) as all_imps_count, sum(i.unique_imps_count) as unique_imps_count, b.campaignid". 
               " from impressions i, wd_pa_banners b ".
               " where i.affiliateid="._q($this->UserID).
               " and accountid="._q($this->AccountID)." and commissiongiven=0".
               " and i.bannerid=b.bannerid and b.campaignid="._q($this->CampaignID).
               " group by b.campaignid";

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF)
        {    
            $errorMsg = "Show banner: Error update CPM Commission";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }

        if($rs->fields['all_imps_count'] >= 1000000)
        {
            return $this->saveCPMCommission();
        }
        
        return false;
    }
    
    //--------------------------------------------------------------------------

    function saveCPMCommission()
    {
        // first save commission
        QCore_History::writeHistory(WLOG_DEBUG, "Banner Viewer: Start saving CPM commission", __FILE__, __LINE__);

        if(($commission = $this->getCommission()) === false) return false;

        $remoteAddr = $_SERVER['HTTP_REFERER'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $status = AFFSTATUS_APPROVED;
        
        $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
        $sql = "insert into transactions ".
            "(transid, accountid, affiliateid, campcategoryid, bannerid,".
            " dateinserted, transtype, transkind, refererurl,".
            " ip, rstatus, commission)".
            "values("._q($TransID).","._q($this->AccountID).
            ","._q($this->UserID).","._q($this->CampaignCategoryID).
            ","._q($this->BannerID).",".sqlNow().
            ",".TRANSTYPE_CPM.",".TRANSKIND_NORMAL.","._q($remoteAddr).
            ","._q($ip).","._q($status).","._q($commission).")";

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            $errorMsg = "Click registration: Error saving click";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        
        QCore_History::writeHistory(WLOG_DEBUG, "Banner Viewer: End saving CPM commission", __FILE__, __LINE__);
        
        //------------------------------------------------
        // now change impression status to commissiongiven=1
        $sql = "select bannerid from partner_banners where bannerid="._q($this->CampaignID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {    
            $errorMsg = "Show banner: Error getting banner ID by campaign";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
        
        $bannerIDs = array();
        while(!$rs->EOF)
        {
            $bannerIDs[] = $rs->fields['bannerid'];
            
            $rs->MoveNext();
        }

        $chunkedBannerIDs = array_chunk($bannerIDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedBannerIDs as $bannerIDsArray)
        {
            $bannerIDSql = "('".implode("','", $bannerIDsArray)."')";
            
            $sql = 'update impressions set commissiongiven=1'.
                   ' where bannerid in '.$bannerIDSql.
                   '   and accountid='._q($this->AccountID).
                   '   and userid='._q($this->UserID);

            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------

    function getCommission()
    {
        if(!$this->checkUserInCampaign())
            return false;
            
        return ($this->CPMCommission != '' ? $this->CPMCommission : 0);
    }
    
    //--------------------------------------------------------------------------
    
    function setExtraData($Data1)
    {
        $this->extraData1 = $Data1;
    }    
}
?>
