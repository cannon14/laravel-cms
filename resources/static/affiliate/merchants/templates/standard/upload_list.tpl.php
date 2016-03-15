<script type="text/javascript">
<!--

function rerateTrans(ID)
{
  if(confirm("Recalculate rate for this transaction?")) {
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_UploadManager&transid="+ID+"&action=rerateTrans";
  }
}

function deleteTrans(ID)
{
  if(confirm("Delete transaction?")) {
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_UploadManager&transid="+ID+"&action=deleteTrans";
  }
}

function syncTransactions(form)
{
	if (form.providerid.value != "") {
		
		if(confirm("Sync transactions?")) {
		   	return true;
		} else {
			return false;
		}
	} else {
		alert("Please select a provider to sync from the drop-down list.");
		return false;
	}
}

function validateMassAction(frm)
{
	if (frm.massaction.value != "")
	{
		if (frm.massaction.value == "deleteTrans")
		{
			if(confirm("Delete transactions?")) {
				return true;
			}
			return false;
		} else if (frm.massaction.value == "rerateTrans")
		{
			if(confirm("Recalculate rates?")) {
				return true;
			}
			return false;
		}
	}
}

function deselectApplyToAll()
{
	document.getElementById("applyToAll").checked = false;
	
	//clear alert
	document.getElementById("applyToAllAlert").className = '';
	
	//set hidden var to flag global change
	document.getElementById("FilterForm").globalaction.value = '';
}

function toggleApplyToAll()
{
	/*
	* if apply to all checkbox is clicked, deselect all other checkboxes on page
	*/
	
	if (document.getElementById("applyToAll").checked == true)
	{
		if(confirm("Apply action to all <?=$this->a_allcount ?> records?"))
		{
			
			var theElement = document.getElementById("itemschecked");
			theElement.checked = true;
			
			var theForm = theElement.form;
			for(z=0; z<theForm.length;z++)
			{
				if((theForm[z].type == 'checkbox') && (theForm[z].name == 'itemschecked[]'))
				{
					theForm[z].checked = false;
				}
			}
			
			//set alert
			document.getElementById("applyToAllAlert").className = 'redAlert';
			
			//set hidden var to flag global change
			theForm.globalaction.value = true;
		} else {
			deselectApplyToAll();
		}
	} else {
		deselectApplyToAll();
	}
	
	if ((document.getElementById("checkItemsButton").value == '[  ]') && (document.getElementById("applyToAll").checked == true))
	{
		document.getElementById("checkItemsButton").value = '[X]'
		
		checkboxState = true;
		
	}
}

/*
*	Overriding function in global JS file
*/
function checkAllItems()
{
  var buttons = document.getElementById("checkItemsButton");
  if(typeof(buttons) == 'undefined') return;
  if(buttons.length > 0)
  {
    for (var b = 0; b < buttons.length; b++)
    {
      if(checkboxState == true) {
        buttons[b].value = '[  ]';
      } else { 
        buttons[b].value = '[X]';
       }
    }
  } else {
    if(checkboxState == true) {
      buttons.value = '[  ]';
    }else{
      buttons.value = '[X]';
    }
  }
	selectAll();
}

function selectAll()
{
	//deselect applyToAll button
	deselectApplyToAll();
	
	var theElement = document.getElementById("itemschecked");
	var theForm = theElement.form;
	for(z=0; z<theForm.length;z++)
	{
		if((theForm[z].type == 'checkbox') && (theForm[z].name != 'applyToAll'))
		{
			theForm[z].checked = checkboxState;
		}
	}
	
	checkboxState = checkboxState==false?true:false;
}
-->
</script>

<style type="text/css">
.redAlert {
	color: #FF0000;
}
</style>

    <table border="0" cellpadding="0" cellspacing="0">
	    <tr>
	    	<td valign="top" style="padding-right: 10px;">
	    	
	    		<form name="FilterForm" id="FilterForm" action="index.php" method="POST" onsubmit="javascript:return validateMassAction(this);">
	    		
	    		<table class=listing border=0 cellspacing=0>
				    <? QUnit_Templates::printFilter(10); ?>
				    <tr>
				    	<td colspan="3" style="padding: 5px;" valign="top">TransID Reference: <input type='text' name='transactionid' class=formbutton size='20' value=<?=$_REQUEST['transactionid']?>> 
				    
					    	&nbsp;&nbsp;&nbsp;&nbsp;Providers: <? $this->a_this->printUploadedProviderChannels(); ?>
					    	&nbsp;&nbsp;&nbsp;&nbsp;Filenames: <? $this->a_this->printUploadedFilenames(); ?>
					    	&nbsp;&nbsp;&nbsp;&nbsp;Revenue: <? $this->a_this->printFilterRevenueList(); ?>
				    	</td>
				    </tr>
				    <tr>
				    	<td style="padding: 5px;" valign="top">
				    		
				    		&nbsp;Rows per page: <select class=formbutton name=numrows onchange="javascript:FilterForm.list_page.value=0;">
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
					      	
					      	&nbsp;&nbsp;&nbsp;&nbsp;Products: <? $this->a_this->printFilterProductList(); ?>
					      	
							<br />
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="formbutton" value="Apply Filter"> <input type="button" onclick="javascript:location.href='index.php?md=Affiliate_Merchants_Views_UploadManager'" class="formbutton" value="Remove Filter">
						</td>
						<td nowrap style="padding: 5px; text-align: right;">
							<?=L_G_FROM?>:&nbsp;
					      <?
					        print L_G_MONTH;
					        echo "&nbsp;<select name=tm_month1>";
					        for($i=1; $i<=12; $i++)
					          echo "<option value='$i' ".($i == $_REQUEST['tm_month1'] ? "selected" : "").">$i</option>\n";
					        echo "</select>&nbsp;&nbsp;";
					        
					        print L_G_DAY;
					        echo "&nbsp;<select name=tm_day1>";
					        for($i=1; $i<=31; $i++)
					          echo "<option value='$i' ".($i == $_REQUEST['tm_day1'] ? "selected" : "").">$i</option>\n";
					        echo "</select>&nbsp;&nbsp;";
					        
							print L_G_YEAR;
					        echo "&nbsp;<select name=tm_year1>";
					        for($i=2003; $i<=$this->a_curyear; $i++)
					          echo "<option value='$i' ".($i == $_REQUEST['tm_year1'] ? "selected" : "").">$i</option>\n";
					        echo "</select>&nbsp;&nbsp;";
					      ?><br /><?=L_G_TO?>:&nbsp;<?
					        print L_G_MONTH;
					        echo "&nbsp;<select name=tm_month2>";
					        for($i=1; $i<=12; $i++)
					          echo "<option value='$i' ".($i == $_REQUEST['tm_month2'] ? "selected" : "").">$i</option>\n";
					        echo "</select>&nbsp;&nbsp;";
					        
					        print L_G_DAY;
					        echo "&nbsp;<select name=tm_day2>";
					        for($i=1; $i<=31; $i++)
					          echo "<option value='$i' ".($i == $_REQUEST['tm_day2'] ? "selected" : "").">$i</option>\n";
					        echo "</select>&nbsp;&nbsp;";
					        
					        print L_G_YEAR;
					        echo "&nbsp;<select name=tm_year2>";
					        for($i=2003; $i<=$this->a_curyear; $i++)
					          echo "<option value='$i' ".($i == $_REQUEST['tm_year2'] ? "selected" : "").">$i</option>\n";
					        echo "</select>&nbsp;&nbsp;";
					      ?>      
					      </td>
						<td style="padding: 5px;" valign="top">
							<?
						    echo "<INPUT TYPE=RADIO NAME='date' VALUE='all'" . ($_REQUEST['date'] != 'dateinserted' && $_REQUEST['date'] != 'providerprocessdate' && $_REQUEST['date'] != 'dateestimated' && $_REQUEST['date'] != 'dateactual' ? 'CHECKED' : '' ) . "> All Dates";
						    echo "<br>";
						    echo "<INPUT TYPE=RADIO NAME='date' VALUE='dateinserted'" . ($_REQUEST['date'] == 'dateinserted' ? 'CHECKED' : '' ) . "> Date Inserted";
						    echo "<br>";
						    echo "<INPUT TYPE=RADIO NAME='date' VALUE='providerprocessdate'" . ($_REQUEST['date'] == 'providerprocessdate' ? 'CHECKED' : '' ) . "> Provider Process Date";
							?>
						
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<br>
    <table class=listingClosed border=0 cellspacing=0 cellpadding=0>    
    	<tr>
	    	<td style="background-color: #EEE; padding: 0px;">
	    		
	    		<table cellspacing="8" cellpadding="0" border="0">
	    			<tr>
	    				<td><input type="checkbox" name="applyToAll" id="applyToAll" value="" onclick="javascript:toggleApplyToAll();"></td>
	    				<td><div id="applyToAllAlert">Apply to <strong>ALL <?=$this->a_allcount ?></strong> records (multiple pages)</div></td>
	    				<td><? $this->a_this->printMassAction(); ?></td>
	    				<td><input class="formbutton" type="submit" value="PERFORM ACTION"></td>
		  			</tr>
		  		</table>
		  		
	    	</td>
	    </tr>
    	<tr>
        	<td class=listPaging align=right>
        		<table width="100%" border="0" height="18" cellspacing="0" cellpadding="0">
			        <tr>
			            <td class=listheaderNoLineLeft width="30%" nowrap>
			                &nbsp;
			                <?php if ($_REQUEST['mode'] == "merchants") { ?>
			                <a class=simplelink href="javascript:showListOptions();"><?=L_G_LISTOPTIONS?></a>
							<?php } ?>
			                &nbsp;
			            </td>
			            <td width="40">&nbsp;</td>
			            <td align="left" class=listheaderNoLineLeft nowrap>
			                <? QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
			            </td>
			        </tr>
        		</table>
        
        		<div id="view_av_options" style="display:none;">
        			<table width="100%"  height="18" cellspacing="0" cellpadding="0">
				        <tr>
				            <td class=listViewLine>
				                <? $this->a_this->printAvailableViews('Affiliate_Merchants_Views_UploadManager'); ?>
				            </td>
				        </tr>
				    </table>
        
        		</div>
        </td>
    </tr>
    <tr>
        <td align=left>
        	<table width="100%" cellspacing="0" cellpadding="1" style="border-top: 1px solid #000D51;">
		        <tr class=listheader>
		            <? $this->a_this->printListHeader(); ?>
		        </tr>
		        
<?
        while($row = $this->a_list_data->getNextRecord())
        {
?>    
        <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
            <? $this->a_this->printListRow($row); ?>
        </tr>
<?
    }
?>
        	</table>
        </td>
    </tr>
    <tr class=listheader>&nbsp;</tr>
</table>

<input type="hidden" name="filtered" value="1">
<input type="hidden" name="md" value="Affiliate_Merchants_Views_UploadManager">
<input type="hidden" name="type" value="all">
<input type="hidden" id="list_page" name="list_page" value="<?=$_REQUEST['list_page']?>">
<input type="hidden" id="action" name="action" value="">
<input type="hidden" id="sortby" name="sortby" value="<?=$_REQUEST['sortby']?>">
<input type="hidden" id="sortorder" name="sortorder" value="<?=$_REQUEST['sortorder']?>">
<input type="hidden" name="mode" value="<?=$_REQUEST['mode']?>">
<input type="hidden" name="commited" value="yes">
<input type="hidden" name="globalaction" value="">
</form>

<br>
<br>
