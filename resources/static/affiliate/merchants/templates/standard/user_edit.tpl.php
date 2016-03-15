
    <center>
    <form action=index_popup.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_REFID;?></b>&nbsp;</td>
      <td><input type=text name=refid size=44 value="<?=$_POST['refid']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_USERNAME;?></b>&nbsp;</td>
      <td><input type=text name=uname size=44 value="<?=$_POST['uname']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_PWD1;?></b>&nbsp;</td>
      <td><input type=password name=pwd1 size=22 value="<?=$_POST['pwd1']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_PWD2;?></b>&nbsp;</td>
      <td><input type=password name=pwd2 size=22 value="<?=$_POST['pwd2']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_NAME;?></b>&nbsp;</td>
      <td><input type=text name=name size=44 value="<?=$_POST['name']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_SURNAME;?></b>&nbsp;</td>
      <td><input type=text name=surname size=44 value="<?=$_POST['surname']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<?=L_G_COMPANYNAME;?>&nbsp;</td>
      <td><input type=text name=company_name size=44 value="<?=$_POST['company_name']?>">&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_WEBURL;?></b>&nbsp;</td>
      <td><input type=text name=weburl size=44 value="<?=$_POST['weburl']?>">*&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_STREET;?></b>&nbsp;</td>
      <td><input type=text name=street size=44 value="<?=$_POST['street']?>">*&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_CITY;?></b>&nbsp;</td>
      <td><input type=text name=city size=44 value="<?=$_POST['city']?>">*&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;<?=L_G_STATE;?>&nbsp;</td>
      <td><input type=text name=state size=44 value="<?=$_POST['state']?>">&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_COUNTRY;?></b>&nbsp;</td>
      <td>
        <select name=country>*
        <option value=""></option>
        <?
          if($_POST['country'] == '') $_POST['country'] = 'Czech Republic';
          
          while($data=$this->a_list_data->getNextRecord())
          {
            echo "<option value=\"$data\" ".($_POST['country'] == $data ? "selected" : "").">$data</option>\n"; 
          }
        ?>
        </select>*&nbsp;
      </td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_ZIPCODE;?></b>&nbsp;</td>
      <td><input type=text name=zipcode size=44 value="<?=$_POST['zipcode']?>">*&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;<?=L_G_PHONE;?>&nbsp;</td>
      <td><input type=text name=phone size=44 value="<?=$_POST['phone']?>">&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;<?=L_G_FAX;?>&nbsp;</td>
      <td><input type=text name=fax size=44 value="<?=$_POST['fax']?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<?=L_G_TAXSSN;?>&nbsp;</td>
      <td><input type=text name=tax_ssn size=44 value="<?=$_POST['tax_ssn']?>">&nbsp;</td>
    </tr>    
    <tr>
      <td colspan=2><hr></td>
    </tr>    
    <tr>
      <td colspan=2 align=center>&nbsp;<b><?=L_G_PAYOUTMETHOD?></b>&nbsp;</td>
    </tr>
    
    <? while($data=$this->a_list_data4->getNextRecord()) { ?>
      <tr><td colspan=2><hr></td></tr>     
      <tr>
        <td valign=top align=left colspan=2>&nbsp;
          <input type=radio name=payout_type value='<?=$data['payoptid']?>' <?=($_POST['payout_type'] == $data['payoptid'] ? 'checked' : '')?>>
          <font size=-2><?=(defined($data['langid']) ? constant($data['langid']) : $data['name'])?></font>&nbsp;
        </td>
      </tr>
      <? if(is_array($this->a_list_data5[$data['payoptid']])) {
           foreach($this->a_list_data5[$data['payoptid']] as $field) { ?>
            <tr>
              <td class=dir_form>&nbsp;<?=(defined($field['langid']) ? constant($field['langid']) : $field['name'])?>&nbsp;</td>
              <td>
                <? if($field['rtype'] == PAYOUTFIELD_TYPE_SELECT) { ?>
                  <select name='<?='field'.$field['payfieldid']?>'>
                    <? if(is_array($field['availablevalues_array'])) {
                         foreach($field['availablevalues_array'] as $value) { ?>
                           <option value='<?=$value?>' <?=($value == $_POST['field'.$field['payfieldid']] ? ' selected' : '')?>><?=$value?></option>
                      <? }
                       } ?>
                  </select>&nbsp;
                <? } else { ?>
                  <input type=text name='<?='field'.$field['payfieldid']?>' size=44 value="<?=$_POST['field'.$field['payfieldid']]?>">&nbsp;
                <? } ?>
              </td>
            </tr>
        <? }
         }
       } ?>

<!--
<? if($this->a_Auth->getSetting('Aff_showcheckinfo') == 1) { ?>  
    <tr>
      <td colspan=2><hr></td>
    </tr>     
    <tr>
      <td valign=top align=left colspan=2><input type=radio name=payout_type value='<?=PAYOUT_TYPE_CHECK?>' <?=($_POST['payout_type'] == PAYOUT_TYPE_CHECK ? 'checked' : '')?>>
      <font size=-2><?=L_G_FORCHECK?></font></td>
    </tr>        
    <tr>
      <td class=dir_form>
      <?=L_G_PAYABLETO?>
      </td>
      <td><input type=text name=payableto size=44 value="<?=$_POST['payableto']?>"></td>
    </tr>
<? } ?>
<? if($this->a_Auth->getSetting('Aff_showpaypalinfo') == 1) { ?>  
    <tr>
      <td colspan=2><hr></td>
    </tr>    
    <tr>
    <tr>
      <td valign=top align=left colspan=2><input type=radio name=payout_type value='<?=PAYOUT_TYPE_PAYPAL?>' <?=($_POST['payout_type'] == PAYOUT_TYPE_PAYPAL ? 'checked' : '')?>>
      <font size=-2><?=L_G_FORPAYPAL?></font></td>
    </tr>        
    </tr>        
    <tr>
      <td class=dir_form>
      <?=L_G_PAYPALEMAIL;?>
      </td>
      <td><input type=text name=paypal_email size=44 value="<?=$_POST['paypal_email']?>"></td>
    </tr>
<? } ?>
<? if($this->a_Auth->getSetting('Aff_showmoneybookersinfo') == 1) { ?>  
    <tr>
      <td colspan=2><hr></td>
    </tr>    
    <tr>
    <tr>
      <td valign=top align=left colspan=2><input type=radio name=payout_type value='<?=PAYOUT_TYPE_MONEYBOOKERS?>' <?=($_POST['payout_type'] == PAYOUT_TYPE_MONEYBOOKERS ? 'checked' : '')?>>
      &nbsp;<font size=-2><?=L_G_FORMONEYBOOKERS?></font></td>
    </tr>        
    </tr>        
    <tr>
      <td class=dir_form>
      <?=L_G_MONEYBOOKERSEMAIL;?>
      </td>
      <td><input type=text name=mb_email size=44 value="<?=$_POST['mb_email']?>"></td>
    </tr>
<? } ?>
<? if($this->a_Auth->getSetting('Aff_showbankinfo') == 1) { ?>    
    <tr>
      <td colspan=2><hr></td>
    </tr>    
    <tr>
      <td valign=top align=left colspan=2><input type=radio name=payout_type value='<?=PAYOUT_TYPE_WIRE?>' <?=($_POST['payout_type'] == PAYOUT_TYPE_WIRE ? 'checked' : '')?>>
      <font size=-2><?=L_G_FORWIRE?></font></td>
    </tr>        
    <tr>
      <td class=dir_form>
      <?=L_G_BANKACCOUNTNAME;?>
      </td>
      <td><input type=text name=bank_accountname size=44 value="<?=$_POST['bank_accountname']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_BANKNAME;?>
      </td>
      <td><input type=text name=bank_name size=44 value="<?=$_POST['bank_name']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_BANKACCOUNT;?>
      </td>
      <td><input type=text name=bank_account size=44 value="<?=$_POST['bank_account']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_BANKCODE;?>
      </td>
      <td><input type=text name=bank_code size=44 value="<?=$_POST['bank_code']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_BANKADDRESS;?>
      </td>
      <td><input type=text name=bank_address size=44 value="<?=$_POST['bank_address']?>"></td>
    </tr>        
    <tr>
      <td class=dir_form>
      <?=L_G_BANKSWIFT;?>
      </td>
      <td><input type=text name=bank_swift size=44 value="<?=$_POST['bank_swift']?>"></td>
    </tr>        
<? } ?>
-->
<? if($this->a_Auth->getSetting('Aff_min_payout_options') != '') { ?>
    <tr>
      <td colspan=2><hr></td>
    </tr>       
    <tr>
      <td class=dir_form>&nbsp;<b><?=L_G_MINPAYOUT;?></b>&nbsp;</td>
      <td>
      <?=$this->a_Auth->getSetting('Aff_system_currency')?>&nbsp;<select name=minpayout>
<?    while($data=$this->a_list_data2->getNextRecord()) { ?>
        <option value='<?=$data?>' <?=($_POST['minpayout'] == $data ? 'selected' : '')?>><?=$data?></option>
    
<?    } ?>  
      </select>
      *&nbsp;</td>
    </tr>    
<? } ?>
    <tr>
      <td class=dir_form>&nbsp;<?=L_G_PARENTAFFILIATE;?>&nbsp;</td>
      <td>
      <select name=parentuserid>
        <option value=""><?=L_G_NONE2?></option>
<?    while($data=$this->a_list_data3->getNextRecord()) {
        if($_POST['action'] == 'edit' && $data['userid'] == $_POST['aid']){
          continue;
        }
?>
        <option value="<?=$data['userid']?>" <?=($_POST['parentuserid'] == $data['userid'] ? 'selected' : '')?>><?=$data['userid'].': '.$data['name'].' '.$data['surname']?></option>
<?    } ?>
      </select>&nbsp;
      </td>
    </tr>    
    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=aid value=<?=$_POST['aid']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      <input type=hidden name=max_campaigns value="1">
      <input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    </table>
    </form>
    </center>
