<?
csCore_Import::importClass('csCore_UI_SLLists');
$sortableLists = new csCore_UI_SLLists('../cmsCore/include/csCore/JS/scriptaculous');
$sortableLists->addList('assignedList','assignedListOrder');
$sortableLists->printTopJS();

?>
  <script>
  	function addPage(categoryID, pageID){
  		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&pageID="+pageID+"&siteId="+categoryID+"&action=addPage";
  	}

  	function showCreateRedirect(link, siteId, pageLink){
  		Modalbox.show('/cms/index.php?mod=CMS_view_redirects&embed=true&action=create&filename='+pageLink+'&siteId='+siteId, {title: 'Create Redirect', width: 800, closeValue: "Skip Redirect", transitions: true, redirectOnHide: link});
  		return true;  	
  	}
	function createRedirect(){
		var url="/cms/index.php";
		new Ajax.Request(url, {
			  method: 'post',
			  parameters: {
				commited: 1,
			  	action: "create",
			  	mod: "CMS_view_redirects",
			  	site_id: document.getElementById('site_id').value,
			  	filename: document.getElementById('filename').value,
			  	destination_url: document.getElementById('destination_url').value
			  },
			  onSuccess: function(transport) {
			    Modalbox.hide();
			  },
			  onFailure: function(transport) {
				  alert("Boo!");
			  }
			});
	}
  </script>
  
  <link rel="stylesheet" href="/cms/modalbox.css" type="text/css" media="screen" />
  <script type="text/javascript" src="/cms/js/prototype.js"></script>
  <script type="text/javascript" src="/cms/js/scriptaculous.js?load=effects"></script>
  <script type="text/javascript" src="/cms/js/modalbox.js"></script>
  
  <style type="text/css" media="screen">
		ul.sortableList {
			list-style-type: none;
			padding: 0px;
			margin: 0px;
			width: 100%;
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

.offer-left-sub {
font-size: 13px;
background-color: #EEEEEE; 
text-align: left;
font-family: Arial, Helvetica, sans-serif; 
font-weight: bold;
width: 100%;
color: #0066CC;
padding-left: 4px
BACKGROUND: #FFFFFF
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

   <table align='center' class='component'>
	<tr>
	<td class='componentHead'>
	Manage Pages
	</td>
	</tr>
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
	$sortableLists->printForm('index.php', 'POST', 'Commit Changes', $_REQUEST['mod'] , 'siteId' ,'formbutton');
	?>
	<input class=formbutton type=button value="BACK" onClick="goToMod('CMS_view_sites')">     
	</center>
	<br>
	<div>
	<div style="float:center;">
	<!-- Assigned Pages: <a href='index.php?md=Affiliate_CMS_Views_SiteToPageManager&action=removeAll&siteId=<?=$_REQUEST['siteId']?>'>[Remove All]</a><br>
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
		
		<table border=0 cellpadding=0 cellspacing = 0>
		<tr>
		<td>
			<table style="border-width:3px;border-style:solid;border-color:#cccccc;" >
			<tr>
			<td>
			<b><a href="javascript://void(0);" onClick="showCreateRedirect('index.php?mod=<?=$_REQUEST['mod']?>&action=removePage&siteId=<?=$_REQUEST['siteId']?>&cardpageId=<?=$rs->fields['cardpageId']?>', <?=$_REQUEST['siteId']?>, '<?=$rs->fields['pageLink']?>')">Remove Page</a>
			</td>
			</tr>
			</table>
		</td>
		
		<td>
			<table style="border-width:3px;border-style:solid;border-color:#cccccc;" >
			<tr>
			<td>
			<b><a href="index.php?mod=<?=$_REQUEST['mod']?>&pageId=<?=$rs->fields['cardpageId']?>&siteId=<?=$_REQUEST['siteId']?>&action=addSubPage">Edit Sub-Pages</a>
			</td>
			</tr>
			</table>
		</td>
		
		<td>
			<table style="border-width:3px;border-style:solid;border-color:#cccccc;" >
			<tr>
			<td>
			<b><a href="index.php?mod=CMS_view_componentToPage&pageId=<?=$rs->fields['cardpageId']?>&siteId=<?=$_REQUEST['siteId']?>">Edit Components</a>
			</td>
			</tr>
			</table>
		</td>
		
		</tr>
		</table>
		<table width=770 cellpadding="0" cellspacing="0">
			<tr> 
				<td>
					<table class="rc" align="center" width=770 cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
					  <tr> 
					    <th colspan="2" class="offer-left">  
					      <font color='#000999'><?=$rs->fields['pageName']?> <?=$active?>
					  </tr>
					         <tr> 
					    <td width="15%" align='center'>
					      <img src="http://content.inside.cs/content/extras/<?=$rs->fields['pageHeaderImage']?>" border="0"><br />
					  
					    <td width="85%" class="details"> 
						<?=$rs->fields['pageDescription']?>	
					  </tr>
					  </table>
				</td>
			</tr>
		  
		<?	$subPages = $this->rs_assignedSubCats[$rs->fields['cardpageId']];
			if(is_array($subPages))
				foreach($subPages as $subPage){?>
					<tr>
						<td>
							<table class="rc" align="right" width=750 cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#eeeeee;">
							  <tr> 
							    <th colspan="2" class="offer-left-sub">
							      <?if($subPage->fields['hide']){?>
							         <font color='#FF9999'><?=$subPage->fields['pageName']?> <?=$active?><a href=index.php?mod=<?=$_REQUEST['mod']?>&action=hidePage&siteId=<?=$_REQUEST['siteId']?>&pageId=<?=$rs->fields['cardpageId']?>&subpageId=<?=$subPage->fields['cardpageId']?> style="color: #FF9999">[UNHIDE]</a>
							      <?}else{?>
							         <font color='#000999'><?=$subPage->fields['pageName']?> <?=$active?><a href=index.php?mod=<?=$_REQUEST['mod']?>&action=hidePage&siteId=<?=$_REQUEST['siteId']?>&pageId=<?=$rs->fields['cardpageId']?>&subpageId=<?=$subPage->fields['cardpageId']?>>[HIDE]</a>
							      <?}?>
							  </tr>
							         <tr> 
							    <td width="15%" align='center'>
							      <img src="http://content.inside.cs/content/extras/<?=$subPage->fields['pageHeaderImage']?>" border="0"><br />
							  
							    <td width="85%" class="details" <?if($subPage->fields['hide'])print 'style="color: #FF9999;"'?>> 
								<?=$subPage->fields['pageDescription']?>	
							  </tr>
							  </table>
						</td>
					</tr>
		<?}?>
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
	</td>
    </tr> 
    </table>

<script type="text/javascript" defer>
    Sortable.create("assignedList", {tag:'li', dropOnEmpty:true,handle:'handle',containment:["assignedList","unassignedList"],constraint:false});
</script>

<input type=hidden name=tmdl_status value="<?=$_REQUEST['tmdl_status']?>">
<input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
<input type=hidden name=siteId value='<?=$_REQUEST['siteId']?>'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>
<? } ?>