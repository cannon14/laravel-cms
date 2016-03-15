
    <center>
    <form action=index_popup.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>&nbsp;<b>Group Name:</b>&nbsp;</td>
      <td><input type=text value='<?=$_POST['group_name']?>' name="group_name" size=40 value="<?=$_POST['group_name']?>"> *</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Description: </b>&nbsp;</td>
      <td>
      	<textarea cols="40" rows="5" name="description"><?=$_POST['description']?></textarea>
      </td>
    </tr>
    </table>
    <br>
		<input type="hidden" name="campaign_rate_group_id" value="<?=$_POST['campaign_rate_group_id']?>">
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_CampaignRateGroupsManager'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=gid value=<?=$_POST['gid']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
    
    <input type=submit class=formbutton value="Submit">
    </form>
    </center>