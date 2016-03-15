    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter2(3, L_G_COMMUNICATION); ?> 
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SYSTEMEMAIL;?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=system_email value="<?=$_POST['system_email']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><? showHelp('L_G_HLPSYSTEMEMAIL'); ?></td>
    </tr>
    <tr>
      <td nowrap><b><?=L_G_MAIL_SEND_TYPE?></b></td>
      <td valign=top nowrap>
        <input type=radio name=mail_send_type value='<?=EMAILBY_MAIL?>' <?=($_POST['mail_send_type'] == EMAILBY_MAIL ? ' checked' : '')?>><?=L_G_SENDBYMAIL?>
      </td>
      <td><? showHelp('L_G_HLPSENDBYMAIL'); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign=top nowrap>
        <input type=radio name=mail_send_type value='<?=EMAILBY_SMTP?>' <?=($_POST['mail_send_type'] == EMAILBY_SMTP ? ' checked' : '')?>><?=L_G_SENDUSINGSMTP?>
      </td>
      <td><? showHelp('L_G_HLPSENDUSINGSMTP'); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign=top nowrap colspan=2>
      <table border=0 cellspacing=1 cellpadding=0>
      <tr>
        <td align=left>&nbsp;<?=L_G_SMTPSERVER?></td>
        <td align=left>&nbsp;<input type=text name='smtp_server' size=40 value='<?=$_POST['smtp_server']?>'></td>
      </tr>
      <tr>
        <td align=left>&nbsp;<?=L_G_SMTPUSERNAME?></td>
        <td align=left>&nbsp;<input type=text name='smtp_username' size=40 value='<?=$_POST['smtp_username']?>'></td>
      </tr>
      <tr>
        <td align=left>&nbsp;<?=L_G_SMTPPASSWORD?></td>
        <td align=left>&nbsp;<input type=password name='smtp_password' size=40 value='<?=$_POST['smtp_password']?>'></td>
      </tr>
      </table>
      </td>
    </tr>
    </table>
