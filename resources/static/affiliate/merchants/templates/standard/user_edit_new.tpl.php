<? 
function getFieldRow($code, $caption, $settings) {    
    if($settings['Aff_signup_'.$code] == "1") {
        if($settings['Aff_signup_'.$code.'_mandatory'] === "true") {
            $caption = "<b>$caption</b>";
            $mandatSign = "*";
        } else {
            $mandatSign = "";
        }        
        return "<tr>\n" .
             "<td class=dir_form>&nbsp;$caption&nbsp;</td>\n" .
             "<td><input type=text name=$code size=44 value=".$_POST[$code].">$mandatSign&nbsp;</td>" .
             "</tr>";             
    }
} ?>

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
    <?= getFieldRow('name', L_G_NAME, $this->settings)?>
    <?= getFieldRow('surname', L_G_SURNAME, $this->settings)?>
    <?= getFieldRow('company_name', L_G_COMPANYNAME, $this->settings)?>
    <?= getFieldRow('street', L_G_STREET, $this->settings)?>
    <?= getFieldRow('city', L_G_CITY, $this->settings)?>
    <?= getFieldRow('state', L_G_STATE, $this->settings)?>    
    
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
    <?= getFieldRow('zipcode', L_G_ZIPCODE, $this->settings)?>
    <?= getFieldRow('phone', L_G_PHONE, $this->settings)?>
    <?= getFieldRow('weburl', L_G_WEBURL, $this->settings)?>
    <?= getFieldRow('fax', L_G_FAX, $this->settings)?>
    <?= getFieldRow('tax_ssn', L_G_TAXSSN, $this->settings)?>
    <?= getFieldRow('data1', $this->settings['Aff_signup_data1_name'], $this->settings)?>
    <?= getFieldRow('data2', $this->settings['Aff_signup_data2_name'], $this->settings)?>
    <?= getFieldRow('data3', $this->settings['Aff_signup_data3_name'], $this->settings)?>
    <?= getFieldRow('data4', $this->settings['Aff_signup_data4_name'], $this->settings)?>
    <?= getFieldRow('data5', $this->settings['Aff_signup_data5_name'], $this->settings)?>       

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
      <input type=hidden name=userid value=<?=$_POST['aid']?>>
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
