    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter2(3, L_G_FRAUDPROTECTION); ?>
    <tr>
      <td class=listresult2 align=left colspan=3>
        <input type=checkbox name=declinefrequentclicks value=1 <?=($_POST['declinefrequentclicks']==1 ? 'checked' : '')?>>
        <b><?=L_G_DECLINEFREQUENTCLICKS?>
        <input type=text name=clickfrequency size=3 value='<?=$_POST['clickfrequency']?>'>
        <?=L_G_SECONDS?> <?=L_G_DECLINEFREQUENTCLICKS2?>
        </b>
      </td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>&nbsp;<b><?=L_G_WHATTODO_REPEATING_CLICKS?></b>
        <select name=frequentclicks>
          <option value="1" <?=($_POST['frequentclicks'] == '1' ? 'selected' : '')?>><?=L_G_DECLINE?></option>
          <option value="2" <?=($_POST['frequentclicks'] == '2' ? 'selected' : '')?>><?=L_G_DONOT_SAVE?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>
        <input type=checkbox name=declinefrequentsales value=1 <?=($_POST['declinefrequentsales']==1 ? 'checked' : '')?>>
        <b><?=L_G_DECLINEFREQUENTSALES?>
        <input type=text name=salefrequency size=3 value='<?=$_POST['salefrequency']?>'>
        <?=L_G_SECONDS?> <?=L_G_DECLINEFREQUENTSALES2?>
        </b>
      </td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>&nbsp;<b><?=L_G_WHATTODO_REPEATING_SALES?></b>
        <select name=frequentsales>
          <option value="1" <?=($_POST['frequentsales'] == '1' ? 'selected' : '')?>><?=L_G_DECLINE?></option>
          <option value="2" <?=($_POST['frequentsales'] == '2' ? 'selected' : '')?>><?=L_G_DONOT_SAVE?></option>
        </select>    
      </td>
    </tr>
    <tr>
      <td align=left colspan=3>
      <input type=checkbox name=declinesameorderid value=1 <?=($_POST['declinesameorderid']==1 ? 'checked' : '')?>>
      <b>
      <?=L_G_DECLINESALESSAMEORDERID?>
      </b>
      </td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>     
    <? QUnit_Templates::printFilter2(3, L_G_LOGINPROTECTION); ?>
    <tr>
      <td class=dir_form valign=top><b><?=L_G_LOGINPROTECTIONRETRIES;?></b></td>
      <td valign=top><input type=text size=3 name=login_protection_retries value="<?=$_POST['login_protection_retries']?>"><br><br></td>
      <td valign=top><? showHelp('L_G_HLPLOGINPROTECTIONRETRIES'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top><b><?=L_G_LOGINPROTECTIONDELAY;?></b></td>
      <td valign=top><input type=text size=3 name=login_protection_delay value="<?=$_POST['login_protection_delay']?>"><br><br></td>
      <td valign=top><? showHelp('L_G_HLPLOGINPROTECTIONDELAY'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>    
    </table>    
