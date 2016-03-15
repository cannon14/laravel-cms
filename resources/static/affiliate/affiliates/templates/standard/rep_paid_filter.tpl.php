
<table class=listing border=0 cellspacing=0 cellpadding=0>
<? QUnit_Templates::printFilter(1, L_G_PAIDCOMM); ?>
<tr>
  <td valign=top align=left>

  <form action=index.php method=get>
  <table border=0>
    <tr>
      <td align=left>
        <input type=hidden name='rq_reporttype' value='permonth'>
        &nbsp;
        SELECT MONTH: 
      </td>
      <td align=left>
        <select name=rq_month1>
<?      for($i=1; $i<=12; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rq_month1'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
        <select name=rq_year1>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rq_year1'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
      </td>
      <td align=right >
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Affiliates_Views_AffReports'>
      <input type=hidden name=reporttype value='paid'>
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>

  </td>
</tr>
