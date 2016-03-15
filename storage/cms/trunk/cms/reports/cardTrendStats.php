<?php
require_once('global.php');
//the chart's data

function aprString($apr){
	if($apr == 999){
		return "N/A";
	}
	
	if($apr == .01) $apr = 0.00;
	
	return round($apr, 2) . "%";
}

function aprValue($apr){
	if($apr == 999){
		return 0;
	}	
	
	return $apr;
}

$id = $_REQUEST['cardid'];

switch($_REQUEST['type']){


	case "currentVsAvg" :
		$sql = "SELECT * FROM rt_cards as c LEFT JOIN cs_carddata as cd ON (cd.cardId = c.cardId) WHERE c.cardId = " ._q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$sql = "SELECT AVG(regularApr), AVG(introApr), AVG(introAprPeriod) FROM cs_carddata WHERE introApr < 999 AND introApr > 0 AND regularApr > 0";
		$rs2 = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$chart['chart_data'] =  array(	array("", "Regular APR", "Intro APR"),
										array($rs->fields['cardTitle'], aprValue($rs->fields['regularApr']), aprValue($rs->fields['introApr'])),
										array("Overall Average", $rs2->fields['AVG(regularApr)'], $rs2->fields['AVG(introApr)']));
		
		$chart [ 'chart_value_text' ] = array ( array ( null, null, null),
                                        array ( null, aprString($rs->fields['regularApr']), aprString($rs->fields['introApr'])),
                                        array ( null, aprString($rs2->fields['AVG(regularApr)']), aprString($rs2->fields['AVG(introApr)']))
                                      );
                                     

		
		$chart [ 'chart_value' ] = array (  'position'=>"outside", 'size'=>10, 'color'=>"00000", 'alpha'=>100 ); 		
		
		$chart [ 'chart_type' ] = "column";
	break;
	
	case "currentVsMerchantAvg" :
		$sql = "SELECT * FROM rt_cards as c LEFT JOIN cs_carddata as cd ON (cd.cardId = c.cardId) WHERE c.cardId = " ._q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$sql = "SELECT AVG(cd.regularApr), AVG(cd.introApr), AVG(cd.introAprPeriod) FROM cs_carddata as cd JOIN rt_cards as c ON(c.cardId = cd.cardId) WHERE cd.introApr < 999 AND cd.introApr > 0 AND cd.regularApr > 0 AND c.merchant = " ._q($rs->fields['merchant']);
		
		$rs2 = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$chart['chart_data'] =  array(	array("", "Regular APR", "Intro APR"),
										array($rs->fields['cardTitle'], aprValue($rs->fields['regularApr']), aprValue($rs->fields['introApr'])),
										array($rs->fields['merchant'] . " Average", $rs2->fields['AVG(cd.regularApr)'], $rs2->fields['AVG(cd.introApr)']));
		
		$chart [ 'chart_value_text' ] = array ( array ( null, null, null),
                                        array ( null, aprString($rs->fields['regularApr']), aprString($rs->fields['introApr'])),
                                        array ( null, aprString($rs2->fields['AVG(cd.regularApr)']), aprString($rs2->fields['AVG(cd.introApr)']))
                                      );
                                     
		$chart [ 'chart_value' ] = array (  'position'=>"outside", 'size'=>10, 'color'=>"00000", 'alpha'=>100 ); 		
		
		
		$chart [ 'chart_type' ] = "column";
	break;
	
	default :
		$sql = "SELECT * FROM rt_cards as c LEFT JOIN cs_cardhistory as ch ON (ch.cardid = c.cardId) WHERE c.cardId = " . _q($id) . " ORDER BY ch.date DESC LIMIT 1";
		
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$chart [ 'chart_data' ] = array ( array ( "", "Jan", "Feb", "March", "April", "May", "June" ),
		                                  array ( $rs->fields['cardTitle'] . " (".$id.")",     11.5,     12.3,     11.3,     12.1, 14.24, 15.24),
		                                  array	( "Average APR", 10.9, 11.9, 12.1, 14, 14.9, 14.95),
		                                  );
	
		$chart [ 'chart_type' ] = "line";
	break; 
	                             
}

SendChartData ( $chart );
?>