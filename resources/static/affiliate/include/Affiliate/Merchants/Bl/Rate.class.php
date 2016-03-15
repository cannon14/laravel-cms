<?php

/**
 * CreditCards.com
 * Kyle Putnam
 * 
 * Rate DataAccess Object -
 * All SQL pertaining to Rates should be placed here.
 * 
 * 
 */
class Affiliate_Merchants_Bl_Rate {
	
	
	function deleteRates($ids)
	{
			if(!is_array($ids)){
				$ids = array($ids);
			}
			
			$sql = 'DELETE FROM ' .RATE_TABLE. ' WHERE product_rate_id in ("' . implode("','", $ids) . '")';
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			
	}	
	
	function deleteRatesByCampaignId($id)
	{
		$sql = 'DELETE FROM ' . RATE_TABLE . ' WHERE campaign_id = ' . _q($id);
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__); 
	}
	
	function getRateById($id)
	{
		$sql = 'SELECT * FROM ' . RATE_TABLE . ' WHERE product_rate_id = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		return $rs->fields;
		
	}
	
	function getActiveRatesByCampaignId($id)
	{
		$sql = 'SELECT * FROM ' . RATE_TABLE . ' WHERE active = 1 AND campaign_id = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$ret = array();
		
		while(!$rs->EOF){
			$ret[] = $rs->fields;
			$rs->MoveNext();
		}	
		
		return $ret;
	}
	
	function hasRateDefined($trans){
		$sql = 'SELECT rate FROM providers WHERE provider_id = ' . _q($trans['providerid']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		return $rs->fields['rate'];
	}
	
	function deactivateRates($ids)
	{
		foreach ($ids as $id)
		{
			$sql = 'UPDATE ' .RATE_TABLE. ' SET active=0 WHERE product_rate_id=' ._q($id);
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}	
	}
	
	function activateRates($ids)
	{
		foreach ($ids as $id)
		{
			$sql = 'UPDATE ' .RATE_TABLE. ' SET active=1 WHERE product_rate_id=' ._q($id);
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}	
	}
	
	function closeOutRates($ids)
	{
		$closedate = date("Y-m-d 23:59:59");
		
		foreach ($ids as $id)
		{
			$sql = 'UPDATE ' .RATE_TABLE. ' SET rate_end_date="' .$closedate. '" WHERE product_rate_id=' ._q($id);
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
	}
	
	function insertRate($params)
	{
		Affiliate_Merchants_Bl_Rate::_adjustOverlapObselete($params);
		Affiliate_Merchants_Bl_Rate::_adjustOverlapMiddle($params);
		Affiliate_Merchants_Bl_Rate::_adjustOverlapEnd($params);
		Affiliate_Merchants_Bl_Rate::_adjustOverlapBegin($params);

		
		
		
		
		$params['insert_time'] = date('Y-m-d h:i:s');
		$sql = "INSERT INTO " .RATE_TABLE. " (`".implode('`,`', array_keys($params))."`) VALUES ('".implode("','", array_values($params))."')";
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);		
		
		$sql = 'SELECT product_rate_id FROM ' . RATE_TABLE . ' ORDER BY product_rate_id DESC LIMIT 1';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		return $rs->fields['product_rate_id'];
	}
	
	function _adjustOverlapEnd($params)
	{	
		if($params['rate_end_date'] == "0000-00-00"){
			$params['rate_end_date'] = "2035-01-01";
		}
		$sql = 'UPDATE ' . RATE_TABLE . ' ' .
				'SET rate_end_date = DATE_ADD(DATE('._q($params['rate_start_date']).'), INTERVAL -1 DAY) ' .
				'WHERE campaign_id = ' . _q($params['campaign_id']) . ' ' .
				'AND active = 1 ' .
				'AND rate_start_date <= ' . _q($params['rate_start_date']) . ' ' .
				'AND (rate_end_date >= ' . _q($params['rate_start_date']) . ' OR rate_end_date="0000-00-00")' .
				'AND (rate_end_date < '._q($params['rate_end_date']).' OR rate_end_date="0000-00-00")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function _adjustOverlapBegin($params)
	{
		if($params['rate_end_date'] == "0000-00-00"){
			$params['rate_end_date'] = "2035-01-01";
		}
		
		$sql = 'UPDATE ' . RATE_TABLE . ' ' .
				'SET rate_start_date = DATE_ADD(DATE('._q($params['rate_end_date']).'), INTERVAL 1 DAY) ' .
				'WHERE campaign_id = ' . _q($params['campaign_id']) . ' ' .
				'AND active = 1 ' .
				'AND (rate_start_date >= ' . _q($params['rate_start_date']) . ' AND rate_start_date < '._q($params['rate_end_date']).' )' . 
				'AND (rate_end_date >= ' . _q($params['rate_end_date']) . ' OR rate_end_date = "0000-00-00" )' ;
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);		
	}
	
	function _adjustOverlapMiddle($params)
	{
		if($params['rate_end_date'] == "0000-00-00"){
			$params['rate_end_date'] = "2035-01-01";
		}		
		
		$sql = 'SELECT * FROM ' . RATE_TABLE . ' ' .
				'WHERE campaign_id = ' . _q($params['campaign_id']) . ' ' .
				'AND active = 1 ' .
				'AND rate_start_date < ' . _q($params['rate_start_date']) . ' ' . 
				'AND (rate_end_date > ' . _q($params['rate_end_date']) . ' OR rate_end_date = "0000-00-00") ' .
				'AND NOT(rate_end_date = "0000-00-00" AND '._q($params['rate_end_date']).' = "2035-01-01")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
		if($rs->_numOfRows > 0){
			$sql = 'UPDATE ' . RATE_TABLE . ' ' .
					'SET active = 0 ' .
					'WHERE product_rate_id = ' . $rs->fields['product_rate_id'];
			QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			
			$endRate = $startRate = $rs->fields;
			
			unset($endRate['product_rate_id']);
			unset($startRate['product_rate_id']);
			
			$endArray = explode('-', $params['rate_end_date']);
			$startArray = explode('-', $params['rate_start_date']);
			
		
			$startRate['rate_end_date'] = date('Y-m-d', mktime(0, 0, 0, $startArray[1] , $startArray[2] - 1  ,  $startArray[0]));		
			$endRate['rate_start_date'] = date('Y-m-d', mktime(0, 0, 0, $endArray[1] , $endArray[2] + 1  ,  $endArray[0]));		
			
			
			Affiliate_Merchants_Bl_Rate::insertRate($startRate);
			Affiliate_Merchants_Bl_Rate::insertRate($endRate);			
		}
		
	}
	
	function _adjustOverlapObselete($params)
	{
		if($params['rate_end_date'] == "0000-00-00"){
			$params['rate_end_date'] = "2035-01-01";
		}		
		$sql = 'UPDATE ' . RATE_TABLE . ' ' .
				'SET active = 0 ' .
				'WHERE campaign_id = ' . _q($params['campaign_id']) . ' ' .
				'AND active = 1 ' .
				'AND rate_start_date >= ' . _q($params['rate_start_date']) . ' ' . 
				'AND (rate_end_date <= ' . _q($params['rate_end_date']) . ' AND (rate_end_date != "0000-00-00" OR "2035-01-01" = "'.$params['rate_end_date'].'"))';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);			
	}
	
	function getRate($trans)
	{
		$sql = "SELECT * FROM " .PROVIDER_TABLE . " WHERE rate='1' AND provider_id=" . _q($trans['providerid']);
   		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		//make sure provider doesn't provide its own revenue
		if($rs->fields)
		{
			$sql = 	'SELECT r.rate FROM wd_pa_campaigncategories as cc ' .
					'LEFT JOIN ' .RATE_TABLE. ' as r ' .
					'ON cc.campaignid = r.campaign_id ' .
					'WHERE cc.campcategoryid = ' ._q($trans['campcategoryid']) . ' ' .
					'AND r.active = 1 ' .
					'AND cc.campaignid = r.campaign_id ' .
					'AND DATE(r.rate_start_date) <= DATE('._q($trans['providerprocessdate']).') ' .
					'AND (DATE(' . _q($trans['providerprocessdate']) . ') <= DATE(r.rate_end_date) OR DATE(r.rate_end_date) <= DATE(r.rate_start_date))';
					
			if (!$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__))
			{
				QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
				QUnit_Messager::setErrorMessage("Rate doesn't exist for campcategoryid: " . ($trans['campcategoryid']!=""?$trans['campcategoryid']:"None Defined"));
				return false;
			}

			return $rs->fields['rate'];
		}
		else
		{
			QUnit_Messager::setErrorMessage("Providerid " . $trans['providerid'] . " provides their own revenue. Not able to calculate rate.");
			QCore_History::DebugMsg(WLOG_DBERROR, "Providerid " . $trans['providerid'] . " provides their own revenue. Not able to calculate rate.", __FILE__, __LINE__);
			
			return false;
		}
	}
	
	function getProductCurrentRate($id)
	{

		$sql = 	'SELECT rate FROM ' .RATE_TABLE.
				' WHERE active = 1 ' .
				'AND campaign_id = ' . _q($id) .
				'AND DATE(rate_start_date) <= DATE(now()) ' .
				'AND (DATE(now()) <= DATE(rate_end_date) OR DATE(rate_end_date) <= DATE(rate_start_date))';
				
		if (!$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__))
		{
			QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
			return false;
		}

		return $rs->fields['rate'];
	}
	
	function getNFRate($trans)
	{
		$sql = "SELECT * FROM " .PROVIDER_TABLE . " WHERE rate='1' AND provider_id=" . _q($trans['providerid']);
   		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		//make sure provider doesn't provide its own revenue
		if(!$rs->EOF)
		{
			//---get campaignid from nf---------------------------
			$sql = 	'SELECT campaignid FROM wd_pa_campaigncategories ' .
					'WHERE campcategoryid = ' ._q($trans['campcategoryid']);
					
			$nfDb = new Affiliate_Scripts_Bl_NFQuery();
    		$rs = $nfDb->query($sql);
    		
    		$cccom_bannerid = $rs->fields['campaignid'];
			
			//----------hack to get bannerid for NF campaigns which maps to rate table---------
			$sql = 	'SELECT campaignid FROM wd_pa_banners ' .
					'WHERE bannerid = ' ._q($cccom_bannerid);
			
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			
			$bannerid = $rs->fields['campaignid'];
			
			//---get rate on ccom usign nf campaignid---------------------------
			$sql = 	'SELECT rate FROM ' .RATE_TABLE.
					' WHERE active=1' .
					' AND campaign_id=' . _q($bannerid).
					' AND DATE(rate_start_date) <= DATE('._q($trans['providerprocessdate']).') AND (DATE(' . _q($trans['providerprocessdate']) . ') < DATE(rate_end_date)' .
					' OR DATE(rate_end_date) <= DATE(rate_start_date))';
			
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			
			if ($rs->EOF)
			{
				QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
				QUnit_Messager::setErrorMessage("Rate doesn't exist for campcategoryid: " . ($trans['campcategoryid']!=""?$trans['campcategoryid']:"None Defined"));
				return false;
			}

			return $rs->fields['rate'];
		}
		else
		{
			QUnit_Messager::setErrorMessage("Providerid " . $trans['providerid'] . " provides their own revenue. Not able to calculate rate.");
			QCore_History::DebugMsg(WLOG_DBERROR, "Providerid " . $trans['providerid'] . " provides their own revenue. Not able to calculate rate.", __FILE__, __LINE__);
			
			return false;
		}
	}
	
	function getRateCreationDate($trans)
	{
		$sql = "SELECT * FROM " .PROVIDER_TABLE . " WHERE rate='1' AND provider_id=" . _q($trans['providerid']);
   		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		//make sure provider doesn't provide its own revenue
		if($rs->fields)
		{
			$sql = 	'SELECT r.insert_time, r.rate FROM wd_pa_campaigncategories as cc ' .
					'LEFT JOIN ' .RATE_TABLE. ' as r ' .
					'ON cc.campaignid = r.campaign_id ' .
					'WHERE cc.campcategoryid = ' ._q($trans['campcategoryid']) . ' ' .
					'AND r.active = 1 ' .
					'AND cc.campaignid = r.campaign_id ' .
					'AND DATE(r.rate_start_date) <= DATE('._q($trans['providerprocessdate']).') AND (DATE(' . _q($trans['providerprocessdate']) . ') < DATE(r.rate_end_date) ' .
					'OR DATE(r.rate_end_date) <= DATE(r.rate_start_date))';
					
			if (!$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__))
			{
				QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
				QUnit_Messager::setErrorMessage("Rate doesn't exist for campcategoryid: " . ($trans['campcategoryid']!=""?$trans['campcategoryid']:"None Defined"));
				return false;
			}
			return $rs->fields;
		}
		else
		{
			QCore_History::DebugMsg(WLOG_DBERROR, "Cannot calculate rate for providerid=" . $trans['providerid'], __FILE__, __LINE__);
		}
	}
	
	function recalculateRates($trans, $tbl)
	{
		$rate = Affiliate_Merchants_Bl_Rate::getRate($trans);
		
		//if rate exists
		if ($rate) {
			$revenue = $rate * $trans['quantity'];
			
			$col = ($tbl == UPLOAD_ERROR_TABLE) ? 'id' : 'transid';
			
			$sql = 'UPDATE ' .$tbl. ' SET estimatedrevenue="' .$revenue. '", dateadjusted=now() WHERE ' .$col. '=' ._q($trans[$col]);

			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			
			QUnit_Messager::setOkMessage('Rate(s) Recalculated.');
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function getProductRateCategories()
	{
		$sql = 'SELECT c.campaignid, c.name, COUNT(r.campaign_id) as count 
				FROM wd_pa_campaigns as c 
				LEFT JOIN ' . RATE_TABLE . ' as r 
				ON (c.campaignid = r.campaign_id AND r.active = 1) 
				GROUP BY c.campaignid';
				
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
		$ret = array();
		
		while(!$rs->EOF){
			$ret[$rs->fields['campaignid']] = $rs->fields;
			$rs->MoveNext();
		}
		
		return $ret;
	}
	
	function getRatesByProductId($id)
	{
		$sql = 'SELECT r.rate, DATE(r.rate_start_date) as startdate, DATE(r.rate_end_date) as enddate, r.product_rate_id, c.name ' .
				'FROM ' . RATE_TABLE . ' as r ' .
				'LEFT JOIN wd_pa_campaigns as c ' .
				'ON c.campaignid = r.campaign_id ' .
				'WHERE r.campaign_id = ' . _q($id) .
				' AND r.active = 1 ORDER BY r.rate_start_date ASC';
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
		$ret = array();
		
		while(!$rs->EOF){
			$ret[$rs->fields['product_rate_id']] = $rs->fields;
			$rs->MoveNext();
		}
		
		return $ret;			
	}
}
?>