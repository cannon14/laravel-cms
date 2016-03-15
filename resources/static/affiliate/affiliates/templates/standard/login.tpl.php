<script>
function forgot_password()
{
    document.location.href = "index_nosecuritycheck.php?md=QCore_ForgotPassword";
}
</script>

  <center>
  <!--Begin error message-->
  <? include('errorMsg.tpl.php'); ?>
  <!--End error message-->
  <form action=index.php method=post> 
  <table border=0 align=center> 
  <tr> 
    <td colspan=2 align=center><?=L_G_AFFILIATELOGIN?></td>
  </tr><tr> 
    <td align=right><?=L_G_USERNAME?>&nbsp;</td><td><input class=logon type=text name=username size=23 value='<?=$_REQUEST['username']?>'></td> 
  </tr><tr> 
    <td align=right><?=L_G_PASSWORD?>&nbsp;</td><td><input class=logon type=password name=rpassword size=23 value=''></td> 
  </tr>
<? if($this->a_Auth->getSetting('Aff_allow_choose_lang') == 1) 
   { 
?>
  <tr> 
    <td align=right><?=L_G_LANGUAGE?>&nbsp;</td>
    <td>
      <select name=lang>
<?    
      $selectedLang = $_POST['lang'];
      if($selectedLang == '')
        $selectedLang = $this->a_Auth->getSetting('Aff_default_lang');
      
      while($data=$this->a_list_data->getNextRecord()) { ?>
        <option value="<?=$data?>" <?=($selectedLang == $data ? 'selected' : '')?>><?=$data?></option>
<?    } ?>
      </select>
    </td>
  </tr>
<? } else { ?>
    <input type=hidden name=lang value="<?=$this->a_Auth->getSetting('Aff_default_lang')?>">
<? } ?>
  <tr> 
    <td colspan=2 align=center>
      <input type=hidden name=commited value='yes'>
      <input type=hidden name=md value='QCore_Login'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=submit class=formbutton value='<?=L_G_LOGIN?>'></td> 
  </tr> 
  </table> 
  </form>
  <br>
  <font size=-1>
  <?=L_G_FORGOTPASSWORD?> <a href='javascript:forgot_password();'><?=L_G_CLICKHERE?></a>
  </font>
</center>