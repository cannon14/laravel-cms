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
<form action=index.php method=post name=update>
<table class=listing border=0 width=770 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(3, "Version Parameters"); ?>  
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
<?=$_POST['cardDetailText']?>
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

<? if($_POST['action'] == 'createVersion'){ ?>
    <tr>
      <td align="left">&nbsp;<?=L_G_VERSIONNAME?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<SELECT NAME=cardDetailVersion>
					<option value='_'>Select a Page
					<?
					$rs = $_POST['rs_sites'];
					while(!$rs->EOF){
						
						?>
							<option value='<?=$rs->fields['siteId']?>'><?=$rs->fields['siteName']?></option>
						<?
						$rs->MoveNext();
					}
					?>
					</SELECT>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>     
<? } ?>
        <tr>
      <td align="left">&nbsp;<b>Card Link</b><br>(No extension is necessary, this is defined by the site <br>i.e., citi-platinum.php would be just citi-platinum)&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardLink' size='40' value='<?= $_POST['cardLink']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Application Link</b>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='appLink' size='40' value='<?= $_POST['appLink']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
     <tr>
      <td align="left">&nbsp;<b>Card Listing String&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardListingString' size='30' value='<?= $_POST['cardListingString']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr> 

     <tr>
      <td align="left">&nbsp;<b>Card's Page Header String&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardPageHeaderString' size='30' value='<?= $_POST['cardPageHeaderString']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    
    <tr>
      <td align="left">&nbsp;<b>fid&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='fid' size='30' value='<?= $_POST['fid']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    
    <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_CATEGORYIMAGE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='categoryImage' size='30' value='<?= $_POST['categoryImage']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>           
    <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_CATEGORYALTTEXT?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='categoryAltText' size='30' value='<?= $_POST['categoryAltText']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    
    <tr>
      <td align="left">&nbsp;<b>Listing Apply Button Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardButtonAltText' size='30' value='<?= $_POST['cardButtonAltText']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
    <tr>
      <td align="left">&nbsp;<b>Individual Offer Apply Button Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIOButtonAltText' size='30' value='<?= $_POST['cardIOButtonAltText']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>          
           
    <tr>
      <td align="left">&nbsp;<b>Individual Offer Card Image Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIOAltText' size='30' value='<?= $_POST['cardIOAltText']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>   
    
    <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_CARDICONSMALL?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIconSmall' size='30' value='<?= $_POST['cardIconSmall']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_CARDICONMID?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIconMid' size='30' value='<?= $_POST['cardIconMid']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_CARDICONLARGE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardIconLarge' size='30' value='<?= $_POST['cardIconLarge']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>  
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>  	
    <tr>
      <td align="left" colspan=2>&nbsp;<b>Card Detail Text</b>&nbsp;<br><br>


    				<? $_POST['editorObject1']->create(); ?>

      </td>
    </tr> 
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>    
    <tr>
      <td align="left" colspan=2>&nbsp;<b><?=L_G_CRM_CARDINTRODETAIL?></b>&nbsp;<br><br>


    				<? $_POST['editorObject2']->create(); ?>

      </td>
    </tr> 
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>
      <tr>
      <td align="left" colspan=2>&nbsp;<b><?=L_G_CRM_CARDMOREDETAIL?></b>&nbsp;<br><br>


    				<? $_POST['editorObject3']->create(); ?>

      </td>
    </tr> 
           
   
                          
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_CardDetailManager'>
      <input type=hidden name=action value='<?=$_POST['action']?>'>
      <input type=hidden name=postaction value='<?=$_POST['action']?>'>
      <input type=hidden name=cardId value='<?=$_POST['cardId']?>'>
      <? if($_POST['action'] != 'createVersion'){ ?>
      <input type=hidden name=versionId value='<?=$_POST['versionId']?>'>
      <? } ?>
      <input class=formbutton type=submit value="SAVE">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>

