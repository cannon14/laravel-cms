<script type="text/javascript">

function parseFiles(provider)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_RevenueParser&provider="+provider+"&action=process";
}

function syncTransactions(ID)
{
	if(confirm("Sync transactions?"))	
		document.location.href = "index.php?md=Affiliate_Merchants_Views_RevenueParser&providerid=" + ID + "&action=sync";
}

</script>

<form action=index.php method=post>

<!--
<table border=1 cellspacing=0 cellpadding="10" width="100%">
    <tr>
        <td align=left>
	        <table width="100%" cellspacing="0" cellpadding="0" border="0">
		        <tr>
				    <td>
				        
				        	
				         Next scheduled raw file process will run: <strong>
				        	<? $tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));
				        		print(date("m-d-Y 12:00:00", $tomorrow) . " AM"); ?></strong> 
				        
					</td>
				</tr>
	        </table>
        </td>
    </tr>
</table>

<br />
-->
<table class="listingClosed" width="100%" border="0" cellpadding="5" cellspacing="0">
	<tr>
		<td class=listheader nowrap>Provider</td>
		<td class=listheader nowrap># Clean Records</td>
		<td class=listheader nowrap># Error Records</td>
		<td class=listheader nowrap>Revenue</td>
		<td class=listheader nowrap># Error Files</td>
		<td class=listheader nowrap># Files Awaiting Upload</td>
		<td class=listheader nowrap>Actions</td>
	</tr>
	
	<? $this->a_this->getSystemStatus(); ?>
	
</table>

<input type="hidden" name="md" value="Affiliate_Merchants_Views_RevenueParser">
<input type="hidden" name="action" value="process">
</form>
			
<br>
<br>