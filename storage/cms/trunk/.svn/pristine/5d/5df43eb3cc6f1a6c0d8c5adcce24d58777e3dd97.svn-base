<script>  	
	function exclude(SiteID, PageID){
		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&siteId="+SiteID+"&cardpageId="+PageID+"&action=showVersion";
  	}
  	
</script>
<style type="text/css">
li.excluded{
	list-style-type: none;
	float: left;
	clear: left;
	filter: alpha(opacity=25);
	moz-opacity: .25;
	opacity: .25;
	color:#2E7090;
}

li.included{
	list-style-type: none;
	float: left;
	clear: left;
	filter: alpha(opacity=100);
	moz-opacity: 1;
	opacity: 1;
	color:#2E7090;
}

ul.list{
	list-style-type: none;
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
if(!isset($_POST['runQuery'])){
$_POST['siteId'] = isset($_REQUEST['siteId']) ? $_REQUEST['siteId'] : '';
?>

<br>
<table class=component align='center'>
	<tbody>
		<tr>
			<td colspan=2 class='componentHead'>
				Exclude Cards per Version  [<?=$_POST['pageInfo']->fields['pageName']?>]
			</td>
		</tr>   
		<tr>
			<td>
				<br>
				<center>
		    	Change Version: <SELECT NME='version' OnChange="performAction(this)">
		    						<option value='javascript:exclude(-1,<?=$_REQUEST['cardpageId']?>)'>DEFAULT</option>
						    		<?foreach($this->sites as $site){
						    			echo "<option value='javascript:exclude(".$site->fields['siteId'].",".$_REQUEST['cardpageId'].")'";
						    			if($_REQUEST['siteId'] == $site->fields['siteId'])
						    				echo ' selected';
						    			echo">".$site->fields['siteName']."</option>";
						    		}
						    		?>
								</SELECT>
				<br>
				</center>
				<br>
				<hr>
				<br>
				<table width='100%' align=center>
					<tbody>
						<tr>
							<td valign="top"> 
		        				<div align="center">
		        					<table width="90%" border="0" cellpadding="0" cellspacing="0">
		        						<tbody>
			          						<tr>
									            <?if($_POST['pageInfo']->fields['pageHeaderImage'] != ""){ ?>
									            <td rowspan="2" valign="top"><img src="/content/extras/<?=$_POST['pageInfo']->fields['pageHeaderImage']?>" border="0" ></td>
									            <? } ?>
				           						<td rowspan="2"><img src='/content/extras/10-10-spacer.gif' width="10" height="10"></td>
				            					<td><h1><?=$_POST['pageInfo']->fields['pageHeaderString']?></h1></td>
			          						</tr>
			          						<tr>
			            						<td><p><?=$_POST['pageInfo']->fields['pageDescription']?></p></td>
			          						</tr>
		          						</tbody>
		        					</table>
		        				</div>
		        			</td>
		        		</tr>
		        	</tbody>	
				</table>
				<br>
				<ul id="assignedList" class="list">
					<br>
					<?
					$rsCards = $_POST['rs_assignedCards'];
					$count = 1;
					while($rsCards && !$rsCards->EOF){
					if($rsCards->fields['active'] != 1)
						$active = " [ INACTIVE ]";
					?>
	
					<?if(in_array($rsCards->fields['id'], $this->excludedArray)){?>
						<li id='item_<?=$rsCards->fields['id']?>' class='excluded'>
							<table style='border-width:3px;border-style:solid;border-color:#cccccc;'>
								<tbody>
									<tr>
										<td>
											<b><a href='index.php?mod=<?=$_REQUEST['mod']?>&action=excludeCard&siteId=<?=$_REQUEST['siteId']?>&cardpageId=<?=$_REQUEST['cardpageId']?>&cardId=<?=$rsCards->fields['cardId']?>'>Include</a></b>
										</td>
									</tr>
								</tbody>
							</table>
					<?}else{?>
						<li id='item_<?=$rsCards->fields['id']?>' class='included'>
							<table style='border-width:3px;border-style:solid;border-color:#cccccc;'>
								<tbody>
									<tr>
										<td>
											<b><a href='index.php?mod=<?=$_REQUEST['mod']?>&action=excludeCard&siteId=<?=$_REQUEST['siteId']?>&cardpageId=<?=$_REQUEST['cardpageId']?>&cardId=<?=$rsCards->fields['cardId']?>'>Exclude</a></b>
										</td>
									</tr>
								</tbody>
							</table>
						<?}?>		
						<table class="rc" align="center" width=770 cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
							<tbody>
		  						<tr> 
		    						<th colspan="2" class="offer-left">
		    							<font color='#000999'>
		    								<?=$rsCards->fields['cardTitle']?> <?if(!$rsCards->fields['active']) print '[ INACTIVE ]'?>
		    							</font>
		    						</th>
		    					</tr>
		         				<tr> 
		    						<td width="15%" class="cc-card-art-align"><img src="<?=$this->imageRepository?>/<?=$rsCards->fields['imagePath']?>" width="95" height="60" border="0" ><br /></td>
		    						<td width="85%" class="details"><?=$rsCards->fields['cardDetailText']?></td>
								</tr>
							</tbody>
						</table>
						<br>
					</li>
					<?$rsCards->MoveNext();
					  $active = "";
					}?>
				</ul>
			</td>
		</tr>
	</tbody>
</table>		
<br>
<br>
<input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
<input type=hidden name=cardpageId value='<?=$_REQUEST['cardpageId']?>'>
<br>
<br>
<? } ?>
