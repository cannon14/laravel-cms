<?PHP
	include('calendar_functions.tpl.php');
?>
    <center>
    <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
    <form action=index.php method=post name=edit>
    <table class=listing border=0 width="100%" cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
 	<tr>
    	<td>Actual Estimated Revenue: </td><td><?=$_POST['actual_estimatedrevenue']?></td>
 	</tr>
    <tr>
    	<td>Errored Estimated Revenue: </td><td><input type=text name=estimatedrevenue size=8 value="<?=$_POST['estimatedrevenue']?>"></td>
 	</tr>

    <tr>
    	<td>Actual Process Date: </td><td><?=$_POST['actual_providerprocessdate']?></td>
 	</tr>

 	<tr>
    	<td><a href="javascript:javascript:show_calendar('edit.providerprocessdate');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date.'); return true;" onMouseOut="window.status=''; nd(); return true;">Choose Process Date:</a> </td><td><input type=text onfocus="this.blur()" name=providerprocessdate size=16 value="<?=$_POST['providerprocessdate']?>"></td>
 	</tr>
 	
    <tr>
      	<td>Actual Total Cost: </td><td><?=$_POST['actual_totalcost']?></td>
    </tr> 	
 	 <tr>
      	<td>Errored Total Cost: </td><td><input type=text name=totalcost size=8 value="<?=$_POST['totalcost']?>"></td>
    </tr>
    
    <tr>
    	<td>Actual Date Approved: </td><td><?=$_POST['actual_dateapproved']?></td>
 	</tr>

 	<tr>
      	<td><a href="javascript:javascript:show_calendar('edit.dateapproved');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date.'); return true;" onMouseOut="window.status=''; nd(); return true;">Choose Date Approved:</a> </td><td><input type=text onfocus="this.blur()" name=dateapproved size=16 value="<?=$_POST['dateapproved']?>"></td>
    </tr>


	<tr>
		<td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr>
		<td class=dir_form colspan=2 align=center>
      		<input type=hidden name=commited value=yes>
      		<input type=hidden name=md value='Affiliate_Merchants_Views_TransactionErrors'>
      		<input type=hidden name=action value=<?=$_POST['action']?>>
      		<input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      		<input type=hidden name=id value=<?=$_POST['id']?>>
      		<input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      	</td>
    </tr>
    </table>
    </form>
    </center>


