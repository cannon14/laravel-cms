
    <center>
    <form action=index_popup.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(2, L_G_EDITCONTACTINFO); ?>
    <tr>
      <td class=dir_form>
      <?=L_G_NAME;?>
      </td>
      <td><input type=text name=name size=25 value="<?=$_POST['name']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_SURNAME;?>
      </td>
      <td><input type=text name=surname size=25 value="<?=$_POST['surname']?>">*</td>
    </tr>
    <tr>
      <td class=dir_form>
      <?=L_G_CONTACT_PERSON;?>
      </td>
      <td>
        <select name=contact_person>
            <?
              while($data=$this->a_list_data->getNextRecord())
                  echo '<option value='.$data['adminid'].' '.
                       (($data['adminid'] == $_POST['contact_person']) ? 'selected' : '').
                       '>'.$data['name'].' '.$data['surname'].'</option>';
            ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class=dir_form>
      <?=L_G_COMPANYNAME;?>
      </td>
      <td><input type=text name=company_name size=25 value="<?=$_POST['company_name']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_EMAIL;?>
      </td>
      <td><input type=text name=email size=25 value="<?=$_POST['email']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_WEBURL;?>
      </td>
      <td><input type=text name=weburl size=25 value="<?=$_POST['weburl']?>">*</td>
    </tr>    

    <tr>
      <td class=dir_form>
      <?=L_G_STREET;?>
      </td>
      <td><input type=text name=street size=25 value="<?=$_POST['street']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_CITY;?>
      </td>
      <td><input type=text name=city size=25 value="<?=$_POST['city']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_STATE;?>
      </td>
      <td><input type=text name=state size=25 value="<?=$_POST['state']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_COUNTRY;?>
      </td>
      <td>
        <select width=100 name=country>*
        <option value=""></option>
        <?
          while($data=$this->a_list_data2->getNextRecord())
          {
            echo '<option value=\'$data\' '.
                 ($_POST['country'] == $data ? 'selected' : '').'>$data</option>\n';
          }
        ?>
        </select>*
      </td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_ZIPCODE;?>
      </td>
      <td><input type=text name=zipcode size=25 value="<?=$_POST['zipcode']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_PHONE;?>
      </td>
      <td><input type=text name=phone size=25 value="<?=$_POST['phone']?>">*</td>
    </tr>    
    <tr>
      <td class=dir_form>
      <?=L_G_FAX;?>
      </td>
      <td><input type=text name=fax size=25 value="<?=$_POST['fax']?>"></td>
    </tr>    
    
    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantProfile'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=mid value=<?=$_POST['mid']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      <input class=formbutton type=button value='<?=L_G_CLOSE; ?>' onClick='javascript:window.close();'>
      &nbsp;&nbsp;
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>
    </center>

