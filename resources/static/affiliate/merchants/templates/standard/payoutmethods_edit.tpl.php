
    <center>
    <form action=index_popup.php method=post>
    <table class=listing cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_NAME;?></b>&nbsp;</td>
      <td><input type=text name=name size=44 value="<?=$_POST['name']?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_LANGUAGE_CODE;?></b>&nbsp;</td>
      <td><input type=text name=langid size=44 value="<?=$_POST['langid']?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <? showHelp('L_G_HLPLANGUAGE_CODE'); ?>
      </td>
    </tr>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_STATUS;?></b>&nbsp;</td>
      <td>
        <select name=disabled>
        <?
          if($_POST['disabled'] == '') $_POST['disabled'] = STATUS_ENABLED;
          echo "<option value=\"".STATUS_ENABLED."\" ".($_POST['disabled'] == STATUS_ENABLED ? "selected" : "").">".L_G_ENABLED."</option>\n";
          echo "<option value=\"".STATUS_DISABLED."\" ".($_POST['disabled'] == STATUS_DISABLED ? "selected" : "").">".L_G_DISABLED."</option>\n"; 
        ?>
        </select>*&nbsp;
      </td>
    </tr>
    <tr>
      <td class=dir_form nowrap>&nbsp;<b><?=L_G_ORDER?></b>&nbsp;</td>
      <td><input type=text name=rorder size=4 value="<?=($_POST['rorder'] == '' ? '1' : $_POST['rorder'])?>">&nbsp;*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;<b><?=L_G_EXPORTFORMAT;?></b>&nbsp;</td>
      <td><textarea name=exportformat cols=88 rows=2><?=$_POST['exportformat']?></textarea>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <? showHelp('L_G_HLPEXPORTFORMAT'); ?>
      <a class=helplink href="http://www.qualityunit.com/help/index.php?pcid=_&psid=0acd82b535&iid=2967c5dfce" target="_blank"><?=L_G_HLPCLICKHEREFORMOREHELP?></a>
      </td>
    </tr>    
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;<b><?=L_G_BUTTONFORMAT;?></b>&nbsp;</td>
      <td><textarea name=buttonformat cols=88 rows=5><?=$_POST['buttonformat']?></textarea>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <? showHelp('L_G_HLPBUTTONFORMAT'); ?>
      <a class=helplink href="http://www.qualityunit.com/help/index.php?pcid=_&psid=0acd82b535&iid=2967c5dfce" target="_blank"><?=L_G_HLPCLICKHEREFORMOREHELP?></a>
      </td>
    </tr>    
    <tr>
      <td class=dir_form colspan=2 align=center>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_Settings'>
        <input type=hidden name=action value=<?=$_POST['action']?>>
        <input type=hidden name=pid value=<?=$_POST['pid']?>>
        <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
        <input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      </td>
    </tr>
    </table>
    </form>
    </center>
