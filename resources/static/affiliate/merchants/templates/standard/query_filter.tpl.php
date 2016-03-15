<?
$bannerarray = $_POST['banner_array'];
$campaignarray = $_POST['campaign_array'];
asort($bannerarray);
asort($campaignarray);
?>

<script>
function addTransaction()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_QueryTool&action=create&type=all","Transaction","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 
}

function editTransaction(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_QueryTool&action=edit&tid="+ID,"Transaction","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 
}

function traceTransaction(ID)
{
	var url = window.open("index_popup.php?md=Affiliate_Merchants_Views_QueryTool&action=trace&reftrans="+ID ,"Transaction","scrollbars=1, top=100, left=100, width=800, height=250, status=0");;
    url.focus;
}

function approvePayout(ID)
{
	var url = "index.php?md=Affiliate_Merchants_Views_QueryTool&action=approve_payout&tid="+ID;
	window.location=url;
		
}

function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?=L_G_CONFIRMSUPPRESSTRANS?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_QueryTool&type=all&tid="+ID+"&action="+action;
  }
  else if(action == "approve")
  {
    if(confirm("<?=L_G_CONFIRMAPPROVETRANS?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_QueryTool&type=all&tid="+ID+"&action="+action;
  }
}

function Delete(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETETRANS?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_QueryTool&type=all&tid="+ID+"&action=delete";
}
</script>

    <form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 width=600 cellspacing=0>
    <? QUnit_Templates::printFilter(10); ?>
    <tr>
    <td>Transaction ID: </td><td><input type='text' name='transactionid' class=formbutton size='36' value=<?=$_REQUEST['transactionid']?>></td>
    </tr>
    
    <tr>
    <td>Transaction Type: </td><td><select class=formbutton name=transaction_type>
    	<option value="_" >All</option>
    	<option value="1" <? print ($_REQUEST['transaction_type'] == 1 ? 'selected' : '');?>>Click</option>
    	
		<option value="4" <? print ($_REQUEST['transaction_type'] == 4 ? 'selected' : '');?>>Sale</option>
		<option value="99"<? print ($_REQUEST['transaction_type'] == 99 ? 'selected' : '');?> >Commission Adjustment</option>
		<option value="95"<? print ($_REQUEST['transaction_type'] == 95 ? 'selected' : '');?> >Revenue Adjustment</option>
    	<option value="8" <? print ($_REQUEST['transaction_type'] == 8 ? 'selected' : '');?>>Recurring</option>
		<option value="2" <? print ($_REQUEST['transaction_type'] == 2 ? 'selected' : '');?>>Lead</option>
		<option value="16"<? print ($_REQUEST['transaction_type'] == 16 ? 'selected' : '');?> >Signup</option>
		<option value="32"<? print ($_REQUEST['transaction_type'] == 32 ? 'selected' : '');?> >CPM</option>
		<option value="64"<? print ($_REQUEST['transaction_type'] == 64 ? 'selected' : '');?> >Referral</option>
    </tr>    
    
    <tr>
    
    <td>Affiliate ID: </td><td><select class=formbutton name=tm_userid>
        <option value="_"><?=L_G_ALL?></option>
<?    while($data=$this->a_list_users->getNextRecord()) { ?>
        <option value="<?=$data['userid']?>" <?=($_REQUEST['tm_userid'] == $data['userid'] ? 'selected' : '')?>><?=(($data['name']!='' || $data['surname']!='') ? $data['name'].' '.$data['surname'] : $data['username'])?></option>
<?    } ?>   
      </select></td>
    </tr>
    <tr>
    <td>Banner ID: </td><td><select class=formbutton name=tm_bannerid>
    <option value="_"><?=L_G_ALL?></option>
    <?
    foreach($bannerarray as $col=>$value){
  			echo "<option value=" . $col . " " . ($_REQUEST['tm_bannerid'] == $col ? 'selected' : '') . ">" . $value . "</option>\n";	
  		}
    ?>
    		   </select></td>
    </tr>
    <tr>
    <td>Campaign: </td><td><select class=formbutton name=tm_campaign>
    <option value="_"><?=L_G_ALL?></option>
    <?
    foreach($campaignarray as $col=>$value){
  			echo "<option value=" . $col . " " . ($_REQUEST['tm_campaign'] == $col ? 'selected' : '') . ">" . $value . "</option>\n";	
  		}
    ?>
    		   </select></td>
    </tr>    

    <tr>
    <td>Estimate upload filename starts with: </td><td>
    	<input type=text class=formbutton name=estimated_filename <?if ($_REQUEST['estimated_filename'] != '_'){ ?> value='<?=$_REQUEST['estimated_filename']?>' <? } ?>>

    </tr>
        <tr>
    <td>Actual upload filename starts with: </td><td>
    	<input type=text class=formbutton name=actual_filename <?if ($_REQUEST['actual_filename'] != '_'){ ?> value='<?=$_REQUEST['actual_filename']?>' <? } ?> >
    </tr>
    <tr>
    <td colspan=2>
    <?
    echo "<INPUT TYPE=RADIO NAME='date' VALUE='all'" . ($_REQUEST['date'] != 't.dateinserted' && $_REQUEST['date'] != 't.providerprocessdate' && $_REQUEST['date'] != 't.dateestimated' && $_REQUEST['date'] != 't.dateactual' ? 'CHECKED' : '' ) . "> All Dates";
    echo "<br>";
    echo "<INPUT TYPE=RADIO NAME='date' VALUE='t.dateinserted'" . ($_REQUEST['date'] == 't.dateinserted' ? 'CHECKED' : '' ) . "> Date Inserted";
    echo "<br>";
    echo "<INPUT TYPE=RADIO NAME='date' VALUE='t.providerprocessdate'" . ($_REQUEST['date'] == 't.providerprocessdate' ? 'CHECKED' : '' ) . "> Provider Process Date";
    echo "<br>";
    echo "<INPUT TYPE=RADIO NAME='date' VALUE='t.dateestimated'" . ($_REQUEST['date'] == 't.dateestimated' ? 'CHECKED' : '' ) . "> Estimated Date";
	echo "<br>";
	echo "<INPUT TYPE=RADIO NAME='date' VALUE='t.dateactual'" . ($_REQUEST['date'] == 't.dateactual' ? 'CHECKED' : '' ) . "> Total Cost Date";
	?>
<br><br>
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
        echo "&nbsp;<select class=formbutton name=tm_day2>";
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
      <br><br>
          Rows per page: <select class=formbutton name=numrows onchange="javascript:FilterForm.list_page.value=0;">
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
      <br><br>
      <div align="center">
      	<input type=submit class=formbutton value='Search'>
      </div>   
     </td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_QueryTool'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">

<br>
