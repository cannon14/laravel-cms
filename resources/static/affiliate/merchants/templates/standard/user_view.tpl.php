    <center>
    <table class=listing width=100% border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(3, L_G_AFFILIATEPROFILE); ?>
    <tr>
      <td class=formText>&nbsp;<?=L_G_REFID;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['refid']?>&nbsp;</td>
    </tr>
    <tr>
      <td class=formText>&nbsp;<?=L_G_USERNAME;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['uname']?>&nbsp;</td>
    </tr>
    <tr>
      <td class=formText>&nbsp;<?=L_G_PWD1;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['pwd1']?>&nbsp;</td>
    </tr>
    <tr>
      <td class=formText>&nbsp;<?=L_G_NAME;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['name']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_SURNAME;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['surname']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_COMPANYNAME;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['company_name']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_WEBURL;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['weburl']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_STREET;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['street']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_CITY;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['city']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_STATE;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['state']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_COUNTRY;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['country']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_ZIPCODE;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['zipcode']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_PHONE;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['phone']?>&nbsp;</td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_FAX;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['fax']?>&nbsp;</td>
    </tr>
    <tr>
      <td class=formText>&nbsp;<?=L_G_TAXSSN;?>&nbsp;</td><td width=10></td>
      <td><?=$_POST['tax_ssn']?>&nbsp;</td>
    </tr>    
    <tr>
      <td colspan=3 class=formBText align=center><?=L_G_PAYOUTMETHOD?></td>
    </tr>

<? 
    $selectedPayoutMethod = false;
    while($data=$this->a_list_data1->getNextRecord()) 
    { 
        if($_POST['payout_type'] == $data['payoptid']) 
        {
            $selectedPayoutMethod = true;
    ?>
        <tr>
          <td colspan=3><hr></td>
        </tr>
        <tr>
          <td valign=top align=left class=formText colspan=3>&nbsp;&nbsp;&nbsp;&nbsp;
            <?=(defined($data['langid']) ? constant($data['langid']) : $data['name'])?>&nbsp;
          </td>
        </tr>
        <? if(is_array($this->a_list_data2[$data['payoptid']])) {
             foreach($this->a_list_data2[$data['payoptid']] as $field) { ?>
              <tr>
                <td class=formText>&nbsp;<?=(defined($field['langid']) ? constant($field['langid']) : $field['name'])?>&nbsp;</td>
                <td width=10></td>
                <td><?=$_POST['field'.$field['payfieldid']]?>&nbsp;</td>
              </tr>
<?           }
          }
       } 
    }
    
    if(!$selectedPayoutMethod) 
    { 
?>
        <tr>
          <td colspan=3 align=center><?=L_G_PAYOUTMETHODNOTSELECTED?></td>
        </tr>
<?  }
 
    if($this->a_Auth->getSetting('Aff_min_payout_options') != '') 
    { 
?>
    <tr>
      <td colspan=3><hr></td>
    </tr>    
    <tr>
      <td class=formText>&nbsp;<?=L_G_MINPAYOUT;?>&nbsp;</td><td width=10></td>
      <td><?=Affiliate_Merchants_Bl_Settings::showCurrency(($_POST['minpayout'] == '' ? '0' : $_POST['minpayout']))?>&nbsp;</td>
    </tr>  
<? } ?>     
    <tr>
      <td class=formText colspan=3 align=center>
      <input type=button class=formbutton value='<?=L_G_CLOSE?>' onClick='javascript:window.close();'>
      </td>
    </tr>
    </table>
    </form>
    </center>
