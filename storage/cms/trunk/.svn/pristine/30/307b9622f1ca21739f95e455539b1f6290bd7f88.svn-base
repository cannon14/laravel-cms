<link rel="stylesheet" href="css/cardEdit.css" type="text/css"/>
<script type="text/javascript" src="js/cardEdit.js"></script>

<br>
<br>
<form action="index.php" method="post" name="update">
	<table class='component' align='center'>
		<tr>
			<td class='componentHead' colspan="2">Edit Card</td>
		</tr>
		<tr>
			<td align="center">
<table class="listing" border="0" width="770" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2">
		<table class="rc" align="center" cellpadding="0" cellspacing="0"
		       style="border-width: 3px; border-style: solid; border-color: #cccccc;">
			<tr>
				<th colspan="2">
					<a href=""><?= $_POST['cardTitle'] ?></a> (<span id="productId"  style="color: red;"><?= $_POST['cardId'] ?></span>)
				</th>
			</tr>
			<tr>
				<td width="15%" class="cc-card-art-align">
					<a href="t.php?" target="_blank">
						<img src="<?= $this->imageRepository ?>/<?= $_POST['imagePath'] ?>"	width="95" height="60" border="0"><br/>
						<img border="0" src="<?= $this->imageRepository ?>/red.gif ">
					</a>
				</td>
				<td width="85%" class="details">
					<ul>
						<?= $_POST['defaultVersion']->fields['cardDetailText'] ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" class="rate-rc" cellpadding="0"
					       cellspacing="1">
						<tr>
							<? if ($_POST['active_introApr'] == 1) { ?>
								<td class="rate-top">Intro APR</td>

							<?
							}
							if ($_POST['active_introAprPeriod'] == 1) {
								?>
								<td class="rate-top">Intro APR Period</td>
							<?
							}
							if ($_POST['active_regularApr'] == 1) {
								?>
								<td class="rate-top">Regular APR</td>
							<?
							}
							if ($_POST['active_annualFee'] == 1) {
								?>
								<td class="rate-top">Annual Fee</td>
							<?
							}
							if ($_POST['active_monthlyFee'] == 1) {
								?>
								<td class="rate-top">Monthly Fee (up&nbsp;to)</td>
							<?
							}
							if ($_POST['active_balanceTransfers'] == 1) {
								?>
								<td class="rate-top">Balance Transfers</td>
							<?
							}
							if ($_POST['active_balanceTransferIntroApr'] == 1) {
								?>
								<td class="rate-top">Balance Transfer Intro APR</td>
							<?
							}
							if ($_POST['active_balanceTransferIntroAprPeriod'] == 1) {
								?>
								<td class="rate-top">Balance Transfer Intro Period</td>
							<?
							}
							if ($_POST['active_balanceTransferFee'] == 1) {
								?>
								<td class="rate-top">Balance Transfer Fee</td>
							<?
							}
							if ($_POST['active_creditNeeded'] == 1) {
								?>
								<td class="rate-top">Credit Needed</td>
							<? } ?>
						</tr>
						<tr>
							<? if ($_POST['active_introApr'] == 1) { ?>
								<td class="rates-bottom"><?= $_POST['m_introApr'] ?></td>
							<?
							}
							if ($_POST['active_introAprPeriod'] == 1) {
								?>
								<td class="rates-bottom"><?= $_POST['m_introAprPeriod'] ?></td>
							<?
							}
							if ($_POST['active_regularApr'] == 1) {
								?>
								<td class="rates-bottom"><?= $_POST['m_regularApr'] ?></td>
							<?
							}
							if ($_POST['active_annualFee'] == 1) {
								?>
								<td class="rates-bottom"><?= $_POST['m_annualFee'] ?></td>
							<?
							}
							if ($_POST['active_monthlyFee'] == 1) {
								?>
								<td class="rates-bottom"><?= $_POST['m_monthlyFee'] ?></td>
							<?
							}
							if ($_POST['active_balanceTransfers'] == 1) {
								?>
								<td class="rates-bottom"><?= $_POST['m_balanceTransfers'] ?></td>
							<?
							}
							if ($_POST['active_balanceTransferIntroApr'] == 1) {
								?>
								<td class="rates-bottom"><?= $_POST['m_balanceTransferIntroApr'] ?></td>
							<?
							}
							if ($_POST['active_balanceTransferIntroAprPeriod'] == 1) {
								?>
								<td class="rates-bottom"><?= $_POST['m_balanceTransferIntroAprPeriod'] ?></td>
							<?
							}
							if ($_POST['active_balanceTransferFee'] == 1) {
								?>
								<td class="rates-bottom"><?= $_POST['m_balanceTransferFee'] ?></td>
							<?
							}
							if ($_POST['active_creditNeeded'] == 1) {
								?>
								<td class="rates-bottom"><?= $_POST['m_creditNeeded'] ?></td>
							<? } ?>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br/>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Site Code&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><?
					if (isset($_POST['site_code'])) {
						$siteCode = $_POST['site_code'];
					} else {
						$siteCode = '';
					}
					$siteCodes = CMS_libs_Cards::getSiteCodes();

					$numSiteCodes = $siteCodes->numRows();
					?>
						<select name="site_code">
						<option value="">-Select a site code-</option>
						<?
						while ($siteCodes && !$siteCodes->EOF) {
							?>
							<option value="<?= $siteCodes->fields['site_code']; ?>"
								<?= $siteCode == $siteCodes->fields['site_code'] ? 'selected' : ''; ?>><?= $siteCodes->fields['site_description']; ?></option>
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
	<td align="left">&nbsp;Internal Name&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><input type='text' name='cardDescription'
				                        size='100' value="<?= $_POST['cardDescription'] ?>">
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Card Title&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><input type='text' name='cardTitle'
				                        size='100' disabled="disabled"
				                        value="<?= $_POST['cardTitle'] ?>"></td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;Card Network&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					<select name='network_id' id="network_id_select">
						<option value="-1">Select One</option>
						<?php if (!empty($this->allNetworks)): ?>
							<?php foreach ($this->allNetworks as $network): ?>
								<?php $selected = $_POST['network_id'] == $network['network_id'] ? "selected" : "" ?>
								<option
									value="<?= $network['network_id'] ?>" <?= $selected ?>><?= $network['name'] ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</td>
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
				                        value="<?= $_POST['applyByPhoneNumber'] ?>"></td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;Active&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><? $checked = '';
					if ($_POST['active'] == 1)
						$checked = "checked='true'";
					?>
					<input type="CHECKBOX" name="active" disabled="disabled" value="1"
						<?= $checked ?> /></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Suppress on Mobile</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><?php $checked = '';
					if ($_POST['suppress_mobile'] == 1)
						$checked = 'checked="true"';
					?>
					<input type="checkbox" value="1" name="suppress_mobile" <?= $checked ?> />
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
<tr>
	<td align="left">&nbsp;Build Enhanced Product Details Pages</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><input type="checkbox"
				                        name="active_epd_pages" value="1"
						<?= $_POST['active_epd_pages'] == 1 ? 'checked="checked"' : '' ?> />
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
						<?= $_POST['active_show_epd_rates'] == 1 ? 'checked="checked"' : '' ?> />
					(Only applicable if enhanced product detail pages are turned on)
				</td>
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
					<input type="text" size="100" name="show_verify" value="<?= $_POST['show_verify'] ?>"
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Image Path&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><input type='text' name='imagePath'
				                        size='100' disabled="disabled"
				                        value="<?= $_POST['imagePath'] ?>"></td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;T-Page Text&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><input type='text' name='tPageText'
				                        size='100' value="<?= $_POST['tPageText'] ?>"></td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;Card Merchant&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><select name='merchant' disabled="disabled">
						<? foreach ($this->allMerchants as $merchant) { ?>
							<? $selected = $_POST['merchant'] == $merchant['merchantid'] ? "selected" : "" ?>
							<option
								value="<?= $merchant['merchantid'] ?>" <?= $selected ?>><?= $merchant['merchantname'] ?></option>
						<? } ?>
					</select></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Secured&nbsp;</td>
	<td align="left">
		<input type="checkbox" name="secured" value="1" <?= $_POST['secured'] == 1 ? 'checked="checked"' : '' ?> />
		(Checking this option will enable the use of the Insulator Web Service for securing Offer Clicks. Only use this
		option if the Issuer is setup in the Insulator.)
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Intro APR&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					<?php
					$iachecked = '';
					if ($_POST['active_introApr'] == 1) {
						$iachecked = "checked='true'";
					}
					?>
					Show: <input type="CHECKBOX" name="active_introApr" value="1"
						<?= $iachecked ?> /> <input type='text' name='introApr'
					                                size='40' value="<?= $_POST['introApr'] ?>"/> <input
						type='text' name='d_introApr' size='40' disabled="disabled"
						value="<?= $_POST['d_introApr'] ?>"/></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Intro APR Period&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><? $iapchecked = '';
					if ($_POST['active_introAprPeriod'] == 1)
						$iapchecked = "checked='true'";
					?>
					Show: <input type="CHECKBOX" name="active_introAprPeriod"
					             value="1" <?= $iapchecked ?> /> <input type='text'
					                                                    name='introAprPeriod' size='40'
					                                                    value="<?= $_POST['introAprPeriod'] ?>"/> <input
						type='text' name='d_introAprPeriod' size='40' disabled="disabled"
						value="<?= $_POST['d_introAprPeriod'] ?>"/></td>
			</tr>
		</table>
	</td>
</tr>

<tr>
	<td align="left">&nbsp;Regular APR&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					<?php
					$rachecked = '';
					if ($_POST['active_regularApr'] == 1) {
						$rachecked = "checked='true'";
					}
					?>
					Show: <input type="CHECKBOX" name="active_regularApr" value="1"
						<?= $rachecked ?> /><input type='text' name='regularApr'
					                               size='40' value="<?= $_POST['regularApr'] ?>"/> <input
						type='text' name='d_regularApr' size='40' disabled="disabled"
						value="<?= $_POST['d_regularApr'] ?>"/></td>
			</tr>
		</table>
	</td>
</tr>


<tr>
	<td align="left">&nbsp;Annual Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					<?php
					$afchecked = '';
					if ($_POST['active_annualFee'] == 1)
						$afchecked = "checked='true'";
					?>
					Show: <input type="CHECKBOX" name="active_annualFee" value="1"
						<?= $afchecked ?> /><input type='text' name='annualFee'
					                               size='40' value="<?= $_POST['annualFee'] ?>"/> <input
						type='text' name='d_annualFee' size='40' disabled="disabled"
						value="<?= $_POST['d_annualFee'] ?>"/></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Monthly Fee (up&nbsp;to)&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><? $mfchecked = '';
					if ($_POST['active_monthlyFee'] == 1)
						$mfchecked = "checked='true'";
					?>
					Show: <input type='checkbox' name='active_monthlyFee' value='1'
						<?= $mfchecked ?>> <input type='text' name='monthlyFee'
					                              size='40' value="<?= $_POST['monthlyFee'] ?>"> <input
						type='text' name='d_monthlyFee' size='40' disabled="disabled"
						value="<?= $_POST['d_monthlyFee'] ?>"></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Balance Transfers&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><?
					$btchecked = '';
					if ($_POST['active_balanceTransfers'] == 1) {
						$btchecked = "checked='true'";
					}

					$d_balancetransfers = isset($_POST['d_balancetransfers']) ? $_POST['d_balancetransfers'] : '';

					?>
					Show: <input type="CHECKBOX" name="active_balanceTransfers"
					             value="1" <?= $btchecked ?> /> <input type='text'
					                                                   name='balanceTransfers' size='40'
					                                                   value="<?= $_POST['balanceTransfers'] ?>"/>
					<select
						name='d_balanceTransfers' disabled="disabled">
						<option
							<?= ($d_balancetransfers == 0) ? "selected" : "" ?>
							value="0">N/A
						</option>
						<option
							<?= ($d_balancetransfers == 1) ? "selected" : "" ?>
							value="1">Yes
						</option>
					</select></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Balance Transfer Fee&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><? $btchecked = $_POST['active_balanceTransferFee'] == 1 ? "checked='true'" : ''; ?>
					Show: <input type="CHECKBOX" name="active_balanceTransferFee"
					             value="1" <?= $btchecked ?> /> <input type='text'
					                                                   name='balanceTransferFee' size='40'
					                                                   value="<?= $_POST['balanceTransferFee'] ?>"/>
					<input
						type='text' name='d_balanceTransferFee' size='40'
						disabled="disabled"
						value="<?= $_POST['d_balanceTransferFee'] ?>"/></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Balance Transfer Intro APR&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><? $btchecked = $_POST['active_balanceTransferIntroApr'] == 1 ? "checked='true'" : ''; ?>
					Show: <input type="CHECKBOX" name="active_balanceTransferIntroApr"
					             value="1" <?= $btchecked ?> /> <input type='text'
					                                                   name='balanceTransferIntroApr' size='40'
					                                                   value="<?= $_POST['balanceTransferIntroApr'] ?>"/>
					<input
						type='text' name='d_balanceTransferIntroApr' size='40'
						disabled="disabled"
						value="<?= $_POST['d_balanceTransferIntroApr'] ?>"/></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Balance Transfer Intro APR Period&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left"><? $btchecked = $_POST['active_balanceTransferIntroAprPeriod'] == 1 ? "checked='true'" : ''; ?>
					Show: <input type="CHECKBOX"
					             name="active_balanceTransferIntroAprPeriod" value="1"
						<?= $btchecked ?> /> <input type='text'
					                                name='balanceTransferIntroAprPeriod' size='40'
					                                value="<?= $_POST['balanceTransferIntroAprPeriod'] ?>"/>
					<input type='text' name='d_balanceTransferIntroAprPeriod'
					       size='40' disabled="disabled"
					       value="<?= $_POST['d_balanceTransferIntroAprPeriod'] ?>"/>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;Credit Needed&nbsp;</td>
	<td align="left">
		<table>
			<tr>
				<td align="left">
					<?php $cnchecked = $_POST['active_creditNeeded'] == 1 ? "checked='true'" : ''; ?>
					Show: <input type="CHECKBOX" name="active_creditNeeded" value="1"
						<?= $cnchecked ?> /> <input type='text' name='creditNeeded'
					                                size='40' value="<?= $_POST['creditNeeded'] ?>"/> <select
						name='d_creditNeeded' disabled="disabled">
						<option <?= ($_POST['d_creditNeeded'] == 0) ? "selected" : "" ?>
							value="0">No Credit Check
						</option>
						<option <?= ($_POST['d_creditNeeded'] == 1) ? "selected" : "" ?>
							value="1">Bad credit OK
						</option>
						<option <?= ($_POST['d_creditNeeded'] == 2) ? "selected" : "" ?>
							value="2">Fair Credit
						</option>
						<option <?= ($_POST['d_creditNeeded'] == 3) ? "selected" : "" ?>
							value="3">Good Credit
						</option>
						<option <?= ($_POST['d_creditNeeded'] == 4) ? "selected" : "" ?>
							value="4">Excellent Credit
						</option>
					</select></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2" class='componentHead'>Site History</td>
</tr>
<tr>
	<td colspan="2">
		<table align='center'>
			<tr>
				<td align="center" width='50%' colspan="2"><b>Non-Historical Sites</b></td>
				<td colspan="2" align="center" width='50%'><b>Recent Sites (Added in the last 5 days)</b></td>
			</tr>
			<tr>
				<td width='50%' colspan="2"><select name='unassignedSitesFacade[]'
				                                    id='unassignedSitesFacade' style="width: 300px" size="10" multiple>
						<? foreach ($this->unassignedSites as $site) { ?>
							<option value="<?= $site['siteId'] ?>"><?= $site['siteName'] ?></option>
						<? } ?>
					</select>
					<select name='unassignedSites[]' id='unassignedSites' multiple style="display: none"></select>
					<br>

					<p align="center"><input class="formbutton" type="button"
					                         onclick="siteHistory_one2two()" value=" Add to history >> "></p>
				</td>

				<td align="center" colspan="2" width='50%'><select
						name='assignedSitesFacade[]' id='assignedSitesFacade' style="width: 300px"
						size="10" multiple>
						<? foreach ($this->recentlyAssignedSites as $site) { ?>
							<option value="<?= $site['siteId'] ?>"><?= $site['siteName'] ?></option>
						<? } ?>
					</select>
					<select name='assignedSites[]' id='assignedSites' multiple style="display: none"></select>
					<br>

					<p align="center"><input class="formbutton" type="button"
					                         onclick="siteHistory_two2one()" value=" << Remove from history"></p>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="4"><b>All Historical Sites</b></td>
			</tr>
			<tr>
				<td align="center" colspan="4">
					<textarea
						id='assignedSites'
						style="width: 100%"
						rows="10"
						cols="80"
						readonly><? foreach ($this->assignedSites as $site) {
							print $site['siteName'] . "\n";
						} ?></textarea>
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
					<select name='nonExcludedFacade[]' id='nonExcludedFacade' style="width: 300px" size="10" multiple>
						<? foreach ($this->nonExcluded as $site) { ?>
							<option value="<?= $site['siteId'] ?>"><?= $site['siteName'] ?></option>
						<? } ?>
					</select>
					<select name='nonExcluded[]' id='nonExcluded' style="display: none" multiple></select>
					<br>

					<p align="center"><input class="formbutton" type="button" onclick="excludes_one2two()"
					                         value=" Assign >> "></p>
				</td>

				<td align="center" colspan="2" width='50%'>
					<select name='excludedFacade[]' id='excludedFacade' style="width: 300px" size="10" multiple>
						<? foreach ($this->excluded as $site) { ?>
							<option value="<?= $site['siteId'] ?>"><?= $site['siteName'] ?></option>
						<? } ?>
					</select>
					<select name='excluded[]' id='excluded' style="display: none" multiple></select>
					<br>

					<p align="center"><input class="formbutton" type="button" onclick="excludes_two2one()"
					                         value=" << Remove "></p>
				</td>
			</tr>
		</table>
	</td>
</tr>


<tr>
	<td colspan="2" class='componentHead'>Card Amenities</td>
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
						<? foreach ($this->allAmenities as $amenities) { ?>
							<option value="<?= $amenities['amenityid'] ?>"><?= $amenities['label'] ?></option>
						<? } ?>
					</select> <br>

					<p align="center"><input class="formbutton" type="button"
					                         onclick="one2two(m1, m2)" value=" Assign >> "></p>

				</td>

				<td align="center" colspan="2" width='50%'><select
						name='assignedAmenities[]' id='assignedAmenities'
						style="width: 300px" size="10" multiple>
						<? foreach ($this->assignedAmenities as $amenities) { ?>
							<option value="<?= $amenities['amenityid'] ?>"><?= $amenities['label'] ?></option>
						<? } ?>
					</select> <br>

					<p align="center"><input class="formbutton" type="button"
					                         onclick="two2one(m1, m2)" value=" << Remove "></p>
				</td>
			</tr>
		</table>
	</td>
</tr>


<tr>
	<td colspan="2" class='componentHead' id="productLinksHeader">Product Links</td>
</tr>
<tr>
	<td colspan="2">
		<div class="bootstrap">
			<br/><br/>
			<table id="productLinksTable" class="display compact cell-border">
				<thead>
				<tr>
					<th>Link ID</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>Link Type</th>
					<th>Device Type</th>
					<th>Website ID</th>
					<th>Account Type</th>
					<th>URL</th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($this->productLinks as $productLink) {
					$linkId = $productLink['link_id'];
					$editLinkId = 'pl_edit' . $linkId;
					$deleteLinkId = 'pl_delete' .$linkId;
					$testLinkId = 'pl_test' . $linkId;
					echo "<tr>
							<td>{$productLink['link_id']}</td>
							<td>
								<button type='button'
										class='btn btn-primary btn-sm'
										aria-label='Left Align'
										id='{$editLinkId}'
										title='Edit'
										onclick='editLink($linkId)'>
									<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
								</button>
							</td>
							<td>
								<button type='button' class='btn btn-danger btn-sm'	aria-label='Left Align' id='{$deleteLinkId}' title='Delete'>
									<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
								</button>
							</td>
							<td>
								<button type='button'
										class='btn btn-primary btn-sm'
										aria-label='Left Align'
										id='{$testLinkId}'
										title='Test link'
										onclick='testLink({$linkId})'>
									<span class='glyphicon glyphicon-link' aria-hidden='true'></span>
								</button>
							</td>
							<td>{$productLink['link_type_name']}</td>
							<td>{$productLink['device_type_name']}</td>
							<td>{$productLink['website_id']}</td>
							<td>{$productLink['account_type_name']}</td>
							<td>{$productLink['url']}</td>
						</tr>";
				}
				?>
				</tbody>
			</table>
			<br/><br/>
			<button type="button" class="btn btn-success btn-sm" name="pl_add" id="pl_add">Add New</button>
		</div>
		<br/><br/>
	</td>
</tr>


<tr>
	<td colspan="2" class='componentHead'>Card Version</td>
</tr>
<tr>
	<td>Edit Version <br>
	</td>
	<td><br>
		<select name="add" onchange="performAction(this);">
			<option value="-">--------------------------------</option>
			<?
			$rs = $_POST['rs_versions'];
			while (!$rs->EOF){
			?>
			<option
				value="javascript:editVersion('<?= $rs->fields['id'] ?>', '<?= $_POST['cardId'] ?>', '<?=
				$_REQUEST['mod'] ?>')
				"><?= $rs->fields['cardDetailLabel'] ?>
				<? $rs->MoveNext();
				} ?></option>
		</select> <br>
		<br>
	</td>
</tr>
<tr>
	<td colspan="2" align='center'>
		<a href="index.php?mod=<?= $_REQUEST['mod'] ?>&amp;action=createVersion&amp;cardId=<?= $_POST['cardId'] ?>">
			Create New Version
		</a>
		<br><br>
	</td>
</tr>

<tr>
	<td colspan="3" align="center">
		<input type="hidden" name="commited" value="yes">
		<input type="hidden" name="mod" value="<?= $_REQUEST['mod'] ?>">
		<input type="hidden" name="action" value='update'>
		<input type="hidden" name="postaction" value='update'>
		<input type="hidden" name="cardId" value="<?= $_POST['cardId'] ?>">
		<input
			class="formbutton" type="button"
			onclick='selectAll(); validateForm();' value="UPDATE">
		<input class="formbutton" type="button"
		       value="CANCEL" onclick="goToMod('<?= $_REQUEST['mod'] ?>')">
	</td>
</tr>
</table>
</td>
</tr>
</table>
</form>


<div id="productLinkModal" class="basic-grey">
	<br /><br />
	<h3>Create/Edit a Product Link</h3>
	<form id="pl_form">
		<input type="hidden" name="pl_productId" id="pl_productId" value="<?= $_POST['cardId'] ?>"/>
		<input type="hidden" name="pl_username" id="pl_username" value="<?= $this->username ?>"/>
		<input type="hidden" name="pl_linkId" id="pl_linkId" value="-1"/>

		<div id="errorMsg"><label></label></div>
		<label>Select Link Type: </label>
		<input type="radio" name="pl_link_type" id="link_type_default" value="card" checked="checked"><label for="default_link_type">Default</label>
		<br/><br/>
		<input type="radio" name="pl_link_type" id='link_type_terms' value="terms"><label for="link_type_terms">Terms & Conditions</label>
		<br/><br/>
		<input type="radio" name="pl_link_type" id='link_type_account' value="account"><label for="link_type_account">Account Type</label>
		<select id="pl_account_type" name="pl_account_type" class="account-select-field">
			<?php
			foreach ($this->accountTypes as $accountType)
				echo "<option value=\"{$accountType['partner_account_type_id']}\">
						{$accountType['account_type']}</option>";
			?>
		</select>
		<br/>
		<input type="radio" name="pl_link_type" id='link_type_website' value="website"><label for="link_type_website">Website</label>
		<input type="text" class="id-text-field" name="pl_website" id="pl_website"
		       placeholder="Website ID or Name"/>
		<input type="hidden" name="pl_websiteId" id="pl_websiteId" value="-1"/>
		<br/>
		<label>Select Device Type: </label>
		<select name="pl_device_type" id="pl_device_type" class="device-select-field">
			<?php
			foreach ($this->deviceTypes as $deviceType)
				echo "<option value=\"{$deviceType['device_type_id']}\">{$deviceType['name']}</option>";
			?>
		</select>
		<br/>
		<label>URL: </label>
		<textarea wrap="soft" rows="60" id="pl_url" name="pl_url" class="url-text-field"></textarea>
		<br /><br />
		<input type="button" id="pl-btn-cancel" class="pl-btn-cancel" value="Cancel" />
		<input type="button" id="pl-btn-create" class="pl-btn-create" value="Save" />
	</form>
</div>

<div id="productLinkDeleteConfirm" title="Confirmation Required">
	<p><span class="ui-icon ui-icon-alert" id="pl_delete_confirm_span"></span>Are you sure you want to delete <br/>
		this product link?</p>
</div>
