
    <center>
    <form action=index_popup.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(1, $_POST['header']); ?>
    <tr><td>
    <table border=0 cellspacing=0 cellpadding=2>
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_NAME;?></b>&nbsp;</td>
      <td><input type=text name=name size=44 value="<?=$_POST['name']?>">*&nbsp;</td>
    </tr>
    </table>
    
    </td></tr>
    <? QUnit_Templates::printFilter(2, L_G_USER_RIGHTS); ?>
    <tr><td>
    
    <table border=0 cellspacing=0 cellpadding=2>
    <? if(is_array($this->a_rts)) { ?>
      <? foreach($this->a_rts as $category) { ?>
        <tr>
          <td valign=top colspan=2 nowrap>&nbsp;<b><?=(defined($category['category']) ? constant($category['category']) : $category['category'])?></b>&nbsp;</td>
        </tr>
        <? if(is_array($category['rights'])) { ?>
          <? foreach($category['rights'] as $code => $right) { ?>
            <tr>
              <td valign=top nowrap>&nbsp;&nbsp;&nbsp;&nbsp;<?=(defined($right['right']) ? constant($right['right']) : $right['right'])?>&nbsp;</td>
              <td valign=top nowrap>
              <? foreach($right['types'] as $type) { ?>
                   <td valign=top nowrap>
                    <input type=checkbox name=userrighttype[] value='<?=$type['righttypeid']?>' 
                            <?=(in_array($type['righttypeid'], $_POST['userrighttype']) ? 'checked' : '')?>
                            >&nbsp;<?=(defined($type['langid']) ? constant($type['langid']) : $type['langid'])?>&nbsp;
                   </td>
              <? } ?>
              </td>
            </tr>
          <? } ?>
        <? } ?>
      <? } ?>
    <? } ?>
<!--    
<? //while($data=$this->a_list_data->getNextRecord()) { ?>
    <tr>
      <td valign=top colspan=2><input type=checkbox name=userrighttype[] value=<?//=$data['code']?>
             <?//=(in_array($data['code'], $_POST['userrighttype']) ? 'checked' : '')?>><?//eval("echo ".$data['langid'].";");?></td>
    </tr>
<? //} ?>
-->
    </td></tr>
    </table>
    <tr>
      <td class=dir_form align=center><br>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_UserProfiles'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=upid value=<?=$_POST['upid']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      <input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      <br><br>
      </td>
    </tr>
    </table>
    </form>
    </center>
