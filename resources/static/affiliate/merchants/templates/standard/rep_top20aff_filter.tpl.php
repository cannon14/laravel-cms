
<table class=listing border=0 cellspacing=0 cellpadding=0>
<? QUnit_Templates::printFilter(1, L_G_TOPAFFILIATES); ?>
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
<?      while($data=$this->a_list_data->getNextRecord()) { ?>
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['rt_campaign'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
      <td align=left>
        <?=L_G_NUMBEROFTOPAFFILIATES?>
      </td>
      <td align=left>
        <select name=rt_topcount>
          <option value='_'><?=L_G_ALL?></option>
          <option value='10' <?=($_REQUEST['rt_topcount'] == 10 ? 'selected' : '')?>>10</option>
          <option value='20' <?=($_REQUEST['rt_topcount'] == 20 ? 'selected' : '')?>>20</option>
          <option value='30' <?=($_REQUEST['rt_topcount'] == 30 ? 'selected' : '')?>>30</option>
          <option value='50' <?=($_REQUEST['rt_topcount'] == 50 ? 'selected' : '')?>>50</option>
          <option value='100' <?=($_REQUEST['rt_topcount'] == 100 ? 'selected' : '')?>>100</option>
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
        <input type=radio name=rt_reporttype value=perday <?=($_REQUEST['rt_reporttype']=='perday' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_PER.' '.L_G_DAY?>
      </td>
      <td align=left>
        <select name=rt_pd_day>
<?      for($i=1; $i<=31; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pd_day'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        <select name=rt_pd_month>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pd_month'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        <select name=rt_pd_year>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rt_pd_year'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td align=left>
        <input type=radio name=rt_reporttype value=permonth <?=($_REQUEST['rt_reporttype']=='permonth' ? "checked" : "")?>>
        &nbsp;
        <?=L_G_PER.' '.L_G_MONTH?>
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
        <?=L_G_PER.' '.L_G_YEAR?>
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
      <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantReports'>
      <input type=hidden name=reporttype value='top20affiliates'>
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>

  <hr>
