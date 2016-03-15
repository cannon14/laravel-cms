    <table width=500 class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(3, L_G_AFFILIATEPROFILE); ?>
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_USERNAME;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['username']?>&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_NAME;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['name']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_SURNAME;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['surname']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_COMPANYNAME;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['company_name']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_WEBURL;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['weburl']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_STREET;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['street']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_CITY;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['city']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_STATE;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['state']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_COUNTRY;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['country']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_ZIPCODE;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['zipcode']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_PHONE;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['phone']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_FAX;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['fax']?>&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_TAXSSN;?>&nbsp;</td><td width=10></td>
      <td><?=$this->a_payoutData['tax_ssn']?>&nbsp;</td>
    </tr>
    <tr>
        <td colspan=3>&nbsp;</td>
    </tr>
    <? QUnit_Templates::printFilter2(3, L_G_PAYOUTMETHODS); ?> 

<?      while($data=$this->a_list_data1->getNextRecord()) 
        { 
            if($this->a_payoutData['payoptid'] == $data['payoptid']) 
            {
?>
        <tr>
          <td valign=top align=left colspan=3>
            &nbsp;<b><?=(defined($data['langid']) ? constant($data['langid']) : $data['name'])?></b>&nbsp;
          </td>
        </tr>
<?              if(is_array($this->a_list_data2[$data['payoptid']])) 
                {
                    foreach($this->a_list_data2[$data['payoptid']] as $field) 
                    { 
?>
              <tr>
                <td class=dir_form width="1%" nowrap>&nbsp;<?=(defined($field['langid']) ? constant($field['langid']) : $field['name'])?>&nbsp;</td>
                <td width=10></td>
                <td><?=$this->a_payoutData['field'.$field['payfieldid']]?>&nbsp;</td>
              </tr>
<?                  
                    }
                }
            }
        }
?>
    
    <tr>
      <td colspan=3><hr></td>
    </tr>
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_PAYMENTTOBEPAID?>&nbsp;</td><td width=10></td>
      <td><b><?=Affiliate_Merchants_Bl_Settings::showCurrency($this->a_payoutData['amount'])?></b>&nbsp;</td>
    </tr>
<? if($this->a_Auth->getSetting('Aff_min_payout_options') != '') { ?>
    <tr>
      <td class=dir_form width="1%" nowrap>&nbsp;<?=L_G_MINPAYOUT;?>&nbsp;</td><td width=10></td>
      <td><?=Affiliate_Merchants_Bl_Settings::showCurrency($this->a_payoutData['minpayout'])?>&nbsp;</td>
    </tr>
<? } ?>
    <tr>
      <td colspan=3><hr></td>
    </tr>
    <tr>
      <td colspan="3" align="center" valign="middle">
      <?=$this->a_payoutData['paybuttonformat']?>
      </td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="top">
      <br><br>
      <? showHelp('L_G_HLPAFTERMANUALPAYMENT'); ?>
      </td>
    </tr>
    <tr>
      <td colspan="3" align="center" valign="top">
      <form name=ResultsForm id=ResultsForm action=index.php method=post>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliatePayments'>
      <input type=hidden name=postaction id=postaction value=approvepayment>
      <input type=hidden name=rtype value=trans>
      <input type=hidden name=mp_date1 value="<?=$this->a_payoutData['date1']?>">
      <input type=hidden name=mp_date2 value="<?=$this->a_payoutData['date2']?>">
      <input type=hidden name="payout_type_<?=$this->a_payoutData['userid']?>" value="something">
      <input type=hidden name="itemschecked[]" value="<?=$this->a_payoutData['userid']?>">
      <input class=formbutton type=submit value='<?=L_G_PAYDONE; ?>'>
      </form>
      </td>
    </tr>
    </table>
    
    
