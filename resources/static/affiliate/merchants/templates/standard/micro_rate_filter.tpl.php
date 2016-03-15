
<script>

function goBack()
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_RateManager";
}

function deActivate(ID)
{
	 if(confirm("Are you sure you want to deactivate this rate?  Once rates are deactivated they may not be reactivated."))
	document.location.href = "index.php?md=Affiliate_Merchants_Views_RateMicroManager&action=deactivate&rid=<?=$_REQUEST['rid']?>&id="+ID;
}

function addRate()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_RateMicroManager&action=add&mode=rate&rid=<?=$_REQUEST['rid']?>","EditRate","scrollbars=1, top=100, left=100, width=800, height=550, status=0");
    wnd.focus();
}

</script>

				
	<form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 cellspacing=0>
    <? QUnit_Templates::printFilter(10, "Product Rates Filter"); ?>
     <tr>
      <td align='center' colspan=4><img src='/affiliate/scripts/rateGantt.php?campaignid=<?=$_REQUEST['rid']?>'>     
      <br /><br />
      </td>
     
      </tr>
    <tr>
    	<td colspan="3" style="padding: 5px;" valign="top"> 
	    	 &nbsp;&nbsp;&nbsp;&nbsp;Rows per page: 	 
	    	<select  name=numrows onchange="javascript:FilterForm.list_page.value=0;">
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
	      	<br />
    	</td>
    	<td>
 	    	&nbsp;&nbsp;&nbsp;&nbsp;Show: 
 	    	<select  name=show >
	        <option value=''>Active</option>
	        <option <?=($_REQUEST['show'] == 'all' ? 'Selected' : '')?> value='all'>All</option>
	        <option <?=($_REQUEST['show'] == 'inactive' ? 'Selected' : '')?> value='inactive'>Inactive</option>
	      	</select>   	
    	</td>
    </tr>
    <tr>
    <td colspan=4 align='center'>
    <br /><br />
    <input class='formButton' type='submit' name='submitButton' value='Apply Filter'/>&nbsp;&nbsp; 
    <input type='button' class='formButton' value='Back To Product Rates' onClick='goBack();'/>
    <br /><br />
         		    <input type=hidden name=filtered value=1>
				    <input type=hidden name=md value='Affiliate_Merchants_Views_RateMicroManager'>
				    <input type=hidden name=type value='all'>
				    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
				    <input type=hidden id=action name=action value=''>    
				    <input type=hidden id=rid name=rid value="<?=$_REQUEST['rid']?>">
				    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
				    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
   					</form>
    </td>
    </tr>
    </table>
