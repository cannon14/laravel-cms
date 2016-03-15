    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter2(3, L_G_LINKSTYLE); ?>
   <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_LINKSTYLE;?></b></td>
      <td colspan=2>
      <select name=link_style>
        <option value="<?=LINK_STYLE_OLD?>" <?=($_POST['link_style'] == LINK_STYLE_OLD ? 'selected' : '')?>><?=L_G_LINKSTYLE_OLD?></option>
        <option value="<?=LINK_STYLE_NEW?>" <?=($_POST['link_style'] == LINK_STYLE_NEW ? 'selected' : '')?>><?=L_G_LINKSTYLE_NEW?></option>
      </select>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><? showHelp('L_G_HLPLINKSTYLE'); ?></td>
    </tr>

    <tr><td class=settingsLine colspan=3><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_PERMANENT_REDIRECT?></b></td>
      <td valign=top>
      <input type=checkbox name=permanent_redirect value=1 <?=($_POST['permanent_redirect'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <? showHelp('L_G_HLPPERMANENT_REDIRECT'); ?>
      </td>
    </tr>

    <tr><td class=settingsLine colspan=3><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_TRACKREFSBYSESSION?></b></td>
      <td valign=top>
      <input type=checkbox name=track_by_session value=1 <?=($_POST['track_by_session'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <? showHelp('L_G_HLPTRACKREFSBYSESSION'); ?>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 

    <tr>
      <td class=dir_form valign=top nowrap><b>Click Success Tracking Cookies</b></td>
      <td valign=top>
      <input type=checkbox name=csCookie value=1 <?=($_POST['csCookie'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <? showHelp('This is the CLick Success Session Tracking Cookie Implementation.'); ?>
      </td>
    </tr> 
 <tr><td class=settingsLine colspan=3><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_TRACKREFSBYIP?></b></td>
      <td valign=top>
      <input type=checkbox name=track_by_ip value=1 <?=($_POST['track_by_ip'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top rowspan=2>
      <? showHelp('L_G_HLPTRACKREFSBYIP'); ?>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_IPADDRESSVALIDITY?></b></td>
      <td valign=top>
      <input type=text size=5 name=ip_validity value="<?=$_POST['ip_validity']?>">
      &nbsp;
      <select name=ip_validity_type>
        <option value="minutes" <?=($_POST['ip_validity_type'] == 'minutes' ? 'selected' : '')?>><?=L_G_MINUTES?></option>
        <option value="hours" <?=($_POST['ip_validity_type'] == 'hours' ? 'selected' : '')?>><?=L_G_HOURS?></option>
        <option value="days" <?=($_POST['ip_validity_type'] == 'days' ? 'selected' : '')?>><?=L_G_DAYS?></option>
        <option value="years" <?=($_POST['ip_validity_type'] == 'years' ? 'selected' : '')?>><?=L_G_YEARS?></option>
      </select><br>      
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_OVERWRITE_COOKIE?></b></td>
      <td valign=top>
      <input type=checkbox name=overwrite_cookie value=1 <?=($_POST['overwrite_cookie'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <? showHelp('L_G_HLPOVERWRITECOOKIE'); ?>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_DELETE_COOKIE?></b></td>
      <td valign=top>
      <input type=checkbox name=delete_cookie value=1 <?=($_POST['delete_cookie'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <? showHelp('L_G_HLPDELETECOOKIE'); ?>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_REFERRED_AFFILIATE?></b></td>
      <td valign=top>
      <input type=checkbox name=referred_affiliate_allow value=1 <?=($_POST['referred_affiliate_allow'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <? showHelp('L_G_HLPREFERREDAFFILIATE'); ?>
      </td>
    </tr>
    
   
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_CHOOSE_REFERRED_AFFILIATE;?></b></td>
      <td valign=top colspan=2>
        <select name=referred_affiliate>
        <? while($data=$this->a_list_data->getNextRecord()) { ?>
             <option value='<?=$data['userid']?>' <?=($_POST['referred_affiliate'] == $data['userid'] ? ' selected' : '')?>><?=$data['userid'].' : '.$data['name'].' '.$data['surname']?></option>
        <? } ?>
        </select>
      </td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    
    <? QUnit_Templates::printFilter2(3, L_G_P3PPOLICY); ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_URLTOP3PPOLICYXML?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=p3p_xml value="<?=$_POST['p3p_xml']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_COMPACTP3PPOLICY?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=p3p_compact value="<?=$_POST['p3p_compact']?>"></td>
    </tr>    
    <tr>
      <td></td>
      <td colspan=2><? showHelp('L_G_HLPP3P'); ?></td>
    </tr>    
    <tr><td colspan=3>&nbsp;</td></tr>

    </table>
