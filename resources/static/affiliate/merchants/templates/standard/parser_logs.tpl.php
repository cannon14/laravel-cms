<?php
	$file = "../logs/";
	
	if($_REQUEST['reporttype'] == "error log"){
		$file .= "parser_error.log"; 
		$purge = "<a href='" . $_SERVER['PHP_SELF'] . "?md=Affiliate_Merchants_Views_ParserLogs&reporttype=error log&purge=error'>Purge</a>"; 
	}else{
		$file .= "parser.log";
		$purge = "<a href='" . $_SERVER['PHP_SELF'] . "?md=Affiliate_Merchants_Views_ParserLogs&reporttype=parser log&purge=parser'>Purge</a>"; 
	}
	
	if(($purgelog = $_REQUEST['purge']) != null){
		$fp = fopen($file, "w");
		fwrite($fp, "");
		fclose($fp);
		$message = "Log successfully purged.<br>";
	}
	
	$fp = fopen($file, 'r');
	?>
	<table class=listing border=0 width=600 cellspacing=0>
	<? $header =  $_REQUEST['reporttype'] . " [" . $purge . "]"; 
	QUnit_Templates::printFilter(10, $header); 
	?>
    <tr>
    <td>
   
	<?
	echo $message . "<br>";
	while($read = fgets($fp, 1048))
		echo $read . "<br>";
	?>
	</td>
	</tr>
	</table>
