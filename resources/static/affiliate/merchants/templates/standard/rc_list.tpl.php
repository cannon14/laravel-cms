
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=listheader colspan=14 align=center><?=L_G_LISTOFRECURRINGCOMMISSIONS?>&nbsp;<? print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=listheader>
      <td class=listheader width=1% nowrap><input type=button id=checkItemsButton value='[X]' OnClick="checkAllItems();"></td>
<?
    QUnit_Templates::printHeader(L_G_RECCOMID, 't.recurringcommid');
    QUnit_Templates::printHeader(L_G_PCNAME, 'cc.campaignid');
    QUnit_Templates::printHeader(L_G_AFFILIATE, 'affiliateid');
    QUnit_Templates::printHeader(L_G_ORDERID, 't.orderid');
    QUnit_Templates::printHeader(L_G_ORDERDATE, 'r.dateinserted');
    QUnit_Templates::printHeader(L_G_COMMISSION, 'r.commission');
    QUnit_Templates::printHeader(L_G_MULTITIERCOMMISSION);
    QUnit_Templates::printHeader(L_G_STATUS, 'r.rstatus');    
    QUnit_Templates::printHeader(L_G_ACTIONS);
    QUnit_Templates::printHeader(L_G_PAYMENTDAY);
    QUnit_Templates::printHeader(L_G_COMMDATETYPE, 'r.datetype');    
?>
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>    
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult><input type=checkbox id=itemschecked name="affcampid_<?=$data['affcampid']?>" value=1></td>
      <td class=listresult><?=$data['recurringcommid']?></td>
      <td class=listresult nowrap>&nbsp;<?=$this->a_campaigns[$data['campaignid']]['name']?></td>
      <td class=listresult nowrap>&nbsp;<?=$this->a_affiliates[$data['affiliateid']]['name'].' '.$this->a_affiliates[$data['affiliateid']]['surname']?></td>
      <td class=listresult nowrap>&nbsp;<?=$data['orderid']?></td>
      <td class=listresult nowrap>&nbsp;<?=$data['dateinserted']?></td>
      <td class=listresult nowrap>&nbsp;
<?    if($data['commission'] != '')
      {
        if($data['commtype'] == '%')
          print $data['commission'].' %';
        else
          print Affiliate_Merchants_Bl_Settings::showCurrency($data['commission']);
      }
?>      
      </td>
      <td class=listresult nowrap>&nbsp;
<?    if($data['st2commission'] != '' && $data['st2commission'] != 0)
        print L_G_YES;
      else
        print L_G_NO;
?>      
      </td>
      <td class=listresult nowrap>&nbsp;
<?
      if($data['rstatus'] == AFFSTATUS_NOTAPPROVED) print L_G_WAITINGAPPROVAL;
      else if($data['rstatus'] == AFFSTATUS_APPROVED) print L_G_ACTIVE;
      else if($data['rstatus'] == AFFSTATUS_SUPPRESSED) print L_G_SUPPRESSED;      
?>
      &nbsp;</td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
        <option value="-">------------------------</option>
        <? if($this->a_action_permission['approve']) { ?>
          <? if($data['rstatus'] != AFFSTATUS_APPROVED) { ?>
          <option value="javascript:ChangeState('<?=$data['recurringcommid']?>','approve');"><?=L_G_APPROVE?></a>
          <? } ?>
          <? if($data['rstatus'] != AFFSTATUS_SUPPRESSED) { ?>
          <option value="javascript:ChangeState('<?=$data['recurringcommid']?>','suppress');"><?=L_G_SUPPRESS?></a>
          <? } ?>
        <? } ?>
        <? if($this->a_action_permission['delete']) { ?>
          <option value="javascript:Delete('<?=$data['recurringcommid']?>');"><?=L_G_DELETE?></a>
        <? } ?>
        </select>
      </td>
      <td class=listresult nowrap>&nbsp;
<?
      // get next payment day (compute from day of order and period)
      $nextPaymentDate = getNextPaymentDate($data['dayofmonth'], $data['dayofweek'], $data['month'], $data['week'],$data['year'], $data['datetype']);
      print $nextPaymentDate;
?>
      </td>
      <td class=listresult nowrap>&nbsp;
<?
      switch($data['datetype'])
      {
          case RECURRINGTYPE_WEEKLY: print L_G_WEEKLY; break;
          case RECURRINGTYPE_MONTHLY: print L_G_MONTHLY; break;
          case RECURRINGTYPE_QUARTERLY: print L_G_QUARTERLY; break;
          case RECURRINGTYPE_BIANNUALLY: print L_G_BIANNUALLY; break;
          case RECURRINGTYPE_YEARLY: print L_G_YEARLY; break;
      }
?>
      </td>
  </tr>      
<?
    }
?>
    <tr class=listheader>
      <td class=listresultnocenter colspan=14 align=left>&nbsp;<?=L_G_SELECTED;?>&nbsp;
        <select name=action_select OnChange="performAction(this);">
          <option value="-">------------------------</option>
          <? if($this->a_action_permission['approve']) { ?>
            <option value="javascript:FilterForm.action.value='suppress_selected'; FilterForm.submit();"><?=L_G_SUPPRESS?></a>
            <option value="javascript:FilterForm.action.value='approve_selected'; FilterForm.submit();"><?=L_G_APPROVE?></a>
          <? } ?>
        </select>
      </td>
    </tr>
  </table>
  </form>
