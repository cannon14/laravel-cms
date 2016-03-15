
<script>
function editVersion(ID, pageId){
  		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&action=editVersion&versionId=" + ID +"&cardpageId&=" + pageId;
		
}

function validate_page_create() {

    valid = true;
    
    numChecked = 0;
    upperLimitChecked = 7;
    
    if (document.update.active_introApr.checked == true) { numChecked++; }
    if (document.update.active_introAprPeriod.checked == true) { numChecked++; }
    if (document.update.active_regularApr.checked == true) { numChecked++; }
    if (document.update.active_annualFee.checked == true) { numChecked++; }
    if (document.update.active_monthlyFee.checked == true) { numChecked++; }
    if (document.update.active_balanceTransfers.checked == true) { numChecked++; }
    if (document.update.active_balanceTransferFee.checked == true) { numChecked++; }
    if (document.update.active_balanceTransferIntroApr.checked == true) { numChecked++; }
    if (document.update.active_balanceTransferIntroAprPeriod.checked == true) { numChecked++; }
    if (document.update.active_creditNeeded.checked == true) { numChecked++; }
    if (document.update.active_transactionFeeSignature.checked == true) { numChecked++; }
    if (document.update.active_transactionFeePin.checked == true) { numChecked++; }
    if (document.update.active_loadFee.checked == true) { numChecked++; }
    if (document.update.active_activationFee.checked == true) { numChecked++; }
    if (document.update.active_atmFee.checked == true) { numChecked++; }
    if (document.update.active_prepaidText.checked == true) { numChecked++; }
    
    if ( (numChecked <= 0) || (numChecked > upperLimitChecked) ) {
    	alert("Please select between one (1) and seven (7) Custom Fields.");
    	valid = false;
    }
    
    return valid;

}

</script>
  <form action=index.php method=post name=update onsubmit="return validate_page_create();">
  
    <table class='component' align='center'>
	<tr>
	<td colspan=2 class='componentHead'>
	Create Page
	</td>
	</tr>
    <tr>
     <td align=left nowrap>&nbsp;Page Name</td>
     <td align=left>
        <input type=text name=pageName size=120 value=''>
     </td>
    </tr>   
    <tr>         
      <td align="left">&nbsp;Rollup in sitemap&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type="radio" value="true" name="rollup" />&nbsp;Yes<br>
					<input type="radio" value="false" name="rollup" selected />&nbsp;No
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>         
      <td align="left">&nbsp;Active&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" checked />
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
    <tr>
    	<td align="left">&nbsp;Page Type&nbsp;</td>
    	<td><select name="pageType">
    			<option value="BANK">bank</option>
    			<option value="CREDIT">credit</option>
    			<option value="TYPE">type</option>
    		</select>
    	</td>
    </tr>
    <tr>
    	<td align="left">&nbsp;Content Type&nbsp;</td>
    	<td><select name=contentType>
    			<option >card</option>
    			<option >merchant service</option>
    			<option>specials</option>
    			<option>altspecials</option>
    			<option>index</option>
    			<option>profile</option>
                <option>merchant service application</option>
    		</select>
    	</td>
    </tr> 
    <tr>
    	<td align="left">&nbsp;Schumer Box Type&nbsp;</td>
    	<td><select name="schumerType">
    			<option value="STANDARD">Standard</option>
    			<option value="PREPAID">Prepaid/Debit</option>
    		</select>
    	</td>
    </tr>
    <tr>
    	<td align="left">&nbsp;<?=USE_CHAMELEON?>&nbsp;</td>
    	<td><input type="checkbox" name="useChameleon"></td>
    </tr>
    <!-- START : Project prepaid-card-attr : Custom Fields Section -->
    <tr>
      <td colspan="2" class="componentHead">       
        Custom Fields
      </td>
    </tr>
    <tr>
    	<td align="left">&nbsp;Intro APR&nbsp;</td>
    	<td><input type="checkbox" name="active_introApr" VALUE="1" checked></td><!-- Default to checked per spec -->
    </tr>
    <tr>
    	<td align="left">&nbsp;Intro APR Period&nbsp;</td>
    	<td><input type="checkbox" name="active_introAprPeriod" VALUE="1" checked></td><!-- Default to checked per spec -->
    </tr>
    <tr>
    	<td align="left">&nbsp;Regular APR&nbsp;</td>
    	<td><input type="checkbox" name="active_regularApr" VALUE="1" checked></td><!-- Default to checked per spec -->
    </tr>
    <tr>
    	<td align="left">&nbsp;Annual Fee&nbsp;</td>
    	<td><input type="checkbox" name="active_annualFee" VALUE="1" checked></td><!-- Default to checked per spec -->
    </tr>
    <tr>
    	<td align="left">&nbsp;Monthly Fee (up&nbsp;to)&nbsp;</td>
    	<td><input type="checkbox" name="active_monthlyFee"></td>
    </tr>
    <tr>
    	<td align="left">&nbsp;Balance Transfers&nbsp;</td>
    	<td><input type="checkbox" name="active_balanceTransfers" VALUE="1" checked></td><!-- Default to checked per spec -->
    </tr>
    <tr>
    	<td align="left">&nbsp;Balance Transfer Fee&nbsp;</td>
    	<td><input type="checkbox" name="active_balanceTransferFee"></td>
    </tr>
    <tr>
    	<td align="left">&nbsp;Balance Transfer Intro APR&nbsp;</td>
    	<td><input type="checkbox" name="active_balanceTransferIntroApr"></td>
    </tr>
    <tr>
    	<td align="left">&nbsp;Balance Transfer Intro APR Period&nbsp;</td>
    	<td><input type="checkbox" name="active_balanceTransferIntroAprPeriod"></td>
    </tr>
    <tr>
    	<td align="left">&nbsp;Credit Needed&nbsp;</td>
    	<td><input type="checkbox" name="active_creditNeeded" VALUE="1" checked></td><!-- Default to checked per spec -->
    </tr>
    <tr>
    	<td align="left">&nbsp;Transaction Fee (Signature)&nbsp;</td>
    	<td><input type="checkbox" name="active_transactionFeeSignature"></td>
    </tr>
    <tr>
    	<td align="left">&nbsp;Transaction Fee (PIN)&nbsp;</td>
    	<td><input type="checkbox" name="active_transactionFeePin"></td>
    </tr>
    <tr>
    	<td align="left">&nbsp;Load Fee&nbsp;</td>
    	<td><input type="checkbox" name="active_loadFee"></td>
    </tr>
    <tr>
    	<td align="left">&nbsp;Activation Fee&nbsp;</td>
    	<td><input type="checkbox" name="active_activationFee"></td>
    </tr>
    <tr>
    	<td align="left">&nbsp;ATM Fee&nbsp;</td>
    	<td><input type="checkbox" name="active_atmFee"></td>
    </tr>
    <!--  END  : Project prepaid-card-attr : Custom Fields Section --> 
    <!--  BEGIN : Project custom-page-attr : Add Prepaid Custom Text -->
    <tr>
    	<td align="left">&nbsp;Prepaid Custom Text&nbsp;</td>
    	<td><input type="checkbox" name="active_prepaidText"></td>
    </tr>
    <!--   END  : Project custom-page-attr : Add Prepaid Custom Text -->   
    <tr>
     <td colspan="2" class="componentHead">       
        Create Page Details [Default Version]
     </td>
    </tr>
    <tr>
    <tr>
     <td align=left nowrap>&nbsp;Page Title</td>
     <td align=left>
        <input type=text name=pageTitle size=120 value=''>
     </td>
    </tr>
    
    <tr>
     <td align=left nowrap>&nbsp;Page Header String</td>
     <td align=left>
        <input type=text name=pageHeaderString size=120 value=''>
     </td>
    </tr>   
    
     <tr>
     <td align=left nowrap>&nbsp;Page Header Image</td>
     <td align=left>
        <input type=text name=pageHeaderImage size=120 value=''>
     </td>
    </tr>
    
    <tr>
     <td align=left nowrap>&nbsp;Page Header Image Alt Text</td>
     <td align=left>
        <input type=text name=pageHeaderImageAltText size=120 value=''>
     </td>
    </tr>      
    
    <tr>
     <td align=left nowrap>&nbsp;Primary Navigation String</td>
     <td align=left>
        <input type=text name=primaryNavString size=120 value=''>
     </td>
    </tr>  
    
    <tr>
     <td align=left nowrap>&nbsp;Secondary Navigation String</td>
     <td align=left>
        <input type=text name=secondaryNavString size=120 value=''>
     </td>
    </tr> 
    
    <tr>
     <td align=left nowrap>&nbsp;Navigation Bar String</td>
     <td align=left>
        <input type=text name=navBarString size=120 value=''>
     </td>
    </tr>             
    
     <tr>
     <td align=left nowrap>&nbsp;Page Link <br>(No extension is necessary, this is defined by the site <br>i.e., citi-platinum.php would be just citi-platinum)</td>
     <td align=left>
        <input type=text name=pageLink size=120 value=''>
     </td>
    </tr> 
    
	<tr>
     <td align=left nowrap>&nbsp;Site Map Title</td>
     <td align=left>
        <input type=text name=siteMapTitle size=120 value=''>
     </td>
    </tr>  
    
    <tr>
     <td align=left nowrap>&nbsp;Site Map Description</td>
     <td align=left>
        <input type=text name=siteMapDescription size=120 value=''>
     </td>
    </tr>             
    
    <tr>
     <td align=left nowrap>&nbsp;Page fid</td>
     <td align=left>
        <input type=text name=fid size=120 value=''>
     </td>
    </tr>                
    
     <tr>
     <td align=left nowrap>&nbsp;Small Image</td>
     <td align=left>
        <input type=text name=pageSmallImage size=120 value=''>
     </td>
    </tr>
       
     <tr>
     <td align=left nowrap>&nbsp;Small Image Alt Text</td>
     <td align=left>
        <input type=text name=pageSmallImageAltText size=120 value=''>
     </td>
    </tr>        
    
    <tr>
     <td align=left nowrap>&nbsp;Special Offer Image</td>
     <td align=left>
        <input type=text name=pageSpecialOfferImage size=120 value=''>
     </td>
    </tr>
    
    <tr>
     <td align=left nowrap>&nbsp;Special Offer Image Alt Text</td>
     <td align=left>
        <input type=text name=pageSpecialOfferImageAltText size=120 value=''>
     </td>
    </tr>
    
    <tr>
     <td align=left nowrap>&nbsp;Special Offer Link</td>
     <td align=left>
        <input type=text name=pageSpecialOfferLink size=120 value=''>
     </td>
    </tr>    
    <tr>         
      <td align="left">&nbsp;Create Landing Page&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                    <INPUT TYPE=CHECKBOX NAME=landingPage VALUE="1" id="landingPage" onclick="javascript:showHide('landingPage', 'landingPageOptions')">
                    <div style="display: none" id="landingPageOptions">
                        <table>
                            <tr>
                                <td>FID:&nbsp;</td>
                                <td><input type=text name='landingPageFid' value=""></td>
                            </tr>
                            <tr>
                                <td>Page Image: &nbsp;</td>
                                <td><input type=text name='landingPageImage' value=""></td>
                            </tr>
                            <tr>
                                <td>Header String: &nbsp;</td>
                                <td><input type=text name='landingPageHeaderString' value=""></td>
                            </tr>
                        </table>
                    </div>                        
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>         
      <td align="left">&nbsp;Create Sub-Page Navigation&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                    <INPUT TYPE=CHECKBOX NAME=subPageNav VALUE="1">
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>         
      <td align="left">&nbsp;Flag Top Pick In Category&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                    <INPUT TYPE=CHECKBOX NAME=flagTopPick VALUE="1">
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>         
      <td align="left">&nbsp;Flag Additional Offer In Category&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<INPUT TYPE=CHECKBOX NAME=flagAdditionalOffer VALUE="1">
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <!-- <tr>         
      <td align="left">&nbsp;Associated Article Category&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<select name=associatedArticleCategory>
						<option></option>
							<?
							if(isset($this->articleCats)){
								foreach($this->articleCats as $cat){
									$selected = $_POST['associatedArticleCategory']==$cat['cat_name']?'selected':'';
									echo '<option'.$selected.'>'.$cat['cat_name'].'</option>';
								}
							}
							?>
					</select>
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    <tr>         
      <td align="left">&nbsp;Articles Per Page&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<INPUT TYPE=INUPT NAME=articlesPerPage VALUE="<?=isset($_POST['articlesPerPage']) ? $_POST['articlesPerPage'] : 0?>" size=2>
                </td>
            </tr>
        </table>
      </td>
    </tr> -->
    <tr>         
      <td align="left">&nbsp;Enable Sort&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<INPUT TYPE=CHECKBOX NAME=enableSort VALUE="1">
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>         
      <td align="left">&nbsp;Create Links on Sitemap&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<INPUT TYPE=CHECKBOX NAME=sitemapLink VALUE="1">
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    <tr>
      <td align="left">&nbsp;Items on 1st page&nbsp;</td>
      <td>                 
         <input type="text" name="itemsOnFirstPage" size="5" maxlength="5" value="">&nbsp;(Leave blank or use "All" for all cards)
      </td>
    </tr> 
    <tr>
      <td align="left">&nbsp;Show only main category on 1st page&nbsp;</td>
      <td>
         <input type="checkbox" name="showMainCatOnFirstPage" value="1">
      </td>
    </tr>    
    <tr>
        <td align="left">&nbsp;Items per page&nbsp;</td>
        <td>        
         <input type="text" name="itemsPerPage" size="5" maxlength="5" value="">&nbsp;(Leave blank or use "All" for all cards)
        </td>
    </tr>                   
    <tr>
     <td align=left nowrap>&nbsp;Top Pick In Category Alt Text</td>
     <td align=left>
        <input type=text name=topPickAltText size=120 value=''>
     </td>
    </tr>      
    
      <tr>
      <td align="left">&nbsp;Page Meta Keywords/Description (html)&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="pageMeta" COLS=80 ROWS=6></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>   
    
    <tr>
      <td align="left">&nbsp;Page Intro Description&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<TEXTAREA NAME="pageIntroDescription" COLS=80 ROWS=6></TEXTAREA>
                </td>
            </tr>
        </table>
      </td>
    </tr>         
    
    <tr>
      <td align="left">&nbsp;Page Detailed Description&nbsp;</td>
      <td align="left"><TEXTAREA NAME="pageDescription" COLS=80 ROWS=6></TEXTAREA></td>
    </tr>
     <tr>
      <td align="left">&nbsp;Page Disclaimer&nbsp;</td>
      <td align="left"><TEXTAREA NAME="pageDisclaimer" COLS=80 ROWS=6></TEXTAREA></td>
    </tr> 
    <tr>
    	<td colspan=2>
    		<br><hr><br>
    	</td>
    </tr>
   <tr>
      <td colspan=2 align="left">&nbsp;Also See&nbsp;</td>
    </tr>
    <tr>
      <td colspan=2 align="left">
    				<? $_POST['editorObject3']->create(); ?>
      </td>
    </tr>         
         
    
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=postaction value=<?=$_POST['action']?>>
      <input class=formbutton type=submit value="SAVE">   
      <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
      </td>
    </tr> 
    </table>
  </form>
</center>
<script>
    function showHide(control, id){
        var elmnt = document.getElementById(id);
        var ctrl = document.getElementById(control);
        elmnt.style.display = ctrl.checked == false?"none":"inline";
    }
    showHide("landingPage", "landingPageOptions");
</script>
