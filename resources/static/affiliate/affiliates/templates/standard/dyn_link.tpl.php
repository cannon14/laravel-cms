    <center>
    <form action="index_popup.php" method="post">
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(2, L_G_DYNAMICLINK) ?>
    <tr>
      <td class=dir_form>
      <?=L_G_DESTURL;?>
      </td>
      <td><input type=text name=desturl size=74 value="<?=$_POST['desturl']?>">*</td>
    </tr>
    <tr>
      <td class=dir_form align=center colspan=2>
      <input type=hidden name="md" value="Affiliate_Affiliates_Views_AffBannerManager">
      <input type=hidden name="bid" value="<?=$_REQUEST['bid']?>">
      <input type=hidden name="action" value="gendynamiclink">
      <input type=submit class=formbutton value='<?=L_G_SUBMIT?>'>&nbsp;&nbsp;&nbsp;
      <input type=button class=formbutton value='<?=L_G_CLOSE?>' onClick='javascript:window.close();'>
      </td>
    </tr>
    </table>
    </form>
    </center>
