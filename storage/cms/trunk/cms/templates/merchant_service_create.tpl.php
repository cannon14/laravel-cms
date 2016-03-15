<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
  <form action=index.php method=post name=update>
 <table class='component' align='center'>
  <tr>
  <td class='componentHead' colspan=2>
  Create Merchant Service
  </td>
  </tr>
  <td align=center>
    <table class=listing width=770 border=0 cellspacing=0 cellpadding=0>
    
    <tr>
      <td align="left">&nbsp;<b>Merchant Service Id&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
  
  
					<input type='text' name='merchantServiceId' size='50' value='<?= $_POST['merchant_service_id']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
    <tr>
      <td align="left">&nbsp;<b>Merchant Service Name&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
  
  
					<input type='text' name='merchantServiceName' size='50' value='<?= $_POST['merchant_service_name']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
    <tr>
      <td align="left">&nbsp;<b>Merchant Service Link&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
  
  
					<input type='text' name='url' size='50' value='<?= $_POST['url']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left" class="card_borderbottom">&nbsp;<b>Active&nbsp;</td>
      <td align="left" class="card_borderbottom">
        <table>
            <tr>
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" checked='true'</INPUT>
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    </tr>
    <tr>
      <td align="left">&nbsp;<b>One-Time Setup Fee&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['oneTimeSetupFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeSetupFee VALUE="1" <?=$iachecked?></inpu/>     
                	<input type='text' name='setupFee' size='30' value="<?=$_POST['setup_fee']?$_POST['setup_fee']:'$@@setup_fee@@'?>">
                	<input type='text' name='d_setupFee' size='30' value="<?=$_POST['d_setup_fee']?>">
                </td>
            </tr>
        </table>
      </td>
    </tr>  
	<tr>
      <td align="left">&nbsp;<b>Application Fee&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['applicationFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeApplicationFee VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='applicationFee' size='30' value='<?=$_POST['applicationFee']?$_POST['applicationFee']:'$@@application_fee@@'?>'>
					<input type='text' name='d_applicationFee' size='30' >
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Address Verification Fee&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['addressVerificationFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeAddressVerificationFee VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='addressVerificationFee' size='30' value='<?=$_POST['addressVerificationFee']?$_POST['addressVerificationFee']:'$@@address_verification_fee@@'?>'>
					<input type='text' name='d_addressVerificationFee' size='30' >
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Monthly Minimum&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['monthlyMinimum'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeMonthlyMinimum VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='monthlyMinimum' size='30' value="<?=$_POST['monthly_minimum']?$_POST['monthly_minimum']:'$@@monthly_minimum@@'?>">
					<input type='text' name='d_monthlyMinimum' size='30' value="<?=$_POST['d_monthly_minimum']?>">                        
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    
    <tr>
      <td align="left">&nbsp;<b>Retail Discount Rate&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['discount_rate'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeDiscountRate VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='discountRate' size='30' value='<?=$_POST['discount_rate']?$_POST['discount_rate']:'@@discount_rate@@%'?>'> 
					<input type='text' name='d_discountRate' size='30' >                         
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    <tr>
      <td align="left">&nbsp;<b>Internet Discount Rate&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['internetDiscountRate'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeInternetDiscountRate VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='internetDiscountRate' size='30' value='<?=$_POST['internetDiscountRate']?$_POST['internetDiscountRate']:'$@@internet_discount_rate@@'?>'>
					<input type='text' name='d_internet_discount_rate' size='30' >
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Gateway Fee&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['gatewayFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeGatewayFee VALUE="1" <?=$iachecked?></input>  
                	<input type='text' name='gatewayFee' size='30' value='<?=$_POST['gateway_fee']?$_POST['gateway_fee']:'$@@gateway_fee@@'?>'>
                	<input type='text' name='d_gatewayFee' size='30'>
                </td>
            </tr>
        </table>
      </td>
    </tr>


    <tr>
      <td align="left">&nbsp;<b>Statement Fee&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['statementFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeStatementFee VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='statementFee' size='30' value='<?=$_POST['statement_fee']?$_POST['statement_fee']:'$@@statement_fee@@'?>'>
					<input type='text' name='d_statementFee' size='30'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Retail Transaction Fee&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['transactionFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeTransactionFee VALUE="1" <?=$iachecked?></input>  
                	<input type='text' name='transactionFee' size='30' value='<?=$_POST['transaction_fee']?$_POST['transaction_fee']:'$@@transaction_fee@@'?>'>
                	<input type='text' name='d_transactionFee' size='30' >                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
        <tr>
      <td align="left">&nbsp;<b>Internet Transaction Fee&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['internetTransactionFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeInternetTransactionFee VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='internetTransactionFee' size='30' value='<?=$_POST['internetTransactionFee']?$_POST['internetTransactionFee']:'$@@internet_transaction_fee@@'?>'>
					<input type='text' name='d_internetTransactionFee' size='30' >
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Tech Support Fee&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['techSupportFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeTechSupportFee VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='techSupportFee' size='30' value='<?=$_POST['tech_support_fee']?$_POST['tech_support_fee']:'$@@tech_support_fee@@'?>'>
					<input type='text' name='d_techSupportFee' size='30' >
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Reserve&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['reserve'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeReserve VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='reserve' size='30' value='<?=$_POST['reserve']?$_POST['reserve']:'$@@reserve@@'?>'>
					<input type='text' name='d_reserve' size='30' >
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left">&nbsp;<b>Chargeback Fee&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
                	<? if($_POST['chargebackFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeChargebackFee VALUE="1" <?=$iachecked?></input>  
					<input type='text' name='chargebackFee' size='30' value='<?=$_POST['chargebackFee']?$_POST['chargebackFee']:'$@@chargeback_fee@@'?>'>
					<input type='text' name='d_chargebackFee' size='30' >
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
  <tr>
  <td class='componentHead' colspan=2>
  Default Version Properties
  </td>
  </tr>
   <tr>
      <td align="left">&nbsp;<b>Image Path&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchantServiceImagePath' size='50' value='<?= $_POST['merchant_service_image_path']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>       
    <tr>
      <td align="left">&nbsp;<b>Merchant Service Link</b><br>(No extension is necessary, this is defined by the site <br>i.e., merchantX.php would be just merchantX)&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchantServiceLink' size='40' value='<?= $_POST['merchant_service_link']?>'>                          
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
					<input type='text' name='appLink' size='40' value='<?= $_POST['app_link']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    
     <tr>
      <td align="left">&nbsp;<b>Merchant Service Header String&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchantServiceHeaderString' size='30' value='<?= $_POST['merchant_service_header_string']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    
        <tr>
      <td align="left">&nbsp;<b>Category Image Path&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='categoryImagePath' size='30' value='<?= $_POST['categoryImagePath']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    
    <tr>
      <td align="left">&nbsp;<b>Category Image Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='categoryImageAltText' size='30' value='<?= $_POST['categoryImageAltText']?>'>                          
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
      <td align="left">&nbsp;<b>Apply Button Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='applyButtonAltText' size='30' value='<?= $_POST['apply_button_alt_text']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>         
           
    <tr>
      <td align="left">&nbsp;<b>Merchant Service Image Alt Text&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left">
					<input type='text' name='merchantServiceImageAltText' size='30' value='<?= $_POST['merchant_service_image_alt_text']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>   

    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>  	
    <tr>
      <td align="left" colspan=2>&nbsp;<b>Merchant Service Detail Text</b>&nbsp;<br><br>


    				<? $_POST['editorObject1']->create(); ?>

      </td>
    </tr> 
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>    
    <tr>
      <td align="left" colspan=2>&nbsp;<b>Merchant Service Intro Detail</b>&nbsp;<br><br>


    				<? $_POST['editorObject2']->create(); ?>

      </td>
    </tr> 
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>
      <tr>
      <td align="left" colspan=2>&nbsp;<b>Merchant Service More Detail</b>&nbsp;<br><br>


    				<? $_POST['editorObject3']->create(); ?>

      </td>
    </tr> 
           
    <tr>
    <td colspan=2><br><hr><br></td>
    </tr>
 
   
                          
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=mod value='<?=$_REQUEST['mod']?>'>
      <input type=hidden name=action value='create'>
      <input type=hidden name=postaction value='create'>
      <input class=formbutton type=submit value="Create">
       <input class=formbutton type=button value="CANCEL" onClick="goToMod('<?=$_REQUEST['mod']?>')">     
           
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>