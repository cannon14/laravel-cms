    <center>
    <form action=index_popup.php method=post>
    <table class=listing width=450 border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>
      <?=L_G_CATEGORYNAME;?>
      </td>
      <td><input type=text name=catname size=40 value="<?=$_POST['catname']?>">*</td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
        <td align=left colspan=2>
        
        <? @include $this->a_commissions ?>
       
        </td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_CampCategoriesManager'>
      <input type=hidden name=cid value=<?=$_REQUEST['cid']?>>
      <input type=hidden name=catid value=<?=$_POST['catid']?>>      
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      <input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      <input type=hidden name=commtypenoarray value='<?=$_POST['commtypenoarray']?>'>
      </td>
    </tr>
    </table>
    </form>
    </center>
