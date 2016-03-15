<script type="text/javascript" language="javascript">
<!--

function validateKeywordsEntry(frm)
{
	if (frm.keywords.value=="")
	{
		alert("Please enter keywords.");
		return false;
	} 
	else if(checkbox_checker(frm) == 0)
	{
		alert("Please select at least one keyword type.");
		return false;
	}
	
	return true;
}

function checkbox_checker(frm)
{
	var choices = 0;
	
	for (i=0; i<frm.types.length; i++)
	{
		if (frm.types[i].checked)
		{
			choices++;
		}	
	}
	
	return choices;
}
-->
</script>

    <center>
    
    <form action="index_popup.php" method="post" onsubmit="javascript:return validateKeywordsEntry(this);">
    <table border="0" class="listing" cellspacing="0" cellpadding="2">
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
    	<td colspan="2" style="padding: 5px;">
    		Paste keywords in the textbox below with one keyword per line.
    		<br />
    		Select the types to add from the right. Types will be added
    		<br />
    		to ALL keywords that are listed.
    		<br /><br />
    	</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Keywords:</b>&nbsp;</td>
      <td class=dir_form>&nbsp;<b>Types:</b>&nbsp;</td>
    </tr>
    <tr>
      <td style="padding-right: 15px;"><textarea name="keywords" cols="50" rows="15"></textarea></td>
      <td valign="top" style="padding-right: 15px;">
      		<input type="checkbox" id="types" name="types[]" value="Exact" /> Exact
			<br />
			<input type="checkbox" id="types" name="types[]" value="Broad" /> Broad
			<br />
			<input type="checkbox" id="types" name="types[]" value="Phrase" /> Phrase
      </td>
    </tr>
    </table>
    		
    <br>
      
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_KeywordsManager'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      <input type=hidden name=mode value="<?=$_REQUEST['mode']?>">
    
    <input type=submit class=formbutton value="Submit">
    </form>
    </center>