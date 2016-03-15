<script type="text/javascript">

function parseFiles(provider)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_ExpenseParser&provider="+provider+"&action=process";
}

function syncExpenses(ID)
{
	if(confirm("Sync expenses?"))	
		document.location.href = "index.php?md=Affiliate_Merchants_Views_ExpenseParser&affiliate_id=" + ID + "&action=sync";
}

function syncOtherExpenses()
{
	if(confirm("Sync other expenses?"))	
		document.location.href = "index.php?md=Affiliate_Merchants_Views_ExpenseParser&action=syncOther";
}

</script>

<table border=0 cellspacing=0 cellpadding="10" width="100%">
    <tr>
        <td align=left>
	        <table width="100%" cellspacing="0" cellpadding="0" border="0">
		        <tr>
				    <td>
				        <form action=index.php method=post>
				        	
				        <!-- Next scheduled raw file process will run: <strong>
				        	<? $tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));
				        		print(date("m-d-Y 12:00:00", $tomorrow) . " AM"); ?></strong> -->
				        
					</td>
				</tr>
	        </table>
        </td>
    </tr>
</table>

<br />

<table class="listingClosed" width="100%" border="0" cellpadding="5" cellspacing="0">
	<tr>
		<td class=listheader nowrap>Network</td>
		<td class=listheader nowrap># Clean Records</td>
		<td class=listheader nowrap># Error Records</td>
		<td class=listheader nowrap>Expense</td>
		<td class=listheader nowrap># Error Files</td>
		<td class=listheader nowrap># Files Awaiting Upload</td>
		<td class=listheader nowrap>Actions</td>
	</tr>
	
	<? $this->a_this->getSystemStatus(); ?>
	
</table>

<input type=hidden name=md value='Affiliate_Merchants_Views_RevenueParser'>
<input type=hidden name=action value='process'>
</form>
			
<br>
<br>