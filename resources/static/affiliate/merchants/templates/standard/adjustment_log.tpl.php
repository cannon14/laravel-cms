	<table class=listing border=0 width=600 cellspacing=0>
	<?  
	QUnit_Templates::printFilter(10, "Adjustment Log"); 
	?>
    <tr>
    <td><b>Date Modified</td><td><b>Trans ID</td><td><b>Value Modified</td><td><b>Previous Value</td><td><b>New Value</td><td><b>Modified By</td>
   	</tr>
   	<tr>
   	<td colspan=6><hr></td>
   	</tr>
	<?
		echo $_POST['log'];
	?>
	</td>
	</tr>
	</table>
