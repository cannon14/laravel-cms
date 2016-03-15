<script>
function changeCategory(sel)
{
  if(sel.value != '')
  {
    document.location.href = 'index.php?md=Affiliate_Merchants_Views_AffEmailTemplates&emailcategory='+sel.value+'&language=<?=$_REQUEST['language']?>';
  }
}

function changeLanguage(sel)
{
  if(sel.value != '')
  {
    document.location.href = 'index.php?md=Affiliate_Merchants_Views_AffEmailTemplates&emailcategory=<?=$_REQUEST['emailcategory']?>&language='+sel.value;
  }
}
</script>
<table border=0 cellspacing=0 cellpadding=5>
<tr>
  <td align=left valign=top>   
    <form action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <? QUnit_Templates::printFilter(3, L_G_ETMANAGEMENT); ?>
<? if($this->a_Auth->getSetting('Aff_allow_choose_lang') == 1) 
   { 
?>       
    <tr>
     <td align=left>&nbsp;<?=L_G_LANGUAGE?></td>
     <td align=left colspan=2 >
      <select name=language onchange="changeLanguage(this);">
<?    while($data=$this->a_list_data3->getNextRecord()) { ?>
        <option value="<?=$data?>" <?=($_REQUEST['language'] == $data ? 'selected' : '')?>><?=$data?></option>
<?    } ?>
      </select>     
     </td>
    </tr>    
<? } else { ?>
    <input type=hidden name=language value="<?=$this->a_Auth->getSetting('Aff_default_lang')?>">
<? } ?>
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_CATEGORY?></td>
     <td align=left>
     <select name=emailcategory onchange="changeCategory(this);">
<?
      while($data=$this->a_list_data2->getNextRecord())
        echo "<option value='".$data."' ".($_REQUEST['emailcategory'] == $data ? "selected" : "").">".constant('L_G_'.$data)."</option>\n";
?>
     </select>
     </td>
     <td align=right>
     </td>
    </tr>    

<? $data=$this->a_list_data->getNextRecord(); ?>
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_SUBJECT?></td>
     <td align=left colspan=2>
     <input type=text size=70 name=emailsubject value='<?=str_replace("'",'',$data['emailsubject'])?>'>
     </td>
    </tr>    
    <tr>
      <td colspan=3 align=left>&nbsp;<?=L_G_TEXT?></td>
    </tr>   
    <tr>
      <td colspan=3 align=center>&nbsp;
      <textarea name=emailtext rows=18 cols=80><?=$data['emailtext']?></textarea>&nbsp;
      </td>
    </tr>    
    <tr>
      <td colspan=3 align=center>
      <? if($this->a_action_permission['edittemplate']) { ?>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_AffEmailTemplates'>
        <input type=hidden name=action value=<?=$_POST['action']?>>
        <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
        <input class=formbutton type=submit value='<?=L_G_SAVECHANGES; ?>'>
      <? } ?>
      </td>
    </tr>
    <tr>
      <td colspan=3>&nbsp;</td>
    </tr>
    </table>
    </form>
    
  </td>
  <td align=left valign=top>   

    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <? QUnit_Templates::printFilter(3, L_G_ALLOWEDCONSTANTS); ?>
    <tr>
      <td valign=top align=left>
      <? showHelp('L_G_HLPEMAILTEMPLATES'); ?>
      </td>
    </tr>    
    <tr>
      <td valign=top align=left>
      <?=constant('L_G_HLP_'.$_REQUEST['emailcategory'])?>
      </td>
    </tr>
    </table>
    
  </td>
</tr>
</table>    
