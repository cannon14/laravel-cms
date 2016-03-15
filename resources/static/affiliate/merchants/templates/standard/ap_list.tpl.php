<? if($_REQUEST['exportFileName'] != '') { ?>
     <table class=listing border=0 cellspacing=0 cellpadding=2>
     <? QUnit_Templates::printFilter(10, L_G_EXPORTFILE); ?>
     <tr>
       <td align=center>
       <?=L_G_DOWNLOADCSV?> <br><a class=mainlink href="<?=QUnit_GlobalFuncs::makePath($this->a_Auth->getSetting('Aff_export_url'), $_REQUEST['exportFileName'])?>"><b><?=$_REQUEST['exportFileName']?></b></a>
       </td>
     </tr>
    </table>
    <br><br>
<? } ?>
    
    <form name=ResultsForm id=ResultsForm action=index.php method=post>
    <table class=listing width=60% border=0 cellspacing=0 cellpadding=1>
    <tr class=listheader>
    <td class=listheader width="1%" nowrap><input type=button id=checkItemsButton value="[X]" OnClick="checkAllItems();"></td>

<?
    QUnit_Templates::printHeader(L_G_AFFILIATEID, '');
    QUnit_Templates::printHeader(L_G_NAME, '');
    QUnit_Templates::printHeader(L_G_SURNAME, '');
    QUnit_Templates::printHeader(L_G_AMOUNT, '');
    
    if($this->a_Auth->getSetting('Aff_min_payout_options') != '')
        QUnit_Templates::printHeader(L_G_MINPAYOUT, '');
        
    QUnit_Templates::printHeader(L_G_PAYOUTMETHOD, '');
    QUnit_Templates::printHeader(L_G_PAYMENTDATA, '');
    QUnit_Templates::printHeader(L_G_ADDRESS, '');
    QUnit_Templates::printHeader(L_G_ACTIONS, '');
?>    
    </tr>
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="<?=$data['userid']?>" <?=(is_array($_POST['itemschecked']) ? (in_array($data['userid'], $_POST['itemschecked']) ? 'checked' : '') : '')?>></td>
      <td class=listresult nowrap>&nbsp;<?=$data['userid']?></td>
      <td class=listresult nowrap>&nbsp;<?=$data['name']?></td>
      <td class=listresult nowrap>&nbsp;<?=$data['surname']?></td>
      <td class=listresult nowrap>&nbsp;<?=Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['approved']))?>&nbsp;</td>
<?    if($this->a_Auth->getSetting('Aff_min_payout_options') != '') { ?>      
        <td class=listresult nowrap>&nbsp;<?=($data['minpayout'] == 0 || $data['minpayout'] == '' ? L_G_NOTSPECIFIED : Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($data['minpayout'])))?></td>
<?    } ?>      
      <td class=listresult nowrap>&nbsp;<?=$data['payment_type']?><input type=hidden name="payout_type_<?=$data['userid']?>" value="<?=$data['db_payout_type']?>"></td>
      <td class=listresultnocenter nowrap align=left>&nbsp;<?=$data['payment_data']?></td>
      <td class=listresultnocenter nowrap align=left>&nbsp;<?=$data['address']?></td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
            <option value="-">------------------------</option>
            <option value="javascript:manualPayment('<?=$data['userid']?>');"><?=L_G_MANUALPAYMENT?></option>
        </select>
      </td>      
    </tr>      
<?
    }
    
    if($this->a_transdata>0) 
    {
?>
    <tr class=listresult>
      <td class=listresult colspan=11 align=center><br>
      <?=L_G_PAYMENTNOTE?><br>
      <textarea name=accounting_note rows=2 cols=70></textarea>
      </td>
    </tr>
<?  } ?>

    <tr class=listresult>
      <td class=listresultnocenter colspan=11 align=left nowrap>
      <input type=hidden name=date1 value='<?=$_REQUEST['ap_year1'].'-'.$_REQUEST['ap_month1'].'-'.$_REQUEST['ap_day1']?>'>
      <input type=hidden name=date2 value='<?=$_REQUEST['ap_year2'].'-'.$_REQUEST['ap_month2'].'-'.$_REQUEST['ap_day2']?>'>
      <input type=hidden name=ap_year1 value='<?=$_REQUEST['ap_year1']?>'>
      <input type=hidden name=ap_month1 value='<?=$_REQUEST['ap_month1']?>'>
      <input type=hidden name=ap_day1 value='<?=$_REQUEST['ap_day1']?>'>
      <input type=hidden name=ap_year2 value='<?=$_REQUEST['ap_year2']?>'>
      <input type=hidden name=ap_month2 value='<?=$_REQUEST['ap_month2']?>'>
      <input type=hidden name=ap_day2 value='<?=$_REQUEST['ap_day2']?>'>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliatePayments'>
      <input type=hidden name=postaction id=postaction value=approvepayment>
      <input type=hidden name=rtype value=trans>
      <input class=formbutton type=button value='<?=L_G_PAYDENIED; ?>'  onclick="javascript:ResultsForm.postaction.value='denypayment'; ResultsForm.submit();">
      &nbsp;&nbsp;
      <input class=formbutton type=button value='<?=L_G_GENERATEEXPORTFILE?>'  onclick="javascript:ResultsForm.postaction.value='generateexport'; ResultsForm.submit();">
      &nbsp;&nbsp;
      <input class=formbutton type=submit value='<?=L_G_PAYDONE; ?>'>
      </td>
    </tr>
    </table>
    </form>
    <br>

