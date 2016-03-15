    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter2(3, L_G_EDITCUSTOMIZATION); ?>
    <tr>
      <td class=listresult2 valign=top><b><?=L_G_AFFAPPROVAL?></b></td>
      <td class=listresult2 align=left valign=top>
        <select name=affiliateapproval>
          <option value="<?=APPROVE_AUTOMATIC?>" <?=($_POST['affiliateapproval'] == APPROVE_AUTOMATIC ? 'selected' : '')?>><?=L_G_AUTOMATIC?></option>
          <option value="<?=APPROVE_MANUAL?>" <?=($_POST['affiliateapproval'] == APPROVE_MANUAL ? 'selected' : '')?>><?=L_G_MANUAL?></option>
        </select>
      </td>
      <td class=listresult2 valign=top><? showHelp('L_G_HLPAFFAPPROVAL'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_LOGOUTURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=afflogouturl value="<?=$_POST['afflogouturl']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><? showHelp('L_G_HLPLOGOUTURL'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_POSTSIGNUPURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=affpostsignupurl value="<?=$_POST['affpostsignupurl']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><? showHelp('L_G_HLPPOSTSIGNUPURL'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_JOIN_CAMPAIGN?></b></td>
      <td valign=top><input type=checkbox name=join_campaign value=1 <?=($_POST['join_campaign'] == 1 ? 'checked' : '')?>></td>
      <td><? showHelp('L_G_HLPJOINCAMPAIGN'); ?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
      <td class=formBText valign=top nowrap><?=L_G_DISPLAY_NEWS?></td>
      <td valign=top><input type=checkbox name=display_news value=1 <?=($_POST['display_news'] == 1 ? 'checked' : '')?>></td>
      <td><? showHelp('L_G_HLPDISPLAY_NEWS'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?=L_G_DISPLAY_RESOURCES?></td>
      <td valign=top><input type=checkbox name=display_resources value=1 <?=($_POST['display_resources'] == 1 ? 'checked' : '')?>></td>
      <td><? showHelp('L_G_HLPDISPLAY_RESOURCES'); ?></td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?=L_G_DISPLAY_BANNER_STATISTICS_ALL?></td>
      <td valign=top><input type=checkbox name=display_banner_stats_all value=1 <?=($_POST['display_banner_stats_all'] == 1 ? 'checked' : '')?>></td>
      <td><? showHelp('L_G_HLPDISPLAY_BANNER_STATISTICS_ALL'); ?></td>
    </tr>
    <? QUnit_Templates::printFilter2(3, L_G_MATRIXSETTINGS); ?>   
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_USE_FORCED_MATRIX?></b></td>
      <td valign=top><input type=checkbox name=use_forced_matrix value=1 <?=($_POST['use_forced_matrix'] == 1 ? 'checked' : '')?>></td>
      <td><? showHelp('L_G_HLPUSE_FORCED_MATRIX'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_MATRIX_HEIGHT?></b></td>
      <td valign=top><input type=text name=matrix_height value='<?=($_POST['matrix_height'] < 0 ? '0' : $_POST['matrix_height'])?>' style='width: 30px' maxlength='3'></td>
      <td><? showHelp('L_G_HLPMATRIX_HEIGHT'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_MATRIX_WIDTH?></b></td>
      <td valign=top><input type=text name=matrix_width value='<?=($_POST['matrix_width'] < 0 ? '0' : $_POST['matrix_width'])?>' style='width: 30px' maxlength='3'></td>
      <td><? showHelp('L_G_HLPMATRIX_WIDTH'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SEND_SPILLOVER_TO;?></b></td>
      <td valign=top colspan=2>
        <select name=matrix_forced_user>
          <option value='<?=MATRIX_ACTUAL_SPONSOR?>' <?=$_POST['matrix_forced_user'] == MATRIX_ACTUAL_SPONSOR ? 'selected' : ''?>><?=L_G_ACTUAL_SPONSOR?></option>
          <option value='<?=MATRIX_NO_SPONSOR?>' <?=$_POST['matrix_forced_user'] == MATRIX_NO_SPONSOR ? 'selected' : ''?>><?=L_G_NO_SPONSOR?></option>
          <option value=''><?=L_G_CHOOSE_FORCED_AFFILIATE?></option>
        <? while($data=$this->a_list_data->getNextRecord()) { ?>
             <option value='<?=$data['userid']?>' <?=($_POST['matrix_forced_user'] == $data['userid'] ? ' selected' : '')?>><?=$data['userid'].' : '.$data['name'].' '.$data['surname']?></option>
        <? } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign=top colspan=2><? showHelp('L_G_HLPSEND_SPILLOVER_TO'); ?></td>
    </tr>
    </table>
