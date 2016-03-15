<script>
function Details(ID)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_Accounting&aid="+ID+"&action=details";
}

</script>
    <form name=FilterForm action=index.php method=post>
    <table class=listing border=0 width=600 cellspacing=0>
    <? QUnit_Templates::printFilter(10); ?>
    <tr>
      <td width=1% nowrap>&nbsp;<?=L_G_AFFILIATE?>&nbsp;</td>
      <td width=50%>
      <select name=acc_userid>
        <option value="_"><?=L_G_ALL?></option>
<?    while($data=$this->a_list_data->getNextRecord()) { ?>
        <option value="<?=$data['userid']?>" <?=($_REQUEST['acc_userid'] == $data['userid'] ? 'selected' : '')?>><?=(($data['name']!='' || $data['surname']!='') ? $data['name'].' '.$data['surname'] : $data['username'])?></option>
<?    } ?>      
      </select>
      </td>
      <td width=1% nowrap>&nbsp;<?=L_G_NOTE?>&nbsp;</td>
      <td><input type=text name=acc_note size=35 value="<?=$_REQUEST['acc_note']?>"></td>
    </tr>
    <tr>
      <td colspan=4>&nbsp;<?=L_G_FROM?>&nbsp;
      <?
        print L_G_DAY;
        echo "&nbsp;<select name=acc_day1>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['acc_day1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=acc_month1>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['acc_month1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=acc_year1>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['acc_year1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>
      &nbsp;&nbsp;&nbsp;<?=L_G_TO?>&nbsp;
      <?
        print L_G_DAY;
        echo "&nbsp;<select name=acc_day2>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['acc_day2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=acc_month2>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['acc_month2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=acc_year2>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['acc_year2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>      
      </td>
    </tr>
    <tr>
      <td colspan=4 width=50% align=center>&nbsp;<input type=submit class=formbutton value='Search'></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_Accounting'>
    <input type=hidden name=rtype value='all'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">

  <br>
