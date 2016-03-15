    <center>
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(2, L_G_DYNAMICLINK) ?>
      <tr>
        <td class=listresult align=center colspan=2></td>   
      </tr>    
      <tr>
        <td align=left colspan=2><?=L_G_CODETOINSERT?><br>
          <center>
          <textarea cols=90 rows=6><?=$this->a_bannerCode?></textarea>
          </center>
        </td>
      </tr>
    <tr>
      <td class=dir_form align=center colspan=2>
      <input type=hidden name="md" value="Affiliate_Affiliates_Views_AffBannerManager">
      <input type=hidden name="action" value="gendynamiclink">
      <input type=button class=formbutton value='<?=L_G_BACK?>'  onClick='javascript:document.location.href="index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=dynamiclink&bid=<?=$_REQUEST['bid']?>";'>&nbsp;&nbsp;&nbsp;
      <input type=button class=formbutton value='<?=L_G_CLOSE?>' onClick='javascript:window.close();'>
      </td>
    </tr>
    </table>
    </center>