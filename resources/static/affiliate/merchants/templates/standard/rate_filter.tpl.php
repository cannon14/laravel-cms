<script language="javascript" type="text/javascript">
<!--

function editRate(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_RateMicroManager&mode=rate&rid=" + ID;
}

function filterByAlphabet(ID)
{
	frm = document.getElementById("FilterForm");
	frm.alphabetFilter.value = ID;
	
	frm.submit();
}

//-->
</script>

				
	<form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 width=650 cellspacing=0>
    <? QUnit_Templates::printFilter(10, "Product Rates Filter"); ?>    
    <tr>
    	<td colspan="3" style="padding: 5px;" valign="top">
	    	Search by Name / Product ID: <input type="text" name="product_search" value="<?=$_REQUEST['product_search']?>" size="50">
    	</td>
    </tr>
    <tr>
    	<td colspan="3" style="padding: 5px;" valign="top"> 
	    	Select Product: <? $this->a_this->printRateAvailableProducts(); ?>
    	</td>
    </tr>
    <tr>
    	<td style="padding: 5px;" valign="top"> 
    		 Show: &nbsp;&nbsp;&nbsp;&nbsp;
			<select name=showProd>
	        <option value='1' <?=($_REQUEST['showProd'] == '1' ? 'selected' : '')?> >Products With Active Rates</option>
	        <option value='0' <?=($_REQUEST['showProd'] == '0' ? 'selected' : '')?> >Products Without Active Rates</option>
	        <option value='all' <?=($_REQUEST['showProd'] == 'all' ? 'selected' : '')?> >All</option>
	      	</select>    		
    	</td>
    	<td>
    		Rows per page: <select  name=numrows onchange="javascript:FilterForm.list_page.value=0;">
	        <option value=10 <? print ($_REQUEST['numrows']==10 ? "selected" : ""); ?>>10</option>
	        <option value=20 <? print ($_REQUEST['numrows']==20 ? "selected" : ""); ?>>20</option>
	        <option value=30 <? print ($_REQUEST['numrows']==30 ? "selected" : ""); ?>>30</option>
	        <option value=50 <? print ($_REQUEST['numrows']==50 ? "selected" : ""); ?>>50</option>
	        <option value=100 <? print ($_REQUEST['numrows']==100 ? "selected" : ""); ?>>100</option>
	        <option value=200 <? print ($_REQUEST['numrows']==200 ? "selected" : ""); ?>>200</option>
	        <option value=500 <? print ($_REQUEST['numrows']==500 ? "selected" : ""); ?>>500</option>
	        <option value=1000 <? print ($_REQUEST['numrows']==1000 ? "selected" : ""); ?>>1000</option>
	        <option value=100000000 <? print ($_REQUEST['numrows']==100000000 ? "selected" : ""); ?>><?=L_G_ALL?></option>
	      	</select>
    	</td>
    	<td>
    		&nbsp;&nbsp;Alphabet Filter: <input type="text" name="alphabetFilter" size="5" id="alphabetFilter" value="<?=$_REQUEST['alphabetFilter']?>" readonly><br><small>(Select letter below to activate)</small>
    	</td>
    </tr>
    <tr>
    	<td style="padding: 5px;" valign="top">
    		<!--Status: <input name="hold" type="checkbox" checked value="modified" /> Active &nbsp;&nbsp; <input name="hold" type="checkbox" checked value="new" /> Archived-->
			<br />
			<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="formbutton" value="Apply Filter"> <input type="button" onclick="javascript:location.href='index.php?md=Affiliate_Merchants_Views_RateManager'" class="formbutton" value="Remove Filter">
		</td>
		<td nowrap style="padding: 5px; text-align: right;">
			
	      </td>
	      <td style="padding: 5px;" valign="top">
			
	
				    <input type=hidden name=filtered value=1>
				    <input type=hidden name=md value='Affiliate_Merchants_Views_RateManager'>
				    <input type=hidden name=type value='all'>
				    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
				    <input type=hidden id=action name=action value=''>    
				    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
				    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
					</form>
				
				</td>
			</tr>
		</table>