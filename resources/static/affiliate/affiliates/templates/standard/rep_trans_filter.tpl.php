
<table class=listing border=0 cellspacing=0 cellpadding=2>
<? QUnit_Templates::printFilter(1, L_G_TRANSACTIONS); ?>
<tr>
  <td valign=top align=left>

  <form name=FilterForm action=index.php method=get>
  <table border=0>
  <tr>
    <td colspan=2>
    <table width=100% border=0 cellspacing=0 cellpading=0>
    <tr>
      <td align=left width=1% nowrap>
        <?=L_G_PCNAME?>
      </td>
      <td align=left width=50%>&nbsp;
        <select name=rq_campaign>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['rq_campaign'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
      <td colspan=2>&nbsp;</td>
    </tr>
    <tr>
      <td align=left width=1% nowrap valign=top>
        <?=L_G_STATUS?>
      </td>
      <td align=left width=50% valign=top>&nbsp;
        <select name=rq_status>
          <option value='_'><?=L_G_ALLSTATES?></option>
          <option value=<?=AFFSTATUS_NOTAPPROVED?> <? print ($_REQUEST['rq_status'] == AFFSTATUS_NOTAPPROVED ? 'selected' : '');?>><?=L_G_WAITINGAPPROVAL?></option>
          <option value=<?=AFFSTATUS_APPROVED?> <? print ($_REQUEST['rq_status'] == AFFSTATUS_APPROVED ? 'selected' : '');?>><?=L_G_APPROVED?></option>
          <option value=<?=AFFSTATUS_SUPPRESSED?> <? print ($_REQUEST['rq_status'] == AFFSTATUS_SUPPRESSED ? 'selected' : '');?>><?=L_G_SUPPRESSED?></option>
      </select>&nbsp;&nbsp;
      </td>
      <td align=left width=1% nowrap valign=top>
        <?=L_G_TYPE?>
      </td>
      <td align=left width=50%>&nbsp;
          <? $this->a_Auth->getCommissionTypeSelect('rq_transtype[]', $_REQUEST['rq_transtype'], false); ?>
          &nbsp;&nbsp;
      </td>
      </tr>
      </table>
    </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <?=L_G_TIMEPERIOD?>
      </td>
    </tr>
    
    <tr>
      <td align=left>
        <input type=radio name=rq_reporttype value=today <?=($_REQUEST['rq_reporttype']=='today' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_TODAY?>
      </td>
    </tr>
    <tr>
      <td align=left>
        <input type=radio name=rq_reporttype value=thisweek <?=($_REQUEST['rq_reporttype']=='thisweek' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_THISWEEK?>
      </td>
    </tr>
    <tr>
      <td align=left>
        <input type=radio name=rq_reporttype value=thismonth <?=($_REQUEST['rq_reporttype']=='thismonth' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_THISMONTH?>
      </td>
    </tr>
    <tr>
      <td align=left>
        <input type=radio name=rq_reporttype value=timerange <?=($_REQUEST['rq_reporttype']=='timerange' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_TIMERANGE?>
      </td>
      <td align=left>
        &nbsp;
        <b><?=L_G_FROM?></b>
        &nbsp;<?=L_G_DAY?>&nbsp;
        <select name=rq_day1>
<?      for($i=1; $i<=31; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rq_day1'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        &nbsp;<?=L_G_MONTH?>&nbsp;
        <select name=rq_month1>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rq_month1'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        &nbsp;<?=L_G_YEAR?>&nbsp;
        <select name=rq_year1>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rq_year1'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>

        &nbsp;<b><?=L_G_TO?></b>&nbsp;

        &nbsp;<?=L_G_DAY?>&nbsp;
        <select name=rq_day2>
<?      for($i=1; $i<=31; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rq_day2'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        &nbsp;<?=L_G_MONTH?>&nbsp;
        <select name=rq_month2>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rq_month2'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        &nbsp;<?=L_G_YEAR?>&nbsp;
        <select name=rq_year2>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rq_year2'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        
      </td>
    </tr>
    <tr><td align=left nowrap><?=L_G_ROWSPERPAGE?></td>
      <td>&nbsp;
      <select name=numrows onchange="javascript:FilterForm.list_page.value=0;">
        <option value=10 <? print ($_REQUEST['numrows']==10 ? "selected" : ""); ?>>10</option>
        <option value=20 <? print ($_REQUEST['numrows']==20 ? "selected" : ""); ?>>20</option>
        <option value=30 <? print ($_REQUEST['numrows']==30 ? "selected" : ""); ?>>30</option>
        <option value=50 <? print ($_REQUEST['numrows']==50 ? "selected" : ""); ?>>50</option>
        <option value=100 <? print ($_REQUEST['numrows']==100 ? "selected" : ""); ?>>100</option>
        <option value=200 <? print ($_REQUEST['numrows']==200 ? "selected" : ""); ?>>200</option>
        <option value=500 <? print ($_REQUEST['numrows']==500 ? "selected" : ""); ?>>500</option>
        <option value=1000 <? print ($_REQUEST['numrows']==1000 ? "selected" : ""); ?>>1000</option>
        <option value=100000000 <? print ($_REQUEST['numrows']==100000000 ? "selected" : ""); ?>><?=L_G_ALL?></option>
      </select>
      </td>
    </tr>       
    <tr>
      <td align=center colspan=2>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Affiliates_Views_AffReports'>
      <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'> 
      <input type=hidden name=reporttype value='transactions'>
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>


