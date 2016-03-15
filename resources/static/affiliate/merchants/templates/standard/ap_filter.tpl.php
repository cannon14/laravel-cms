<script>
function manualPayment(ID)
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliatePayments&aid="+ID+"&action=manualpay";
}
</script>

    <form name=FilterForm action=index.php method=get>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(10, L_G_FILTER); ?>
    <tr>
      <td align=left>&nbsp;<?=L_G_PAYOUTMETHOD?>&nbsp;
        <select name=ap_payout_type>
          <option value='_'><?=L_G_ALL?></option>
<?      foreach($this->a_payout_methods as $method) { ?>
          <option value=<?=$method['payoptid']?> <? print ($_REQUEST['ap_payout_type'] == $method['payoptid'] ? 'selected' : '');?>><?=(defined($method['langid']) ? constant($method['langid']) : $method['name']) ?></option>
<?      } ?>
        </select>
      </td>
    </tr>
<? if($this->a_Auth->getSetting('Aff_min_payout_options') != '') { ?>     
    <tr>
      <td align=left><input type=checkbox name=ap_reachedminpayout value='yes' <?=($_REQUEST['ap_reachedminpayout'] == 'yes' ? 'checked' : '')?>>&nbsp;
          <?=L_G_REACHEDMINPAYOUT?>&nbsp;
      </td>
    </tr>
<? } ?>    
    <tr>
      <td align=left><input type=radio name=ap_showtype value='allunpaid' <?=($_REQUEST['ap_showtype'] == 'allunpaid' ? 'checked' : '')?>>&nbsp;
          <?=L_G_ALLUNPAID?>&nbsp;
      </td>
    </tr>
    <tr>
      <td align=left><input type=radio name=ap_showtype value='daterange' <?=($_REQUEST['ap_showtype'] == 'daterange' ? 'checked' : '')?>>&nbsp;
          <?=L_G_DATERANGE?>&nbsp;
      </td>
    </tr>
    <tr>
      <td align=center>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <b><?=L_G_FROM?></b>&nbsp;
      <?
        print L_G_DAY;
        echo "&nbsp;<select name=ap_day1>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['ap_day1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=ap_month1>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['ap_month1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=ap_year1>";
        for($i=$this->a_minyear; $i<=$this->a_maxyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['ap_year1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>
      &nbsp;&nbsp;&nbsp;<b><?=L_G_TO?></b>&nbsp;
      <?
        print L_G_DAY;
        echo "&nbsp;<select name=ap_day2>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['ap_day2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=ap_month2>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['ap_month2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=ap_year2>";
        for($i=$this->a_minyear; $i<=$this->a_maxyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['ap_year2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>      
      </td>
    </tr>    
    <tr>
      <td colspan=4 align=center>&nbsp;<input type=submit class=formbutton value='<?=L_G_SUBMIT?>'></td>
    </tr>
    <tr>
      <td>&nbsp;</td>      
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliatePayments'>
    <input type=hidden name=reporttype value='transactions'>
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
    </form>
    <br>
