<?php

require_once($GLOBALS['cccomPath'] . 'cardsearchclient/src/cardsearch/plugin/SearchPlugin.class.php');

class Affiliate_Scripts_Bl_SearchSiteCatalyst extends Cardsearch_Plugin_SearchPlugin
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
		/* We're pushing these into global scope sot hat we can access them cia sitecatalyst */
		$GLOBALS['search_query'] = ($totalNumResults == 0 ? 'null:' . $query : $query);
		$GLOBALS['search_num_results'] = ($totalNumResults == 0 ? 'zero' : $totalNumResults);
	}	
}
?>
