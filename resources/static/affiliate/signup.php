<? 
//----------------------------------------------------------------------------
// DO NOT EDIT ANYTHING IN THIS SECTION UNLESS YOU KNOW WHAT YOU ARE DOING
//----------------------------------------------------------------------------


require_once('global.php');

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QCore_Bl_Accounts');
QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('QCore_Settings');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SignupUserNew');
$settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $_REQUEST['aid']);
$settings = array_merge($settings, QCore_Settings::getGlobalSettings());
//Affiliate_Scripts_Bl_Signup::setLanguageFile(($settings['Aff_default_lang'] != '' ? 
//            $settings['Aff_default_lang'] : $settings['Glob_default_lang']));

if($_POST['commited'] == 'yes')
{
    $signup = QUnit_Global::newObj('Affiliate_Scripts_Bl_SignupUserNew');
    
    if($signup->processSignup() == false) {
        $errorMessage = $signup->getErrorMessage();
    } else {
        $errorMessage = "Added successfully";
        //$signup->redirect($signup->settings['Aff_affpostsignupurl']);
    }

}

function getFieldRow($code, $caption) {
    global $settings;
    if($settings['Aff_signup_'.$code] == "1") {
        if($settings['Aff_signup_'.$code.'_mandatory'] === "true") {
            $caption = "<b>$caption</b>";
            $mandatSign = "*";
        } else {
            $mandatSign = "";
        }        
        return "<tr>\n" .
             "<td class=dir_form>$caption</td>\n" .
             "<td><input type=text name=$code size=44 value=".$_POST[$code].">$mandatSign</td>" .
             "</tr>";             
    }
}
//----------------------------------------------------------------------------
// End of section
//----------------------------------------------------------------------------
?>

<?
include('./header.htm');
?>
<center>
<?
    echo $errorMessage;
//if(QUnit_Messager::getOkMessage() != '') 
//    print '<div id="okMessage">'.QUnit_Messager::getOkMessage().'</div>';
//
//if(QUnit_Messager::getErrorMessage() != '') 
//    print '<div id="errorMessage">'.QUnit_Messager::getErrorMessage().'</div>';
?>
<br>
    <form method='post' action='signup.php'>
    <table border=0 cellspacing=0 cellpadding=2>
    <?= getFieldRow('username', L_G_EMAIL)?>
    <?= getFieldRow('name', L_G_NAME)?>
    <?= getFieldRow('surname', L_G_SURNAME)?>
    <?= getFieldRow('company_name', L_G_COMPANYNAME)?>
    <?= getFieldRow('street', L_G_STREET)?>
    <?= getFieldRow('city', L_G_CITY)?>
    <?= getFieldRow('state', L_G_STATE)?>
        
    <tr>
      <td class=dir_form><b><?=L_G_COUNTRY?></b></td>
      <td>
        <select name=country>&nbsp;*
        <? if($country == '') $country = 'United States';
           foreach($GLOBALS['countries'] as $item_country) { ?>
            <option value="<?=$item_country?>" <? if($item_country == $country) echo ' selected'; ?>><?=$item_country?></option>
        <? } ?>
        </select>&nbsp;*
      </td>
    </tr>
    
    <?= getFieldRow('zipcode', L_G_ZIPCODE)?>
    <?= getFieldRow('phone', L_G_PHONE)?>
    <?= getFieldRow('weburl', L_G_WEBURL)?>
    <?= getFieldRow('fax', L_G_FAX)?>
    <?= getFieldRow('tax_ssn', L_G_TAXSSN)?>
    <?= getFieldRow('data1', $settings['Aff_signup_data1_name'])?>
    <?= getFieldRow('data2', $settings['Aff_signup_data2_name'])?>
    <?= getFieldRow('data3', $settings['Aff_signup_data3_name'])?>
    <?= getFieldRow('data4', $settings['Aff_signup_data4_name'])?>
    <?= getFieldRow('data5', $settings['Aff_signup_data5_name'])?>
    
    <tr>
      <td colspan=2><hr></td>
    </tr>
<? if($_REQUEST['pid'] == '' && (!isset($_COOKIE[COOKIE_NAME]) || $_COOKIE[COOKIE_NAME] == '')) { ?>    
    <tr>
      <td class=dir_form><?=L_G_AFFTOLDABOUTAFFPROGRAM?></td>
      <td valign=top><input type=text name=parentuserid size=10 value="<?=$_POST['parentuserid']?>"></td>
    </tr>       
<? } else { ?>
    <input type=hidden name=pid value="<?=$_REQUEST['pid']?>">
<? } ?>
        <? if($settings['Aff_signup_display_terms'] == "1") { ?>
        <tr>
          <td class=dir_form colspan=2 align=center>
           <?=L_G_TERMSOFSERVICE?><br>
           <textarea readonly cols="50" rows="6"><?= $settings['Aff_signup_terms_conditions']?></textarea><br>
            <? if($settings['Aff_signup_force_acceptance'] == "1") { ?>
                <input type='checkbox' name='tos' value='1'><?=L_G_IAGREEWITH?>      
            <? } ?>
          </td>
        </tr>
        <? } ?>
    <tr>
      <td class=dir_form colspan=2 align=center><b><?=L_G_AFFPASSWORDSENTTOEMAILADDRESS?></b></td>
    </tr>    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=l value='<?=$_REQUEST['l']?>'>
      <input type=hidden name=aid value='<?=$_REQUEST['aid']?>'>
      <input type=hidden name=upid value='<?=$_REQUEST['upid']?>'>
      <input type=hidden name=commited value='yes'>
      <input type=submit value='<?=L_G_SUBMIT?>'>
      </td>
    </tr>
    </table>
    </form>
    
    
    </center>

<?
  include('./footer.htm');
?>
