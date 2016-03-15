<?php

require_once($GLOBALS['cccomPath'] . 'cardsearchclient/src/cardsearch/plugin/SearchPlugin.class.php');

class Affiliate_Scripts_Bl_SearchLogger extends Cardsearch_Plugin_SearchPlugin
{
	/**
	 * This method is called prior to making webservice call
	 * 
	 * @access public
	 * @abstract 
	 * @param String $siteCode
	 * @param String $indexCode
	 * @param String $query
	 * @param int $offset
	 * @param int $num
	 * @param int $totalNumResults
	 */
	function preSearch(&$siteCode, &$indexCode, &$query, &$offset, &$num, &$totalNumResults)
	{
		$sql = 'INSERT INTO cccom_search.cccom_logs' . 
				' (l_includes, l_num, l_mode, l_ts) VALUES (' . _q($query) . ',' .
				 _q($totalNumResults) . ',"s", NOW())';		
				 
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}	
}
?>
