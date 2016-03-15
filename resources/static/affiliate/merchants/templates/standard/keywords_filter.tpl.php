<?
if(!$_REQUEST['beginDay'])
	$_REQUEST['beginDay']=date("j");
if(!$_REQUEST['beginMonth'])
	$_REQUEST['beginMonth']=date("n");
if(!$_REQUEST['beginDay'])
	$_REQUEST['beginYear']=date("Y");
	
if(!$_REQUEST['endDay'])
	$_REQUEST['endDay']=date("j");
if(!$_REQUEST['endMonth'])
	$_REQUEST['endMonth']=date("n");
if(!$_REQUEST['endDay'])
	$_REQUEST['endYear']=date("Y");
?>

<script language="javascript" type="text/javascript">
<!--
function Delete(ID)
{
  if(confirm("Delete keyword?"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_KeywordsManager&keyword_id="+ID+"&action=delete";
}

function editKeyword(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_KeywordsManager&action=edit&keyword_text_id="+ID,"Edit","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}
-->
</script>
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

<form name=FilterForm action=index.php method=GET>
	<table class=listing border=0 width=800 cellspacing=0>
	<? QUnit_Templates::printFilter(4); ?>
		<tr>
			<td valign="top" nowrap style="padding: 5px; border-bottom: 1px solid #CCC;">
				
				&nbsp;Keyword Search:
				<br />
				<div style="float: right;" id="result_count"></div>
				<br />
				<input type="text" id="suggestTerm" name="keyword_text" size="35" value="<?=$_REQUEST['keyword_text']?>" title="Search Criteria" onkeyup="javascript:searchSuggest();" onclick="javascript:clearSearchPopup();" autocomplete="off">
				<input type="hidden" name="rt_keywordId" id="rt_keywordId" value="">
				<br />
				<div id="search_suggest"></div>
				
			</td>
			<td valign="top" nowrap style="padding: 5px; border-right: 1px solid #CCC; border-bottom: 1px solid #CCC;">
				<div>
					<input type="radio" name="searchType" value="exact" title="Exact Match" <? print ($_REQUEST['searchType']=='exact' ? "checked" : ""); ?> /> Exact Match
					<br />
					<input type="radio" name="searchType" value="begins" title="Begins With" <? print ($_REQUEST['searchType']=='begins' ? "checked" : ""); ?> /> Begins With
					<br />
					<input type="radio" name="searchType" value="contains" title="Contains" <? print ($_REQUEST['searchType']=='contains' ? "checked" : ""); ?> /> Contains
				</div>
			</td>
			<td valign="top" nowrap style="padding: 5px; border-right: 1px solid #CCC; border-bottom: 1px solid #CCC;">
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
		      	
		      	<br />
		      	<br />
		      	Status: <select class=formbutton name="status">
		      			<option value="all" <? print ($_SESSION['status']=='all' ? "selected" : ""); ?>>All</option>
		      			<option value="active" <? print ($_SESSION['status']=='active' ? "selected" : ""); ?>>Active</option>
		      			<option value="deleted" <? print ($_SESSION['status']=='deleted' ? "selected" : ""); ?>>Deleted</option>
		      		</select>
			</td>
			<td style="border-bottom: 1px solid #CCC;">
			
				<table>
					<tr>
						<td><input type="checkbox" name="searchDates" value="true" <? print ($_SESSION['searchDates'] ? "checked" : ""); ?>> Last Updated Date of Keyword Types:</td>
					</tr>
					<tr>
				      <td valign=top nowrap>
				      	<b>From&nbsp;&nbsp;</b>
				      	
					      Month <select name=beginMonth>
					      <?for($x=1; $x<=12; $x++){?>
					      <option <?=$_REQUEST['beginMonth']==$x?"selected":""?>><?=$x?></option>;
					      <?}?>
					      </select>
					      &nbsp;&nbsp;
					      Day <select name=beginDay>
				      	<?for($x=1; $x<=31; $x++){?>
				      	<option <?=$_REQUEST['beginDay']==$x?"selected":""?>><?=$x?></option>;
				      	<?}?>
					      </select>
					      &nbsp;&nbsp;
					      Year <select name=beginYear>
					      <?for($x=0; $x<=2; $x++){?>
					      <option <?=$_REQUEST['beginYear']==(date("Y")-$x)?"selected":""?>><?=(date("Y")-$x)?></option>;
					      <?}?>
					      </select>
				      
				      	<br>
				      	
					      <b>To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
					      
					      Month <select name=endMonth>
					      <?for($x=1; $x<=12; $x++){?>
					      <option <?=$_REQUEST['endMonth']==$x?"selected":""?>><?=$x?></option>;
					      <?}?>
					      </select>
					      &nbsp;&nbsp;
					      Day <select name=endDay>
					      <?for($x=1; $x<=31; $x++){?>
					      <option <?=$_REQUEST['endDay']==$x?"selected":""?>><?=$x?></option>;
					      <?}?>
					      </select>
					      &nbsp;&nbsp;
					      Year <select name=endYear>
					      <?for($x=0; $x<=2; $x++){?>
					      <option <?=$_REQUEST['endYear']==(date("Y")-$x)?"selected":""?>><?=(date("Y")-$x)?></option>;
					      <?}?>
					      </select>
					    </td>
				    </tr>
			   	</table>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="right" style="padding: 5px 350px;"><input class=formbutton value="search" type="submit"></td>
		</tr>
    </table>
    
    <br>
    <br>

    <input type="hidden" name="md" value="<?=$_REQUEST['md']?>">
    <input type="hidden" name="mode" value="<?=$_REQUEST['mode']?>">