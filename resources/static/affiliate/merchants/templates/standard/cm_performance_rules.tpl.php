<script>
function editRule(ID)
{
    document.myForm.editrid.value = ID;
    document.myForm.submit();
}

function deleteRule(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETERULE?>"))
  {
    document.myForm.rid.value = ID;
    document.myForm.action.value = 'deleteRule';
    document.myForm.postaction.value = '';
    document.myForm.submit();
  }
}
</script>

    <table border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=formBText valign=top nowrap><?=L_G_PUT_AFFILIATE_SPECIAL_CATEGORY;?>&nbsp;</td>
        <td valign=top>
          <select name=cond_action_value>
          <? if(is_array($this->a_campaigns))
               foreach($this->a_campaigns as $key => $value) {
          ?>
                 <option value='<?=$key?>' <?=($_POST['cond_action_value'] == $key ? ' selected' : '')?>><?=((($value == UNASSIGNED_USERS) && defined($value)) ? constant($value) : $value)?></option>
          <? } ?>
          </select>
          <input type=hidden name=cond_action value='<?=L_G_PUT_AFFILIATE_SPECIAL_CATEGORY?>'>
        </td>
      </tr>
      <tr>
        <td class=formBText valign=top nowrap><?=L_G_WHEN;?></td>
        <td valign=top>
          <select name=cond_when>
            <option value='<?=RULE_NUMBER_OF_SALES?>' <?=$_POST['cond_when'] == RULE_NUMBER_OF_SALES ? 'selected' : ''?>><?=L_G_NUMBER_OF_SALES?></option>
            <option value='<?=RULE_AMOUNT_OF_COMMISSIONS?>' <?=$_POST['cond_when'] == RULE_AMOUNT_OF_COMMISSIONS ? 'selected' : ''?>><?=L_G_AMOUNT_OF_COMMISSIONS?></option>
          </select>
        </td>
      </tr>
      <tr>
        <td class=formBText valign=top nowrap><?=L_G_IN;?></td>
        <td valign=top>
          <select name=cond_in>
            <option value='<?=RULE_ACTUAL_MONTH?>' <?=$_POST['cond_in'] == RULE_ACTUAL_MONTH ? 'selected' : ''?>><?=L_G_ACTUAL_MONTH?></option>
            <option value='<?=RULE_ACTUAL_YEAR?>' <?=$_POST['cond_in'] == RULE_ACTUAL_YEAR ? 'selected' : ''?>><?=L_G_ACTUAL_YEAR?></option>
            <option value='<?=RULE_ALL?>' <?=$_POST['cond_in'] == RULE_ALL ? 'selected' : ''?>><?=L_G_ALL?></option>
          </select>
        </td>
      </tr>
      <tr>
        <td class=formBText valign=top nowrap><input type=radio name=cond_is_type value='<?=RULE_IS?>' checked>&nbsp;<?=L_G_IS;?></td>
        <td class=formBText valign=top>
          <select name=cond_is>
            <option value='<?=RULE_LOWER?>' <?=$_POST['cond_is'] == RULE_LOWER ? 'selected' : ''?>><?=L_G_LOWER?></option>
            <option value='<?=RULE_HIGHER?>' <?=$_POST['cond_is'] == RULE_HIGHER ? 'selected' : ''?>><?=L_G_HIGHER?></option>
          </select>
          &nbsp;<?=strtolower(L_G_AS)?>&nbsp;<input type=text name='cond_value1' value=<?=$_POST['cond_value1']?>>
        </td>
      </tr>
      <tr>
        <td class=formBText valign=top nowrap><input type=radio name=cond_is_type value='<?=RULE_IS_BETWEEN?>' <?=($_POST['cond_is_type'] == RULE_IS_BETWEEN ? ' checked' : '')?>>&nbsp;<?=L_G_IS_BETWEEN;?></td>
        <td class=formBText><input type=text name='cond_value2' value=<?=$_POST['cond_value2']?>>
          &nbsp;<?=L_G_AND?>&nbsp;<input type=text name='cond_value3' value=<?=$_POST['cond_value3']?>>
        </td>
      </tr>
      <tr>
        <td align=center><input class=formbutton type=submit value='<?=L_G_SAVE_RULE; ?>'></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>

    <table border=0 cellspacing=0 cellpadding=1>
      <tr>
        <td class=formBText colspan=7>&nbsp;<?=L_G_LISTOFRULES?>&nbsp;</td>
      </tr>
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>
      <tr class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
        <td class=formText align=center nowrap>&nbsp;<?=$data['cond_action']?></td>
        <td class=formText align=center nowrap>&nbsp;<?=$data['special_campaign_name']?></td>
        <td class=formText align=center nowrap>&nbsp;<?=strtolower(L_G_WHEN).'&nbsp;';?>
            <? if($data['cond_when'] == RULE_NUMBER_OF_SALES) print L_G_NUMBER_OF_SALES;
            else if($data['cond_when'] == RULE_AMOUNT_OF_COMMISSIONS) print L_G_AMOUNT_OF_COMMISSIONS;
          ?></td>
        <td class=formText align=center nowrap>&nbsp;<?=strtolower(L_G_IN).'&nbsp;';?>
            <?if($data['cond_in'] == RULE_ACTUAL_MONTH) print L_G_ACTUAL_MONTH;
            else if($data['cond_in'] == RULE_ACTUAL_YEAR) print L_G_ACTUAL_YEAR;
            else if($data['cond_in'] == RULE_ALL) print L_G_ALL;
          ?></td>
        <td class=formText align=center nowrap>&nbsp;<?
            if($data['cond_is_type'] == RULE_IS) {
                print strtolower(L_G_IS).'&nbsp;';
                if($data['cond_is'] == RULE_LOWER) print L_G_LOWER;
                else if($data['cond_is'] == RULE_HIGHER) print L_G_HIGHER;
            }
            else if($data['cond_is_type'] == RULE_IS_BETWEEN) {
                print strtolower(L_G_IS_BETWEEN).'&nbsp;';
            }
          ?></td>
        <td class=formText align=center nowrap>&nbsp;<?
            if($data['cond_is_type'] == RULE_IS) {
                print strtolower(L_G_AS).' '.$data['cond_value1'];
            }
            else {
                print $data['cond_value1'].' '.L_G_AND.' '.$data['cond_value2'];
            }
          ?></td>
        <td align=center>&nbsp;
          <a href="javascript:editRule('<?=$data['ruleid']?>');"><?=L_G_EDIT?></a>&nbsp;&nbsp;
          <a href="javascript:deleteRule('<?=$data['ruleid']?>');"><?=L_G_DELETE?></a>&nbsp;
        </td>
      </tr>
<?  } ?>
    </table>
    <input type=hidden name=rid id=rid value='<?=$_POST['ruleid']?>'>
    <input type=hidden name=editrid id=editrid value=''>

