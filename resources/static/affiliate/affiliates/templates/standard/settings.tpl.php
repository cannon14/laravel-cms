
    <center>
    <form action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(3, L_G_EMAILNOTIFICATIONS) ?>
<? if($this->a_Auth->getSetting('Aff_allow_choose_lang') == 1) 
   { 
?>       
    <tr>
      <td class=listresult2><b><?=L_G_LANGOFNOTIFICATIONS?></b></td>
      <td class=listresult2 align=left valign=top colspan=2>
      <select name=aff_notificationlang>
<?    while($data=$this->a_list_data->getNextRecord()) { ?>
        <option value="<?=$data?>" <?=($_POST['aff_notificationlang'] == $data ? 'selected' : '')?>><?=$data?></option>
<?    } ?>
      </select>     
      </td>
    </tr>
<?  } ?>
    
    <tr>
      <td class=listresult2><b><?=L_G_ONSUBAFFSIGNUP?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_affonaffsignup value=1 <?=($_POST['email_affonaffsignup'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><? showHelp('L_G_HLPAFFONAFFSIGNUP'); ?></td>      
    </tr>
    <tr>
      <td class=listresult2><b><?=L_G_ONSALE?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_affonsale value=1 <?=($_POST['email_affonsale'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><? showHelp('L_G_HLPONSALE'); ?></td>      
    </tr>
<? if($this->a_Auth->getSetting('Aff_email_supportdailyreports') == 'yes') { ?>     
    <tr>
      <td class=listresult2><b><?=L_G_DAILYREPORT?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_affdailyreport value=1 <?=($_POST['email_affdailyreport'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><? showHelp('L_G_HLPDAILYREPORT'); ?></td>      
    </tr>
<? } ?>    
    <tr><td colspan=3>&nbsp;</td></tr>

    <tr>
      <td class=dir_form colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Affiliates_Views_Settings'>
      <input type=hidden name=action value='edit'>
      <input class=formbutton type=submit value="<?=L_G_SAVECHANGES?>">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    </table>
    
    </form>
    </center>
    <br>
