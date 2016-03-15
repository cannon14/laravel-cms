<html>
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
<title>Affiliate</title> 
<link rel="stylesheet" type="text/css" href="<?=$_SESSION[SESSION_PREFIX.'style']?>">
<SCRIPT language=JavaScript src="<?=$_SESSION[SESSION_PREFIX.'javascript']?>"></SCRIPT>
<script>
// function for checking or unchecking all items
var checkedAllItems = false;
</script>
</head> 
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0"  bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000"> 
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0"> 
  <tr> 
    <td valign=top align=center>
    <br>
    <!--Begin error message--> 

    <? include('errorMsg.tpl.php'); ?>
    <? //@include $this->my_message ?>

    <!--End error message-->

    <!--Begin content--> 

    <?= $this->content ?>

    <!--End content--> 
    <br>    
    </td>
  </tr>
  </table>
</body> 
</html>