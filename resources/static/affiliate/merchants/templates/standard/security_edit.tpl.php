      <center>
      <form action=index.php method=post>
      <table class=listing border=0 cellspacing=0 cellpadding=3>
      <? QUnit_Templates::printFilter(2, L_G_FRAUDPROTECTION); ?>
      <tr>
        <td class=listresult2 align=left>
        <input type=checkbox name=declinefrequentclicks value=1 <?=($_POST['declinefrequentclicks']==1 ? 'checked' : '')?>>
        <?=L_G_DECLINEFREQUENTCLICKS?>
        <input type=text name=clickfrequency size=4 value='<?=$_POST['clickfrequency']?>'>
        <?=L_G_SECONDS?> <?=L_G_DECLINEFREQUENTCLICKS2?>
        </td>
      </tr>
<? if($_POST['hiddencommtype'] != TRANSTYPE_CLICK) { ?>
      <tr>
        <td class=listresult2 align=left>
        <input type=checkbox name=declinefrequentsales value=1 <?=($_POST['declinefrequentsales']==1 ? 'checked' : '')?>>
        <?=L_G_DECLINEFREQUENTSALES?>
        <input type=text name=salefrequency size=4 value='<?=$_POST['salefrequency']?>'>
        <?=L_G_SECONDS?> <?=L_G_DECLINEFREQUENTSALES2?>
        
        </td>
      </tr>
      <tr>
        <td align=left class=listresult2>
        <input type=checkbox name=declinesameorderid value=1 <?=($_POST['declinesameorderid']==1 ? 'checked' : '')?>>
        <?=L_G_DECLINESALESSAMEORDERID?>
        </td>
      </tr>
<? } ?>      
        <tr>
          <td align=center>
          <input type=hidden name=commited value=yes>
          <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantProfile'>
          <input type=hidden name=postaction value='security'>
          <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>
          </td>
          </tr>      
      </table>
      </form>
      </center>
