<script>
	function editVersion(ID, eid) {
		document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>&action=editVersion&versionId=" + ID + "&merchantServiceId=" + eid;

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
		padding-left: 4px BACKGROUND : #FFFFFF
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
<br><br>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<form action=index.php method=post name=update border=0>
<table class='component' align='center'>
<tr>
	<td class='componentHead' colspan=2>Edit Merchant Service</td>
</tr>
<tr>
<td align=center colspan=2>
<table class=listing border=0 width=770 cellspacing=0 cellpadding=0>
<tr>
	<td colspan=2>
		<table class="rc" align="center" cellpadding="0" cellspacing="0"
		       style="border-width:3px;border-style:solid;border-color:#cccccc;">
			<th colspan="2" class="offer-left"><a href=""><?= $_POST['merchantServiceName'] ?></a></th>
			<tr>
				<td width="15%" class="cc-card-art-align"><a href="t.php?" target="_blank">
						<img
							src="<?= $this->imageRepository ?>/<?= $_POST['defaultVersion']->fields['merchant_service_image_path'] ?>"
							width="95" height="60" border="0"><br/>
						<img border="0" src="<?= $this->imageRepository ?>/red.gif "
						     alt="<?= $_POST['defaultVersion']->fields['apply_button_alt_text'] ?>"></a>
				</td>
				<td width="85%" class="details">
					<ul><?= $_POST['defaultVersion']->fields['merchant_service_detail_text'] ?></ul>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" class="rate-rc" cellpadding="0" cellspacing="1">
						<tr>
							<? if ($_POST['activeSetupFee'] == 1) { ?>
								<td class="rate-top">Setup Fee</td><? } ?>
							<? if ($_POST['activeMonthlyMinimum'] == 1) { ?>
								<td class="rate-top">Monthly Minimum</td><? } ?>
							<? if ($_POST['activeGatewayFee'] == 1) { ?>
								<td class="rate-top">Gateway Fee</td><? } ?>
							<? if ($_POST['activeStatementFee'] == 1) { ?>
								<td class="rate-top">Statement Fee</td><? } ?>
							<? if ($_POST['activeDiscountRate'] == 1) { ?>
								<td class="rate-top">Discount Rate</td><? } ?>
							<? if ($_POST['activeTransactionFee'] == 1) { ?>
								<td class="rate-top">Transaction Fee</td><? } ?>
							<? if ($_POST['activeTechSupportFee'] == 1) { ?>
								<td class="rate-top">Tech Support Fee</td><? } ?>
						</tr>
						<tr>
							<? if ($_POST['activeSetupFee'] == 1) { ?>
								<td class="rates-bottom"><?= $_POST['m_setupFee'] ?></td><? } ?>
							<? if ($_POST['activeMonthlyMinimum'] == 1) { ?>
								<td class="rates-bottom"><?= $_POST['m_monthlyMinimum'] ?></td><? } ?>
							<? if ($_POST['activeGatewayFee'] == 1) { ?>
								<td class="rates-bottom"><?= $_POST['m_gatewayFee'] ?></td><? } ?>
							<? if ($_POST['activeStatementFee'] == 1) { ?>
								<td class="rates-bottom"><?= $_POST['m_statementFee'] ?></td><? } ?>
							<? if ($_POST['activeDiscountRate'] == 1) { ?>
								<td class="rates-bottom"><?= $_POST['m_discountRate'] ?></td><? } ?>
							<? if ($_POST['activeTransactionFee'] == 1) { ?>
								<td class="rates-bottom"><?= $_POST['m_transactionFee'] ?></td><? } ?>
							<? if ($_POST['activeTechSupportFee'] == 1) { ?>
								<td class="rates-bottom"><?= $_POST['m_techSupportFee'] ?></td><? } ?>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br/>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Merchant Service Name&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					<input type='text' name='merchantServiceName' size='70'
					       value="<?= $_POST['merchantServiceName'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;Merchant Service Link&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					<input type='text' name='url' size='70' value="<?= $_POST['url'] ?>">
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
					<? if ($_POST['active'] == 1)
						$checked = "checked='true'";
					?>
					<INPUT TYPE=CHECKBOX NAME=active VALUE="1" <?= $checked ?></INPUT>
				</td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;One-Time Setup Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeSetupFee
					             VALUE="1" <?= $_POST['activeSetupFee'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='setupFee' size='30'
					       value="<?= $_POST['setupFee'] ? $_POST['setupFee'] : '$@@setup_fee@@' ?>">
					<input type='text' name='d_setupFee' size='30' value="<?= $_POST['d_setupFee'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Application Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeApplicationFee
					             VALUE="1" <?= $_POST['activeApplicationFee'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='applicationFee' size='30'
					       value='<?= $_POST['applicationFee'] ? $_POST['applicationFee'] : '$@@application_fee@@' ?>'>
					<input type='text' name='d_application_fee' size='30' value="<?= $_POST['d_application_fee'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Address Verification Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					<? if ($_POST['addressVerificationFee'] == 1)
						$iachecked = "checked='true'";
					?>
					Show: <input type=checkbox name=activeAddressVerificationFee
					             VALUE="1" <?= $_POST['activeAddressVerificationFee'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='addressVerificationFee' size='30'
					       value='<?= $_POST['addressVerificationFee'] ? $_POST['addressVerificationFee'] : '$@@address_verification_fee@@' ?>'>
					<input type='text' name='d_address_verification_fee' size='30'
					       value="<?= $_POST['d_address_verification_fee'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Monthly Minimum&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeMonthlyMinimum
					             VALUE="1" <?= $_POST['activeMonthlyMinimum'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='monthlyMinimum' size='30'
					       value="<?= $_POST['monthlyMinimum'] ? $_POST['monthlyMinimum'] : '$@@monthly_minimum@@' ?>">
					<input type='text' name='d_monthlyMinimum' size='30' value="<?= $_POST['d_monthlyMinimum'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;Retail Discount Rate&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeDiscountRate
					             VALUE="1" <?= $_POST['activeDiscountRate'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='discountRate' size='30'
					       value='<?= $_POST['discountRate'] ? $_POST['discountRate'] : '@@discount_rate@@%' ?>'>
					<input type='text' name='d_discountRate' size='30' value='<?= $_POST['d_discountRate'] ?>'>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Internet Discount Rate&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeInternetDiscountRate
					             VALUE="1" <?= $_POST['activeInternetDiscountRate'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='internetDiscountRate' size='30'
					       value='<?= $_POST['internetDiscountRate'] ? $_POST['internetDiscountRate'] : '$@@internet_discount_rate@@' ?>'>
					<input type='text' name='d_internet_discount_rate' size='30'
					       value="<?= $_POST['d_internet_discount_rate'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Gateway Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeGatewayFee
					             VALUE="1" <?= $_POST['activeGatewayFee'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='gatewayFee' size='30'
					       value='<?= $_POST['gatewayFee'] ? $_POST['gatewayFee'] : '$@@gateway_fee@@' ?>'>
					<input type='text' name='d_gatewayFee' size='30' value='<?= $_POST['d_gatewayFee'] ?>'>
				</td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;Statement Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeStatementFee
					             VALUE="1" <?= $_POST['activeStatementFee'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='statementFee' size='30'
					       value='<?= $_POST['statementFee'] ? $_POST['statementFee'] : '$@@statement_fee@@' ?>'>
					<input type='text' name='d_statementFee' size='30' value='<?= $_POST['d_statementFee'] ?>'>
				</td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;Retail Transaction Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeTransactionFee
					             VALUE="1" <?= $_POST['activeTransactionFee'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='transactionFee' size='30'
					       value='<?= $_POST['transactionFee'] ? $_POST['transactionFee'] : '$@@transaction_fee@@' ?>'>
					<input type='text' name='d_transactionFee' size='30' value='<?= $_POST['d_transactionFee'] ?>'>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Internet Transaction Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeInternetTransactionFee
					             VALUE="1" <?= $_POST['activeInternetTransactionFee'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='internetTransactionFee' size='30'
					       value='<?= $_POST['internetTransactionFee'] ? $_POST['internetTransactionFee'] : '$@@internet_transaction_fee@@' ?>'>
					<input type='text' name='d_internet_transaction_fee' size='30'
					       value="<?= $_POST['d_internet_transaction_fee'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Tech Support Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeTechSupportFee
					             VALUE="1" <?= $_POST['activeTechSupportFee'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='techSupportFee' size='30'
					       value='<?= $_POST['techSupportFee'] ? $_POST['techSupportFee'] : '$@@tech_support_fee@@' ?>'>
					<input type='text' name='d_techSupportFee' size='30' value='<?= $_POST['d_techSupportFee'] ?>'>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Reserve&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeReserve
					             VALUE="1" <?= $_POST['activeReserve'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='reserve' size='30'
					       value='<?= $_POST['reserve'] ? $_POST['reserve'] : '$@@reserve@@' ?>'>
					<input type='text' name='d_reserve' size='30' value="<?= $_POST['d_reserve'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Chargeback Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					Show: <input type=checkbox name=activeChargebackFee
					             VALUE="1" <?= $_POST['activeChargebackFee'] == 1 ? 'checked="checked"' : ""; ?></input>
					<input type='text' name='chargebackFee' size='30'
					       value='<?= $_POST['chargebackFee'] ? $_POST['chargebackFee'] : '$@@chargeback_fee@@' ?>'>
					<input type='text' name='d_chargeback_fee' size='30' value="<?= $_POST['d_chargeback_fee'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>
</td>
</tr>
<tr>
	<td class='componentHead' colspan=2>Merchant Service Version</td>
</tr>
<tr>
	<td>Edit Version</td>
	<td>
		<SELECT NAME="add" OnChange="performAction(this);">
			<option value="-">--------------------------------</option>
			<? while (!$_POST['versions']->EOF) { ?>
				<OPTION
					VALUE="javascript:editVersion('<?= $_POST['versions']->fields['merchant_service_detail_id'] ?>', '<?= $_POST['merchantServiceId'] ?>')"><?= $_POST['versions']->fields['merchant_service_detail_label'] ?></OPTION>
				<?$_POST['versions']->MoveNext();
			}
			?>
		</SELECT>
		<br>
		<br>
	</td>
</tr>
<tr>
	<td colspan=2 align='center'><a
			href="index.php?mod=<?= $_REQUEST['mod'] ?>&action=createVersion&merchantServiceId=<?= $_POST['merchantServiceId'] ?>">Create
			New Version</a><br><br></td>
</tr>
<tr>
	<td colspan=2 align=center>
		<input type=hidden name=commited value=yes>
		<input type=hidden name=mod value="<?= $_REQUEST['mod'] ?>">
		<input type=hidden name=action value='update'>
		<input type=hidden name=postaction value='update'>
		<input type=hidden name=merchantServiceId value="<?= $_POST['merchantServiceId'] ?>">
		<input class=formbutton type=submit value="UPDATE">
		<input class=formbutton type=button value="CANCEL" onClick="goToMod('<?= $_REQUEST['mod'] ?>')">
	</td>
</tr>
</table>
</form>
</center>