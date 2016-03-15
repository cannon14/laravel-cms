<style type="text/css">
.suggest_link {
	background-color: #FFFFFF;
	padding: 2px 6px 2px 6px;
}

.suggest_link_over {
	background-color: #3366CC;
	padding: 2px 6px 2px 6px;
	color: #FFF;
}

#search_suggest {
	position: absolute; 
	background-color: #FFFFFF; 
	text-align: left; 
	border: 1px solid #000000;            
}
</style>
<script language="JavaScript" type="text/javascript" src="/affiliate/include/javascript/keyword_search_ajax.js"></script>

<script>
function validateMassAction(frm)
{
	if (frm.massaction.value == "delete")
	{
		if (confirm("Delete expenses?"))
		{
			return true;
		}
		
		return false;
		
	}
}

function addExpense()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ExpensesUploadManager&action=create&type=all","Expense","scrollbars=1, top=100, left=100, width=600, height=500, status=0");
    wnd.focus(); 
}
function editExpense(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ExpensesUploadManager&action=edit&eid="+ID,"Expense","scrollbars=1, top=100, left=100, width=600, height=500, status=0");
    wnd.focus(); 
}
function deleteExpense(ID)
{

  if(confirm("<?=L_G_CONFIRMDELETEEXPENSE?> - "+ID))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_ExpensesUploadManager&type=all&eid="+ID+"&action=delete";

}
</script>
<form name=FilterForm id=FilterForm action=index.php method=get>
    <table class="listing" border="0" width="850" cellspacing="0" cellpadding="2">
    	<? QUnit_Templates::printFilter(10, "Expense Uploads Filter"); ?>
    	
    	<tr>
			<td nowrap>&nbsp;<?=L_G_AFFILIATE?>&nbsp;</td>
			<td>
				  <select name=exp_affiliate_id>
				<option value="_"><?=L_G_ALL?></option>
				<?    while($data=$this->a_list_users->getNextRecord()) { ?>
				<option value="<?=$data['affiliate_id']?>" <?=($_REQUEST['exp_affiliate_id'] == $data['affiliate_id'] ? 'selected' : '')?>><?=$data['name']?></option>
				<?    } ?>      
				  </select>
			</td>
			
			<td rowspan="5" nowrap style="border-left: 1px solid #000;">
			    <div style="width: 200px; margin-left: 50px;">
			    	<?
				    echo "<INPUT TYPE=RADIO NAME='date' VALUE='all' " . ($_REQUEST['date'] != 'e.purchasedate' && $_REQUEST['date'] != 'e.expensedate' && $_REQUEST['date'] != 'e.endexpensedate' ? 'CHECKED' : '' ) . "> All Dates";
				    echo "<br>";
				    echo "<INPUT TYPE=RADIO NAME='date' VALUE='e.purchasedate' " . ($_REQUEST['date'] == 'e.purchasedate' ? 'CHECKED' : '' ) . "> Purchase Date";
				    echo "<br>";
				    echo "<INPUT TYPE=RADIO NAME='date' VALUE='e.expensedate' " . ($_REQUEST['date'] == 'e.expensedate' ? 'CHECKED' : '' ) . "> Expense Start Date";
				    echo "<br>";
				    echo "<INPUT TYPE=RADIO NAME='date' VALUE='e.endexpensedate' " . ($_REQUEST['date'] == 'e.endexpensedate' ? 'CHECKED' : '' ) . "> Expense End Date";
					?>
				</div>
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
			   </td>
    	</tr>
    	
    	<tr>
    		<td align=left>
	        &nbsp;<?=L_G_EXTCAMPAIGN?>
	      </td>
	      <td align=left>
	        <select name=exp_extcampaign_id>
	          <option value='_'><?=L_G_ALL?></option>
	<?      while($data=$this->cid_list_data1->getNextRecord()) { ?>
	          <option value='<?=$data['trackerId']?>' <?=($_REQUEST['exp_extcampaign_id'] == $data['trackerId'] ? 'selected' : '')?>><?=$data['name']?> (<?=$data['trackerId']?>)</option>
	<?      } ?>          
	      </select>&nbsp;&nbsp;
	      </td>
	   </tr>
	   
	   <tr>
	      <td align=left>
	        &nbsp;<?=L_G_EPISODE?>
	      </td>
	      <td align=left>
	        <div style="float: right;" id="result_count"></div>
			<br />
			<input type="text" id="suggestTerm" name="keyword_text" size="35" value="<?=$_REQUEST['keyword_text']?>" title="Search Criteria" onkeyup="searchSuggest();" onclick="clearSearchPopup();" onblur="validateKeywordFields();" autocomplete="off"> &nbsp;&nbsp; Keyword ID: <input type="text" size="7" name="exp_keyword_id" id="rt_keywordId" value="<?=$_REQUEST['exp_keyword_id']?>" readonly>
			<br />
			<div id="search_suggest"></div>
	
	      </td>
    	</tr>
    	
	    <tr>
	      <td align=left nowrap>&nbsp;<?=L_G_ROWSPERPAGE?></td>
	      <td>
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
      		<td colspan="2" align="center"><input type=submit class=formbutton value='Search'></td>
    	</tr>
    
    </table>
  
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_ExpensesUploadManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">

<br>
