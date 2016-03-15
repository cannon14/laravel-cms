<html> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
<title>SuperAdmin</title> 
<link rel="stylesheet" type="text/css" href="<?=$_SESSION[SESSION_PREFIX.'style']?>">
<SCRIPT language=JavaScript src="<?=$_SESSION[SESSION_PREFIX.'javascript']?>"></SCRIPT>
<script>
// function for checking or unchecking all items
var checkedAllItems = false;

// preload images
//...
</script>
</head>

<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0"  bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td colspan="2">
  <!--Start header-->
  <? include('header.tpl.php'); ?>
  <!--End header-->
  </td>
</tr>
<tr height="100%">
  <td class="contents">
      <!--Begin content--> 
      <?= $this->content ?>
      <!--end content--> 
      <br>
  </td>
</tr>

<tr>
  <td colspan="2">
  <!--Begin footer-->
  <? include('footer.tpl.php'); ?>
  <!--End footer-->
  </td>
</tr>
</table>

</body> 
</html>  
