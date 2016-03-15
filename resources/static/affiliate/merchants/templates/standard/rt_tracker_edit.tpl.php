
    <center>
    <form action=index_popup.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>&nbsp;<b>Tracker Id:</b>&nbsp;</td>
      <td><input type=text name=trackerId size=44 value="<?=$_POST['trackerId']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Tracker Name: </b>&nbsp;</td>
      <td><input type=text name=trackerName size=44 value="<?=$_POST['trackerName']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Show Item at Top of List: </b>&nbsp;</td>
      <td><input type=checkbox name=ordering<?php if ($_POST['ordering'] == "1") echo " checked=checked"; ?>></td>
    </tr>
    </table>
    <br>
    
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_TrackingManager'>
      <input type=hidden name=mode value=<?=$_REQUEST['mode']?>>
       <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=entryId value=<?=$_POST['entryId']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
    
    <input type=submit class=formbutton value="Submit">
    </form>
    </center>