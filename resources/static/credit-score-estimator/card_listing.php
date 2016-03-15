<?php

$tncHelper = QUnit_Global::newObj('Affiliate_Scripts_Bl_TermsAndConditionsHelper');
$tncLink = $tncHelper->getTermsAndConditionsLink($card->cardId);
$tncAid = $tncHelper->getSentinelAidValue();
$tncSid = $tncHelper->getSentinelWebsiteIdValue();
if ($tncLink){
	$termsLink =  "<a href=\"/oc/?pid=$card->cardId&pg=$fid&pgpos=$counter&aid=$tncAid&sid=$tncSid\" ".
		"class=\"tnc-link\" target=\"_blank\">Rates &amp; Disclosures</a>";
} else {
	$termsLink = '';
}
$issuerName = $card->merchant;
$phoneNumber = $card->applyByPhoneNumber;
$isTopPick = $counter === 1;

$introApr = $card->introAprLabel;
$introAprPeriod = $card->introAprPeriodLabel;
$balanceTransferIntroApr = $card->balanceTransferIntroAprLabel;
$balanceTransferIntroPeriod = $card->balanceTransferIntroAprPeriodLabel;
$regularApr = $card->regularAprLabel;
$annualFee = $card->annualFeeLabel;
$creditNeeded = $card->creditNeededLabel;
?>

<div class="res-schumer-box">
	<div class="row">
		<div class="col-sm-18 col-md-18 col-lg-18">

			<div class="res-offer-left">
				<a href="/credit-cards/<?=$card->individualOfferLink?>"><?= $card->cardName ?></a>
			</div>

			<div class="row">
				<div class="col-xs-24 col-sm-8 col-md-9 col-lg-7">
					<div class="row">
						<div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
							<div class="res-cc-card-art-align">
								<a target="_blank" href="/oc/?pid=<?=$card->cardId?>&pg=<?=$fid?>&pgpos=<?=$counter?>">
									<img src="<?= $cardImagesRoot ?>/<?= $card->imagePath ?>" border="0" class="img-responsive" alt="<?= $card->cardName ?>">
								</a>
							</div>
						</div>
						<div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
							<div class="res-field-apply-now-768">
								<a class="btn btn-apply btn-lg btn-block" href="/oc/?pid=<?= $card->cardId ?>&pg=<?=$fid?>&pgpos=<?=$counter?>" target="_blank" name="&amp;lid=citi-simplicity-card"><i class="fa fa-lock fa-lg"></i> &nbsp;APPLY ONLINE</a>
								<br>
								<br>

								<?php
								if (!empty($phoneNumber)) {
								?>
								<a class="btn btn-primary btn-lg btn-block"
								   href="tel:<?= $phoneNumber ?>"
								   onclick="var s=s_gi('ccardsccmobile'); s.linkTrackVars='eVar33,events'; s.linktrackevents='event9'; s.events='event9'; s.eVar33='<?= $card->cardId ?>'; s.tl(this,'o','Apply by Phone');">
									<i class="fa fa-phone fa-lg"></i> &nbsp;APPLY BY PHONE
								</a>
								<?php } ?>

								<div class="credit-needed-hldr">
									Credit Needed <span style="color:#16487b; font-weight:bold;"><br><?= $card->creditNeededLabel ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-24 col-sm-14 col-md-15 col-lg-17">
					<div class="res-details">

						<?= $card->detailList ?>

					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-6 col-lg-6 apply-now-btn-padding">
			<div class="res-field-apply-now">
				<a class="btn btn-apply btn-lg" href="/oc/?pid=<?=$card->cardId?>&pg=<?=$fid?>&pgpos=<?=$counter?>" target="_blank" name="&amp;lid=citi-simplicity-card">
					<i class="fa fa-lock fa-lg"></i>
					&nbsp;APPLY NOW
				</a>
				<br>
				<p>At <?= $issuerName ?>'s <br>
					secure site
				</p>

				<?php
				if (!empty($phoneNumber)) {
					?>
					<p class="apply-call">
                            <span>or call <?= $issuerName ?>
								at <br/><b><?= $phoneNumber ?></b></span>
					</p>
					<br>
				<?php } ?>

				<div class="credit-needed-hldr">
					Credit Needed <span style="color:#16487b; font-weight:bold;"><br><?= $card->creditNeededLabel ?></span>
				</div>

			</div>
		</div>
	</div>
	<?php
	if(!function_exists('isNA')) {
		function isNA($arg, $arg2) {
			return preg_match('/n\/a/i',$arg) == 1 && preg_match('/n\/a/i',$arg2) == 1;
		}
	}

	if(!function_exists('isNone')) {
		function isNone($arg, $arg2) {
			return preg_match('/none/i',$arg) == 1 && preg_match('/none/i',$arg2) == 1;
		}
	}

	if(!function_exists('isUntil')) {
		function isUntil($arg) {
			return preg_match('/until/i',$arg) == 1;
		}
	}

	if(!function_exists('isSeeTerms')) {
		function isSeeTerms($arg, $arg2) {
			return preg_match('/see terms/i',$arg) == 1 && preg_match('/see terms/i',$arg2) == 1;
		}
	}

	$iAPR = strtolower($introApr);
	$iAPRPeriod = strtolower($introAprPeriod);
	$bAPR = strtolower($balanceTransferIntroApr);
	$bAPRPeriod = strtolower($balanceTransferIntroPeriod);

	if(isNA($iAPR, $iAPRPeriod)) {
		$iText = $introApr;
	} elseif(isNone($iAPR, $iAPRPeriod)) {
		$iText = 'None';
	} elseif(isSeeTerms($iAPR, $iAPRPeriod)) {
		$iText = 'See Terms';
	} elseif(isUntil($iAPRPeriod)) {
		$iText = $iAPR . " " . $iAPRPeriod;
	} else {
		$iText = $iAPR . " for " . $iAPRPeriod;
	}

	if(isNA($bAPR, $bAPRPeriod)) {
		$bText = $balanceTransferIntroApr;
	} elseif(isNone($bAPR, $bAPRPeriod)) {
		$bText = 'None';
	} elseif(isSeeTerms($bAPR, $bAPRPeriod)) {
		$bText = 'See Terms';
	} elseif(isUntil($bAPRPeriod)) {
		$bText = $bAPR . " " . $bAPRPeriod;
	} else {
		$bText = $bAPR . " for " . $bAPRPeriod;
	}
	?>
	<div class="row">
		<div class="col-sm-24 col-md-24 col-lg-24">
			<div class="res-card-data-hldr">
				<ul class="responsive-table">
					<li class="first-row">
						<dl>
							<dt>Purchases Intro APR</dt>
							<dd>
								<?= $iText ?>
								<input type="hidden" id="purchase-intro-apr-<?= $card->cardId ?>" value="<?= $introApr ?>">
								<?= $introAprPeriod ?> <input type="hidden" id="purchase-intro-period-<?= $card->cardId ?>" value="<?= $introAprPeriod ?>">
							</dd>
						</dl>

						<dl>
							<dt>Balance Transfers Intro APR</dt>
							<dd>
								<?= $bText ?>
								<input type="hidden" id="bt-intro-apr-<?= $card->cardId ?>" value="<?= $balanceTransferIntroApr ?>">
								<input type="hidden" id="bt-intro-period-<?= $card->cardId ?>" value="<?= $balanceTransferIntroPeriod ?>">
							</dd>
						</dl>

						<dl>
							<dt>Regular APR</dt>
							<dd>
								<?= $regularApr ?>
								<input type="hidden" id="bt-min-apr-<?= $card->cardId ?>" value="<?= $regularApr ?>">
							</dd>
						</dl>

						<dl>
							<dt>Annual Fee</dt>
							<dd>
								<?= $annualFee ?>
								<input type="hidden" id="bt-fee-<?= $card->cardId ?>" value="<?= $annualFee ?>">
							</dd>
						</dl>

						<dl>
							<dt>Credit Needed</dt>
							<dd>
								<?= $creditNeeded ?>
							</dd>
						</dl>
						<div style="clear:both;"></div>
					</li>
				</ul>

				<div style="clear:both;"></div>
				
			</div>
		</div>
	</div>

</div>
<br>