<html> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
<title>Merchants</title> 
<link rel="stylesheet" type="text/css" href="<?=$_SESSION[SESSION_PREFIX.'style']?>">
<SCRIPT language=JavaScript src="<?=$GLOBALS['IncludesPath'].'QUnit/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js'?>"></script>
<link rel="stylesheet" href="<?=$GLOBALS['IncludesPath'].'QUnit/js_calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css'?>" media="screen"></LINK>
<SCRIPT language=JavaScript src="<?=$_SESSION[SESSION_PREFIX.'javascript']?>"></SCRIPT>
<SCRIPT language=JavaScript src="/javascript/dojo.js"></SCRIPT>
<script>
// function for checking or unchecking all items
var checkedAllItems = false;

// preload images
//...
</script>
</head>

<body onload="javascript: initCollapsedMenuItems();" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0"  bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td colspan="3">
  <!--Start header-->
  <? include('header.tpl.php'); ?>
  <!--End header-->
  </td>
</tr>
<tr height="100%">

<? if($this->a_Auth->isLogged()) { ?>
  <td class="leftMenu" height="100%">
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

<tr>
  <td colspan="3">
  <!--Begin footer-->
  <? include('footer.tpl.php'); ?>
  <!--End footer-->
  </td>
</tr>
</table>

</body> 
</html>  