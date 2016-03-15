  <br>
  <form action=index.php method=post>
  <table class=listing cellspacing=0 cellpadding=2 border=0>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
	<tr>
	<td colspan=2><B>EMAIL</B><HR size=1></td>
	</tr>
    <tr>
      <td align=left nowrap>&nbsp;<b><?=L_G_SUBJECT?></b></td>
      <td align=left><input type=text size=60 name=emailsubject value='<?=str_replace("'",'',$_POST['emailsubject'])?>'></td>
    </tr>
    <tr>
      <td colspan=2 align=left nowrap>&nbsp;<b><?=L_G_MESSAGE_TEXT?></b></td>
    </tr>   
    <tr>
      <td colspan=2>&nbsp;
        <textarea name=emailtext rows=15 cols=80><?=$_POST['emailtext']?></textarea>&nbsp;
      </td>
    </tr>
    <tr>
      <td colspan=2 align=center>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Affiliates_Views_ContactUs'>
        <input type=hidden name=action value=<?=$_POST['action']?>>
        <input type=submit class=formbutton value='<?=L_G_SEND?>'>
      </td>
    </tr>
    <tr>
	<td colspan=2><HR size=1></td>
	</tr>
    <tr>
	<td colspan=2><B>PHONE</B><HR size=1></td>
	</tr>
	<tr>
      <td colspan=2 align=left nowrap>&nbsp;You can reach us by phone, at <b>1-512-249-5748 x104</b></td>
    </tr>
  </table>
  </form>

  <br>
