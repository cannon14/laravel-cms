
    <center>
    <form action=index_popup.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>&nbsp;<b>Keyword Id:</b>&nbsp;</td>
      <td><input type=text name=keywordId size=44 value="<?=$_POST['keywordId']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Keyword Name: </b>&nbsp;</td>
      <td><input type=text name=keyword size=44 value="<?=$_POST['keyword']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Show on Top: </b>&nbsp;</td>
      <td><input type=checkbox name=ordering <?= $_POST['ordering'] ? 'CHECKED' : ''?>>&nbsp;</td>
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