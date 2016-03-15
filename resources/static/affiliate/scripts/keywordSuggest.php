<?php
/*
 * Created on Mar 2, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// include files
require_once('global.php');

$keyword = addslashes($_GET['keyword']);

//Make sure that a value was sent.
if (isset($keyword) && $keyword != '')
{
	/*$sql = "SELECT kt.keyword_text, k.keyword_id FROM keyword_text as kt LEFT JOIN keywords as k using keyword_text_id" .
			" WHERE kt.keyword_text Like '" . $keyword . "%'" .
			" ORDER BY kt.keyword_text ASC" .
			" LIMIT 200";
	*/
	$sql = "SELECT kt.keyword_text, k.keyword_id FROM keyword_text as kt LEFT JOIN keywords as k on kt.keyword_text_id=k.keyword_text_id" .
			" WHERE kt.keyword_text Like '" . $keyword . "%' OR k.keyword_id Like '" . $keyword . "%'" .
			" ORDER BY kt.keyword_text ASC" .
			" LIMIT 200";
	
	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
    
    if(!$rs)
    {
      QUnit_Messager::setErrorMessage(L_G_DBERROR);
      return false;
    }
    
	$count = 0;
	
	$results = '';
	
	while(!$rs->EOF)
    {
		//Return each page title seperated by a newline.
		$results .= $rs->fields['keyword_text'] . " - " . $rs->fields['keyword_id'] . "\n";
		
		$count++;
		
		$rs->MoveNext();
	}
	
	$results .= "|,|" . $count;
	
	echo $results;
}
?>
