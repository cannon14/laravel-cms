<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing width=770 border=0 cellspacing=0 cellpadding=0>
    <? QUnit_Templates::printFilter(3, L_G_CRM_CREATECARD); ?>  
	
      <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_CARDID?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardId' size='30' value='<?= $_POST['cardId']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_CARDTITLE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='cardTitle' size='50' value='<?= $_POST['cardTitle']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
    <tr>
      <td align="left" class="card_borderbottom">&nbsp;<?=L_G_ACTIVE?>&nbsp;</td>
      <td align="left" class="card_borderbottom">
        <table>
            <tr>
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" checked='true'</INPUT>
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_IMAGEPATH?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='imagePath' size='50' value='<?= $_POST['imagePath']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_MERCHANT?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchant' size='50' value='<?= $_POST['merchant']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    <tr>
      <td align="left">&nbsp;<b><?=L_G_CRM_INTROAPR?>&nbsp;</td>
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
      <td align="left">&nbsp;<b><?=L_G_CRM_INTROAPRPERIOD?>&nbsp;</td>
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
      <td align="left">&nbsp;<b><?=L_G_CRM_REGAPR?>&nbsp;</td>
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
      <td align="left">&nbsp;<b><?=L_G_CRM_ANNUALFEE?>&nbsp;</td>
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
      <td align="left">&nbsp;<b><?=L_G_CRM_MONTHLYFEE?>&nbsp;</td>
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
      <td align="left">&nbsp;<b><?=L_G_CRM_BALANCETRANSFERS?>&nbsp;</td>
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
      <td align="left">&nbsp;<b><?=L_G_CRM_CREDITNEEDED?>&nbsp;</td>
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
    <? QUnit_Templates::printFilter(3, L_G_CRM_DEFAULTVPARAMS); ?>  
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
    <td colspan=2><br><hr><br></td>
    </tr>
 
   
                          
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_CardDetailManager'>
      <input type=hidden name=action value='create'>
      <input type=hidden name=postaction value='create'>
      <input type=hidden name=eid value='<?=$_POST['siteId']?>'>
      <input class=formbutton type=submit value="<?=L_G_CREATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
