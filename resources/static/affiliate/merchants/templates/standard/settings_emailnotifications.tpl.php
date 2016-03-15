    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter2(3, L_G_EMAILNOTIFICATIONS); ?>    
    <tr>
      <td class=listresult2 valign=top><b><?=L_G_ONAFFSIGNUP?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_onaffsignup value=1 <?=($_POST['email_onaffsignup'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><? showHelp('L_G_HLPONAFFSIGNUP'); ?></td>       
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?=L_G_ONSALE?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_onsale value=1 <?=($_POST['email_onsale'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><? showHelp('L_G_HLPONSALE'); ?></td>      
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?=L_G_DAILYREPORT?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_dailyreport value=1 <?=($_POST['email_dailyreport'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><? showHelp('L_G_HLPSUPPORTDAILYREPORTS'); ?></td>       
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?=L_G_ONRECURRINGTRANSGENERATED?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_recurringtrangenerated value=1 <?=($_POST['email_recurringtrangenerated'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><? showHelp('L_G_HLPRECURRINGTRANGENERATED'); ?></td>       
    </tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_EMAILFORSENDINGNOTIFICATIONS;?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=notifications_email value="<?=$_POST['notifications_email']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><? showHelp('L_G_HLPEMAILFORSENDINGNOTIFICATIONS'); ?></td>
    </tr>
    </table>
