
<head>
<?
$sortableLists = new Affiliate_Merchants_Bl_SLLists('scriptaculous');
$sortableLists->addList('assignedList','assignedListOrder');
$sortableLists->printTopJS();

?>


  <script src="scriptaculous/prototype.js" type="text/javascript"></script>
  <script src="scriptaculous/scriptaculous.js" type="text/javascript"></script>
  
  <style type="text/css" media="screen">
		ul.sortableList {
			list-style-type: none;
			padding: 0px;
			margin: 0px;
			width: 300px;
			font-family: Arial, sans-serif;
		}
		
		ul.sortableList li.blue {
			cursor: move;
			padding: 2px 2px;
			margin: 2px 0px;
			border: 1px solid #000000;
			background-color: #D6DFF5;
		}
		
		ul.sortableList li.red {
			cursor: move;
			padding: 2px 2px;
			margin: 2px 0px;
			border: 1px solid #000000;
			background-color: #FFCCCC;
		}
		ul.sortableList span.name {
			cursor: move;
			padding: 2px 2px;
			margin: 2px 0px;
			border: 1px solid #FFFFFF;
			BACKGROUND: #FFFFFF url("cc-menuheader_center.gif") repeat-x top left; 
			width: '100%';
		}
		
		
		
  </style>
</head>

<? 

if($_POST['runQuery'] == null){
?>

   <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(10, "Assigned Pages [" . $_POST['siteName'] . "]"); ?>
    <tr>
	<td>
	hey
	<br>
	<center>
	<?
	$sortableLists->printForm('index.php', 'GET', 'Commit Changes', 'Affiliate_Merchants_Views_SiteToPageManager' ,'formbutton');
	?>
	</center>
	<br>
	<div>
	<div style="float:left;">
	Assigned Pages: <a href='index.php?md=Affiliate_Merchants_Views_SiteToPageManager&action=removeAll&siteId=<?=$_REQUEST['siteId']?>'>[Remove All]</a><br>
	<ul id="assignedList" class="sortableList">
		<?
		$rs = $_POST['rs_assigned'];
		$count = 1;
		while(!$rs->EOF){
		if($rs->fields['active'] != 1)
			$active = " [ INACTIVE ]";
		?>
		
		<li class='blue' id="item_<?=$rs->fields['categoryId']?>"><span class="name"><font color='white'><b><?=$rs->fields['categoryName']?></b><?=$active?></font></span>
		<img src='/images/<?=$rs->fields['pageHeaderImage']?>'>
		<b>Created: </b>
		<?=$rs->fields['dateCreated']?>
		<br>		
		<b>Page Description: </b>
		<?=$rs->fields['categoryDescription']?>
		
		
		
		
		</li>		
		<?
		$active = "";
		$rs->MoveNext();
		}
		?>
	</ul>
	</div>		
    
	<div style="float:right;">
	Unassigned Pages: <a href='index.php?md=Affiliate_Merchants_Views_SiteToPageManager&action=assignAll&siteId=<?=$_REQUEST['siteId']?>'>[Assign All]</a><br>
	<ul id="unassignedList" class="sortableList">
		<?
		$rs = $_POST['rs_unassigned'];
		
		while(!$rs->EOF){
		if($rs->fields['active'] != 1)
			$active = " [ INACTIVE ]";
		?>
		<li class='red' id="item_<?=$rs->fields['categoryId']?>"><span class="name"><font color="white"><b><?=$rs->fields['categoryName']?></b><?=$active?></class></font></span>
		<b>Created: </b>
		<?=$rs->fields['dateCreated']?>
		<br>
		<b>Page Description: </b>
		<?=$rs->fields['categoryDescription']?>
		</li>
		<?
		$active = "";
		$rs->MoveNext();
		}
		?>
	</ul>
	</div>
	</div>
	<br>
	<br>	
	

	
	</td>
    </tr>
    </table>    
    
     <script type="text/javascript">
 	// <![CDATA[
    Sortable.create("assignedList",
     {tag:'li', dropOnEmpty:true,handle:'handle',containment:["assignedList","unassignedList"],constraint:false});
    Sortable.create("unassignedList",
     {tag:'li', dropOnEmpty:true,handle:'handle',containment:["assignedList","unassignedList"],constraint:false});

 	// ]]>
 	</script>


<input type=hidden name=tmdl_status value="<?=$_REQUEST['tmdl_status']?>">
<input type=hidden name=md value='Affiliate_Merchants_Views_SiteToPageManager'>
<input type=hidden name=siteId value='<?=$_REQUEST['siteId']?>'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>
<? } ?>
