<?
$sortableLists = new csCore_UI_SLLists('../cmsCore/include/csCore/JS/scriptaculous');
$sortableLists->addList('assignedList','assignedListOrder');
$sortableLists->printTopJS();
?>
  <script>
  	function addMerchantService(PageID, MerchantServiceID){
  		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&merchantServiceId="+MerchantServiceID+"&cardpageId="+PageID+"&action=addCard";
  	}
  	
  	function showExclude(SiteID, PageID){
  		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&siteId="+SiteID+"&cardpageId="+PageID+"&action=showVersion";
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
<?if($_POST['pageInfo']->fields['contentType'] == 'merchant service' || $_POST['pageInfo']->fields['contentType'] == 'merchant service application'){?>
<? 
if($_POST['runQuery'] == null){	
$_POST['siteId'] = $_REQUEST['siteId'];
?>
	<div id='foo' style="width=100%">
	<div style="float:left;">
    <br>
    <table class=component align='center'>
 	<tr>
 	<td colspan=2 class='componentHead'>Manage Merchant Services  [<?=$_POST['pageInfo']->fields['pageName']?>]
 	</td>
 	</tr>   
    <tr>
    <td>	
	<br>
	    <center>
    	Change Version: <SELECT NME='version' OnChange="performAction(this)">
    		<option value='javascript:showExclude('-1','<?=$_REQUEST['cardpageId']?>')'>DEFAULT</option>
    		<?foreach($this->sites as $site){
    			echo "<option value='javascript:showExclude('".$site->fields['siteId']."','".$_REQUEST['cardpageId']."')'";
    			if($_REQUEST['siteId'] == $site->fields['siteId'])
    				echo ' selected';
    			echo">".$site->fields['siteName']."</option>";
    		}
    		?>
    		</SELECT>
    <br>
	<br>
        Add Merchant Service: <SELECT NAME="add" OnChange="performAction(this);">
        <option value="-">----------------------------------------------------------</option>
        <?
        $rs = $_POST['rs_unassignedMerchantServices'];
        while(!$rs->EOF){
        ?>
                <OPTION VALUE="javascript:addMerchantService('<?=$_REQUEST['cardpageId']?>', '<?=$rs->fields['merchant_service_id']?>')"><?=$rs->fields['merchant_service_name']?>
        <?
        $rs->MoveNext();
        }
        ?>
        </SELECT>
        <br>

	</center>
	<br>
	<hr>
	<br>
	<center>
	<?
	$sortableLists->printForm('index.php', 'GET', 'Commit Current Order', $_REQUEST['mod'] , 'cardpageId','formbutton');
	?>
	<input class=formbutton type=button value="BACK" onClick="goToMod('CMS_view_pages')">     
	</center>
	<br><hr><br>
	<table width='100%'>
				<td valign="top"> 
		        <div align="center">
		        <table width="90%" border="0" cellpadding="0" cellspacing="0">
		          <tr>
	
		         

		            <tr>
		            <?if($_POST['pageInfo']->fields['pageHeaderImage'] != ""){ ?>
		            <td rowspan="2" valign="top"><img src="/content/extras/<?=$_POST['pageInfo']->fields['pageHeaderImage']?>" border="0" ></td>
		            <? } ?>
		            <td rowspan="2"><img src='/content/extras/10-10-spacer.gif' width="10" height="10"></td>
		            <td>
		            <h1><?=$_POST['pageInfo']->fields['pageHeaderString']?></h1></td>
		          </tr>
		          <tr>
		            <td><p> <?=$_POST['pageInfo']->fields['pageDescription']?></p></td>
		          </tr>
		        </table>	
	</table>
	<br>
	<br>
	<br>
	<ul id="assignedList" class="sortableList">
    	<br>
		<?
		$rsMS = $_POST['rs_assignedMerchantServices'];
		$count = 1;
		while($rsMS && !$rsMS->EOF){
		if($rsMS->fields['active'] != 1)
			$active = " [ INACTIVE ]";
		?>
		

		<li class='blue' id="item_<?=$rsMS->fields['merchant_service_id']?>">
		

		<table style="border-width:3px;border-style:solid;border-color:#cccccc;" >
		<tr>
		<td>
		<b><a href='index.php?mod=<?=$_REQUEST['mod']?>&action=removeMerchantService&cardpageId=<?=$_REQUEST['cardpageId']?>&merchantServiceId=<?=$rsMS->fields['merchant_service_id']?>'>Remove Merchant Service</a>
		
		</td>
		</tr>
		</table>		
		<table class="rc" align="center" width=770 cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
		  <tr> 
		    <th colspan="2" class="offer-left">  
		      <font color='#000999'><?=$rsMS->fields['merchant_service_name']?> <?=$active?>
		  </tr>
		         <tr> 
		    <td width="15%" class="cc-card-art-align">
		      <img src="<?=$this->imageRepository?>/<?=$rsMS->fields['merchant_service_image_path']?>" width="95" height="60" border="0" ><br />
		    <td width="85%" class="details"> 	
		    <?=$rsMS->fields['merchant_service_detail_text']?>
		    </td>
			</tr>
		</table>
		</li>
		<br>
		<?	$rsMS->MoveNext();
			$active = "";
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
    Sortable.create("assignedList",
     {tag:'li', dropOnEmpty:true,handle:'handle',containment:["assignedList"],constraint:false});
 	// ]]>
 	</script>


<input type=hidden name=tmdl_status value="<?=$_REQUEST['tmdl_status']?>">
<input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
<input type=hidden name=cardpageId value='<?=$_REQUEST['cardpageId']?>'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>
<? } ?>
<?}else{echo "The items you are trying to add and the content type for the page do not match.<br>Please try another item type.";}?>
