<script>
availableArray = new Array();
<?
  while($this->a_campaigns && !$this->a_campaigns->EOF){?>
	availableArray['<?=$this->a_campaigns->fields['campaignid']?>']='<?=addslashes($this->a_campaigns->fields['name'])?>';
<?$this->a_campaigns->MoveNext();}?>

function showCampaignFilter(){
	var campFilter = document.getElementById('campaignFilter');
	var useCampFilter = document.getElementById('byCampaign');
	if(useCampFilter.value==1)
		campFilter.style.display="block";
	else
		campFilter.style.display="none";
}

function toggleCampaignFilter(){
	var campFilter = document.getElementById('campaignFilter');
	var useCampFilter = document.getElementById('byCampaign');
	if(useCampFilter.value==0){
		campFilter.style.display="block";
		useCampFilter.value=1;
	}else{
		campFilter.style.display="none";
		useCampFilter.value=0;
	}	
}

function selectAll(){
	var addField = document.getElementById('selectedcampcategory');
	for(var x=0; x<addField.options.length;x++){
		addField.options[x].selected=true;
	}
}

function showOptions(){
	var selectField = document.getElementById('availablecampcategory');
	var x=0;
	for(keyVar in availableArray){
		selectField.options[x++]=new Option(availableArray[keyVar], keyVar);
	}	
}

function swapOpts(){
	var form = document.getElementById("FilterForm");
	selectAll();
	form.submit();
}

function add(){
	var availField = document.getElementById('availablecampcategory');
	var addField = document.getElementById('selectedcampcategory');
	for(var x=0; x<availField.options.length;){
		if(availField.options[x].selected){
			addField.options[addField.options.length]=new Option(availField.options[x].text, availField.options[x].value);
			availField.options[x]=null;
		}
		else
			x++;
	}	
}
function remove(){
	var availField = document.getElementById('availablecampcategory');
	var addField = document.getElementById('selectedcampcategory');
	for(var x=0; x<addField.options.length;){
		if(addField.options[x].selected){
			availField.options[availField.options.length]=new Option(addField.options[x].text, addField.options[x].value);
			addField.options[x]=null;
		}else
			x++;
	}
}

function submitFilter(){
		//submit form
		document.getElementById("commited").value=1;
		selectAll();
		document.getElementById('FilterForm').submit();
}
</script>
<form name=FilterForm id=FilterForm action=index.php method=post>
	<table class=listing border=0 cellspacing=0 cellpadding=2 width='850px'>
	<? QUnit_Templates::printFilter(10, "Apply Bonus to Transactions"); ?>
		<tr>
	 		<td valign=top align=left>
				<table width='100%' border=0>
					<tr>
						<td><b>Date</b></td>
					</tr>
					<tr>
						<td align=left>
							<table>
								<tr>
									<td>&nbsp;<b><?=L_G_FROM?></b></td>
									<td>&nbsp;<?=L_G_MONTH?>&nbsp;
								        <select name=rq_month1 id=rq_month1>
										<?for($i=1; $i<=12; $i++){?>
								        <option value='<?=$i?>' <?=($i == $_REQUEST['rq_month1'] ? "selected" : "")?>><?=$i?></option>
										<?}?>
								        </select></td>							
										<td>&nbsp;<?=L_G_DAY?>&nbsp;
											<select name=rq_day1 id=rq_day1>
											<?for($i=1; $i<=31; $i++){?>
											<option value='<?=$i?>' <?=($i == $_REQUEST['rq_day1'] ? "selected" : "")?>><?=$i?></option>
											<?}?>
											</select></td>
				    
								        <td>&nbsp;<?=L_G_YEAR?>&nbsp;
									        <select name=rq_year1 id=rq_year1>
											<?for($i=2003; $i<=$this->curyear; $i++){?>
											          <option value='<?=$i?>' <?=($i == $_REQUEST['rq_year1'] ? "selected" : "")?>><?=$i?></option>
											<?}?>
									        </select></td>
									</tr>
									<tr>							
				    					<td>&nbsp;<b><?=L_G_TO?></b>&nbsp;</td>
				
									    <td>&nbsp;<?=L_G_MONTH?>&nbsp;
									        <select name=rq_month2 id=rq_month2>
											<?for($i=1; $i<=12; $i++){?>
									        <option value='<?=$i?>' <?=($i == $_REQUEST['rq_month2'] ? "selected" : "")?>><?=$i?></option>
											<?}?>
									        </select></td>
				
								        <td>&nbsp;<?=L_G_DAY?>&nbsp;
									        <select name=rq_day2 id=rq_day2>
											<?for($i=1; $i<=31; $i++){?>
									        <option value='<?=$i?>' <?=($i == $_REQUEST['rq_day2'] ? "selected" : "")?>><?=$i?></option>
											<?}?>
								        </select></td>
					        
								        <td>&nbsp;<?=L_G_YEAR?>&nbsp;
									        <select name=rq_year2 id=rq_year2>
											<?for($i=2003; $i<=$this->curyear; $i++){?>
									        <option value='<?=$i?>' <?=($i == $_REQUEST['rq_year2'] ? "selected" : "")?>><?=$i?></option>
											<?}?>
								        </select></td>
								   </tr>
								   <tr>
								   	<td colspan=4><span class="errorMessage">Dates begin at 12:00am on the begining date and end at 11:59pm on the ending date.</span></td>
								   </tr>
							 </table>
						</td>
					</tr>
					<tr>
						<td align="left"><input type="button" class="formbutton" value="Add/Remove Campaign Filter" onClick="toggleCampaignFilter();"></td>
					</tr>
					<tr>
						<td>
							<div id=campaignFilter class=hidden style="display: none"><table border=0>
								<tr>
									<td colspan=4><hr></td>
								</tr>
								<tr>
									<td colspan=4><b>Campaign</b><br><br></td>
								</tr>
								<tr align="center">
									<td>Campaign Category Type</td>
									<td>Available Campaigns</td>
									<td width=5%>&nbsp;</td>
									<td>Selected Campaigns</td>
								</tr>
								<tr align="center">
									<td valign="top"><select name=campcategorytype id=campcategorytype onChange='swapOpts();'>
											<option value='_'>All</option>
											<?foreach($this->a_campcategorytypes as $type){?>
												<option value=<?=$type['typeid']?> <?=$_REQUEST['campcategorytype']==$type['typeid']?"selected":""?>><?=$type['typename']?></option>
											<?}?></td>
									<td valign="top"><select multiple name=availablecampcategory[] id=availablecampcategory style="height: 125px;width:300px;">
										<script>showOptions()</script>
									</td>
									<td valign="center"><input type=button value=">>" onClick="javascript:add()"><br><input type=button value="<<" onClick="javascript:remove()"></td>
									<td valign="top"><select multiple name=selectedcampcategory[] id=selectedcampcategory style="height: 125px; width:300px;">
											<?while($this->a_selected && !$this->a_selected->EOF){?>
												<option value=<?=$this->a_selected->fields['campaignid']?> selected><?=$this->a_selected->fields['name']?></option>
											<?$this->a_selected->MoveNext();}?></td>
								</tr>
							</table></div>
						</td>
					</tr>
					<tr>
						<td><hr></td>
					</tr>
					<tr>
						<td align=left nowrap><b><?=L_G_ROWSPERPAGE?>&nbsp;&nbsp;</b><select name=numrows id=numrows onchange="javascript:FilterForm.list_page.value=0;">
					        <option value=10 <? print ($_REQUEST['numrows']==10 ? "selected" : ""); ?>>10</option>
					        <option value=20 <? print ($_REQUEST['numrows']==20 ? "selected" : ""); ?>>20</option>
					        <option value=30 <? print ($_REQUEST['numrows']==30 ? "selected" : ""); ?>>30</option>
					        <option value=50 <? print ($_REQUEST['numrows']==50 ? "selected" : ""); ?>>50</option>
					        <option value=100 <? print ($_REQUEST['numrows']==100 ? "selected" : ""); ?>>100</option>
					        <option value=200 <? print ($_REQUEST['numrows']==200 ? "selected" : ""); ?>>200</option>
					        <option value=500 <? print ($_REQUEST['numrows']==500 ? "selected" : ""); ?>>500</option>
					        <option value=1000 <? print ($_REQUEST['numrows']==1000 ? "selected" : ""); ?>>1000</option>
					        <option value=100000000 <? print ($_REQUEST['numrows']==100000000 ? "selected" : ""); ?>><?=L_G_ALL?></option>
						</select></td>
					</tr>
					<tr>
						<td align=center colspan=4>
							<input class=formbutton type=button name='getTransactions' value='<?=L_G_SUBMIT; ?>' onClick='submitFilter();'>
							<input type=hidden name='list_view' value=<?=$_REQUEST['list_view']?>>      
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<input type=hidden name=commited id=commited value='<?=$_REQUEST['commited']?>'>
	<input type=hidden name=byCampaign id=byCampaign value='<?=$_REQUEST['byCampaign']?>'>
	<input type=hidden name=md value='Affiliate_Merchants_Views_ApplyBonus'>
	<input type=hidden name=type value='all'>
	<input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?$_REQUEST['list_page']:0?>'>
	<input type=hidden id=action name=action value=''>    
	<input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
	<input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
</form>
<script>showCampaignFilter();</script>