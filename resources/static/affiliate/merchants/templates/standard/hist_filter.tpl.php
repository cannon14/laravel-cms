
    <form name=FilterForm action=index.php method=post>
    <table class=listing border=0 width=600 cellspacing=0>
    <? QUnit_Templates::printFilter(2); ?>
    <tr>
      <td width=1% nowrap>&nbsp;<?=L_G_HISTORYTYPE?>&nbsp;</td>
      <td nowrap>&nbsp;
        <select name=h_historytype>
          <option value='_'><?=L_G_ALL?></option>
          <option value=<?=WLOG_DBERROR?> <? print ($_REQUEST['h_historytype'] == WLOG_DBERROR ? 'selected' : '');?>><?=L_G_LOG_DBERROR?></option>
          <option value=<?=WLOG_ERROR?> <? print ($_REQUEST['h_historytype'] == WLOG_ERROR ? 'selected' : '');?>><?=L_G_LOG_ERROR?></option>
          <option value=<?=WLOG_ACTIONS?> <? print ($_REQUEST['h_historytype'] == WLOG_ACTIONS ? 'selected' : '');?>><?=L_G_LOG_ACTIONS?></option>
          <option value=<?=WLOG_DEBUG?> <? print ($_REQUEST['h_historytype'] == WLOG_DEBUG ? 'selected' : '');?>><?=L_G_LOG_DEBUG?></option>
          <option value=100 <? print ($_REQUEST['h_historytype'] == "100" ? 'selected' : '');?>><?=L_G_SYS_NOTIFY?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td width=1% nowrap>&nbsp;<?=L_G_SEARCHTEXT?>&nbsp;</td>
      <td nowrap>&nbsp;
      <input type=text name=h_note size=35 value="<?=$_REQUEST['h_note']?>"></td>
    </tr>
    <tr>
      <td align=left>&nbsp;<?=L_G_FROM?>&nbsp;
      </td>
      <td>&nbsp;
      <?
        print L_G_DAY;
        echo "&nbsp;<select name=h_day1>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['h_day1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=h_month1>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['h_month1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=h_year1>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['h_year1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>
      &nbsp;&nbsp;&nbsp;<?=L_G_TO?>&nbsp;
      <?
        print L_G_DAY;
        echo "&nbsp;<select name=h_day2>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['h_day2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=h_month2>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['h_month2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=h_year2>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['h_year2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>      
      </td>
    </tr>
    <tr><td align=left nowrap>&nbsp;<?=L_G_ROWSPERPAGE?></td>
      <td>&nbsp;
      <select name=numrows onchange="javascript:FilterForm.list_page.value=0;">
        <option value=10 <? print ($_REQUEST['numrows']==10 ? "selected" : ""); ?>>10</option>
        <option value=20 <? print ($_REQUEST['numrows']==20 ? "selected" : ""); ?>>20</option>
        <option value=30 <? print ($_REQUEST['numrows']==30 ? "selected" : ""); ?>>30</option>
        <option value=50 <? print ($_REQUEST['numrows']==50 ? "selected" : ""); ?>>50</option>
        <option value=100 <? print ($_REQUEST['numrows']==100 ? "selected" : ""); ?>>100</option>
        <option value=200 <? print ($_REQUEST['numrows']==200 ? "selected" : ""); ?>>200</option>
        <option value=500 <? print ($_REQUEST['numrows']==500 ? "selected" : ""); ?>>500</option>
        <option value=1000000 <? print ($_REQUEST['numrows']==1000000 ? "selected" : ""); ?>><?=L_G_ALL?></option>
      </select>
      </td>
    </tr>        
    <tr>
      <td align=center colspan=2>&nbsp;<input class="formbutton" type=submit value='Search'></td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_History'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>      
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">

<br>
