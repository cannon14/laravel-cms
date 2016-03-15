
<table class=listing border=0 cellspacing=0 cellpadding=0>
<? QUnit_Templates::printFilter(1, L_G_QUICK); ?>
<tr>
  <td valign=top align=left>

  <form action=index.php method=get>
  <table border=0>
    <tr>
      <td align=left nowrap>
        <?=L_G_AFFILIATE?>
      </td>
      <td align=left width=99%>
        <select name=rq_affiliate>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data2->getNextRecord()) { ?>
          <option value='<?=$data['userid']?>' <?=($_REQUEST['rq_affiliate'] == $data['userid'] ? 'selected' : '')?>><?=$data['name'].' '.$data['surname']?></option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
      <td align=left nowrap>
        <?=L_G_PCNAME?>
      </td>
      <td align=left>
        <select name=rq_campaign>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['rq_campaign'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <?=L_G_TIMEPERIOD?>
      </td>
    </tr>
    
    <tr>
      <td align=left colspan=2>
        <input type=radio name=rq_reporttype value=today <?=($_REQUEST['rq_reporttype']=='today' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_TODAY?>
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <input type=radio name=rq_reporttype value=thisweek <?=($_REQUEST['rq_reporttype']=='thisweek' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_THISWEEK?>
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <input type=radio name=rq_reporttype value=thismonth <?=($_REQUEST['rq_reporttype']=='thismonth' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_THISMONTH?>
      </td>
    </tr>
    <tr>
      <td align=left colspan=2>
        <input type=radio name=rq_reporttype value=timerange <?=($_REQUEST['rq_reporttype']=='timerange' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_TIMERANGE?>
       &nbsp;&nbsp;
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
    <tr>
      <td align=center colspan=2>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantReports'>
      <input type=hidden name=reporttype value='quick'>
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>

  </td>
</tr>
