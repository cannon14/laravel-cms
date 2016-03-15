<head>
<?
csCore_Import::importClass('csCore_UI_SLLists');
$sortableLists = new csCore_UI_SLLists('../cmsCore/include/csCore/JS/scriptaculous');
$sortableLists->addList('assignedList','assignedListOrder');
$sortableLists->printTopJS();

?>
  <script>
  	function addPage(specialsPageId, pageId){
  		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&pageId="+pageId+"&cardpageId="+specialsPageId+"&action=addPage";
  	}
  </script>
  
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
</head>

<? 

if($_POST['runQuery'] == null){
?>

   <table align='center' class='component'>
	<tr>
	<td class='componentHead'>
	Specials Page
	</td>
	</tr>
	<tr>
		<td><h4 style="text-align: center">The Specials Page is a single page that selects the top pick in each category listed below.<br>Each top card will be listed the order of the categories as seen below.</h4>
    <tr>
	<td>
		<center>
        Add Pages: <SELECT NAME="add" OnChange="performAction(this);">
        <option value="-">----------------------------------------------------------</option>
        <?while(!$this->unassigned->EOF){?>
                <OPTION VALUE="javascript:addPage(<?=$_REQUEST['cardpageId']?>, <?=$this->unassigned->fields['cardpageId']?>)"><?=$this->unassigned->fields['pageName']?>
        <?$this->unassigned->MoveNext();}?>
        </SELECT>

	</center>
	<br>
	<center>
	<?$sortableLists->printForm('index.php', 'GET', 'Commit Changes', $_REQUEST['mod'] , 'cardpageId' ,'formbutton');?>
	<input class=formbutton type=button value="BACK" onClick="goToMod('CMS_view_sites')">     
	</center>
	<br>
	<div>
	<div style="float:center;">
	<ul id="assignedList" class="sortableList">
		<?while(!$this->assigned->EOF){
			$active = $this->assigned->fields['active'] != 1?' [ INACTIVE ]':'';?>
		
		<li class='blue' id="item_<?=$this->assigned->fields['cardpageId']?>">
		
		<table border=0 cellpadding=0 cellspacing = 0>
			<tr>
				<td>
					<table style="border-width:3px;border-style:solid;border-color:#cccccc;" >
					<tr>
					<td>
					<b><a href=index.php?mod=<?=$_REQUEST['mod']?>&action=removePage&cardpageId=<?=$_REQUEST['cardpageId']?>&pageId=<?=$this->assigned->fields['cardpageId']?>>Remove Page</a>
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
					      <font color='#000999'><?=$this->assigned->fields['pageName']?> <?=$active?>
					  </tr>
					         <tr> 
					    <td width="15%" align='center'>
					      <img src="http://content.inside.cs/content/extras/<?=$this->assigned->fields['pageHeaderImage']?>" border="0"><br />
					  
					    <td width="85%" class="details"> 
						<?=$this->assigned->fields['pageDescription']?>	
					  </tr>
					  </table>
				</td>
			</tr>
		</table>
		
		</li>
		<br>		
		<?$this->assigned->MoveNext();}?>
	</ul>
	</div>		
	</div>
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
<input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
<input type=hidden name=cardpageId value='<?=$_REQUEST['cardpageId']?>'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>
<? } ?>
