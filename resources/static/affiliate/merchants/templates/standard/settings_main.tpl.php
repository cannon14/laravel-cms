<script>
function changeSheet(action, sheet)
{
    document.myForm.sheet.value = sheet;
    document.myForm.submit();
}
</script>

<form name=myForm action=index.php method=post>
<table class=listing33 border=0 width="100%" cellspacing=0 cellpadding=0>
<tr><td height="5"></td></tr>

<tr>
  <td colspan=2 align="left" valig=="top">
<?
    // include tabs
    QUnit_Templates::drawTabs($this->a_tabs, $this->a_selectedTab, 2);
?>    
  </td>
</tr>

<tr><td height="5" class="sideborders"><img src="'.$_SESSION[SESSION_PREFIX.'templateImages'].'blank.png" border="0" width="1" height="1"></td></tr>

<tr>
    <td class=settings align=left>

        <?=$this->a_tabcontent?>
    </td>
</tr>

<tr><td height="5"></td></tr>

<tr>
    <td align=left>
    &nbsp;&nbsp;
             <input type=hidden name=commited value=yes>
             <input type=hidden name=md value="Affiliate_Merchants_Views_Settings">
             <input type=hidden name=action value="edit">
<!--             <input type=hidden name=subact value=<?=$_POST['subact']?>>-->
             <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
             <input type=hidden name=sheet id=sheet value='<?=$_REQUEST['sheet']?>'>
             <input type=hidden name=subact value='<?=$_REQUEST['sheet']?>'>
             <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>
             <br><br>
    </td>
</tr>
</table>
</form>

