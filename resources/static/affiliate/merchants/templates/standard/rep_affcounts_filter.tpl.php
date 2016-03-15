
<table class=listing border=0 cellspacing=0 cellpadding=1>
<? QUnit_Templates::printFilter(1, L_G_AFFILIATECOUNTS); ?>
<tr>
  <td valign=top align=left>

  <form action=index.php method=get>
  <table border=0>
    <tr>
      <td align=left colspan=2>
        <?=L_G_TIMEPERIOD?>
      </td>
    </tr>
    
    <tr>
      <td align=left>
        &nbsp;
        <?=L_G_PER.' '.L_G_YEAR?>
      </td>
      <td align=left>
        <select name=rac_py_year>
<?      for($i=2003; $i<=$this->a_curyear; $i++) { ?>
          <option value='<?=$i?>' <?=($i == $_REQUEST['rac_py_year'] ? "selected" : "")?>><?=$i?></option>
<?      } ?>
        </select>
      </td>
    </tr>
    <tr>
      <td align=center colspan=2>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_MerchantReports'>
      <input type=hidden name=reporttype value='affiliatecounts'>
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>      
      </form>
      </td>
    </tr>
  </table>
  </form>
<hr>