
<head>
<?
$sortableLists = new Affiliate_Merchants_Bl_SLLists('scriptaculous');
$sortableLists->addList('assignedList','assignedListOrder');
$sortableLists->printTopJS();

?>

  <script>
  	function addPage(categoryID, pageID){
  		document.location.href = "index.php?md=Affiliate_Merchants_Views_ArticlePageToCategoryManager&pageID="+pageID+"&categoryId="+categoryID+"&action=addPage";
  	}
  	
  </script>
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
			border: 0px solid #000000;
			BACKGROUND: #FFFFFF
		}
		
		ul.sortableList span.name {
			cursor: move;
			padding: 2px 2px;
			margin: 2px 0px;
			border: 1px solid #FFFFFF;
			BACKGROUND: #FFFFFF url("cc-menuheader_center.gif") repeat-x top left; 
			width: '100%';
		}

.rate-top {  
font-family: Arial, Helvetica, sans-serif; 
font-size: 10px; 
background-color: #d7d7d7; 
text-align: center; 
padding-right: 1px; 
padding-left: 1px
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
</head>

<? 

if($_POST['runQuery'] == null){
?>

   <table class=listingClosed border=0 width=770 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(10, $_POST['categoryName']); ?>
    <tr>
	<td>
		<center>
        Add Pages: <SELECT NAME="add" OnChange="performAction(this);">
        <option value="-">----------------------------------------------------------</option>
        <?
        $rs = $_POST['rs_unassigned'];
        while(!$rs->EOF){
        ?>
                <OPTION VALUE="javascript:addPage(<?=$_REQUEST['siteId']?>, <?=$rs->fields['cardpageId']?>)"><?=$rs->fields['pageName']?>
        <?
        $rs->MoveNext();
        }
        ?>
        </SELECT>

	</center>
	<br>
	<center>
	<?
	$sortableLists->printForm('index.php', 'GET', 'Commit Changes', 'Affiliate_Merchants_Views_ArticlePageToCategoryManager' ,'formbutton');
	?>
	</center>
	<br>
	<div>
	<div style="float:center;">
	<!-- Assigned Pages: <a href='index.php?md=Affiliate_Merchants_Views_SiteToPageManager&action=removeAll&siteId=<?=$_REQUEST['siteId']?>'>[Remove All]</a><br>
	!-->
	<ul id="assignedList" class="sortableList">
		<?
		$rs = $_POST['rs_assigned'];
		$count = 1;
		while(!$rs->EOF){
		if($rs->fields['active'] != 1)
			$active = " [ INACTIVE ]";
		?>
		
		<li class='blue' id="item_<?=$rs->fields['cardpageId']?>">
		
		
		<table style="border-width:3px;border-style:solid;border-color:#cccccc;" >
		<tr>
		<td>
		<b><a href=index.php?md=Affiliate_Merchants_Views_ArticlePageToCategoryManager&action=removePage&categoryId=<?=$_REQUEST['siteId']?>&cardpageId=<?=$rs->fields['cardpageId']?>>Remove Page</a></a> | Edit Page
		
		</td>
		</tr>
		</table>		
		<table class="rc" align="center" width=770 cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
		  <tr> 
		    <th colspan="2" class="offer-left">  
		      <font color='#000999'><?=$rs->fields['pageName']?> <?=$active?>
		  </tr>
		         <tr> 
		    <td width="15%" align='center'>
		    <? if ($rs->fields['pageHeaderImage'] != ""){ ?>
		      <img src="/images/<?=$rs->fields['pageHeaderImage']?>" border="0"><br />
		    <? } ?>
		  
		    <td width="85%" class="details"> 
			<?=$rs->fields['pageDescription']?>
		    </td>
		
		  </tr>
		  </table>		
		
		</li>
		<br>		
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

 	// ]]>
 	</script>


<input type=hidden name=tmdl_status value="<?=$_REQUEST['tmdl_status']?>">
<input type=hidden name=md value='Affiliate_Merchants_Views_ArticlePageToCategoryManager'>
<input type=hidden name=siteId value='<?=$_REQUEST['siteId']?>'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>
<? } ?>
