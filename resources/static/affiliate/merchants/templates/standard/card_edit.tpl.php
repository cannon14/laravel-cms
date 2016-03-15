<head>
<script>
	function editVersion(ID, eid){
  		document.location.href = "index.php?md=Affiliate_Merchants_Views_CardDetailManager&action=editVersion&versionId=" + ID + "&eid=" + eid;
		
	}
	function createVersion(ID){
  		document.location.href = "index.php?md=Affiliate_Merchants_Views_CardDetailManager&action=createVersion&cardId=" + ID;
		wnd.focus();
	}
</script>

<style>
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

<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index_popup.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 width=770 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(3, L_G_CRM_EDITCARD); ?>  
	<tr>
	<td colspan=2>
				<table class="rc" align="center" cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
		  <tr> 
		    <th colspan="2" class="offer-left">  
		      <a href=""><?= $_POST['cardTitle']?></a>
		  </tr>
		         <tr> 
		       
		    <td width="15%" class="cc-card-art-align"><a href="t.php?" target="_blank">
		      <img src="/images/<?= $_POST['imagePath']?>" width="95" height="60" border="0" ><br />
		      <img name="/images/Apply-Now" border="0" src="/images/apply-now.gif " width="95" height="28" alt="Apply for an Citi&reg; Diamond Preferred &reg; Rewards Card "></a></td>
		    <td width="85%" class="details"> <ul>
<?=$_POST['defaultVersion']->fields['cardDetailText']?>
</ul>
		    </td>
		
		  </tr>
		  <tr> 
		    <td colspan="2"> 
		      <table align="center" class="rate-rc" cellpadding="0" cellspacing="1">
		        <tr > 
		          <?if($_POST['active_introApr'] == 1){?>
		          <td class="rate-top">Intro APR</td>
		           
		           <?}if($_POST['active_introAprPeriod'] == 1){?>
		          <td class="rate-top">Intro APR Period</td>
		           <?}if($_POST['active_regularApr'] == 1){?>
		          <td class="rate-top">Regular APR</td>
		           <?}if($_POST['active_annualFee'] == 1){?>
		          <td class="rate-top">Annual Fee</td>
		           <?}if($_POST['active_monthlyFee'] == 1){?>
		          <td class="rate-top">Monthly Fee</td>
		           <?}if($_POST['active_balanceTransfers'] == 1){?>
		          <td class="rate-top">Balance Transfers</td>
		           <?}if($_POST['active_creditNeeded'] == 1){?>
		          <td class="rate-top">Credit Needed</td>
		          <? } ?>
		        </tr>
		        <tr> 
		        <?if($_POST['active_introApr'] == 1){?>
		          <td class="rates-bottom"><?= $_POST['introApr']?></td>
		         <?}if($_POST['active_introAprPeriod'] == 1){?> 
		          <td class="rates-bottom"><?= $_POST['introAprPeriod']?></td>
		         <?}if($_POST['active_regularApr'] == 1){?> 
		          <td class="rates-bottom"><?= $_POST['regularApr']?></td>
		          <?}if($_POST['active_annualFee'] == 1){?>
		          <td class="rates-bottom"><?= $_POST['annualFee']?></td>
		          <?}if($_POST['active_monthlyFee'] == 1){?>
		          <td class="rates-bottom"><?= $_POST['monthlyFee']?></td>
		          <?}if($_POST['active_balanceTransfers'] == 1){?>
		          <td class="rates-bottom"><?= $_POST['balanceTransfers']?></td>
		          <?}if($_POST['active_creditNeeded'] == 1){?>
		          <td class="rates-bottom"><?= $_POST['creditNeeded']?></td>
		          <? } ?>
		        </tr>
		      </table>
		    </td>
		  </tr>
		</table>
		<br />
	</td>
	</tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CARDTITLE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardTitle' size='70' value='<?= $_POST['cardTitle']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>   
    
    <tr>
     <td align="left">&nbsp;<?=L_G_ACTIVE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['active'] == 1)
						$checked = "checked='true'";
					?>
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" <?=$checked?></INPUT>
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_IMAGEPATH?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='imagePath' size='70' value='<?= $_POST['imagePath']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_MERCHANT?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchant' size='70' value='<?= $_POST['merchant']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_INTROAPR?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                <? if($_POST['active_introApr'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <INPUT TYPE=CHECKBOX NAME=active_introApr VALUE="1" <?=$iachecked?></INPUT>
					<input type='text' name='introApr' size='30' value='<?= $_POST['introApr']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_INTROAPRPERIOD?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                <? if($_POST['active_introAprPeriod'] == 1)
						$iapchecked = "checked='true'";
					?>
					Show: <INPUT TYPE=CHECKBOX NAME=active_introAprPeriod VALUE="1" <?=$iapchecked?></INPUT>
					<input type='text' name='introAprPeriod' size='30' value='<?= $_POST['introAprPeriod']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>    
      
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_REGAPR?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                <? if($_POST['active_regularApr'] == 1)
						$rachecked = "checked='true'";
					?>
					Show: <INPUT TYPE=CHECKBOX NAME=active_regularApr VALUE="1" <?=$rachecked?></INPUT>
					<input type='text' name='regularApr' size='30' value='<?= $_POST['regularApr']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>


    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_ANNUALFEE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                <? if($_POST['active_annualFee'] == 1)
						$afchecked = "checked='true'";
					?>
					Show: <INPUT TYPE=CHECKBOX NAME=active_annualFee VALUE="1" <?=$afchecked?></INPUT>
					<input type='text' name='annualFee' size='30' value='<?= $_POST['annualFee']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_MONTHLYFEE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                <? if($_POST['active_monthlyFee'] == 1)
						$mfchecked = "checked='true'";
					?>
					Show: <INPUT TYPE=CHECKBOX NAME=active_monthlyFee VALUE="1" <?=$mfchecked?></INPUT>
					<input type='text' name='monthlyFee' size='30' value='<?= $_POST['monthlyFee']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_BALANCETRANSFERS?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                <? if($_POST['active_balanceTransfers'] == 1)
						$btchecked = "checked='true'";
					?>
					Show: <INPUT TYPE=CHECKBOX NAME=active_balanceTransfers VALUE="1" <?=$btchecked?></INPUT>
					<input type='text' name='balanceTransfers' size='30' value='<?= $_POST['balanceTransfers']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<?=L_G_CRM_CREDITNEEDED?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                <? if($_POST['active_creditNeeded'] == 1)
						$cnchecked = "checked='true'";
					?>
					Show: <INPUT TYPE=CHECKBOX NAME=active_creditNeeded VALUE="1" <?=$cnchecked?></INPUT>
					<input type='text' name='creditNeeded' size='30' value='<?= $_POST['creditNeeded']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>   
 

    <? QUnit_Templates::printFilter(3, "Card Versions"); ?>  
    <tr>
    <td>
	Edit Version <br></td><td><br><SELECT NAME="add" OnChange="performAction(this);">
	<option value="-">--------------------------------</option>
	<?
	$rs = $_POST['rs_versions'];
	while(!$rs->EOF){
	?>
		<OPTION VALUE="javascript:editVersion(<?=$rs->fields['id']?>, <?=$_POST['cardId']?>)"><?=$rs->fields['cardDetailLabel']?>
	<?
	$rs->MoveNext();
	}
	?>
	</SELECT>
	<br>
	<br>
    </td>
    </tr>
    <tr>
    <td colspan=2 align='center'><a href="javascript:createVersion(<?=$_POST['cardId']?>)">Create New Version</a><br><br></td>
    </tr>
         
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_CardDetailManager'>
      <input type=hidden name=action value='update'>
      <input type=hidden name=postaction value='update'>
      <input type=hidden name=cardId value='<?=$_POST['cardId']?>'>
      <input type=hidden name=eid value='<?=$_POST['siteId']?>'>
      <input class=formbutton type=submit value="<?=L_G_UPDATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
