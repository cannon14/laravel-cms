/**
 *	tabularDataHelper is a helper function to assist in generating the tabular data html, which varies depending on the category being viewed.
 *
 *	@param JSON card contains all the card data as a json object returned from the API
 */
Handlebars.registerHelper("tabularDataHelper", function (card) {
	// references for later use
	var data = card.tabularCardData,
		displayType = card.tabularCardData.cardDisplayType,
		calculationsData = card.calculationsData;

	// string variables used multiple times to construct html
	var tabularCardDataHtml = '',
		openDl = '<dl>',
		closeDl = '</dl>',
		openDt = '<dt>',
		closeDt = '</dt>',
		openDd = '<dd>',
		closeDd = '</dd>',
		wrapDataBegin = '<ul class="responsive-table"><li class="first-row">',
		wrapDataEnd = '</li></ul><div style="clear:both;"></div>';

	// prepare html <dl> fragments used in multiple tabular card data display types
	var introPurchaseAprHtml = openDl;
	introPurchaseAprHtml += openDt + 'Intro Purchase APR' + closeDt + openDd + data.purchaseApr + closeDd;
	introPurchaseAprHtml += closeDl;

	var purchaseAprPeriodHtml = openDl;
	purchaseAprPeriodHtml += openDt + 'Purchase APR Period' + closeDt + openDd + data.purchaseAprPeriod + closeDd;
	purchaseAprPeriodHtml += closeDl;

	var introBalanceTransfersAprHtml = openDl;
	introBalanceTransfersAprHtml += openDt + 'Intro Balance Transfers APR' + closeDt + openDd + data.balanceTransferIntroApr + closeDd;
	introBalanceTransfersAprHtml += closeDl;

	var balanceTransfersAprPeriodHtml = openDl;
	balanceTransfersAprPeriodHtml += openDt + 'Balance Transfers Intro Period' + closeDt + openDd + data.balanceTransferAprPeriod + closeDd;
	balanceTransfersAprPeriodHtml += closeDl;

	var cardNormalApr = '';
	if (data.regularApr != null || typeof data.regularApr != 'undefined') {
		cardNormalApr = data.regularApr;
	}
	else {
		cardNormalApr = data.typicalApr;
	}

	var regularAprHtml = openDl;
	regularAprHtml += openDt + 'Regular <br>APR' + closeDt + openDd + cardNormalApr + closeDd;
	regularAprHtml += closeDl;

	var cardFee = '';
	if (data.cardFee != null || typeof data.cardFee != 'undefined') {
		cardFee = data.cardFee.feeValue;
	}

	var annualFeeHtml = openDl;
	annualFeeHtml += openDt + 'Annual <br>Fee' + closeDt + openDd + cardFee + closeDd;
	annualFeeHtml += closeDl;

	var creditNeededHtml = openDl;
	creditNeededHtml += openDt + 'Credit Needed' + closeDt + openDd + data.creditNeeded + closeDd;
	creditNeededHtml += closeDl;

	// put together and create custom html depending on display type
	switch (displayType) {
		case 'balance-transfer':
			wrapDataBegin = '<ul class="responsive-table-bt"><li class="first-row">';

			var introAprHiddenInput = '<input type="hidden" id="bt-intro-apr-' + card.cardId + '" value="' + calculationsData.balanceTransferIntroApr + '">';
			var introAprHtml = openDl;
			introAprHtml += openDt + 'Balance Transfer Intro APR' + closeDt + openDd + data.balanceTransferIntroApr + introAprHiddenInput + closeDd;
			introAprHtml += closeDl;

			var aprPeriodHiddenInput = '<input type="hidden" id="bt-intro-period-' + card.cardId + '" value="' + calculationsData.balanceTransferIntroPeriod + '">';
			var aprPeriodHtml = openDl;
			aprPeriodHtml += openDt + 'Balance Transfer Intro Period' + closeDt + openDd + data.balanceTransferAprPeriod + aprPeriodHiddenInput + closeDd;
			aprPeriodHtml += closeDl;

			var balanceTransferFeeHiddenInput = '<input type="hidden" id="bt-fee-' + card.cardId + '" value="' + calculationsData.balanceTransferFee + '">';
			balanceTransferFeeHtml = openDl;
			balanceTransferFeeHtml += openDt + 'Balance Transfer Fee' + closeDt + openDd + data.balanceTransferFee + balanceTransferFeeHiddenInput + closeDd;
			balanceTransferFeeHtml += closeDl;

			var regularAprHiddenInput = '<input type="hidden" id="bt-min-apr-' + card.cardId + '" value="' + calculationsData.regularApr + '">';
			regularAprHtml = openDl;
			regularAprHtml += openDt + 'Regular <br>APR' + closeDt + openDd + cardNormalApr + regularAprHiddenInput + closeDd;
			regularAprHtml += closeDl;

			var potentialSavingLabel = '<dt>';
			potentialSavingLabel += '<a name="card-estimate-button" class="card-estimate-button" style="color:#66c0ff; cursor:pointer; text-decoration: none" id="card-estimate-' + card.cardId + '"><i class="fa fa-info-circle fa-lg card-estimate-button" data-toggle="modal" data-target="#bt-calculator-modal"></i></a>';
			potentialSavingLabel += '&nbsp;Potential Savings Estimate*</dt>';
			var potentialSavingHiddenInput = '<input type="hidden" value="0" id="bt-calc-exclude-' + card.cardId + '">';
			var potentialSavingData = '<dd id="bt-calc-result-' + card.cardId + '" class="potential_savings">Calculating...</dd>';
			var potentialSavingHtml = openDl;
			potentialSavingHtml += potentialSavingLabel + potentialSavingHiddenInput + potentialSavingData;
			potentialSavingHtml += closeDl;

			tabularCardDataHtml = wrapDataBegin;
			tabularCardDataHtml += introAprHtml + aprPeriodHtml + balanceTransferFeeHtml + regularAprHtml + annualFeeHtml + creditNeededHtml + potentialSavingHtml;
			tabularCardDataHtml += wrapDataEnd;
			break;

		case 'low-interest-zero-apr':
			var hiddenCardDataDiv = '<div id="card-' + card.cardId + '-data" style="display:none;">';
			hiddenCardDataDiv += '<input type="hidden" class="purchase-intro-apr" value="' + calculationsData.purchaseIntroApr + '">';
			hiddenCardDataDiv += '<input type="hidden" class="purchase-intro-apr-period" value="' + calculationsData.purchaseAprPeriod + '">';
			hiddenCardDataDiv += '<input type="hidden" class="regular-apr" value="' + calculationsData.regularApr + '">';
			hiddenCardDataDiv += '<input type="hidden" class="ignore-calculations" value="' + calculationsData.ignoreCalculations + '">';
			hiddenCardDataDiv += '</div>';

			var trueInterestHtml = openDl;
			trueInterestHtml += openDt + '<a name="card-estimate-button" class="true-interest-button" style="color:#66c0ff; cursor:pointer; text-decoration: none" data-card-id="' + card.cardId + '" "=""><i class="fa fa-info-circle fa-lg card-estimate-button" data-toggle="modal" data-target="#true-interest-calculator-modal"></i></a>&nbsp;True Interest' + hiddenCardDataDiv + closeDt + openDd + 'Calculating...' + closeDd;
			trueInterestHtml += closeDl;

			tabularCardDataHtml = wrapDataBegin;
			tabularCardDataHtml += introPurchaseAprHtml + purchaseAprPeriodHtml + introBalanceTransfersAprHtml + balanceTransfersAprPeriodHtml + regularAprHtml + annualFeeHtml + trueInterestHtml;
			tabularCardDataHtml += wrapDataEnd;
			break;

		case 'prepaid-debit':
			wrapDataBegin = '<ul class="responsive-table-prepaid"><li class="first-row">';

			tabularCardDataHtml = wrapDataBegin;
			tabularCardDataHtml += introPurchaseAprHtml + purchaseAprPeriodHtml + introBalanceTransfersAprHtml + balanceTransfersAprPeriodHtml + regularAprHtml + annualFeeHtml + creditNeededHtml;
			tabularCardDataHtml += wrapDataEnd;
			break;

		case 'issuer-network-top-offers':
			wrapDataBegin = '<ul class="responsive-table-all"><li class="first-row">';
			
			tabularCardDataHtml = wrapDataBegin;
			tabularCardDataHtml += introPurchaseAprHtml + purchaseAprPeriodHtml + introBalanceTransfersAprHtml + balanceTransfersAprPeriodHtml + regularAprHtml + annualFeeHtml + creditNeededHtml;
			tabularCardDataHtml += wrapDataEnd;
			break;

		default:
			tabularCardDataHtml = wrapDataBegin;
			tabularCardDataHtml += introPurchaseAprHtml + purchaseAprPeriodHtml + introBalanceTransfersAprHtml + balanceTransfersAprPeriodHtml + regularAprHtml + annualFeeHtml + creditNeededHtml;
			tabularCardDataHtml += wrapDataEnd;
			break;
	}

	return tabularCardDataHtml;
});

/**
 *	injectCardSet is a helper function used in the event listener to prepare the html for the card set received from the API and append it to the DOM
 *
 *	@param JSON cardSet is a json array of the next x cards returned from the API after the user clicks "show more"
 */
function injectCardSet(cardSet, cardSetCount) {
	var template = Handlebars.templates['card-listing-template.html'],
		cardHtml = '',
		divId = 'more-cards-' + cardSetCount,
		cardSetHtml = '<div style="display: none" id="' + divId +'">';
	for (var i = 0; i < cardSet.length; i++) {
		cardHtml = template(cardSet[i]);
		cardSetHtml += cardHtml;
	}
	cardSetHtml += '</div>';
	$('.show-more-results').before(cardSetHtml);
	$('#' + divId).slideDown(400);
}

$(document).ready(function () {

	var tempCard = {
			cardId: 123,
			cardTitle: 'BoA Visa Card',
			isFeatured: true,
			pageFid: 245,
			pagePosition: 3,
			cardLinkId: 4001,
			imageFileName: "bankamericard-cash-rewards-credit-card-52714.png",
			imageAltTag: 'boa card',
			cardDetailBulletsInitial: {
				bullet1: 'This card is dope.',
				bullet2: 'This card is bling.'
			},
			cardDetailBulletsMore: {
				bullet3: 'This card could be better, even though it\'s dope.',
				bullet4: 'Check out this card at it\'s official website yo.'
			},
			cardIssuer: 'Bank Of America',
			issuerPhoneNumber: "1-800-yur-mama",
			tabularCardData: {
				cardDisplayType: 'low-interest-zero-apr',
				purchaseApr: '2.1',
				purchaseAprPeriod: '2',
				balanceTransferIntroApr: '3.0',
				balanceTransferAprPeriod: '3',
				balanceTransferFee: '5',
				regularApr: '3.5',
				cardFee: {
					feeType: 'annual',
					feeValue: '1'
				},
				creditNeeded: 'Good'
			},
			calculationsData: {
				purchaseIntroApr: 2.1,
				purchaseAprPeriod: 2,
				balanceTransferIntroApr: 3.0,
				balanceTransferAprPeriod: 3,
				balanceTransferFee: 5,
				regularApr: 3.5,
				cardFee: 1,
				ignoreCalculations: 0
			}
		};

	var tempCard2 = {};
	$.extend(tempCard2, tempCard);
	tempCard2.cardId = '234';

	var tempCardSet = [tempCard, tempCard2];
	var cardSetCount = 0;

	/**
	 *	event listener for the "show more" button to append the next card set
	 */
	$('.show-more-results').click(function (event){
		// ajax implementation to fetch next card set will go here, remove simulation below!
		event.preventDefault();
		cardSetCount++;
		injectCardSet(tempCardSet, cardSetCount);
		// attack event listeners to change 'show more' button text and icons
		$('#more-cards-' + cardSetCount + ' a').click(function() {

			if($.trim($(this).text()) == 'Show More') {
				$(this).text('Show Less');
				$(this).parent().find('i').attr('class', 'fa fa-chevron-up');
			}
			else {
				$(this).text('Show More');
				$(this).parent().find('i').attr('class', 'fa fa-chevron-down');
			}
		});
	});

});
