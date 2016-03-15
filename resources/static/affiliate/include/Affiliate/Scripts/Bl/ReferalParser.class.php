<?php
/**
 * 
 * Patrick J. Mizer
 * CreditCards.com
 * October 22, 2006
 * 
 */
 define('ORGANIC_TABLE', 'organic_search_results');
 
class Affiliate_Scripts_Bl_ReferalParser {
    
    function store($ccid, $refer)
    {
    	
    	$searchMap = array
    	(
    		'google.com' 			=> array('q', '1064'),
    		'search.yahoo.com'		=> array('p', '1065'),
    		'search.msn.com'		=> array('q', '1066'),
    		'ask.com' 				=> array('q', '1067'),
    		'search.aol.com'		=> array('query', '1068'),
    		'sandbox.localhost.com'	=> array('q', '1069'),
    		'other'					=> array('', '1069'),
    	);
    	
    	
    	$parsedData = parse_url($refer);
    	
    	$host = str_replace('www.', '', $parsedData['host']);
    	
    	
    	
    	if($host == null){
    		//QCore_History::writeHistory(WLOG_ERROR, "Organic Search: No Host returning: aid=" .$_SESSION['aid'], __FILE__, __LINE__);
    		return $_SESSION['aid'];
    	}
    	
    	$scheme = $parsedData['scheme'];
    	
    	$path = $parsedData['path'];
    	
    	$vars = explode('&', urldecode($parsedData['query']));
    	
    	foreach($vars as $pair){
    		$tmp = explode('=', $pair);
    		$variables[$tmp[0]] = $tmp[1];
    	}
    	
    	$keyword = str_replace('+', ' ', $variables[$searchMap[$host][0]]);    	
		
		$aid = $searchMap[$host][1];
		
		if($keyword == null){
			$qs = $parsedData['query'];	
			$aid = $searchMap['other'][1];
		}
		
		Affiliate_Scripts_Bl_ReferalParser::_insert($ccid, $host, $keyword, $qs);
		//QCore_History::writeHistory(WLOG_ERROR, "Organic Search: returning: aid=" .$aid, __FILE__, __LINE__);
		return $aid;
    }
    
    
    function _insert($ccid, $host, $keyword, $qs)
    {
    	$sql = 	'INSERT INTO '.ORGANIC_TABLE.' (ccid, host, keyword, raw_query_string, dateinserted) ' .
    			'VALUES ('._q($ccid).','._q($host).','._q($keyword). ',' . _q($qs) . ',' ._q(date('Y-m-d H:i:s')).')';
    
    	QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    }
}
?>