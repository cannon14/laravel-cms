
<head>
<?
$sortableLists = new Affiliate_Merchants_Bl_SLLists('scriptaculous');
$sortableLists->addList('assignedList','assignedListOrder');
$sortableLists->printTopJS();
?>


  <script src="scriptaculous/prototype.js" type="text/javascript"></script>
  <script src="scriptaculous/scriptaculous.js" type="text/javascript"></script>
  <script>
  	function addCard(PageID, CardID){
  		document.location.href = "index.php?md=Affiliate_Merchants_Views_CardToPageManager&cardId="+CardID+"&siteId="+PageID+"&action=addCard";
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
</head>

<? 

if($_POST['runQuery'] == null){
	
$_POST['siteId'] = $_REQUEST['siteId'];

?>
	<div style="width=100%">
	<div style="float:left;">
    <br>
    <table class=listingClosed border=0 width=770 cellspacing=0 cellpadding=0 nowrap>
    <? QUnit_Templates::printFilter(10, "Add/Reorder Cards"); ?>
    <tr>
    <td>	
	<br>
	<center>
        Add Card: <SELECT NAME="add" OnChange="performAction(this);">
        <option value="-">----------------------------------------------------------</option>
        <?
        $rs = $_POST['rs_unassigned'];
        while(!$rs->EOF){
        ?>
                <OPTION VALUE="javascript:addCard(<?=$_REQUEST['siteId']?>, <?=$rs->fields['cardId']?>)"><?=$rs->fields['cardTitle']?>
        <?
        $rs->MoveNext();
        }
        ?>
        </SELECT>
        <br><br>
        Add Card Sub Category: <SELECT NAME="add" OnChange="performAction(this);">
        <option value="-">----------------------------------------------------------</option>
        <?
        $rs = $_POST['rs_unassignedCats'];
        while(!$rs->EOF){
        ?>
                <OPTION VALUE="javascript:addCard(<?=$_REQUEST['siteId']?>, <?=$rs->fields['id']?>)"><?=$rs->fields['catTitle']?>
        <?
        $rs->MoveNext();
        }
        ?>
        </SELECT>        


	</center>
	<br>
	<hr>
	<br>
	<center>
	<?
	$sortableLists->printForm('index.php', 'GET', 'Commit Current Order', 'Affiliate_Merchants_Views_CardToPageManager' ,'formbutton');
	?>
	</center>
	<br><hr><br>
	<table>
				<td valign="top"> 
		        <div align="center">
		        <table width="90%" border="0" cellpadding="0" cellspacing="0">
		          <tr>
		            <td rowspan="2" valign="top"><img src="/images/<?=$_POST['pageInfo']->fields['pageHeaderImage']?>" border="0" ></td>
		            <td rowspan="2"><img src='/images/spacer.gif' width="10" height="10"></td>
		            <td><h1><?=$_POST['pageInfo']->fields['pageTitle']?></h1></td>
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
		$rs = $_POST['rs_assigned'];
		$count = 1;
		while(!$rs->EOF){
		if($rs->fields['subCat'] == 0){
		if($rs->fields['active'] != 1)
			$active = " [ INACTIVE ]";
		?>
		

		<li class='blue' id="item_<?=$rs->fields['id']?>">
		

		<table style="border-width:3px;border-style:solid;border-color:#cccccc;" >
		<tr>
		<td>
		<b><a href='index.php?md=Affiliate_Merchants_Views_CardToPageManager&action=removeCard&siteId=<?=$_REQUEST['siteId']?>&cardId=<?=$rs->fields['cardId']?>'>Remove Card</a> | Edit Card
		
		</td>
		</tr>
		</table>		
		<table class="rc" align="center" width=770 cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
		  <tr> 
		    <th colspan="2" class="offer-left">  
		      <font color='#000999'><?=$rs->fields['cardTitle']?> <?=$active?>
		  </tr>
		         <tr> 
		    <td width="15%" class="cc-card-art-align">
		      <img src="/images/<?=$rs->fields['imagePath']?>" width="95" height="60" border="0" alt="The Discover&Acirc;&reg; Platinum Gas Card "><br />
		      <img name="/images/Apply-Now" border="0" src="/images/apply-now.gif " width="95" height="28" alt="Apply for an The Discover&Acirc;&reg; Platinum Gas Card "></td>
		    <td width="85%" class="details"> 
			<?=$rs->fields['cardDetailText']?>
		    </td>
		
		  </tr>
		  <tr> 
		    <td colspan="2"> 
		      <table align="center" width='100%' class="rate-rc" cellpadding="0" cellspacing="1">
		        <tr > 
		          <?if($rs->fields['active_introApr'] == 1){?>
		          <td class="rate-top">Intro APR</td>
		           
		           <?}if($rs->fields['active_introAprPeriod'] == 1){?>
		          <td class="rate-top">Intro APR Period</td>
		           <?}if($rs->fields['active_regularApr'] == 1){?>
		          <td class="rate-top">Regular APR</td>
		           <?}if($rs->fields['active_annualFee'] == 1){?>
		          <td class="rate-top">Annual Fee</td>
		           <?}if($rs->fields['active_monthlyFee'] == 1){?>
		          <td class="rate-top">Monthly Fee</td>
		           <?}if($rs->fields['active_balanceTransfers'] == 1){?>
		          <td class="rate-top">Balance Transfers</td>
		           <?}if($rs->fields['active_creditNeeded'] == 1){?>
		          <td class="rate-top">Credit Needed</td>
		          <? } ?>
		        </tr>
		        <tr> 
		        <?if($rs->fields['active_introApr'] == 1){?>
		          <td class="rates-bottom"><?= $rs->fields['introApr']?></td>
		         <?}if($rs->fields['active_introAprPeriod'] == 1){?> 
		          <td class="rates-bottom"><?= $rs->fields['introAprPeriod']?></td>
		         <?}if($rs->fields['active_regularApr'] == 1){?> 
		          <td class="rates-bottom"><?= $rs->fields['regularApr']?></td>
		          <?}if($rs->fields['active_annualFee'] == 1){?>
		          <td class="rates-bottom"><?= $rs->fields['annualFee']?></td>
		          <?}if($rs->fields['active_monthlyFee'] == 1){?>
		          <td class="rates-bottom"><?= $rs->fields['monthlyFee']?></td>
		          <?}if($rs->fields['active_balanceTransfers'] == 1){?>
		          <td class="rates-bottom"><?= $rs->fields['balanceTransfers']?></td>
		          <?}if($rs->fields['active_creditNeeded'] == 1){?>
		          <td class="rates-bottom"><?= $rs->fields['creditNeeded']?></td>
		          <? } ?>
		        </tr>
		      </table>		
		
		</table>
		</li>
		<br>
		<?}else{ ?>
			<li class='blue' id="item_<?=$rs->fields['id']?>">
			<br><br>
			<table style="border-width:3px;border-style:solid;border-color:#cccccc;" >
		<tr>
		<td>
		<b><a href='index.php?md=Affiliate_Merchants_Views_CardToPageManager&action=removeCard&siteId=<?=$_REQUEST['siteId']?>&cardId=<?=$rs->fields['cardId']?>'>Remove Category</a> | Edit Category
		
		</td>
		</tr>
		</table>		
				<table>
				<td valign="top"> 
		        <div align="center">
		        <table width="90%" border="0" cellpadding="0" cellspacing="0">
		          <tr>
		            <td rowspan="2" valign="top"><img src="/images/<?=$rs->fields['catImage']?>" border="0" ></td>
		            <td rowspan="2"><img src='/images/spacer.gif' width="10" height="10"></td>
		            <td><h1><?=$rs->fields['catTitle']?></h1></td>
		          </tr>
		          <tr>
		            <td><p> <?=$rs->fields['catDescription']?></p><br><br><br><br></td>
		          
		          </tr>
		        </table>
		      </table>
			</li>
		<?}
		$active = "";
		$rs->MoveNext();
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
<input type=hidden name=md value='Affiliate_Merchants_Views_CardToPageManager'>
<input type=hidden name=siteId value='<?=$_REQUEST['siteId']?>'>
<input type=hidden name=commited value='yes'>
</form>

<br><br>
<? } ?>
