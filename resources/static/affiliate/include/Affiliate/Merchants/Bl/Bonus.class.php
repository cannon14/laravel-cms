<?
class Affiliate_Merchants_Bl_Bonus
{
    function getTransactions($conditions)
    {
    	//create base sql
    	$sql = 'SELECT t.*,
					SUM(t.estimatedrevenue) as totalestimatedrevenue,
					COUNT(t.transid) as records
					FROM wd_pa_transactions as t';

		//create joins where needed
		if($conditions['campcategory'])				
			$join .= ' LEFT JOIN wd_pa_campaigncategories as cc' .
					 ' ON t.campcategoryid=cc.campcategoryid';
		
		//create where clause
		$where = ' WHERE providerprocessdate >= '._q($conditions['from']).
		 		 ' AND providerprocessdate <= '._q($conditions['to']);
		 		 
		 if($conditions['campcategory'])
		 	$where .=  ' AND cc.campaignid IN ("'.implode('","',$conditions['campcategory']).'")';
				 
		$orderBy = ' GROUP BY reftrans'.$conditions['orderby'];
		
		$sql2 = 'SELECT trans.* FROM('.$sql.$join.$where.$orderBy.') as trans ' .
				'WHERE trans.estimatedrevenue IS NOT NULL ' .
				'AND trans.estimatedrevenue != 0';
		
		//echo  $sql2.'<br>';
		$rs = QCore_Sql_DBUnit::execute($sql2, __FILE__, __LINE__, true);
		
		//init paging
		$_REQUEST['allcount'] = $rs->_numOfRows;
		if($rs->_numOfRows<$conditions['page']*$conditions['rowsPerPage'])
	    	$page = 0;          
	          
	    $_REQUEST['list_pages'] = (int) ceil($rs->_numOfRows/$conditions['rowsPerPage']);
	    $_REQUEST['list_page'] = $conditions['page'];
	    
	    if($conditions['page'] == 0)
	    	$limitOffset = 0;
	    else
	    	$limitOffset = ($conditions['page'])*$conditions['rowsPerPage'];
	    
	    if($conditions['page'] !== '' && $conditions['rowsPerPage'] !== '' && $conditions['pagination']) // paging query
	        $rs = QCore_Sql_DBUnit::selectLimit($sql2, $limitOffset, $conditions['rowsPerPage'], __FILE__, __LINE__, true);
		return $rs;
    }
    
    function insertBonus($amount, $rsData)
    {
    	if($rsData['reftrans'] == '')
    		$rsData['reftrans'] = $rsData['transid'];
    		
		$rsData['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
		$rsData['transtype'] = TRANSTYPE_BONUS;
		$rsData['estimatedrevenue'] = $amount;
		$rsData['dateestimated'] = date("Y-m-d H:i:s");
		$rsData['commission'] = 0;		
		$rsData['totalcost'] = 0;
		
		unset($rsData['totalestimatedrevenue']);
		unset($rsData['records']);
    	
    	$sql = 'INSERT into wd_pa_transactions (`'.implode('`, `',array_keys($rsData)).'`) VALUES ("'.implode('", "',$rsData).'")';
    	//echo $sql.'<br>';
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	//QUnit_Messager::setErrorMessage('This feature is currently restricted during testing.');
    }
}
?>
