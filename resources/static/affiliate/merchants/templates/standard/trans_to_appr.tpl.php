
<form name=FilterForm action=index.php method=post>
<table border=0 cellspacing=0>
</table>
<table class=listing border=0 cellspacing=0 cellpadding=1>
<tr>
<td class=listheader colspan=10 align=center><?=L_G_TRANSLIST?>&nbsp;<? print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
</tr>
<tr class=listheader>
<td class=listheader width=1% nowrap><input type=button id=checkItemsButton value='[X]' OnClick="checkAllItems();"></td>
<?
QUnit_Templates::printHeader(L_G_TRANSID, 'transid');
QUnit_Templates::printHeader(L_G_CAMOUNT, 'commission');
QUnit_Templates::printHeader(L_G_TOTALCOST, 'totalcost');
QUnit_Templates::printHeader(L_G_ORDERID, 'orderid');
QUnit_Templates::printHeader(L_G_CREATED, 'dateinserted');
QUnit_Templates::printHeader(L_G_PCNAME, 'cc.campaignid');
QUnit_Templates::printHeader(L_G_TYPE, 'transkind');
QUnit_Templates::printHeader(L_G_IP, 'ip');    
QUnit_Templates::printHeader(L_G_AFFILIATE, 'userid');    
?>
</tr>
<?
while($data=$this->a_list_data->getNextRecord())
{
    ?>      
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
    <td class=listresult><input type=checkbox id=itemschecked name="transid_<?=$data['transid']?>" value=1></td>
    <td class=listresult><?=$data['transid']?></td>
    <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['commission']))?></td>
    <td class=listresult><?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['totalcost']))?></td>
    <td class=listresult>&nbsp;<?=$data['orderid']?></td>
    <td class=listresult nowrap>&nbsp;<?=$data['dateinserted']?></td>
    <td class=listresult nowrap>&nbsp;<?=$data['campaignname']?></td>
    <td class=listresult nowrap>&nbsp;
    <?
    if($data['transkind'] > TRANSKIND_SECONDTIER)
        print ($data['transkind'] - TRANSKIND_SECONDTIER).' - '.L_G_TIER.' ';

    print $GLOBALS['Auth']->getCommissionTypeString($data['transtype']);            
    ?>
    &nbsp;</td>
    <td class=listresult>&nbsp;<?=$data['ip']?></td>
    <td align=left class=listresult nowrap>&nbsp;<?=(($this->a_users[$data['userid']]['name'] || $this->a_users[$data['userid']]['surname']) ? $this->a_users[$data['userid']]['name'].' '.$this->a_users[$data['userid']]['surname'] : $this->a_users[$data['userid']]['username'])?></td>      
    </tr>    
    <?
}
?>
<tr class=listresult>
<td height=15 colspan=10 align=center>&nbsp;</td>
</tr>
<tr class=listresult>
<td class=listresult colspan=10 align=center>
<input type=hidden name=commited value=yes>
<input type=hidden name=md value='Affiliate_Merchants_Views_TransactionManager'>
<input type=hidden name=postaction value=''>
<input type=hidden name=type value=trans>
<input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
<input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">      
<input class=formbutton type=button value='<?=L_G_DENYSELECTED; ?>' onclick="javascript:FilterForm.postaction.value='denytrans'; FilterForm.submit();">
&nbsp;&nbsp;
<input class=formbutton type=submit value='<?=L_G_APPROVESELECTED; ?>' onclick="javascript:FilterForm.postaction.value='approvetrans'; FilterForm.submit();">
</td>
</tr>
</table>
</form>
