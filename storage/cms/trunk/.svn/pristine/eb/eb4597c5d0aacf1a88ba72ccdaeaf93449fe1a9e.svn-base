<script>

    function changeVersion(cardID, dataVersion) {
        version = document.getElementById('version_id').value
        document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&action=editVersion&version_id=" + version +"&cardpageId=" + cardID + "&data_from_version=" + dataVersion;
    }

    function loaddefvals(cardId) {
        if (confirm('Are you sure you want to reset page details to default version?')) {
            changeVersion(cardId, -1);
        }
    }

    function validate_page_edit() {

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
<form action=index.php method=post name=update onsubmit="return validate_page_edit();">
    <table class='component' align='center'>
        <tr>
            <td colspan=2 class='componentHead'>
                Edit Page [<?=$_POST['pageName']?>]
            </td>
        </tr>
        <tr>
            <td align=left nowrap>&nbsp;Page Name</td>
            <td align=left>
                <input type=text name=pageName size=120 value='<?=$_POST['pageName']?>'>
            </td>
        </tr>
        <tr>
			<td align="left">&nbsp;Rollup in sitemap&nbsp;</td>
			<td align="left">
				<table>
					<tr>
						<td align="left">
							<input type="radio" value="1" name=rollup <?=$_POST['rollup'] == 1 ? 'checked' : '' ?>/>&nbsp;Yes<br>
							<input type="radio" value="2" name=rollup <?=$_POST['rollup'] == 2 ? 'checked' : '' ?>/>&nbsp;No
						</td>
					</tr>
				</table>
			</td>
        </tr>
        <?$active_checked = $_POST['active'] == 1?'checked':''?>
        <tr>
            <td align="left">&nbsp;Active&nbsp;</td>
            <td align="left">
                <table>
                    <tr>
                        <td align="left">
                            <INPUT TYPE=CHECKBOX NAME=active VALUE="1" <?=$active_checked?> />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td align="left">&nbsp;Page Type&nbsp;</td>
            <td><select name="pageType">
                    <option <?=$_POST['pageType']=='BANK'?'selected':''?> value="BANK">bank</option>
                    <option <?=$_POST['pageType']=='CREDIT'?'selected':''?> value="CREDIT">credit</option>
                    <option <?=$_POST['pageType']=='TYPE'?'selected':''?> value="TYPE">type</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="left">&nbsp;Content Type&nbsp;</td>
            <td><select name=contentType>
                    <option <?=$_POST['contentType']=='card'?'selected':''?>>card</option>
                    <option <?=$_POST['contentType']=='merchant service'?'selected':''?>>merchant service</option>
                    <option <?=$_POST['contentType']=='specials'?'selected':''?>>specials</option>
                    <option <?=$_POST['contentType']=='altspecials'?'selected':''?>>altspecials</option>
                    <option <?=$_POST['contentType']=='index'?'selected':''?>>index</option>
                    <option <?=$_POST['contentType']=='profile'?'selected':''?>>profile</option>
                    <option <?=$_POST['contentType']=='merchant service application'?'selected':''?>>merchant service application</option>
                </select>
            </td>
        </tr>
    	<tr>
    		<td align="left">&nbsp;Schumer Box Type&nbsp;</td>
    		<td><select name="schumerType">
    				<option <?=$_POST['schumerType']=='STANDARD'?'selected':''?> value="STANDARD">Standard</option>
    				<option <?=$_POST['schumerType']=='PREPAID'?'selected':''?> value="PREPAID">Prepaid/Debit</option>
    			</select>
    		</td>
    	</tr>
        <tr>
            <td align="left">&nbsp;<?=USE_CHAMELEON?>&nbsp;</td>
            <?$checked = $_POST['useChameleon']?'checked':''?>
            <td><input type="checkbox" name="useChameleon" <?=$checked?>></td>
        </tr>
        <!-- START : Project prepaid-card-attr : Custom Fields Section -->
        <tr>
            <td colspan="2" class="componentHead">
                Custom Fields
            </td>
        </tr>
        <tr>
            <td align="left">&nbsp;Intro APR&nbsp;</td>
            <?$checked = $_POST['active_introApr']?'checked':''?>
            <td><input type="checkbox" name="active_introApr" <?=$checked?>></td><!-- Default to checked per spec -->
        </tr>
        <tr>
            <td align="left">&nbsp;Intro APR Period&nbsp;</td>
            <?$checked = $_POST['active_introAprPeriod']?'checked':''?>
            <td><input type="checkbox" name="active_introAprPeriod" <?=$checked?>></td><!-- Default to checked per spec -->
        </tr>
        <tr>
            <td align="left">&nbsp;Regular APR&nbsp;</td>
            <?$checked = $_POST['active_regularApr']?'checked':''?>
            <td><input type="checkbox" name="active_regularApr" <?=$checked?>></td><!-- Default to checked per spec -->
        </tr>
        <tr>
            <td align="left">&nbsp;Annual Fee&nbsp;</td>
            <?$checked = $_POST['active_annualFee']?'checked':''?>
            <td><input type="checkbox" name="active_annualFee" <?=$checked?>></td><!-- Default to checked per spec -->
        </tr>
        <tr>
            <td align="left">&nbsp;Monthly Fee (up&nbsp;to)&nbsp;</td>
            <?$checked = $_POST['active_monthlyFee']?'checked':''?>
            <td><input type="checkbox" name="active_monthlyFee" <?=$checked?>></td>
        </tr>
        <tr>
            <td align="left">&nbsp;Balance Transfers&nbsp;</td>
            <?$checked = $_POST['active_balanceTransfers']?'checked':''?>
            <td><input type="checkbox" name="active_balanceTransfers" <?=$checked?>></td><!-- Default to checked per spec -->
        </tr>
        <tr>
            <td align="left">&nbsp;Balance Transfer Fee&nbsp;</td>
            <?$checked = $_POST['active_balanceTransferFee']?'checked':''?>
            <td><input type="checkbox" name="active_balanceTransferFee" <?=$checked?>></td>
        </tr>
        <tr>
            <td align="left">&nbsp;Balance Transfer Intro APR&nbsp;</td>
            <?$checked = $_POST['active_balanceTransferIntroApr']?'checked':''?>
            <td><input type="checkbox" name="active_balanceTransferIntroApr" <?=$checked?>></td>
        </tr>
        <tr>
            <td align="left">&nbsp;Balance Transfer Intro APR Period&nbsp;</td>
            <?$checked = $_POST['active_balanceTransferIntroAprPeriod']?'checked':''?>
            <td><input type="checkbox" name="active_balanceTransferIntroAprPeriod" <?=$checked?>></td>
        </tr>
        <tr>
            <td align="left">&nbsp;Credit Needed&nbsp;</td>
            <?$checked = $_POST['active_creditNeeded']?'checked':''?>
            <td><input type="checkbox" name="active_creditNeeded" <?=$checked?>></td><!-- Default to checked per spec -->
        </tr>
        <tr>
            <td align="left">&nbsp;Transaction Fee (Signature)&nbsp;</td>
            <?$checked = $_POST['active_transactionFeeSignature']?'checked':''?>
            <td><input type="checkbox" name="active_transactionFeeSignature" <?=$checked?>></td>
        </tr>
        <tr>
            <td align="left">&nbsp;Transaction Fee (PIN)&nbsp;</td>
            <?$checked = $_POST['active_transactionFeePin']?'checked':''?>
            <td><input type="checkbox" name="active_transactionFeePin" <?=$checked?>></td>
        </tr>
        <tr>
            <td align="left">&nbsp;Load Fee&nbsp;</td>
            <?$checked = $_POST['active_loadFee']?'checked':''?>
            <td><input type="checkbox" name="active_loadFee" <?=$checked?>></td>
        </tr>
        <tr>
            <td align="left">&nbsp;Activation Fee&nbsp;</td>
            <?$checked = $_POST['active_activationFee']?'checked':''?>
            <td><input type="checkbox" name="active_activationFee" <?=$checked?>></td>
        </tr>
        <tr>
            <td align="left">&nbsp;ATM Fee&nbsp;</td>
            <?$checked = $_POST['active_atmFee']?'checked':''?>
            <td><input type="checkbox" name="active_atmFee" <?=$checked?>></td>
        </tr>
        <!--  END  : Project prepaid-card-attr : Custom Fields Section -->
        <!--  BEGIN : Project custom-page-attr : Add Prepaid Custom Text -->
        <tr>
    		<td align="left">&nbsp;Prepaid Custom Text&nbsp;</td>
    		<?$checked = $_POST['active_prepaidText']?'checked':''?>
    		<td><input type="checkbox" name="active_prepaidText" <?=$checked?>></td>
    	</tr>
        <!--   END  : Project custom-page-attr : Add Prepaid Custom Text -->   
        <tr>
            <td colspan="2" class="componentHead">
                Edit Page Details [<?=$_POST['version_name'] ?>]
            </td>
        </tr>
        <tr>
            <td align=left nowrap>&nbsp;Currently Editing Version (* = Active)</td>
            <td align=left>
                <?=$_POST['selectExisitngVersion']?>
                <input type=button name=copyDefaultVersion value="Copy Default Version details to this version" onClick="loaddefvals(<?=$_POST['cardpageId']?>)"/>
            </td>
        </tr>
        <tr>
            <td align=left nowrap>&nbsp;Active Version </td>
            <td align=left>
                <input type=checkbox name=version_active value="1" <?=($_POST['version_active'] == 1 ? 'checked' : '')?> />
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Page Title</td>
            <td align=left>
                <input type=text name=pageTitle size=120 value='<?=$_POST['pageTitle']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Page Header String</td>
            <td align=left>
                <input type=text name=pageHeaderString size=120 value='<?=$_POST['pageHeaderString']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Page Header Image</td>
            <td align=left>
                <input type=text name=pageHeaderImage size=120 value='<?=$_POST['pageHeaderImage']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Page Header Image Alt Text</td>
            <td align=left>
                <input type=text name=pageHeaderImageAltText size=120 value='<?=$_POST['pageHeaderImageAltText']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Primary Navigation String</td>
            <td align=left>
                <input type=text name=primaryNavString size=120 value='<?=$_POST['primaryNavString']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Secondary Navigation String</td>
            <td align=left>
                <input type=text name=secondaryNavString size=120 value='<?=$_POST['secondaryNavString']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Navigation Bar String</td>
            <td align=left>
                <input type=text name=navBarString size=120 value='<?=$_POST['navBarString']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Page Link <br>(No extension is necessary, this is defined by the site <br>i.e., citi-platinum.php would be just citi-platinum)</td>
            <td align=left>
                <input type=text name=pageLink size=120 value='<?=$_POST['pageLink']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Site Map Title</td>
            <td align=left>
                <input type=text name=siteMapTitle size=120 value='<?=$_POST['siteMapTitle']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Site Map Description</td>
            <td align=left>
                <input type=text name=siteMapDescription size=120 value='<?=$_POST['siteMapDescription']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Page fid</td>
            <td align=left>
                <input type=text name=fid size=120 value='<?=$_POST['fid']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Small Image</td>
            <td align=left>
                <input type=text name=pageSmallImage size=120 value='<?=$_POST['pageSmallImage']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Small Image Alt Text</td>
            <td align=left>
                <input type=text name=pageSmallImageAltText size=120 value='<?=$_POST['pageSmallImageAltText']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Special Offer Image</td>
            <td align=left>
                <input type=text name=pageSpecialOfferImage size=120 value='<?=$_POST['pageSpecialOfferImage']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Special Offer Image Alt Text</td>
            <td align=left>
                <input type=text name=pageSpecialOfferImageAltText size=120 value='<?=$_POST['pageSpecialOfferImageAltText']?>'>
            </td>
        </tr>

        <tr>
            <td align=left nowrap>&nbsp;Special Offer Link</td>
            <td align=left>
                <input type=text name=pageSpecialOfferLink size=120 value='<?=$_POST['pageSpecialOfferLink']?>'>
            </td>
        </tr>
        <?$landing_checked = $_POST['landingPage'] == 1?'checked':''?>
        <tr>
            <td align="left">&nbsp;Create Landing Page&nbsp;</td>
            <td align="left">
                <table>
                    <tr>
                        <td align="left">
                            <INPUT TYPE=CHECKBOX ID=landingPage NAME=landingPage VALUE="1" <?=$landing_checked?> onclick="javascript:showHide('landingPage', 'landingPageOptions')"/>
                            <div style="display: none" id="landingPageOptions">
                                <table>
                                    <tr>
                                        <td>FID:&nbsp;</td>
                                        <td><input type=text name='landingPageFid' value="<?=$_POST['landingPageFid']?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Page Image: &nbsp;</td>
                                        <td><input type=text name='landingPageImage' value="<?=$_POST['landingPageImage']?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Header String: &nbsp;</td>
                                        <td><input type=text name='landingPageHeaderString' value="<?=$_POST['landingPageHeaderString']?>"></td>
                                    </tr>
                                </table>
                            </div>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?$nav_checked = $_POST['subPageNav'] == 1?'checked':''?>
        <tr>
            <td align="left">&nbsp;Create Sub-Page Navigation&nbsp;</td>
            <td align="left">
                <table>
                    <tr>
                        <td align="left">
                            <INPUT TYPE=CHECKBOX NAME=subPageNav VALUE="1" <?=$nav_checked?> />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?$flag_checked = $_POST['flagTopPick'] == 1?'checked':''?>
        <tr>
            <td align="left">&nbsp;Flag Top Pick In Category&nbsp;</td>
            <td align="left">
                <table>
                    <tr>
                        <td align="left">
                            <INPUT TYPE=CHECKBOX NAME=flagTopPick VALUE="1" <?=$flag_checked?> />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?$flagAdd_checked = $_POST['flagAdditionalOffer'] == 1?'checked':''?>
        <tr>
            <td align="left">&nbsp;Flag Additional Offer In Category&nbsp;</td>
            <td align="left">
                <table>
                    <tr>
                        <td align="left">
                            <INPUT TYPE=CHECKBOX NAME=flagAdditionalOffer VALUE="1" <?=$flagAdd_checked?>>
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
    if(is_array($this->articleCats)){
        foreach($this->articleCats as $cat){
            $selected = $_POST['associatedArticleCategory']==$cat['cat_name']?'selected':'';
            echo '<option '.$selected.'/>'.$cat['cat_name'].'</option>';
        }
    }
}?>
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
</tr> 
<?
$sort_checked = ''; 
if($_POST['enableSort'] == 1)
$sort_checked = "checked='true'";
?>

        <tr> -->
        <td align="left">&nbsp;Enable Sort&nbsp;</td>
        <td align="left">
            <table>
                <tr>
                    <td align="left">
                        <INPUT TYPE=CHECKBOX NAME=enableSort VALUE="1" <?=$sort_checked?>>
                    </td>
                </tr>
            </table>
        </td>
        </tr>
        <? $sitemapLink_checked = $_POST['sitemapLink']==1?'checked':''?>
        <tr>
            <td align="left">&nbsp;Create Links on Sitemap&nbsp;</td>
            <td align="left">
                <table>
                    <tr>
                        <td align="left">
                            <INPUT TYPE=CHECKBOX NAME=sitemapLink VALUE="1" <?=$sitemapLink_checked?>>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left">&nbsp;Items on 1st page&nbsp;</td>
            <td>
                <input type="text" name="itemsOnFirstPage" size="5" maxlength="5" value="<?=$_POST['itemsOnFirstPage'] == 99999?'All':$_POST['itemsOnFirstPage'];; ?>">&nbsp;(Leave blank or use "All" for all cards)
            </td>
        </tr>
        <tr>
            <td align="left">&nbsp;Show only main category on 1st page&nbsp;</td>
            <td>
                <?
                // is the isset check really needed here in the edit tpl?
                if($_POST['showMainCatOnFirstPage'] == 1)
                {
                    $checked = 'checked';
                }
                else
                {
                    $checked = '';
                }
                ?>
                <input type="checkbox" name="showMainCatOnFirstPage" <?=$checked; ?> value="1">
            </td>
        </tr>
        <tr>
            <td align="left">&nbsp;Items per page&nbsp;</td>
            <td>
                <input type="text" name="itemsPerPage" size="5" maxlength="5" value="<?=$_POST['itemsPerPage'] == 99999?'All':$_POST['itemsPerPage'];?>">&nbsp;(Leave blank or use "All" for all cards)
            </td>
        </tr>
        <tr>
            <td align=left nowrap>&nbsp;Top Pick In Category Alt Text</td>
            <td align=left>
                <input type=text name=topPickAltText size=120 value='<?=$_POST['topPickAltText']?>'>
            </td>
        </tr>
        <tr>
            <td align="left">&nbsp;Page Meta Keywords/Description (html)&nbsp;</td>
            <td align="left"><TEXTAREA NAME="pageMeta" COLS=80 ROWS=6><?=$_POST['pageMeta']?></TEXTAREA></td>
        </tr>

        <tr>
            <td align="left">&nbsp;Page Intro Description&nbsp;</td>
            <td align="left"><TEXTAREA NAME="pageIntroDescription" ID="pageIntroDescription" COLS=80 ROWS=6><?=$_POST['pageIntroDescription']?></TEXTAREA></td>
        </tr>

        <tr>
            <td align="left">&nbsp;Page Detailed Description&nbsp;</td>
            <td align="left"><TEXTAREA NAME="pageDescription" COLS=80 ROWS=6><?=$_POST['pageDescription']?></TEXTAREA></td>
        </tr>
        <tr>
            <td align="left">&nbsp;Page Disclaimer&nbsp;</td>
            <td align="left">
                <TEXTAREA NAME="pageDisclaimer" COLS=80 ROWS=6><?=$_POST['pageDisclaimer']?></TEXTAREA>

            </td>
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
            <td colspan=2 align="left">&nbsp;Learn More&nbsp;</td>
        </tr>
        <tr>
            <td colspan=2 align="left"><? $_POST['editorObject']->create(); ?></td>
        </tr>


        <tr>
            <td colspan=3 align=center>
                <input type=hidden name=commited value=yes>
                <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
                <input type=hidden name=pageDetailVersion value=<?=$_REQUEST['versionId']?>>
                <input type=hidden name=action value=<?=$_POST['action']?>>
                <input type=hidden name=postaction value=<?=$_POST['action']?>>
                <input type=hidden name=cardpageId value='<?=$_POST['cardpageId']?>'>
                <input type=hidden name=type value='<?=isset($_REQUEST['type']) ? $_REQUEST['type'] : ''?>'>
                <input class=formbutton type=submit value="SAVE">
                <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">
            </td>
        </tr>
    </table>
</form>
<script>
    function showHide(control, id){
        var elmnt = document.getElementById(id);
        var ctrl = document.getElementById(control);
        elmnt.style.display = ctrl.checked == false?"none":"inline";
    }
    showHide("landingPage", "landingPageOptions");
</script>
