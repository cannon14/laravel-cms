
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=listheader colspan=11 align=center><?=L_G_ACCOUNTINGRECORDS?>&nbsp;<? print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=listheader>
<?
    QUnit_Templates::printHeader(L_G_ACCOUNTINGID, 'accountingid');
    QUnit_Templates::printHeader(L_G_CREATED, 'dateinserted');
    QUnit_Templates::printHeader(L_G_PERIODFROM, 'datefrom');
    QUnit_Templates::printHeader(L_G_PERIODTO, 'dateto');
    QUnit_Templates::printHeader(L_G_PAIDTOTAL);
    QUnit_Templates::printHeader(L_G_ACTIONS);
    QUnit_Templates::printHeader(L_G_NOTE, 'note');
?>    
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>    
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult><?=$data['accountingid']?></td>
      <td class=listresult nowrap><?=$data['dateinserted']?></td>
      <td class=listresult nowrap><?=$data['datefrom']?></td>
      <td class=listresult nowrap><?=$data['dateto']?></td>
      <td class=listresultnocenter align=right nowrap>&nbsp;<?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['paid']))?>&nbsp;</td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
        <option value="-">------------------------</option>
        <option value="javascript:Details('<?=$data['accountingid']?>');"><?=L_G_DETAILS?></option>
        </select>
      </td>
      <td class=listresult nowrap>&nbsp;<?=$data['note']?>&nbsp;</td>
    </tr>      
<?
    }
?>
  </table>
  </form>
