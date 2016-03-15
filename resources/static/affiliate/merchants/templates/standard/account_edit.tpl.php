
    <center>
    <form action=index_popup.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(2, L_G_EDITACCOUNTSETTINGS); ?>
    <tr>
      <td class=dir_form>
      <?=L_G_USERNAME2;?>
      </td>
      <td><input type=text name=uname size=20 value="<?=$_POST['uname']?>">*</td>
    <tr>
      <td class=dir_form>
      <?=L_G_PASSWORD;?>
      </td>
      <td><input type=password name=pwd1 size=22 value="<?=$_POST['pwd1']?>">*</td>
    </tr>
    <tr>
      <td class=dir_form>
      <?=L_G_PWD2;?>
      </td>
      <td><input type=password name=pwd2 size=22 value="<?=$_POST['pwd2']?>">*</td>
    </tr>
    
    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantProfile'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=mid value=<?=$_POST['mid']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      <input class=formbutton type=button value='<?=L_G_CLOSE; ?>' onClick='javascript:window.close();'>
      &nbsp;&nbsp;
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>
    </center>
