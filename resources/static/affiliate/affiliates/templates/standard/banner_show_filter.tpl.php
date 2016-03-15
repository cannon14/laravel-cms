<? if($this->a_Auth->getSetting('Aff_main_site_url') != '') { ?>  
  <table class=listing border=0 cellspacing=0 cellpadding=3>
  <? QUnit_Templates::printFilter(2, L_G_GENERAL_MAIN_URL); ?>
    <tr>
      <td class=formText nowrap>&nbsp;
      <textarea rows=3 cols=80><?=$this->a_Auth->getSetting('Aff_main_site_url')?>?a_aid=<?=$this->a_params['Affiliate_refid']?></textarea>&nbsp;</td>
    </tr>
  </table>

  <br>
<? } ?>

<? if ($this->a_numrows > 0) { ?>
  <form action=index.php method=post>
  <table class=listing border=0 cellspacing=0 cellpadding=3>
  <? QUnit_Templates::printFilter(2, L_G_FILTER); ?>
   <tr>
     <td width="20%" nowrap><?=L_G_PCNAME?>&nbsp;</td>
     <td>
        <select name=bs_campaign>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['bs_campaign'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>
        </select>        
      </td>
   </tr>
<!--
   <tr>
     <td align=left><?=L_G_SORTBY?></td>
     <td align=left>
        <select name="bs_sortby">
            <option value='campaign'><?=L_G_CAMPAIGN?></option>
            <option value='uniqimps_period'><?=L_G_IMPRESSIONSUNIQUE.' '.L_G_PERIOD?></option>
            <option value='clicks_period'><?=L_G_CLICKS.' '.L_G_PERIOD?></option>
            <option value='ratio_period'><?=L_G_RATIO.' '.L_G_PERIOD?></option>
            <option value='uniqimps_all'><?=L_G_IMPRESSIONSUNIQUE.' '.L_G_ALL2?></option>
            <option value='clicks_all'><?=L_G_CLICKS.' '.L_G_ALL2?></option>
            <option value='ratio_all'><?=L_G_RATIO.' '.L_G_ALL2?></option>
        </select>
     </td>
   </tr>
-->
   <tr>
      <td align=left colspan=2>
        <?=L_G_BANNERSTATSPERIOD?>
      </td>
    </tr>
    
    <tr>
      <td align=left colspan=2>
        <input type=radio name=bs_reporttype value=today <?=($_REQUEST['bs_reporttype']=='today' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_TODAY?>
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <input type=radio name=bs_reporttype value=thisweek <?=($_REQUEST['bs_reporttype']=='thisweek' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_THISWEEK?>
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <input type=radio name=bs_reporttype value=thismonth <?=($_REQUEST['bs_reporttype']=='thismonth' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_THISMONTH?>
      </td>
    </tr>
    <tr>
      <td align=left valign=top nowrap>
        <input type=radio name=bs_reporttype value=timerange <?=($_REQUEST['bs_reporttype']=='timerange' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_TIMERANGE?>
        &nbsp;&nbsp;&nbsp;
      </td>
      <td align=left>
        <? QUnit_Templates::printTimerange('bs_day', 'bs_month', 'bs_year'); ?>      
      </td>
    </tr>
    <tr>
     <td colspan=2 align=left>
      <input type=hidden name=filtered value=1>
      <input type=hidden name=list_page value="<?=$_REQUEST['list_page']?>">
      <input type=hidden name=md value='Affiliate_Affiliates_Views_AffBannerManager'>
      <input type=submit class=formbutton value="<?=L_G_FILTER?>">
     </td>
   </tr>  
   </table>
    </form>
    <? } ?>
