<? 
//----------------------------------------------------------------------------
// DO NOT EDIT ANYTHING IN THIS SECTION UNLESS YOU KNOW WHAT YOU ARE DOING
//----------------------------------------------------------------------------
require_once('global.php');

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QCore_Bl_Accounts');
QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('QCore_Settings');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SignupUser');

if($_POST['commited'] == 'yes')
{
    $signup = QUnit_Global::newObj('Affiliate_Scripts_Bl_SignupUser');

    $signup->processSignup();

    if(count(QUnit_Messager::getErrorMessages()) == 0)
    {
        if($signup->settings['Aff_affpostsignupurl'] == '')
        {
            exit;
        }

        $signup->redirect($signup->settings['Aff_affpostsignupurl']);
        exit;
    }
}
else
{
    $settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $_REQUEST['aid']);
    $settings = array_merge($settings, QCore_Settings::getGlobalSettings());
    Affiliate_Scripts_Bl_Signup::setLanguageFile(($settings['Aff_default_lang'] != '' ? 
            $settings['Aff_default_lang'] : $settings['Glob_default_lang']));
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
if(QUnit_Messager::getOkMessage() != '') 
    print '<div id="okMessage">'.QUnit_Messager::getOkMessage().'</div>';

if(QUnit_Messager::getErrorMessage() != '') 
    print '<div id="errorMessage">'.QUnit_Messager::getErrorMessage().'</div>';
?>
<br>
    <form method='post' action='affsignup.php'>
    <table border=0 cellspacing=0 cellpadding=2>
    <tr>
      <td class=dir_form><b><?=L_G_EMAIL?></b></td>
      <td><input type=text name=uname size=44 value="<?=$_POST['uname']?>">&nbsp;*</td>
    </tr>
    <tr>
      <td class=dir_form><b><?=L_G_NAME?></b></td>
      <td><input type=text name=name size=44 value="<?=$_POST['name']?>">&nbsp;*</td>
    </tr>        
    <tr>
      <td class=dir_form><b><?=L_G_SURNAME?></b></td>
      <td><input type=text name=surname size=44 value="<?=$_POST['surname']?>">&nbsp;*</td>
    </tr>        
    <tr>
      <td class=dir_form><?=L_G_COMPANYNAME?></td>
      <td><input type=text name=company_name size=44 value="<?=$_POST['company_name']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form><b><?=L_G_WEBURL?></b></td>
      <td><input type=text name=weburl size=44 value="<?=$_POST['weburl']?>">&nbsp;*</td>
    </tr>    
    <tr>
      <td class=dir_form><b><?=L_G_STREET?></b></td>
      <td><input type=text name=street size=44 value="<?=$_POST['street']?>">&nbsp;*</td>
    </tr>    
    <tr>
      <td class=dir_form><b><?=L_G_CITY?></b></td>
      <td><input type=text name=city size=44 value="<?=$_POST['city']?>">&nbsp;*</td>
    </tr>    
    <tr>
      <td class=dir_form><?=L_G_STATE?></td>
      <td><input type=text name=state size=44 value="<?=$_POST['state']?>"></td>
    </tr>    
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
    <tr>
      <td class=dir_form><b><?=L_G_ZIPCODE?></b></td>
      <td><input type=text name=zipcode size=44 value="<?=$_POST['zipcode']?>">&nbsp;*</td>
    </tr>    
    <tr>
      <td class=dir_form><?=L_G_PHONE?></td>
      <td><input type=text name=phone size=44 value="<?=$_POST['phone']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form><?=L_G_FAX?></td>
      <td><input type=text name=fax size=44 value="<?=$_POST['fax']?>"></td>
    </tr>    
    <tr>
      <td class=dir_form><?=L_G_TAXSSN?></td>
      <td><input type=text name=tax_ssn size=44 value="<?=$_POST['tax_ssn']?>"></td>
    </tr>    
    <tr>
      <td colspan=2><hr></td>
    </tr>
<? if($_REQUEST['pid'] == '' && ($_COOKIE[COOKIE_NAME] == '')) { ?>    
    <tr>
      <td class=dir_form><?=L_G_AFFTOLDABOUTAFFPROGRAM?></td>
      <td valign=top><input type=text name=parentuserid size=10 value="<?=$_POST['parentuserid']?>"></td>
    </tr>       
<? } else { ?>
    <input type=hidden name=pid value="<?=$_REQUEST['pid']?>">
<? } ?>
    <tr>
      <td class=dir_form colspan=2 align=center>
      <?=L_G_IAGREEWITH?> <a href='./termsofservice.htm' target='_new'><?=L_G_TERMSOFSERVICE?></a> 
      <input type='checkbox' name='tos' value='1' >      
      </td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center><b><?=L_G_AFFPASSWORDSENTTOEMAILADDRESS?></b></td>
    </tr>    <tr>
      <td class=dir_form colspan=2 align=center>
      <input type=hidden name=l value='<?=$_REQUEST['l']?>'>
      <input type=hidden name=aid value='<?=$_REQUEST['aid']?>'>
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
