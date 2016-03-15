
    <center>
    <form action=index_popup.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>&nbsp;<b>Group Name:</b>&nbsp;</td>
      <td><input type=text value='<?=$_POST['name']?>' name=groupname size=44 value="<?=$_POST['refid']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Parent Group: </b>&nbsp;</td>
      <td><select name='parent'>*&nbsp;
      			<option value=''>None</option>
       <? if(is_array($_POST['parentarray'])) {
			foreach($_POST['parentarray'] as $value=>$name) { ?>
            	<option <?if($_POST['parentid'] == $value){?> selected <?}?> value='<?=$value?>'><?=$name?></option>
       		<? } 
       }?>
      </select>
      </td>
    </tr>
    </table>
    <br>
    
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_CampaignCategoryGroupsManager'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=gid value=<?=$_POST['gid']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
    
    <input type=submit class=formbutton value="Submit">
    </form>
    </center>