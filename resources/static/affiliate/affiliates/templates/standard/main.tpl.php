<? include('./header.htm'); ?>

<tr height="100%">

<? if($this->a_Auth->isLogged()) { ?>
  <td class="leftMenu" height="100%">
    <table width="200" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="leftMenuContentBorder"></td>    
      <td class="leftMenuMain">

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

<? include('./footer.htm'); ?>  
