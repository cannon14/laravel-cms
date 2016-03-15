<script>
function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?=L_G_CONFIRMSUPPRESSAFFCAMP?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_AppliedAffiliate&acid="+ID+"&action="+action;
  }    
  else if(action == "approve")
  {
    if(confirm("<?=L_G_CONFIRMAPPROVEAFFCAMP?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_AppliedAffiliate&acid="+ID+"&action="+action;
  }
}
</script>
    <form name=FilterForm action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td align=left colspan=10>
      </td>
    </tr>
    <tr class=header>
      <td class=listheader colspan=10 align=center><?=L_G_LISTOFAPPLIEDAFFILIATES?>&nbsp;<? print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=listheader>
      <td class=listheader width=1% nowrap><input type=button id=checkItemsButton value='[X]' OnClick="checkAllItems();"></td>
<?
    QUnit_Templates::printHeader(L_G_ID, 'a.userid');
    QUnit_Templates::printHeader(L_G_NAME, 'a.name');
    QUnit_Templates::printHeader(L_G_SURNAME, 'a.surname');
    QUnit_Templates::printHeader(L_G_CAMPAIGN_NAME, 'camp_name');
    QUnit_Templates::printHeader(L_G_CREATED, 'c.dateinserted');
    QUnit_Templates::printHeader(L_G_STATUS, 'ac.rstatus');
    QUnit_Templates::printHeader(L_G_ACTIONS);
?>    
    </tr>
    </form>
    <form action=index.php method=post>

<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult><input type=checkbox id=itemschecked name='itemschecked[]' value='<?=$data['affcampid']?>'></td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?=$data['userid']?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?=$data['name']?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?=$data['surname']?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?=$data['camp_name']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['dateinserted']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;
      <? 
        if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
        else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_APPROVED;
        else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED
      ?> &nbsp;
      </td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
          <option value="-">------------------------</option>
          <? if($data['rstatus'] == AFFSTATUS_APPROVED) { ?>
              <option value="javascript:ChangeState('<?=$data['affcampid']?>','suppress');"><?=L_G_SUPPRESS?></option>
          <? } else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) { ?>
              <option value="javascript:ChangeState('<?=$data['affcampid']?>','approve');"><?=L_G_APPROVE?></option>
          <? } else { ?>
              <option value="javascript:ChangeState('<?=$data['affcampid']?>','suppress');"><?=L_G_SUPPRESS?></option>
              <option value="javascript:ChangeState('<?=$data['affcampid']?>','approve');"><?=L_G_APPROVE?></option>
          <? } ?>
        </select>
      </td>
    </tr>    
<?
    }
?>
    <tr class=listheader>
      <td class=listresultnocenter colspan=10 align=left>&nbsp;<?=L_G_SELECTED;?>&nbsp;
        <select name=massaction>
          <option value=""><?=L_G_CHOOSEACTION?></option>
          <option value="suppress"><?=L_G_SUPPRESS?></option>
          <option value="approve"><?=L_G_APPROVE?></option>
        </select>
        &nbsp;&nbsp;
        <input type=submit value="<?=L_G_SUBMITMASSACTION?>">
      </td>
    </tr>
    </table>
    <input type=hidden name=commited value='yes'>
    <input type=hidden name=md value='Affiliate_Merchants_Views_AppliedAffiliate'>
    <input type=hidden id=action name=action value=''>
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
    </form>
