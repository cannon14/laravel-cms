
<script>
function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?=L_G_CONFIRMSUPPRESSRC?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_RecurringManager&rid="+ID+"&action="+action;
  }    
  else if(action == "approve")
  {
    if(confirm("<?=L_G_CONFIRMAPPROVERC?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_RecurringManager&rid="+ID+"&action="+action;
  }
}

function Delete(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETERC?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_RecurringManager&rid="+ID+"&action=delete";
}
</script>
    <table border=0 cellspacing=0>
    </table>
    <form name=FilterForm action=index.php method=get>
    <table class=listing border=0 width=600 cellspacing=0>
    <? QUnit_Templates::printFilter(10); ?>    
    <tr>
      <td width=1% nowrap>&nbsp;<?=L_G_MAINAFFILIATE?>&nbsp;</td>
      <td>
      <select name=f_affiliateid>
        <option value="_"><?=L_G_ALL?></option>
<?    while($data=$this->a_list_data->getNextRecord()) { ?>
        <option value="<?=$data['userid']?>" <?=($_REQUEST['f_affiliateid'] == $data['userid'] ? 'selected' : '')?>><?=(($data['name']!='' || $data['surname']!='') ? $data['name'].' '.$data['surname'] : $data['username'])?></option>
<?    } ?>      
      </select>
      </td>
      <td width=1% nowrap>&nbsp;<?=L_G_ORDERID?>&nbsp;</td>
      <td><input type=text name=f_orderid size=10 value="<?=$_REQUEST['f_orderid']?>"></td>
      <td width=1% nowrap>&nbsp;<?=L_G_STATE?>&nbsp;</td>
      <td>
        <select name=f_status>
          <option value='_'><?=L_G_ALLSTATES?></option>
          <option value=<?=AFFSTATUS_NOTAPPROVED?> <? print ($_REQUEST['f_status'] == AFFSTATUS_NOTAPPROVED ? 'selected' : '');?>><?=L_G_WAITINGAPPROVAL?></option>
          <option value=<?=AFFSTATUS_APPROVED?> <? print ($_REQUEST['f_status'] == AFFSTATUS_APPROVED ? 'selected' : '');?>><?=L_G_ACTIVE?></option>
          <option value=<?=AFFSTATUS_SUPPRESSED?> <? print ($_REQUEST['f_status'] == AFFSTATUS_SUPPRESSED ? 'selected' : '');?>><?=L_G_SUPPRESSED?></option>
        </select>
      </td>         
    </tr>
    <tr>
      <td colspan=6 width=50% align=center>&nbsp;<input type=submit class=formbutton value='Search'></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_RecurringManager'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">

<br>
