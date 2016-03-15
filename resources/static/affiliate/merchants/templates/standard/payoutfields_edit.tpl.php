
    <center>
    <form action=index_popup.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(4, $_POST['header']); ?>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_CODE_FOR_EXPORTFORMAT;?></b>&nbsp;</td>
      <td colspan=3 align=left><input type=text name=code size=44 value="<?=$_POST['code']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_NAME;?></b>&nbsp;</td>
      <td colspan=3 align=left><input type=text name=name size=44 value="<?=$_POST['name']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_LANGUAGE_CODE;?></b>&nbsp;</td>
      <td colspan=3 align=left><input type=text name=langid size=44 value="<?=$_POST['langid']?>">&nbsp;*&nbsp;</td>
    </tr>
    
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_TYPE;?></b>&nbsp;</td>
      <td>
        <select name=rtype>
        <?
          if($_POST['rtype'] == '') $_POST['rtype'] = PAYOUTFIELD_TYPE_TEXT;
          echo "<option value=\"".PAYOUTFIELD_TYPE_TEXT."\" ".($_POST['rtype'] == PAYOUTFIELD_TYPE_TEXT ? "selected" : "").">".L_G_TYPE_TEXT."</option>\n";
          echo "<option value=\"".PAYOUTFIELD_TYPE_SELECT."\" ".($_POST['rtype'] == PAYOUTFIELD_TYPE_SELECT ? "selected" : "").">".L_G_SELECT."</option>\n"; 
        ?>
        </select>&nbsp;*&nbsp;
      </td>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_STATUS;?></b>&nbsp;</td>
      <td align=right>
        <select name=mandatory>
        <?
          if($_POST['mandatory'] == '') $_POST['mandatory'] = STATUS_ENABLED;
          echo "<option value=\"".STATUS_ENABLED."\" ".($_POST['mandatory'] == STATUS_ENABLED ? "selected" : "").">".L_G_MANDATORY."</option>\n";
          echo "<option value=\"".STATUS_DISABLED."\" ".($_POST['mandatory'] == STATUS_DISABLED ? "selected" : "").">".L_G_NO_MANDATORY."</option>\n"; 
        ?>
        </select>&nbsp;*&nbsp;
      </td>
    </tr>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_ORDER;?></b>&nbsp;</td>
      <td valign=top colspan=3 align=left><input type=text name=rorder size=4 value="<?=($_POST['rorder'] == '' ? '1' : $_POST['rorder'])?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;<b><?=L_G_AVAILABLE_VALUES;?></b>&nbsp;</td>
      <td valign=top colspan=3 align=left><textarea name=availablevalues cols=44 rows=5><?=$_POST['availablevalues']?></textarea>&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form colspan=4 align=center>
      <br>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_Settings'>
        <input type=hidden name=action value=<?=$_POST['action']?>>
        <input type=hidden name=pid value=<?=$_POST['pid']?>>
        <input type=hidden name=fid value=<?=$_POST['fid']?>>
        <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
        <input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>
    </center>
