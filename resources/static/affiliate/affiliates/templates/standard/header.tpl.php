<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="headerLogo"><img src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>wdlogo.png" class="logo333" width="173" height="46" border="0"></td>
    
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="topHeader"></td>
    </tr>
    <tr>
        <td class="headerTopMenu">
        <!--Start top menu-->
        <? include('top_menu.tpl.php'); ?>
        <!--End top menu-->
        </td>
    </tr>
    </table>
    </td>
</tr>
<tr>
  <td class="topMenuLine" colspan="2"></td>
</tr>

<? if($this->a_Auth->isLogged()) { ?>

<tr>
  <td class="topMenuLineAboveMenu"></td>
  <td>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td class="topCorner"></td>
      <td class="topMenuLineAboveContent"><img src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png" width="1" height="1" border="0"><td>
    </tr>
    </table>
  </td>
</tr>

<? } else { ?>

<tr>
  <td class="topMenuLineAboveContent" colspan="2"><img src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png" width="1" height="1" border="0"></td>
</tr>
    
<? } ?>
</table>
