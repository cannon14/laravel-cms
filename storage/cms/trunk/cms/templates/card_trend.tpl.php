<table>
<tr>
<td>
<center>
<input class=formbutton type=button value="BACK" onClick="goToMod('CMS_view_cards')">    
</center>
<table align='left'>
<tr>
<td align ='center'>
<h2>
APRs VS Overall Average
</h2>
</td>
</tr>
<tr>
<td>
<?
	echo InsertChart($GLOBALS['IncludesPath']."php_charts/charts.swf", $GLOBALS['IncludesPath']."php_charts/charts_library", "reports/cardTrendStats.php?cardid=".$_REQUEST['cardId']."&type=currentVsAvg", 400, 250, "FFFFFF", false );
?>
</td>
</tr>
</table>
<table>
<tr>
<td align ='center'>
<h2>
APRs VS Issuer Average
</h2>
</td>
</tr>
<tr>
<td>
<?
	echo InsertChart($GLOBALS['IncludesPath']."php_charts/charts.swf", $GLOBALS['IncludesPath']."php_charts/charts_library", "reports/cardTrendStats.php?cardid=".$_REQUEST['cardId']."&type=currentVsMerchantAvg", 400, 250, "FFFFFF", false );
?>
</td>
</tr>
</table>
<br><br>
<font color='red'><b>Everything below the line is dummy data (we don't have enough trend data yet).</b></font><hr>
<table align=left>
<tr>
<td align ='center'>
<h2>
Regular APR
</h2>
</td>
</tr>
<tr>
<td>
<?
	echo InsertChart($GLOBALS['IncludesPath']."php_charts/charts.swf", $GLOBALS['IncludesPath']."php_charts/charts_library", "reports/cardTrendStats.php?cardid=".$_REQUEST['cardId']."&type=regularApr", 400, 250, "FFFFFF", false );
?>
</td>
</tr>
</table>

<table>
<tr>
<td align ='center'>
<h2>
Intro APR
</h2>
</td>
</tr>
<tr>
<td>
<?
	echo InsertChart($GLOBALS['IncludesPath']."php_charts/charts.swf", $GLOBALS['IncludesPath']."php_charts/charts_library", "reports/cardTrendStats.php?cardid=".$_REQUEST['cardId']."&type=introApr", 400, 250, "FFFFFF", false );
?>
</td>
</tr>
</table>
</td>
</tr>
</table>