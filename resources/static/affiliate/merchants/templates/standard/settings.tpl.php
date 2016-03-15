
    <center>
    <form action=index.php method=post>
    <table class=tableresult border=0 cellspacing=0 cellpadding=2>
    <tr>
      <td class=header align=center colspan=3><?=L_G_PAYOUTMETHODS?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SHOWBANKINFO;?></b></td>
      <td valign=top><input type=checkbox name=showbankinfo value=1 <?=($_POST['showbankinfo'] == 1 ? 'checked' : '')?>></td>
      <td><? showHelp('L_G_HLPSHOWBANKINFO'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SHOWPAYPALINFO;?></b></td>
      <td valign=top><input type=checkbox name=showpaypalinfo value=1 <?=($_POST['showpaypalinfo'] == 1 ? 'checked' : '')?>><br><br></td>
      <td rowspan=2 valign=top><? showHelp('L_G_HLPSHOWPAYPALINFO'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_PAYPALCURRENCY?></b></td>
      <td valign=top>
      <select name=paypalcurrency>
        <option value="USD" <?=($_POST['paypalcurrency'] == 'USD' ? 'selected' : '')?>>USD</option>
        <option value="EUR" <?=($_POST['paypalcurrency'] == 'EUR' ? 'selected' : '')?>>EUR</option>
        <option value="GBP" <?=($_POST['paypalcurrency'] == 'GBP' ? 'selected' : '')?>>GBP</option>
        <option value="CAD" <?=($_POST['paypalcurrency'] == 'CAD' ? 'selected' : '')?>>CAD</option>
        <option value="JPY" <?=($_POST['paypalcurrency'] == 'JPY' ? 'selected' : '')?>>JPY</option>
      </select>    
      </td>
    </tr>    
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SHOWMONEYBOOKERSINFO;?></b></td>
      <td valign=top><input type=checkbox name=showmoneybookersinfo value=1 <?=($_POST['showmoneybookersinfo'] == 1 ? 'checked' : '')?>></td>
      <td rowspan=2 valign=top ><? showHelp('L_G_HLPSHOWMONEYBOOKERSINFO'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_MONEYBOOKERSCURRENCY;?></b></td>
      <td valign=top><input type=text size=3 name=moneybookerscurrency value="<?=$_POST['moneybookerscurrency']?>"></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SHOWCHECKINFO;?></b></td>
      <td valign=top><input type=checkbox name=showcheckinfo value=1 <?=($_POST['showcheckinfo'] == 1 ? 'checked' : '')?>></td>
      <td><? showHelp('L_G_HLPSHOWCHECKINFO'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_MINPAYOUTOPTIONS;?></b></td>
      <td colspan=2><input type=text size=70 name=min_payout_options value="<?=$_POST['min_payout_options']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><? showHelp('L_G_HLPMINPAYOUTOPTIONS'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_INITIALMINPAYOUT?></b></td>
      <td colspan=2><input type=text size=20 name=initial_min_payout value="<?=$_POST['initial_min_payout']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><? showHelp('L_G_HLPINITIALMINPAYOUT'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    
    <tr>
      <td class=header align=center colspan=3><?=L_G_SYSTEMSETTINGS?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SUPPORTRECURRINGCOMMISSIONS;?></b></td>
      <td valign=top><input type=checkbox name=support_recurring_commissions value=1 <?=($_POST['support_recurring_commissions'] == 1 ? 'checked' : '')?>></td>
      <td valign=top><? showHelp('L_G_HLPSUPPORTRECURRINGCOMMISSIONS'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>    
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_RECURRINGREALCOMMISSIONS;?></b></td>
      <td valign=top><input type=checkbox name=recurringrealcommissions value=1 <?=($_POST['recurringrealcommissions'] == 1 ? 'checked' : '')?>></td>
      <td valign=top><? showHelp('L_G_HLPRECURRINGREALCOMMISSIONS'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_MAXCOMMISSIONLEVELS?></b></td>
      <td valign=top colspan=2>
      <select name=maxcommissionlevels>
        <option value="1" <?=($_POST['maxcommissionlevels'] == 1 ? 'selected' : '')?>>1 - <?=L_G_NOMULTITIERCOMMISSIONS?></option>
<?      for($i=2; $i<=10; $i++) { ?>
        <option value="<?=$i?>" <?=($_POST['maxcommissionlevels'] == $i ? 'selected' : '')?>><?=$i.' - '.L_G_TIER?></option>
<?      } ?>        
      </select>      
      </td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td valign=top><b><?=L_G_FORCEPRODUCTIDCHOOSING?></b></td>
      <td valign=top colspan=2>
      <select name=forcecommfromproductid>
        <option value="no" <?=($_POST['forcecommfromproductid'] == 'no' ? 'selected' : '')?>><?=L_G_NO?></option>
        <option value="yes" <?=($_POST['forcecommfromproductid'] == 'yes' ? 'selected' : '')?>><?=L_G_YES?></option>
      </select>      
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td class=dir_form colspan=2><? showHelp('L_G_HLPFORCEPRODUCTIDCHOOSING'); ?></td>
    </tr>    
    <tr>
      <td valign=top><b><?=L_G_APPLYCATFROMBANNER?></b></td>
      <td valign=top colspan=2>
      <input type=checkbox name=apply_from_banner value=1 <?=($_POST['apply_from_banner'] == 1 ? 'checked' : '')?>>
    </tr>
    <tr>
      <td class=listresult2 valign=top nowrap>&nbsp;</td>
      <td class=listresult2 colspan=2><? showHelp('L_G_HLPAPPLYCATFROMBANNER'); ?></td>
    </tr>    

    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_EXPORTDIR;?></b></td>
      <td colspan=2 valign=top><input type=text size=70 name=export_dir value="<?=$_POST['export_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2 valign=top><? showHelp('L_G_HLPEXPORTDIR'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_EXPORTURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=export_url value="<?=$_POST['export_url']?>"></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
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
    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=dir_form valign=top><b><?=L_G_BANNERSDIR;?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_dir value="<?=$_POST['banners_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><? showHelp('L_G_HLPBANNERSDIR'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_BANNERSURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_url value="<?=$_POST['banners_url']?>"></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_URLTOSCRIPTSDIR?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=scripts_url value="<?=$_POST['scripts_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><? showHelp('L_G_HLPURLTOSCRIPTSDIR'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SIGNUPURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=signup_url value="<?=$_POST['signup_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><? showHelp('L_G_HLPSIGNUPURL'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_TRACKREFSBYSESSION?></b></td>
      <td valign=top>
      <input type=checkbox name=track_by_session value=1 <?=($_POST['track_by_session'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <? showHelp('L_G_HLPTRACKREFSBYSESSION'); ?>
      </td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_TRACKREFSBYIP?></b></td>
      <td valign=top>
      <input type=checkbox name=track_by_ip value=1 <?=($_POST['track_by_ip'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top rowspan=2>
      <? showHelp('L_G_HLPTRACKREFSBYSESSION'); ?>
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
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SYSTEMEMAIL;?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=system_email value="<?=$_POST['system_email']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><? showHelp('L_G_HLPSYSTEMEMAIL'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SYSTEMCURRENCY;?></b></td>
      <td valign=top><input type=text size=3 name=system_currency value="<?=$_POST['system_currency']?>"></td>
      <td valign=top><? showHelp('L_G_HLPSYSTEMCURRENCY'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SYSTEMLANGUAGE;?></b></td>
      <td valign=top>
      <select name=default_lang>
<?    while($data=$this->a_list_data->getNextRecord()) { ?>
        <option value="<?=$data?>" <?=($_POST['default_lang'] == $data ? 'selected' : '')?>><?=$data?></option>
<?    } ?>
      </select><br>
      </td>
      <td valign=top rowspan=2><? showHelp('L_G_HLPSYSTEMLANGUAGE'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_ALLOWSELECTLANGUAGE;?></b></td>
      <td valign=top colspan=2><input type=checkbox name=allow_choose_lang value=1 <?=($_POST['allow_choose_lang'] == 1 ? 'checked' : '')?>></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SHOWMINIHELP?></b></td>
      <td valign=top><input type=checkbox name=show_minihelp value=1 <?=($_POST['show_minihelp'] == 1 ? 'checked' : '')?>></td>
      <td valign=top><? showHelp('L_G_HLPSHOWMINIHELP', true); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;<b><?=L_G_LOG_LEVEL?></b>&nbsp;</td>
      <td valign=top>
        <input type=checkbox name=log_level_element[] value=<?=WLOG_DBERROR?> <?=(($_POST['log_level'] & WLOG_DBERROR) == WLOG_DBERROR ? ' checked' : '')?>><?=L_G_LOG_DBERROR?>
        <br><input type=checkbox name=log_level_element[] value=<?=WLOG_ERROR?> <?=(($_POST['log_level'] & WLOG_ERROR) == WLOG_ERROR ? ' checked' : '')?>><?=L_G_LOG_ERROR?>
        <br><input type=checkbox name=log_level_element[] value=<?=WLOG_ACTIONS?> <?=(($_POST['log_level'] & WLOG_ACTIONS) == WLOG_ACTIONS ? ' checked' : '')?>><?=L_G_LOG_ACTIONS?>
        <br><input type=checkbox name=log_level_element[] value=<?=WLOG_DEBUG?> <?=(($_POST['log_level'] & WLOG_DEBUG) == WLOG_DEBUG ? ' checked' : '')?>><?=L_G_LOG_DEBUG?>
      </td>
      <td valign=top><? showHelp('L_G_HLP_LOG_LEVEL'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_DEBUGTRANSACTIONS?></b></td>
      <td valign=top>
      <select name=debug_trans>
        <option value="no" <?=($_POST['debug_trans'] == 'no' ? 'selected' : '')?>><?=L_G_NO?></option>
        <option value="yes" <?=($_POST['debug_trans'] == 'yes' ? 'selected' : '')?>><?=L_G_YES?></option>
      </select>      
      </td>
      <td valign=top><? showHelp('L_G_HLPDEBUGTRANSACTIONS'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>

    <tr>
      <td class=header align=center colspan=3><?=L_G_LOGINPROTECTION?></td>
    </tr>
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

    <tr>
      <td class=header align=center colspan=3><?=L_G_FRAUDPROTECTION?></td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>
      <input type=checkbox name=declinefrequentclicks value=1 <?=($_POST['declinefrequentclicks']==1 ? 'checked' : '')?>>
      <b>
      <?=L_G_DECLINEFREQUENTCLICKS?>
      <input type=text name=clickfrequency size=3 value='<?=$_POST['clickfrequency']?>'>
      <?=L_G_SECONDS?> <?=L_G_DECLINEFREQUENTCLICKS2?>
      </b>
      </td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>
      <input type=checkbox name=declinefrequentsales value=1 <?=($_POST['declinefrequentsales']==1 ? 'checked' : '')?>>
      <b>
      <?=L_G_DECLINEFREQUENTSALES?>
      <input type=text name=salefrequency size=3 value='<?=$_POST['salefrequency']?>'>
      <?=L_G_SECONDS?> <?=L_G_DECLINEFREQUENTSALES2?>
       </b>
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

    <tr>
      <td class=header align=center colspan=3><?=L_G_P3PPOLICY?></td>
    </tr>
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

    
    <tr>
      <td class=header align=center colspan=3><?=L_G_EMAILNOTIFICATIONS?></td>
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?=L_G_SUPPORTDAILYREPORTS?></b></td>
      <td class=listresult2 align=left valign=top>
      <select name=email_supportdailyreports>
        <option value="no" <?=($_POST['email_supportdailyreports'] == 'no' ? 'selected' : '')?>><?=L_G_NO?></option>
        <option value="yes" <?=($_POST['email_supportdailyreports'] == 'yes' ? 'selected' : '')?>><?=L_G_YES?></option>
      </select>      
      <td class=listresult2 valign=top><? showHelp('L_G_HLPSUPPORTDAILYREPORTS'); ?></td>
    </tr>
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
      <td class=listresult2 valign=top><? showHelp('L_G_HLPDAILYREPORT'); ?></td>       
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
    <tr><td class=listresult2 colspan=3>&nbsp;</td></tr>

    <tr>
      <td class=header align=center colspan=3><?=L_G_EDITCUSTOMIZATION?></td>
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?=L_G_AFFAPPROVAL?></b></td>
      <td class=listresult2 align=left valign=top>
      <select name=affiliateapproval>
        <option value="<?=APPROVE_AUTOMATIC?>" <?=($_POST['affiliateapproval'] == APPROVE_AUTOMATIC ? 'selected' : '')?>><?=L_G_AUTOMATIC?></option>
        <option value="<?=APPROVE_MANUAL?>" <?=($_POST['affiliateapproval'] == APPROVE_MANUAL ? 'selected' : '')?>><?=L_G_MANUAL?></option>
      </select>      
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
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_JOIN_CAMPAIGN?></b></td>
      <td valign=top><input type=checkbox name=join_campaign value=1 <?=($_POST['join_campaign'] == 1 ? 'checked' : '')?>></td>
      <td><? showHelp('L_G_HLPJOINCAMPAIGN'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_SIGNUP_BONUS?></b></td>
      <td valign=top><input type=text name=program_signup_bonus value='<?=($_POST['program_signup_bonus'] != '' ? $_POST['program_signup_bonus'] : '0')?>'></td>
      <td><? showHelp('L_G_HLPPROGRAM_SIGNUP_BONUS'); ?></td>
    </tr>
    <tr><td class=listresult2 colspan=3>&nbsp;</td></tr>
    
    <tr>
      <td class=dir_form colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_Settings'>
      <input type=hidden name=action value='edit'>
      <input class=formbutton type=submit value="<?=L_G_SAVECHANGES?>">
      </td>
    </tr>    
    </table>
    
    </form>
    </center>
    <br>
