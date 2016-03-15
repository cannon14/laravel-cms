<? include('./header.htm'); ?>

<tr height="100%">
  <td align=left>
  <table border=10 width="100%" cellspacing=0 cellpadding=0>
  <tr>
<? if($this->a_Auth->isLogged()) { ?>
  <td class="leftMenu" bgcolor=ff0000 height="100%">
    <table width="182" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="leftMenuContentBorder"></td>    
      <td class="leftMenuMain" valign="bottom">

      <!--Begin left menu-->
      <? include('left_menu.tpl.php'); ?>
      <!--End left menu-->
      
      </td>
      <td class="leftMenuContentBorder"></td>
      <td class="leftMenuBorder"></td>
    </tr>
    </table>
  </td>
<? } ?>
  
  <td width="5">&nbsp;&nbsp;&nbsp;</td>
  <td class="contents">
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td valign="top" align="left">
    <br>
    
<? if($this->a_Auth->isLogged()) { ?>  
      <!--Begin error message-->
      <? include('error_msg.tpl.php'); ?>
      <!--End error message-->
<? } ?>

      <!--Begin content--> 
      <?= $this->content ?>
      <!--end content--> 
    </td>
  </tr>
  </table>
  </td>
</tr>
  </table>
  </td>
  </tr>
<? include('./footer.htm'); ?>  
