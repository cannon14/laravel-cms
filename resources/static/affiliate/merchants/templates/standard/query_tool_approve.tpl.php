<?PHP
	include('calendar_functions.tpl.php');
?>


<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
   <center>
    <form name="estimates" action="index.php" method="post" >
    
    
    
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(4, $_POST['header']); ?>
    <tr>
    <td class=actionheader colspan="4"> 
    <a class=mainlink href="javascript:javascript:show_calendar('estimates.dateapproved_master');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date.'); return true;" onMouseOut="window.status=''; nd(); return true;">Choose Global Approval Date:</a>&nbsp;
    <input type='text' name='dateapproved_master' value=<?=date("Y-m-d H:i:s") ?> onfocus="this.blur();">
    </td> 
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    
    <?
    foreach($_POST['transarray'] as $currentTrans=>$estimatedRev){
    	$id ++;
    	$sum += $estimatedRev;
    ?>
    
    <tr>
    	<td><b>Transaction ID: </b><?=$currentTrans ?></td>
    </tr>
    <tr>
    	<td width="40%"> <a class=mainlink href="javascript:javascript:show_calendar('estimates.dateapproved_<?=$currentTrans?>');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date.'); return true;" onMouseOut="window.status=''; nd(); return true;">Select Individual Approval Date:</a> <input type="text" onfocus="this.blur()" name="dateapproved_<?=$currentTrans?>" size=15 value=""></td><td width="33%">Estimated Revenue: $<?=$estimatedRev ?></td><td width="26%"> $<input type=text id="$id" name="totalcost_<?=$currentTrans?>" onFocus="document.estimates.totalactual.value = (document.estimates.totalactual.value * 1 - document.estimates.totalcost_<?=$currentTrans?>.value * 1);" onBlur="document.estimates.totalactual.value = (document.estimates.totalactual.value * 1 + document.estimates.totalcost_<?=$currentTrans?>.value * 1);"  size=3 value="<? echo $estimatedRev?>"> Actual Revenue </td>
 	</tr> 
 	<tr>
    	<td colspan="5"><hr></td>
    </tr>	
<? } ?>
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td></td><td><b>Total Estimated Revenue: $<?=$sum?></td><td> $<input type=text size=3 name="totalactual" value="<?=$sum?>" id="totalactual"><b> Total Actual Revenue </td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<tr>
	<tr>
	<td>&nbsp;</td>
	<tr>
	<tr>
		<td class=dir_form colspan=5 align=center>
      		<input type=hidden name=commited value=yes>
      		<input type=hidden name=md value='Affiliate_Merchants_Views_QueryTool'>
      		<input type=hidden name=action value=<?=$_POST['action']?>>
      		<input type=hidden name=postaction value=approve_payout>
      		<input type=hidden name=estimatedrevenue value=<?=$_POST['estimatedrevenue'] ?>>
      		<input type=hidden name=tid value=<?=$_POST['tid']?>>
      		<input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      	</td>
    </tr>

    </table>
    </form>
    
    </center>


