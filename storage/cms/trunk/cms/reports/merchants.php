<?php
require_once('global.php');
//the chart's data

$sql = "SELECT *, COUNT(*) as count FROM rt_cards  WHERE (merchant <> '') GROUP BY merchant ORDER BY count DESC";
$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

$data[] = array ("", "Cards",);

$merchants = array();
while($rs && !$rs->EOF){
	$merchants[] = $rs->fields['merchant'] . " [".$rs->fields['count']."] ";
	$count[] = $rs->fields['count'];	
	$rs->MoveNext();	
}

$chart [ 'chart_data' ] = array($merchants, $count);
$chart [ 'chart_type' ] = "3d pie";

//$chart [ 'series_color' ] = array ( "CCCCCC", "CCCCDD" );
 
//send the new data to charts.swf
SendChartData ( $chart );
?>
