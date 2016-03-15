
<table class=listing border=0 cellspacing=0 cellpadding=2>
<? QUnit_Templates::printFilter(L_G_TRAFFIC); ?>
<tr>
  <td valign=top align=left>

  <form action=index.php method=get>
  <table border=0>
    <tr>
      <td align=left>
        <?=L_G_PCNAME?>
      </td>
      <td align=left>
        <select name=rt_campaign>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['rt_campaign'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
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
      <td align=left>
        <input type=radio name=rt_reporttype value=permonth <?=($_REQUEST['rt_reporttype']=='permonth' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_DAILYINMONTH?>
      </td>
      <td align=left>
        <select name=rt_pm_month>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pm_month'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        <select name=rt_pm_year>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pm_year'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td align=left>
        <input type=radio name=rt_reporttype value=peryear <?=($_REQUEST['rt_reporttype']=='peryear' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_MONTHLYINYEAR?>
      </td>
      <td align=left>
        <select name=rt_py_year>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_py_year'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td align=center colspan=2>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Affiliates_Views_AffReports'>
      <input type=hidden name=reporttype value='traffic'>
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>

  <hr>
