   <table border=0>
   <tr>
   <td align=center valign=top>

    <table class=listing width=400 border=0 cellspacing=0 cellpadding=3>
      <? QUnit_Templates::printFilter(2, L_G_CLICKREGISTRATION); ?>
      <tr>
        <td align=center colspan=2>
        <?=L_G_CLICKREGISTRATIONHLP?>
        </td>
      </tr>
      <tr>
        <td align=left colspan=2>
        <?=L_G_JAVASCRIPTCLICKREGISTRATIONHLP?>
        </td>
      </tr>
      <tr>
        <td align=center colspan=2>
        <textarea rows=10 cols=100><script language="javascript">
<!--
urlparams = top.document.location.search;
if(urlparams != '')
    document.write("<img src='<?=$this->a_Auth->getSetting('Aff_scripts_url')?>t2.php"+urlparams+"&referrer="+escape(top.document.referrer)+"' border='0' width='1' height='1'>");
//-->
</script></textarea>
        </td>
      </tr>
      <tr>
        <td align=left colspan=2><br>
        <?=L_G_PHPCLICKREGISTRATIONHLP?>
        </td>
      </tr>
      <tr>
        <td align=center colspan=2>
        <textarea rows=10 cols=100>if($_GET['a_aid'] != '')
 print "<img src='<?=$this->a_Auth->getSetting('Aff_scripts_url')?>t2.php?a_aid=".$_GET['a_aid']."&a_bid=".$_GET['a_bid']."&referrer=".urlencode($_SERVER['HTTP_REFERER'])."' border='0' width='1' height='1'>";
</textarea>
        </td>
      </tr>
      <tr>
        <td align=left colspan=2>
        <?=L_G_CLICKREGISTRATIONHLP2?>
        </td>
      </tr>      
    </table>
    <br>
    
    <table class=listing width=400 border=0 cellspacing=0 cellpadding=3>
      <? QUnit_Templates::printFilter(2, L_G_TRANSCOMPLETION); ?>
      <tr>
        <td align=center colspan=2>
        <?=L_G_TRANSCOMPLETIONHLP?>
        </td>
      </tr>
      <tr>
        <td align=center colspan=2>
        <textarea rows=4 cols=100><img src="<?=$this->a_Auth->getSetting('Aff_scripts_url')?>sale.php?TotalCost=XXXXXX.XX&OrderID=XXXXXX&ProductID=XXXXXX" width=1 height=1></textarea>
        </td>
      </tr>
      <tr>
        <td align=left colspan=2>
        <?=L_G_TRANSCOMPLETIONHLP2?>
        </td>
      </tr>      
    </table>
    <br>
  </td>
  </tr>
  </table>  
  <br>
