<?
   if(!function_exists('getCombo') && !function_exists('getFieldRow')) {
    function getCombo($name) {
        return "<select name='{$name}_mandatory'>\n".
              "<option value='true' ".(($_POST[$name.'_mandatory'] == 'true') ? "selected" :"").">mandatory</option>".
              "<option value='false' ".(($_POST[$name.'_mandatory'] == 'false') ? "selected" :"").">optional</option>\n".
              "</select>";        
    }
    
    function getFieldRow($code, $caption) {
        return 
            "<tr>\n" .
            "<td>\n" . 
            "<input type='checkbox' name='signup_$code' value='1'".(($_POST['signup_'.$code] == "1") ? "checked" :"").">\n" .
            "$caption</td>" .
            "<td>".getCombo("signup_$code")."</td>" .
            "</tr>";
    }
   }
?>
<table width="100%" border=0 cellspacing=0 cellpadding=3>
<? QUnit_Templates::printFilter2(3, L_G_AFFSIGNUPFORMAT); ?> 
<tr><td>
<h4><?= L_G_AFFSIGNUPFORMAT_TOS?></h4>

<textarea rows="6" cols="50" name="signup_terms_conditions"><?= $_POST['signup_terms_conditions']?></textarea>
<br>
<input type="checkbox" name="signup_display_terms" value="1" <?= (($_POST['signup_display_terms'] == "1") ? "checked" :"") ?>>
<?= L_G_AFFSIGNUPFORMAT_TOS_SHOW?><br>
<input type="checkbox" name="signup_force_acceptance" value="1" <?= (($_POST['signup_force_acceptance'] == "1") ? "checked" :"") ?>>
<?= L_G_AFFSIGNUPFORMAT_TOS_FORCE?><br>
<br>

<input type="checkbox" name="signup_affect_editing" value="1" <?= (($_POST['signup_affect_editing'] == "1") ? "checked" :"") ?>>
<?= L_G_AFFSIGNUPFORMAT_AFFECTEDITING?><br>

<h4><?= L_G_AFFSIGNUPFORMAT_FORMFIELDS?></h4>

<table width="40%" cellpadding="2">
<tr>
<td>
<input type="checkbox" name="signup_email" value="1" checked disabled>email
</td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="name" value="1" checked disabled>name<br></td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="surname" value="1" checked disabled>surname</td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="country" value="1" checked disabled>country</td>
<td></td>
</tr>
<?= getFieldRow('company_name',L_G_COMPANYNAME)?>
<?= getFieldRow('street',L_G_STREET)?>
<?= getFieldRow('city',L_G_CITY)?>
<?= getFieldRow('state',L_G_STATE)?>
<?= getFieldRow('zipcode',L_G_ZIPCODE)?>
<?= getFieldRow('weburl',L_G_WEBURL)?>
<?= getFieldRow('phone',L_G_PHONE)?>
<?= getFieldRow('fax',L_G_FAX)?>
<?= getFieldRow('tax_ssn',L_G_TAXSSN)?>
</table>

<br>

<table width="80%" cellpadding="3">
<? for($i=1;$i<=5;$i++) {?>
<tr>
<td><input type="checkbox" name="signup_data<?= $i?>" value="1" <?= (($_POST['signup_data'.$i] == "1") ? "checked" :"") ?>>
<?= L_G_AFFSIGNUPFORMAT_DATAFIELD.$i ?></td>
<td><?= getCombo("signup_data".$i); ?></td>
<td><?= L_G_AFFSIGNUPFORMAT_FIELDNAME?> <input type="textfield" name="signup_data<?= $i?>_name" value="<?= $_POST["signup_data{$i}_name"]?>"></td>
</tr>
<? } ?>
</table>

</td></tr></table>