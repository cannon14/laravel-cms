<script>
function addExpense()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ExpensesManager&action=create&type=all","Expense","scrollbars=1, top=100, left=100, width=600, height=500, status=0");
    wnd.focus(); 
}
function editExpense(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ExpensesManager&action=edit&eid="+ID,"Expense","scrollbars=1, top=100, left=100, width=600, height=500, status=0");
    wnd.focus(); 
}
function deleteExpense(ID)
{

  if(confirm("<?=L_G_CONFIRMDELETEEXPENSE?> - "+ID))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_ExpensesManager&type=all&eid="+ID+"&action=delete";

}
</script>
<form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 width=600 cellspacing=0>
    <? QUnit_Templates::printFilter(10); ?>
    <tr>
      <td width=1% nowrap>&nbsp;<?=L_G_AFFILIATE?>&nbsp;</td>
      <td>
      <select name=exp_affiliateid>
        <option value="_"><?=L_G_ALL?></option>
<?    while($data=$this->a_list_users->getNextRecord()) { ?>
        <option value="<?=$data['userid']?>" <?=($_REQUEST['exp_affiliateid'] == $data['userid'] ? 'selected' : '')?>><?=(($data['name']!='' || $data['surname']!='') ? $data['name'].' '.$data['surname'] : $data['username'])?></option>
<?    } ?>      
      </select>
      </td>
      <td align=left><?=L_G_PCNAME?></td>
      <td align=left>
        <select name=exp_campaign>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->a_list_campaings->getNextRecord()) { ?>
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['exp_campaign'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
        <td align=left>
        &nbsp;<?=L_G_CHANNEL?>
      </td>
      <td align=left>
        <select name=exp_channel>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->cid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['trackerId']?>' <?=($_REQUEST['exp_channel'] == $data['trackerId'] ? 'selected' : '')?>><?=$data['name']?> (<?=$data['trackerId']?>)</option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
      <td align=left>
        &nbsp;<?=L_G_EPISODE?>
      </td>
      <td align=left>
        <select name=exp_episode>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->did_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['keywordId']?>' <?=($_REQUEST['exp_episode'] == $data['keywordId'] ? 'selected' : '')?>><?=$data['name']?>  (<?=$data['keywordId']?>)</option>
<?      } ?>          
      

     </select>&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
       <td align=left>
        &nbsp;<?=L_G_TIMESLOT?>
      </td>
      <td align=left>
        <select name=exp_timeslot>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->eid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['timeslotId']?>' <?=($_REQUEST['exp_timeslot'] == $data['timeslotId'] ? 'selected' : '')?>><?=$data['name']?>  (<?=$data['timeslotId']?>)</option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
      
    </tr>  
    <tr>
    <td colspan=2>
    <?
    echo "<INPUT TYPE=RADIO NAME='date' VALUE='all' " . ($_REQUEST['date'] != 'e.purchasedate' && $_REQUEST['date'] != 'e.expensedate' && $_REQUEST['date'] != 'e.endexpensedate' ? 'CHECKED' : '' ) . "> All Dates";
    echo "<br>";
    echo "<INPUT TYPE=RADIO NAME='date' VALUE='e.purchasedate' " . ($_REQUEST['date'] == 'e.purchasedate' ? 'CHECKED' : '' ) . "> Purchase Date";
    echo "<br>";
    echo "<INPUT TYPE=RADIO NAME='date' VALUE='e.expensedate' " . ($_REQUEST['date'] == 'e.expensedate' ? 'CHECKED' : '' ) . "> Expense Start Date";
    echo "<br>";
    echo "<INPUT TYPE=RADIO NAME='date' VALUE='e.endexpensedate' " . ($_REQUEST['date'] == 'e.endexpensedate' ? 'CHECKED' : '' ) . "> Expense End Date";
	
	?>
<br><br>
&nbsp;&nbsp;&nbsp;<?=L_G_FROM?>&nbsp;
      <?
        
        
        print L_G_MONTH;
        echo "&nbsp;<select class=formbutton name=exp_month1>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_month1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_DAY;
        echo "&nbsp;<select class=formbutton name=exp_day1>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_day1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select class=formbutton name=exp_year1>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_year1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>
      <P>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=L_G_TO?>&nbsp;
      <?
        
        print L_G_MONTH;
        echo "&nbsp;<select class=formbutton name=exp_month2>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_month2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_DAY;
        echo "&nbsp;<select class=formbutton name=exp_day2>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_day2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select class=formbutton name=exp_year2>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['exp_year2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>
      <P>
       </td>
    </tr>
    
    
    
    
  
    <tr>
      <td align=left nowrap>&nbsp;<?=L_G_ROWSPERPAGE?></td>
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
      <td colspan=4 width=50% align=center>&nbsp;<input type=submit class=formbutton value='Search'></td>
    </tr>
    <tr>
      <td colspan=4>&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_ExpensesManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">

<br>
