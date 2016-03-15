
    <center>
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(3, L_G_AFFDETAILS); ?>
    <tr>
      <td class=dir_form><?=L_G_USERNAME;?></td><td width=10></td>
      <td><?=$_POST['uname']?></td>
    </tr>
    <tr>
      <td class=dir_form><?=L_G_CONTACTNAME;?></td><td width=10></td>
      <td><?=$_POST['name'].' '.$_POST['surname']?></td>
    </tr>    
    <tr>
      <td class=dir_form><?=L_G_COMPANYNAME;?></td><td width=10></td>
      <td><?=$_POST['company_name']?></td>
    </tr>  
    <tr>
      <td colspan=3 align=center><b><?=L_G_PAYOUTMETHOD?></b></td>
    </tr>        
<? if($this->a_Auth->getSetting('Aff_showcheckinfo') == 1 && $_POST['payout_type'] == PAYOUT_TYPE_CHECK) 
   { 
       $payoutTypeSet = true;       
?>  
    <tr>
      <td colspan=3><hr></td>
    </tr>
    <tr>
      <td valign=top align=center colspan=3><font size=-2><?=L_G_FORCHECK?></font></td>
    </tr>      
    <tr>
      <td class=dir_form><?=L_G_PAYABLETO;?></td><td width=10></td>
      <td><?=$_POST['payableto']?></td>
    </tr>
<? } ?>     
<? if($this->a_Auth->getSetting('Aff_showpaypalinfo') == 1 && $_POST['payout_type'] == PAYOUT_TYPE_PAYPAL)
   { 
       $payoutTypeSet = true;       
?>     
    <tr>
      <td colspan=3><hr></td>
    </tr>    
    <tr>
      <td valign=top align=center colspan=3><font size=-2><?=L_G_FORPAYPAL?></font></td>
    </tr>      
    <tr>
      <td class=dir_form><?=L_G_PAYPALEMAIL;?></td><td width=10></td>
      <td><?=$_POST['paypal_email']?></td>
    </tr>    
<? } ?>
<? if($this->a_Auth->getSetting('Aff_showmoneybookersinfo') == 1 && $_POST['payout_type'] == PAYOUT_TYPE_MONEYBOOKERS)
   { 
       $payoutTypeSet = true;       
?>     
    <tr>
      <td colspan=3><hr></td>
    </tr>    
    <tr>
      <td valign=top align=center colspan=3><font size=-2><?=L_G_FORMONEYBOOKERS?></font></td>
    </tr>      
    <tr>
      <td class=dir_form><?=L_G_MONEYBOOKERSEMAIL;?></td><td width=10></td>
      <td><?=$_POST['mb_email']?></td>
    </tr>    
<? } ?>
<? if($this->a_Auth->getSetting('Aff_showbankinfo') == 1 && $_POST['payout_type'] == PAYOUT_TYPE_WIRE)
   { 
       $payoutTypeSet = true;       
?>     
    <tr>
      <td colspan=3><hr></td>
    </tr>
    <tr>
      <td valign=top align=center colspan=3><font size=-2><?=L_G_FORWIRE?></font></td>
    </tr>       
    <tr>
      <td class=dir_form><?=L_G_BANKACCOUNTNAME;?></td><td width=10></td>
      <td><?=$_POST['bank_accountname']?></td>
    </tr>    
    <tr>
      <td class=dir_form><?=L_G_BANKNAME;?></td><td width=10></td>
      <td><?=$_POST['bank_name']?></td>
    </tr>    
    <tr>
      <td class=dir_form><?=L_G_BANKACCOUNT;?></td><td width=10></td>
      <td><?=$_POST['bank_account']?></td>
    </tr>    
    <tr>
      <td class=dir_form><?=L_G_BANKCODE;?></td><td width=10></td>
      <td><?=$_POST['bank_code']?></td>
    </tr>    
    <tr>
      <td class=dir_form><?=L_G_BANKADDRESS;?></td><td width=10></td>
      <td><?=$_POST['bank_address']?></td>
    </tr>        
    <tr>
      <td class=dir_form><?=L_G_BANKSWIFT;?></td><td width=10></td>
      <td><?=$_POST['bank_swift']?></td>
    </tr>        
<? } ?>    
<? if(!$payoutTypeSet) { ?>
    <tr>
      <td colspan=3><hr></td>
    </tr>
    <tr>
      <td valign=top align=center colspan=3><font size=-2 color=#ff0000><?=L_G_NOTSET?></font></td>
    </tr>  
<? } ?>    
    
    </table>
    <br>
    <table class=listing width=60% border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td align=center class=listheader colspan=7><b><?=L_G_AFFPAYMENTSLIST?></b></td>
    </tr>
    <tr class=listheader>
<?
    QUnit_Templates::printHeader(L_G_ACCOUNTINGID);
    QUnit_Templates::printHeader(L_G_CREATED);
    QUnit_Templates::printHeader(L_G_PERIODFROM);
    QUnit_Templates::printHeader(L_G_PERIODTO);
    QUnit_Templates::printHeader(L_G_EXPORTFILES);
    QUnit_Templates::printHeader(L_G_PAIDTOTAL);
    QUnit_Templates::printHeader(L_G_NOTE);
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
      <td class=listresult nowrap>&nbsp;
      <?
        $export = '';
        if($data['paypalfile'])
        {
            if($export != '') $export .= ', ';
            $export .= L_G_FORPAYPAL;
        }
        else if($data['mbfile'])
        {
            if($export != '') $export .= ', ';
            $export .= L_G_FORMONEYBOOKERS;
        }
        else if($data['wirefile'])
        {
            if($export != '') $export .= ', ';
            $export .= L_G_CHECKWIRE;
        }
      
        print $export;
      ?>&nbsp;</td>
      <td class=listresultnocenter align=right nowrap>&nbsp;<?=Affiliate_Merchants_Bl_Settings::showCurrency($data['commission'])?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['note']?>&nbsp;</td>
    </tr>      
<?
    }
?>
    </table>

    </center>
