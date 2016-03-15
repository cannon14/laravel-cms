<script type="text/javascript" language="javascript">
<!--

function validateRateEntry(frm)
{
	if (frm.rate.value=="")
	{
		alert("Please enter a rate.");
		
		return false;
	} 
	else if((frm.month2.value!="00") || ((frm.day2.value!="00")) || ((frm.year2.value!="0000")))
	{
		if((frm.month2.valu=="00") || ((frm.day2.value=="00")) || ((frm.year2.value=="0000")))
		{
			alert("Please select a valid End Date.")
			
			return false;
		}
	}
	
	return true;
}

-->
</script>

<center>

<form action="index_popup.php" method="post" onsubmit="javascript:return validateRateEntry(this);">

<table border=0 class=listing cellspacing=0 cellpadding=2>
<? QUnit_Templates::printFilter(2, $_POST['header']); ?>
	<tr>
		<td class=dir_form>&nbsp;<b>Rate:</b>&nbsp;</td>
		<td>$<input type=text name=rate size=15 value="<?=$_POST['rate']?>">*&nbsp;</td>
	</tr>
	<tr>
		<td class=dir_form>&nbsp;<b>Start Date: </b>&nbsp;</td>
		<td><?
      		print L_G_MONTH;
		    echo "&nbsp;<select name=month1>";
		    for($i=1; $i<=12; $i++)
		      echo "<option value='$i' ".($i == ($_POST['action']=='edit'?$_REQUEST["month1"]:Date(m)) ? "selected" : "").">$i</option>\n";
		    echo "</select>&nbsp;&nbsp;";
		    
		    print L_G_DAY;
		    echo "&nbsp;<select name=day1>";
		    for($i=1; $i<=31; $i++)
		      echo "<option value='$i' ".($i == ($_POST['action']=='edit'?$_REQUEST["day1"]:Date(d)) ? "selected" : "").">$i</option>\n";
		    echo "</select>&nbsp;&nbsp;";
		    
		    print L_G_YEAR;
		    echo "&nbsp;<select name=year1>";
		    for($i=2003; $i<=Date(Y)+1; $i++)
	          echo "<option value='$i' ".($i == ($_POST['action']=='edit'?$_REQUEST["year1"]:Date(Y)) ? "selected" : "").">$i</option>\n";
		    echo "</select>&nbsp;&nbsp;";
	  		?>
		</td>
	</tr>
	<tr>
		<td class=dir_form>&nbsp;<b>End Date: </b>&nbsp;</td>
		<td>
		  <?
		    print L_G_MONTH;
		    echo "&nbsp;<select name=month2>";
		    echo "<option value='00' selected>--</option>\n";
		    for($i=1; $i<=12; $i++)
		      echo "<option value='$i' ".($i == ($_POST['action']=='edit'?$_REQUEST["month2"]:'') ? "selected" : "").">$i</option>\n";
		    echo "</select>&nbsp;&nbsp;";
		    
		    print L_G_DAY;
		    echo "&nbsp;<select name=day2>";
		    echo "<option value='00' selected>--</option>\n";
		    for($i=1; $i<=31; $i++)
		      echo "<option value='$i' ".($i == ($_POST['action']=='edit'?$_REQUEST["day2"]:'') ? "selected" : "").">$i</option>\n";
		    echo "</select>&nbsp;&nbsp;";
		    
		    print L_G_YEAR;
		    echo "&nbsp;<select name=year2>";
		    echo "<option value='0000' selected>----</option>\n";
		    for($i=2003; $i<=Date(Y)+1; $i++)
	          echo "<option value='$i' ".($i == ($_POST['action']=='edit'?$_REQUEST["year2"]:'') ? "selected" : "").">$i</option>\n";
	        echo "</select>&nbsp;&nbsp;";
		  ?>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<b>Comment:</b>
	    	<br />
	    	<br />
	    	<TEXTAREA cols="60" rows="10" name="comment"><?=$_POST['comment']?></TEXTAREA>
		</td>
	</tr>
</table>

<br>

<input type=hidden name=gid value='<?=$_REQUEST['gid']?>'>
<input type=hidden name=commited value=yes>
<input type=hidden name=md value='Affiliate_Merchants_Views_CampaignRateGroupsManager'>
<input type=hidden name=mode value=<?=$_REQUEST['mode']?>>
<input type=hidden name=action value=<?=$_POST['action']?>>
<!--<input type=hidden name=entryId value=<?=$_POST['entryId']?>>-->
<input type=hidden name=postaction value=<?=$_POST['postaction']?>>
    
<input type=submit class=formbutton value="Submit">
</form>
</center>