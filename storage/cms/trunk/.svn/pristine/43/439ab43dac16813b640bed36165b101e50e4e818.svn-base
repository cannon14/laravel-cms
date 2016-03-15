<?
$sortableLists = new csCore_UI_SLLists('../cmsCore/include/csCore/JS/scriptaculous');
$sortableLists->addList('assignedList','assignedListOrder');
$sortableLists->printTopJS();
?>
  <script>
  	function addCard(CatID, CardID){
  		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&card_id="+CardID+"&card_category_id="+CatID+"&action=addCard";
  	}
  	
  	function showExclude(SiteID, PageID){
  		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&siteId="+SiteID+"&card_category_id="+PageID+"&action=showVersion";
  	}
  </script>
  <style type="text/css" media="screen">
		ul.sortableList {
			list-style-type: none;
			padding: 0px;
			margin: 0px;
			width: 560px;
			font-family: Arial, sans-serif;
		}
		
		ul.sortableList li.blue {
			cursor: move;
			padding: 2px 2px;
			margin: 2px 0px;
			
			
		}
		
		ul.sortableList li.red {
			cursor: move;
			padding: 2px 2px;
			margin: 2px 0px;
			border: 1px solid #000000;
		}
		ul.sortableList span.name {
			cursor: move;
			padding: 2px 2px;
			margin: 2px 0px;
			border: 1px solid #FFFFFF;
			BACKGROUND: #FFFFFF url("cc-menuheader_center.gif") repeat-x top left; 
		}
		
.rate-top {  
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 10px; 
	background-color: #d7d7d7; 
	text-align: center; 
	padding-right: 1px; 
	padding-left: 1px
}

h1 {
	color: #000066;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 20px;
	text-align: left;
	margin-right: 0px;
	margin-left: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
	padding-bottom: 0px;
	padding-top: 0px;
	padding-right: 0px;
	padding-left: 0px;
	font-weight: bold;
	
}


.rates-bottom {  
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 9px; 
	background-color: #F2F2F2; 
	text-align: center
}


.rate-rc {  
	width: 100%; 
	background-color: #FFFFFF
}		
		
.cc-card-art-align {
	text-align: right; 
	background-color: #FFFFFF;
	vertical-align: top;
}


.offer-left {
	font-size: 13px;
	background-color: #CCCCCC; 
	text-align: left;
	font-family: Arial, Helvetica, sans-serif; 
	font-weight: bold;
	width: 100%;
	color: #0066CC;
	padding-left: 4px
	BACKGROUND: #FFFFFF
}


.offer-left a:link {
	color: #000999; 
	text-decoration: none

}


.offer-left a:hover {
	color: #000999; 
	text-decoration: none
}


.offer-left a:visited {
	color: #000999; 
	text-decoration: none
}

.details {
	background-color: #FFFFFF;
	list-style-position: outside;
	list-style-image: url(/images/b3-spacer.gif);
	vertical-align: text-top
}
</style>
<? 
if($_POST['runQuery'] == null){	
?>
	<div id='foo' style="width=100%">
	<div style="float:left;">
    <br>
    <table class=component align='center'>
 	<tr>
 	<td colspan=2 class='componentHead'>
 	Manage Card Category Ranks
 	</td>
 	</tr>   
    <tr>
    <td>
	<br>
	<center>
	<style type="text/css">
	#sortableListForm  {
		display: inline;
	}
	</style>
	<?
	$sortableLists->printForm('index.php', 'GET', 'Commit Current Order', $_REQUEST['mod'] , 'card_category_context_id','formbutton');
	?>
	<input class=formbutton type=button value="BACK" onClick="goToMod('CMS_view_cardCategories')">     
	</center>
	<br><hr>
	
	<ul id="assignedList" class="sortableList">
		<?
		$count = 1;
		foreach ($this->cardCategories as $cardCat){
		?>
		

		<li class='blue' id="item_<?=$cardCat['card_category_id']?>">
		<table class="rc" align="center" width=760 cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
		  <tr> 
		    <th colspan="2" class="offer-left">  
		      <font color='#000999'><span id="rank_<?=$cardCat['card_category_id']?>"><?=$count++ ?></span>. <?=$cardCat['card_category_name']?></font>
		    </th>
		  </tr>
		</table>
		</li>
		<?
		}
		?>
		
	
	</ul>
	</td>
    </tr>
    </table>
	</div>		

	</div>
	<br>
	<br>	
	   
    
     <script type="text/javascript">
 	// <![CDATA[
    Sortable.create("assignedList", {
      tag:'li', 
	  dropOnEmpty:true,
	  handle:'handle',
	  containment:["assignedList"],
	  constraint:false,
	  onUpdate: function() {  
      	ele = document.getElementById('assignedList');
      	for (var i=0; i<ele.childNodes.length; i++)
      	{
      		id = ele.childNodes[i].id;
			idparts = id.split("_");
			idnum = idparts[1];
			document.getElementById('rank_'+idnum).innerHTML = i+1;
      	}
      } 
	});
 	// ]]>
 	</script>


<input type=hidden name=tmdl_status value="<?=$_REQUEST['tmdl_status']?>">
<input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
<input type=hidden name=card_category_context_id value='<?=$_REQUEST['card_category_context_id']?>'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>
<? } ?>
