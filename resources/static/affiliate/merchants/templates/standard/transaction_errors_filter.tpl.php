<script>
function addTransaction()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TransactionErrors&action=create&type=all","Transaction","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 
}

function editTransaction(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TransactionErrors&action=edit&id="+ID,"Transaction","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 
}

function traceTransaction(ID)
{
	var url = window.open("index_popup.php?md=Affiliate_Merchants_Views_QueryTool&action=trace&reftrans="+ID ,"Transaction","scrollbars=1, top=100, left=100, width=800, height=250, status=0");;
    url.focus;
}

function ReSubmit(ID)
{
      document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionErrors&type=all&tid="+ID+"&action=resubmit";
}

function DiffTrans(ID)
{
      document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionErrors&type=all&tid="+ID+"&action=difftrans";
}

function Delete(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETETRANS?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionErrors&type=all&tid="+ID+"&action=delete";
}
</script>

    <form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 width=600 cellspacing=0>
    <? QUnit_Templates::printFilter(10, "Error Log Filter"); ?>
	<tr>
    <td colspan="4">
    &nbsp;
    </td>
    </tr>
	<tr>

	  <td>Log:</td><td> <select name=logtype class=formbutton>
	  		<option value="_" <?=($_REQUEST['logtype'] == "_" ? 'selected' : '')?>>All</option>
	  		<option value=error <?=($_REQUEST['logtype'] == "error" ? 'selected' : '')?>>Error Log</option>
	  		<option value=variance <?=($_REQUEST['logtype'] == "variance" ? 'selected' : '')?>>Variance Log</option>
	  		</select></td>
      <td>Affiliate:</td><td> <select name=tm_userid class=formbutton>
        <option value="_"><?=L_G_ALL?></option>
<?    while($data=$this->a_list_users->getNextRecord()) { ?>
        <option value="<?=$data['userid']?>" <?=($_REQUEST['tm_userid'] == $data['userid'] ? 'selected' : '')?>><?=(($data['name']!='' || $data['surname']!='') ? $data['name'].' '.$data['surname'] : $data['username'])?></option>
<?    } ?>      
      </select></td>
    </tr>
    
    <tr>
    <td colspan="4">
    &nbsp;
    </td>
    </tr>

	<tr>
	<td colspan="4">
     From 
      <?
        print L_G_DAY;
        echo "&nbsp;<select class=formbutton name=tm_day1>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_day1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select class=formbutton name=tm_month1>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_month1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select class=formbutton name=tm_year1>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_year1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>
      &nbsp;&nbsp;&nbsp;<?=L_G_TO?>&nbsp;
      <?
        print L_G_DAY;
        echo "&nbsp;<select  class=formbutton name=tm_day2>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_day2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select class=formbutton name=tm_month2>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_month2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select class=formbutton name=tm_year2>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_year2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>    
      <br>
      <br>  
      Rows: <select name=numrows class=formbutton onchange="javascript:FilterForm.list_page.value=0;">
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
		<br>
		<br>
		<div align='center'>
		<input type=submit class=formbutton value='Search'>
		</div>
	</td>
	</tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_TransactionErrors'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">

<br>

