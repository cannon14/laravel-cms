<script language="JavaScript" type="text/javascript">
<!--

function one2two(list1, list2) {
	list1len = list1.length ;
    for ( i=0; i<list1len ; i++){
        if (list1.options[i].selected == true ) {
        	list2len = list2.length;
        	list2.options[list2len]= new Option(list1.options[i].text);
        	list2.options[list2len].value = list1.options[i].value;
        }
    }

    for ( i = (list1len -1); i>=0; i--){
        if (list1.options[i].selected == true ) {
        	list1.options[i] = null;
        }
    }
}

function two2one(list1, list2) {
		list2len = list2.length ;
        for ( i=0; i<list2len ; i++){
            if (list2.options[i].selected == true ) {
                list1len = list1.length;
                list1.options[list1len]= new Option(list2.options[i].text);
                list1.options[list1len].value = list2.options[i].value;
            }
        }
        for ( i=(list2len-1); i>=0; i--) {
            if (list2.options[i].selected == true ) {
                list2.options[i] = null;
            }
        }
}

function selectAll(){
	for (i=0; i<m2.length; i++) { 
		m2.options[i].selected = true; 
	}
	for (i=0; i<m1.length; i++) { 
		m1.options[i].selected = true; 
	}
	for (i=0; i<m3.length; i++) { 
		m3.options[i].selected = true; 
	}
	for (i=0; i<m4.length; i++) { 
		m4.options[i].selected = true; 
	}
	for (i=0; i<m5.length; i++) { 
		m5.options[i].selected = true; 
	}
	for (i=0; i<m6.length; i++) { 
		m6.options[i].selected = true; 
	}
	
	return true;
}

function validateForm()
{   
   if(document.forms[0].site_code.options[0].selected == true)
   {
      alert('Sorry, you must select a site code.');
      return false;
   }
   else
   {
      document.forms[0].submit();
   }
}

//-->
</script>

<div id="overDiv" style="position: absolute; visibility: hidden; z-index: 1000;"></div>
<form action="index.php" method="post" name="update">
<table class='component' align='center'>
	<tr>
		<td class='componentHead'>Create Card</td>
	</tr>
	<tr>
    	<td align="center">
    		<table class="listing" border="0" cellspacing="0" width="100%" cellpadding="0">
    			<tr>
    				<td align="left">&nbsp;<b>Card ID&nbsp;</b></td>
    				<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardId' size='100'
            						value="<?= $_POST['cardId']?>"></td>
            				</tr>
            			</table>
    				</td>
    			</tr>
        		<tr>
        			<td>&nbsp;<b>CCX ID</b>&nbsp;</td>
        			<td>
            			<table>
            				<tr>
            					<td><input type="text" size='100' name="ccxId" id="ccxId"
            						value="<?= $_POST['ccx_id'] ?>" /></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;Site Code&nbsp;</td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><?
                            if(isset($_POST['site_code']))
                            {
                              $siteCode = $_POST['site_code'];                  
                            }
                            else
                            {
                              $siteCode = '';
                            }
                                                 
                            $siteCodes = CMS_libs_Cards::getSiteCodes();                
                            $numSiteCodes = $siteCodes->numRows();            
                            ?>
            					<select name="site_code">
            						<option value="">-Select a site code-</option>
            						<?                     
                                 while(!$siteCodes->EOF)
                                 {                    
                                    ?>
            						<option value="<?= $siteCodes->fields['site_code']; ?>"
            							<?= $sitecode == $sitecodes->fields['site_code'] ? 'selected' : ''; ?>><?= $siteCodes->fields['site_description']; ?></option>
            						<?
                                    $siteCodes->moveNext();
                                 }                                         
                                 ?>
            					</select></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left"><b>&nbsp;Internal Name&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left">
            						<input type='text' name='cardDescription' size='100' value="<?= $_POST['cardDescription']?>" />
            					</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Card Title&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardTitle'
            						size='100' value="<?= $_POST['cardTitle']?>" disabled>
            					</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Card Link&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='url' size='100' value="<?= $_POST['url']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
    				<td align="left">&nbsp;Apply By Phone Number&nbsp;</td>
    				<td align="left">
    				<table>
    					<tr>
    						<td align="left"><input type='text' name='applyByPhoneNumber' size='100'
    							value="<?= $_POST['applyByPhoneNumber']?>"></td>
    					</tr>
    				</table>
    				</td>
    			</tr>
        		<tr>
        			<td align="left" class="card_borderbottom">&nbsp;<b>Active&nbsp;</b></td>
        			<td align="left" class="card_borderbottom">
            			<table>
            				<tr>
            					<input type="CHECKBOX" name="active" value="1" checked='true'></input>
            					<td></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
    			<tr></tr>
    			<tr>
        			<td align="left" class="card_borderbottom">&nbsp;<b>Syndicate&nbsp;</b></td>
        			<td align="left" class="card_borderbottom">
            			<table>
            				<tr>
            					<input type="CHECKBOX" name="syndicate" value="1" checked='true'></input>
            					<td></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;Build Enhanced Product Details Pages</td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type="checkbox"
            						name="active_epd_pages" value="1"
            						<?= $_post['active_epd_pages'] == 1 ? 'checked="checked"' : '' ?> />
            					</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;Show Rates/Fees section&nbsp;</td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type="checkbox"
            						name="active_show_epd_rates" value="1"
            						<?= $_post['active_show_epd_rates'] == 1 ? 'checked="checked"' : '' ?> />
            					(Only applicable if enhanced product detail pages are turned on)</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;Show Verify&nbsp;</td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left">
            						<input type="text"	size="100" name="show_verify" value="<?= $_POST['show_verify']?>"
            					</td>
            				</tr>
            			</table>
        			</td>
    			</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Image Path&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='imagePath'
            						size='100' value="<?= $_POST['imagePath']?>" disabled>
            					</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
				<tr>
        			<td align="left">&nbsp;<b>T-Page Text&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='tPageText'
            						size='100' value="<?= $_POST['tPageText']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Card Merchant&nbsp;</b></td>
        			<td align="left">
        			<table>
        				<tr>
        					<td align="left"><select name='merchant' disabled>
        						<?foreach($this->allMerchants as $merchant){ ?>
        						<option value="<?=$merchant['merchantid']?>"><?=$merchant['merchantname']?></option>
        						<? } ?>
        					</select>
        					</td>
        				</tr>
        			</table>
        			</td>
        		</tr>
        		<tr>
					<td align="left">&nbsp;<b>Secured</b>&nbsp;</td>
					<td align="left">
						<input type="checkbox" name="secured" value="1" <?= $_POST['secured'] == 1 ? 'checked="checked"' : '' ?> />
						(Checking this option will enable the use of the Insulator Web Service for securing Offer Clicks. Only use this option if the Issuer is setup in the Insulator.)
					</td>
				</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Intro APR&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_introApr'] == 1)
            						$iachecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX" name="active_introApr" value="1"
            						<?=$iachecked?>></input> <input type='text' name='introApr'
            						size='40' value='@@introApr@@%*'> <input type='text'
            						name='d_introApr' size='40' disabled></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Intro APR Period&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_introAprPeriod'] == 1)
            						$iapchecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX" name="active_introAprPeriod" value="1"
            						<?=$iapchecked?>></input> <input type='text' name='introAprPeriod'
            						size='40' value='@@introAprPeriod@@*'> <input type='text'
            						name='d_introAprPeriod' size='40' disabled></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Regular APR&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_regularApr'] == 1)
            						$rachecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX" name="active_regularApr" value="1"
            						<?=$rachecked?>></input> <input type='text' name='regularApr'
            						size='40' value='@@regularApr@@%*'> <input type='text'
            						name='d_regularApr' size='40' disabled></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Annual Fee&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_annualFee'] == 1)
            						$afchecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX" name="active_annualFee" value="1"
            						<?=$afchecked?>></input> <input type='text' name='annualFee'
            						size='40' value='$@@annualFee@@*'> <input type='text'
            						name='d_annualFee' size='40' ' disabled></td>
            				</tr>
            			</table>
        			</td>
    			</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Monthly Fee (up&nbsp;to)&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_monthlyFee'] == 1)
            						$mfchecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX" name="active_monthlyFee" value="1"
            						<?=$mfchecked?>></input> <input type='text' name='monthlyFee'
            						size='40' value='$@@monthlyFee@@*'> <input type='text'
            						name='d_monthlyFee' size='40' disabled></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Balance Transfers&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_balanceTransfers'] == 1)
            						$btchecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX" name="active_balanceTransfers"
            						value="1" <?=$btchecked?>></input> <input type='text'
            						name='balanceTransfers' size='40' value='@@balanceTransfers@@*'>
            					<select name='d_balanceTransfers' disabled>
            						<option value="0">N/A</option>
            						<option value="1">Yes</option>
            					</select></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Balance Transfer Fee&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_balanceTransferFee'] == 1)
            						$btchecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX" name="active_balanceTransferFee"
            						value="1" <?=$btchecked?>></input> <input type='text'
            						name='balanceTransferFee' size='40'
            						value='@@balanceTransferFee@@%*'> <input type='text'
            						name='d_balanceTransferFee' size='40' disabled></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Balance Transfer Intro APR&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_balanceTransferIntroApr'] == 1)
            						$btchecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX" name="active_balanceTransferIntroApr"
            						value="1" <?=$btchecked?>></input> <input type='text'
            						name='balanceTransferIntroApr' size='40'
            						value='@@balanceTransferIntroApr@@%*'> <input type='text'
            						name='d_balanceTransferIntroApr' size='40' disabled></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Balance Transfer Intro APR
        			Period&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_balanceTransferAprPeriod'] == 1)
            						$btchecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX"
            						name="active_balanceTransferIntroAprPeriod" value="1"
            						<?=$btchecked?>></input> <input type='text'
            						name='balanceTransferIntroAprPeriod' size='40'
            						value='@@balanceTransferIntroAprPeriod@@%'> <input
            						type='text' name='d_balanceTransferIntroAprPeriod' size='40'
            						disabled></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Credit Needed&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><? if($_POST['active_creditNeeded'] == 1)
            						$cnchecked = "checked='true'";
            					?>
            					Show: <input type="CHECKBOX" name="active_creditNeeded" value="1"
            						<?=$cnchecked?>></input> <input type='text' name='creditNeeded'
            						size='40' value='@@creditNeeded@@*'> <select
            						name='d_creditNeeded' disabled>
            						<option value="0">Bad credit OK</option>
            						<option value="1">Good Credit</option>
            						<option value="1">Excellent Credit</option>
            					</select></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		
        		
        		
        		
        		<tr>
        			<td class='componentHead' colspan="2">Site Assignment</td>
        		</tr>
        		<tr>
        			<td colspan="2">
            			<table align='center'>
            				<tr>
            					<td align="center" width='50%' colspan="2"><b>Unassigned Sites</b></td>
            					<td colspan="2" align="center" width='50%'><b>Assigned Sites</b></td>
            				</tr>
            				<tr>
            					<td width='50%' colspan="2">
            						<select name='sites[]' id='unassignedSites' style="width: 300px" size="10" multiple>
                						<?foreach($this->allSites as $site){ ?>
                							<option value="<?=$site->fields['siteId']?>"><?=$site->fields['siteName']?></option>
                						<? } ?>
            						</select>
            						<br>
                					<p align="center"><input class="formbutton" type="button" onclick="one2two(m3, m4)" value=" Assign >> "></p>
            					</td>
            
            					<td align="center" colspan="2" width='50%'>
            						<select name='assignedSites[]' id='assignedSites' style="width: 300px" size="10" multiple></select>
            						<br>
            						<p align="center"><input class="formbutton" type="button" onclick="two2one(m3, m4)" value=" << Remove "></p>
            					</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        	<tr>
				<td colspan="2" class='componentHead'>Card Exclusions</td>
			</tr>
			<tr>
				<td colspan="2">
				<table align='center'>
					<tr>
						<td align="center" width='50%' colspan="2"><b>Non-excluded Sites</b></td>
						<td colspan="2" align="center" width='50%'><b>Excluded Sites</b></td>
					</tr>
					<tr>
						<td width='50%' colspan="2">
							<select name='nonExcluded[]' id='nonExcluded' style="width: 300px" size="10" multiple>
    							<?foreach($this->allSites as $site){ ?>
                					<option value="<?=$site->fields['siteId']?>"><?=$site->fields['siteName']?></option>
                				<? } ?>
							</select>
							<br>
							<p align="center"><input class="formbutton" type="button" onclick="one2two(m5, m6)" value=" Assign >> "></p>
						</td>

						<td align="center" colspan="2" width='50%'>
							<select name='excluded[]' id='excluded' style="width: 300px" size="10" multiple>
							</select>
							<br>
							<p align="center"><input class="formbutton" type="button" onclick="two2one(m5, m6)" value=" << Remove "></p>
						</td>
					</tr>
				</table>
				</td>
			</tr>
        		
        		
        		
        		
        		
        		
        		
        		
        		
        		
        		
        		
        		
        		<tr>
        			<td class='componentHead' colspan="2">Card Amenities</td>
        		</tr>
        		<tr>
        			<td colspan="2">
            			<table align='center'>
            				<tr>
            					<td align="center" width='50%' colspan="2"><b>Unassigned
            					Amenities</b></td>
            					<td colspan="2" align="center" width='50%'><b>Assigned
            					Amenities</b></td>
            				</tr>
            				<tr>
            					<td width='50%' colspan="2"><select name='amenities[]'
            						id='unAssignedAmenities' style="width: 300px" size="10" multiple>
            						<?foreach($this->allAmenities as $amenities){ ?>
            						<option value="<?=$amenities['amenityid']?>"><?=$amenities['label']?></option>
            						<? } ?>
            					</select> <br>
            
            					<p align="center"><input class="formbutton" type="button"
            						onclick="one2two(m1, m2)" value=" Assign >> "></p>
            
            					</td>
            
            					<td align="center" colspan="2" width='50%'><select
            						name='assignedAmenities[]' id='assignedAmenities'
            						style="width: 300px" size="10" multiple>
            					</select> <br>
            
            					<p align="center"><input class="formbutton" type="button"
            						onclick="two2one(m1, m2)" value=" << Remove "></p>
            					</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td class='componentHead' colspan="2">Default Version Properties
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Card Link</b><br>
        			(No extension is necessary, this is defined by the site <br>
        			i.e., citi-platinum.php would be just citi-platinum)&nbsp;</td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardLink' size='40'
            						value="<?= $_POST['cardLink']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Application Link</b>&nbsp;</td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='appLink' size='40'
            						value="<?= $_POST['appLink']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Card Listing String&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardListingString'
            						size='40' value="<?= $_POST['cardListingString']?>">
            					</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Card's Page Header String&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text'
            						name='cardPageHeaderString' size='40'
            						value="<?= $_POST['cardPageHeaderString']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>fid&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='fid' size='40'
            						value="<?= $_POST['fid']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Category Image&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='categoryImage'
            						size='40' value="<?= $_POST['categoryImage']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Category Alt Text&nbsp;</b></td>
        			<td align="left">
        			<table>
        				<tr>
        					<td align="left"><input type='text' name='categoryAltText'
        						size='40' value="<?= $_POST['categoryAltText']?>"></td>
        				</tr>
        			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Listing Apply Button Alt
        			Text&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardButtonAltText'
            						size='40' value="<?= $_POST['cardButtonAltText']?>">
            					</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Individual Offer Apply Button Alt
        			Text&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardIOButtonAltText'
            						size='40' value="<?= $_POST['cardIOButtonAltText']?>">
            					</td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Individual Offer Card Image Alt
        			Text&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardIOAltText'
            						size='40' value="<?= $_POST['cardIOAltText']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Small Card Icon&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardIconSmall'
            						size='40' value="<?= $_POST['cardIconSmall']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Med Card Icon&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardIconMid'
            						size='40' value="<?= $_POST['cardIconMid']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td align="left">&nbsp;<b>Large Card Icon&nbsp;</b></td>
        			<td align="left">
            			<table>
            				<tr>
            					<td align="left"><input type='text' name='cardIconLarge'
            						size='40' value="<?= $_POST['cardIconLarge']?>"></td>
            				</tr>
            			</table>
        			</td>
        		</tr>
        		<tr>
        			<td colspan="2"><br>
        			<hr>
        			<br>
        			</td>
        		</tr>
        		<tr>
        			<td align="left" colspan="2">&nbsp;<b>Card Detail Text</b>&nbsp;<br>
        			<br>
        			<? $_POST['editorObject1']->create(); ?></td>
        		</tr>
        		<tr>
        			<td colspan="2"><br>
        			<hr>
        			<br>
        			</td>
        		</tr>
        		<tr>
        			<td align="left" colspan="2">&nbsp;<b>Card Intro Detail</b>&nbsp;<br>
        			<br>
        			<? $_POST['editorObject2']->create(); ?></td>
        		</tr>
        		<tr>
        			<td colspan="2"><br>
        			<hr>
        			<br>
        			</td>
        		</tr>
        		<tr>
        			<td align="left" colspan="2">&nbsp;<b>Card More Detail</b>&nbsp;<br>
        			<br>
        			<? $_POST['editorObject3']->create(); ?></td>
        		</tr>
        		<tr>
        			<td colspan="2"><br>
        			<hr>
        			<br>
        			</td>
        		</tr>
        		<tr>
        			<td colspan="2" align="center">
        				<input type="hidden" name="commited" value="yes">
        				<input type="hidden" name="mod" value="<?=$_REQUEST['mod']?>">
        				<input type="hidden" name="action" value='create'>
        				<input type="hidden" name="postaction" value='create'>
        				<input class="formbutton" type="button" onclick='javascript:selectAll(); validateForm();' value="Create">
        				<input class="formbutton" type="button" value="CANCEL" onclick="goToMod('<?=$_REQUEST['mod']?>')">
        			</td>
        		</tr>
        	</table>
		</td>
	</tr>
	<tr></tr>
</table>
</form>
<center></center>
<script language="JavaScript" type="text/javascript">
    var m1 = document.getElementById('unAssignedAmenities');
    var m2 = document.getElementById('assignedAmenities');
    var m3 = document.getElementById('unassignedSites');
    var m4 = document.getElementById('assignedSites');
    var m5 = document.getElementById('nonExcluded');
    var m6 = document.getElementById('excluded');
</script>