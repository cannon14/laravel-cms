<div id='modName'>
<?=$_SESSION['modName']?>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
<tr>
    <td>
      <div align="left" class="merchlogo"><a href="http://www.creditcards.com"><img src="/affiliate/merchants/templates/standard/images/credit-cards.gif" border="0" alt="Credit Cards . Com" target="prodsite" ></a></div>
    </td>
    <td class="topUserInfo" align="right" valign="top">
        <!--Start logged field-->
        <? include('logged_field.tpl.php'); ?>
        <!--End logged field-->
    </td>
</tr>
<tr>
    <td width="100%">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
  <td class="topMenuLine" colspan="3"></td>
</tr>

<? if($this->a_Auth->isLogged()) { ?>

<!--<tr>
  <td class="topMenuLineAboveMenu"></td>
  <td colspan="2">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td class="topCorner"></td>
      <td class="topMenuLineAboveContent"><img src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png" width="1" height="1" border="0"><td>
    </tr>
    </table>
  </td>
</tr>//-->

<? } else { ?>

<!--<tr>
  <td class="topMenuLineAboveContent" colspan="3"><img src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png" width="1" height="1" border="0"></td>
</tr>//-->
    
<? } ?>
</table>
