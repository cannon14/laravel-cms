<?php
/**
 * Rate Chart Template
 * 
 * This is where the rate chart is actually rendered into HTML
 * 
 * @copyright 2008 CreditCards.com
 * 
 */
?>
<style type="text/css">
/*table.ehs_rate_table th {
	background-color: #E7E7E7;
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	text-decoration: none;
	font-weight:normal;
	color:#000000;
}
table.ehs_rate_table tr.odd {
	background-color: #E7E7E7;
}
table.ehs_rate_table {
	border: 1px solid #ccc;
	border-collapse: collapse;
	margin: 10px;
}
table.ehs_rate_table td,table.listWidget th {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;			
	padding: 0px;
	line-height: 16px;
	margin: 0;
}
span.ehs_rate_table_ItemName a {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #003366;
}
span.ehs_rate_table_ItemName a:visited {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #003366;
}
span.ehs_cccom_link a {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #003366;
}

span.ehs_cccom_link a:visited {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #003366;
}
.ehs_rates_link:visited {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #003366;
}
span.ehs_rate_table_ItemAvg a{
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #003366;
}

span.ehs_rate_table_ItemAvg a:visited{
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #003366;
}
.apr {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color:#000000;
	background-color: #E7E7E7;
	text-align: center;
}
span.chart_title {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight:bold;
	color:#6B7173;
	float: left;
}
span.title {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight:bold;
	color:#003366;
}
span.chart_compare a{
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight:bold;
	color:#003366;	
	float: right;
}

span.ehs_rate_table_ItemName a:visited{
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color:#003366;	
}
span.chart_compare a:visited{
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight:bold;
	color:#003366;	
	float: right;
}
span.ehs_rates_link, a.ehs_rates_link{
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color:#003366;
}
*/</style>


<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="table table-striped">
	<tr><td colspan="3">&nbsp;RATE REPORT<span style="float: right; padding-right: 5px;"><?=date("m-d-Y")?></span></td></tr>
	<tr><th colspan="3">&nbsp;CREDIT CARDS</th></tr>
	<tr><td>&nbsp;</td><td>Change</td><td>Avg. APR</td></tr>
	<?php	
			$i = 0;
			foreach($this->_rates as $rate){
			?>
				<tr <?=($i % 2 == 1 ? 'class = "odd"' : '' )?>>
					<td>&nbsp;<a href="<?=$rate->getLink() ?>" ><?=$rate->getName() ?></a></td>
					<td align="center"><?=$rate->getMovement() == 'UP' ? '<img style="float: none; margin: 0; padding: 0;" align="center" src="http://www.imgsynergy.com/16a772df/Up.gif"' : '<img style="float: none; margin: 0; padding: 0;" align="center" src="http://www.imgsynergy.com/16a772df/Down.gif"'?>></td>
					<td align="center"><a href="<?=$rate->getLink() ?>"><?=$rate->getAvgApr() ?>%</a></td>
				</tr>
			<?php	
				++$i;
			}
		?>
</table>

