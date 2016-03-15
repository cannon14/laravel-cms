
    <center>
    <form action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(2, L_G_ACCOUNTINGDETAILS); ?>
    <tr>
      <td class=dir_form>
      <b><?=L_G_ACCOUNTINGID?></b>
      </td>
      <td><?=$_POST['accountingid']?></td>
    </tr>
    <tr>
      <td class=dir_form>
      <b><?=L_G_CREATED?></b>
      </td>
      <td><?=$_POST['dateinserted']?></td>
    </tr>
    <tr>
      <td class=dir_form>
      <b><?=L_G_PERIODFROM?></b>
      </td>
      <td><?=$_POST['datefrom']?></td>
    </tr>
    <tr>
      <td class=dir_form>
      <b><?=L_G_PERIODTO?></b>
      </td>
      <td><?=$_POST['dateto']?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top>
      <b><?=L_G_NOTE;?></b>
      </td>
      <td><textarea rows=3 cols=50 name=note><?=$_POST['note']?></textarea></td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center>
      <? if($this->a_action_permission['savedetails']) { ?>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_Accounting'>
        <input type=hidden name=action value='savedetails'>
        <input type=hidden name=aid value=<?=$_POST['accountingid']?>>
        <input type=submit class=formbutton value='<?=L_G_SAVENOTE?>'>
      <? } ?>
      </td>
    </tr>
    </table>
    </form>
    <br>
    <table class=listing width=60% border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=listheader align=center colspan=5><b><?=L_G_PAYMENTSLIST?></b></td>
    </tr>
    <tr class=listheader>
<?
    QUnit_Templates::printHeader(L_G_AFFILIATEID, '');
    QUnit_Templates::printHeader(L_G_NAME, '');
    QUnit_Templates::printHeader(L_G_SURNAME, '');
    QUnit_Templates::printHeader(L_G_AMOUNT, '');
    QUnit_Templates::printHeader(L_G_PAYOUTMETHOD, '');
?>    
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>    
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult nowrap>&nbsp;<?=$data['userid']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['name']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['surname']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['commission']))?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;
      <?
      if($data['payout_type'] == PAYOUT_TYPE_CHECK)
        print L_G_FORCHECK;
      else if($data['payout_type'] == PAYOUT_TYPE_PAYPAL)
        print L_G_FORPAYPAL;
      else if($data['payout_type'] == PAYOUT_TYPE_MONEYBOOKERS)
        print L_G_FORMONEYBOOKERS;
      else if($data['payout_type'] == PAYOUT_TYPE_WIRE)
        print L_G_FORWIRE;
      ?>
      </td>
    </tr>      
<?
    }
?>
    </table>

    </center>
