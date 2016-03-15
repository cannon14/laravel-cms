<script type="text/javascript" language="javascript">
<!--

function validateKeywordsEntry(frm)
{
	if (frm.keyword_text.value=="")
	{
		alert("Please enter a keyword.");
		return false;
	}
	else if((checkbox_checker(frm) == 0) && (get_radio_value(frm) == 0))
	{
		alert("Please select at least one keyword type.");
		return false;
	}
	
	return true;
}

function get_radio_value(frm)
{
	for (var i=0; i < frm.deleted.length; i++)
   	{
   		if (frm.deleted[i].checked)
      	{
      		return frm.deleted[i].value;
      	}
   	}
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
    	<td colspan="2">
    		&nbsp;
    	</td>
    </tr>
    <tr>
      <td valign="top" style="padding-right: 10px;" class=dir_form>&nbsp;<b>Keyword:</b><br />&nbsp;</td>
      <td valign="top"><input type="text" size="40" name="keyword_text" value="<?=$_POST['keyword_text']?>"></td>
    </tr>
    <tr>
      <td valign="top" style="padding-right: 10px;" class=dir_form>&nbsp;<b>Status:</b><br />&nbsp;</td>
      <td valign="top">
      		<input type="radio" name="deleted" value="0" <? print($_POST['deleted']==0 ? 'checked' : ''); ?> /> Active
      		<br />
      		<input type="radio" name="deleted" value="1" <? print($_POST['deleted']==1 ? 'checked' : ''); ?> /> Inactive
      		<br />
      		<br />
      </td>
    </tr>
    <tr>
      <td valign="top" style="padding-right: 10px;" class="dir_form">&nbsp;<b>Types:</b>&nbsp;</td>
      <td valign="top">
      		<input type="checkbox" id="types" name="types[]" value="Exact" <? print (in_array("Exact", $_POST['types']) ? 'checked' : ''); ?> /> Exact
			<br />
			<input type="checkbox" id="types" name="types[]" value="Broad" <? print (in_array("Broad", $_POST['types']) ? 'checked' : ''); ?> /> Broad
			<br />
			<input type="checkbox" id="types" name="types[]" value="Phrase" <? print (in_array("Phrase", $_POST['types']) ? 'checked' : ''); ?> /> Phrase
      </td>
    </tr>
    </table>
    		
    <br>
      
      <input type="hidden" name="keyword_text_id" value="<?=$_POST['keyword_text_id']?>">
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_KeywordsManager'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      <input type=hidden name=mode value="<?=$_REQUEST['mode']?>">
    
    <input type=submit class=formbutton value="Submit">
    </form>
    </center>