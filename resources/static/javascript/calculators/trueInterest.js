/* Global Variables */
var $periodSlider = $("#amount");
var $sliderRangeMax = $("#slider-range-max");
var $showModalButtons = $('.true-interest-button');
var $calculateButton = $('#calculate-button');
var purchaseAmount = 1000;

/* Helper Functions */
function calculateMonthlyPayment(apr) {
	if (apr == 0) {
		apr = 0.000001;
	} else {
		apr /= 100;
	}
	var monthlyPayment = purchaseAmount * (apr / 12) + ((1 / 100) * 1000);

	return monthlyPayment;
}

function calculateTotalPayment(monthlyPayment, monthsHoldingCard, introPeriod) {
	var totalPayment = 0;
	if (monthsHoldingCard > introPeriod) {
		totalPayment = monthlyPayment * (monthsHoldingCard - introPeriod);
	}

	return totalPayment;
}

function calculateEndingBalanceIntro(introApr, monthlyPayment, introPeriod) {
	if (introApr == 0) {
		introApr = 0.000001;
	} else {
		introApr /= 100;
	}
	var i = introApr / 12;
	var x = 1 + i;
	var endingBalanceIntro = purchaseAmount * Math.pow(x, introPeriod) - (monthlyPayment / i) * (Math.pow(x, introPeriod) - 1);

	return endingBalanceIntro;
}

function calculateEndingBalanceOngoing(endingBalanceIntro, apr, monthlyPayment, monthsHoldingCard, introPeriod) {
	if (apr == 0) {
		apr = 0.000001;
	} else {
		apr /= 100;
	}
	var i = apr / 12;
	var n = monthsHoldingCard - introPeriod;
	var x = 1 + i;
	var endingBalanceOngoing = endingBalanceIntro * Math.pow(x, n) - (monthlyPayment / i) * (Math.pow(x, n) - 1);

	return endingBalanceOngoing;
}

function calculateFinanceCharge(monthsHoldingCard, introPeriod, totalPayment, endingBalanceOngoing, endingBalanceIntro) {
	var financeCharge = 0;
	if (monthsHoldingCard > introPeriod) {
		financeCharge = totalPayment + endingBalanceOngoing - endingBalanceIntro;
	}

	return financeCharge;
}

function calculateTrueInterest(financeCharge, monthsHoldingCard) {
	var trueInterest = ((financeCharge / (monthsHoldingCard / 12)) / purchaseAmount) * 100;
	
	return trueInterest;
}

function performCalculations(cardReference) {
	var cardId = $(cardReference).attr('data-card-id');
	var cardCssId = 'card-' + cardId + '-data';
	var cardRateId = 'card-' + cardId + '-interest';

	var ignoreCalculations = parseFloat($('#' + cardCssId + ' .ignore-calculations').val()) == 1;

	if (ignoreCalculations) {
		$('#' + cardRateId).html('See Terms').addClass('see-terms');
		return;
	}

	var monthsHoldingCard = parseInt($periodSlider.val()) * 12;
	var introApr = parseFloat($('#' + cardCssId + ' .purchase-intro-apr').val());
	var introAprPeriod = parseInt($('#' + cardCssId + ' .purchase-intro-apr-period').val());
	var regularApr = parseFloat($('#' + cardCssId + ' .regular-apr').val());

	introApr = (introApr == 999) ? 0 : introApr;

	var monthlyPayment = calculateMonthlyPayment(regularApr);
	var totalPayment = calculateTotalPayment(monthlyPayment, monthsHoldingCard, introAprPeriod);
	var endingBalanceIntro = calculateEndingBalanceIntro(introApr, monthlyPayment, introAprPeriod);
	var endingBalanceOngoing = calculateEndingBalanceOngoing(endingBalanceIntro, regularApr, monthlyPayment, monthsHoldingCard, introAprPeriod);
	var financeCharge = calculateFinanceCharge(monthsHoldingCard, introAprPeriod, totalPayment, endingBalanceOngoing, endingBalanceIntro);
	var trueInterest = calculateTrueInterest(financeCharge, monthsHoldingCard);

	$('#' + cardRateId).html(trueInterest.toFixed(2) + '%');

	// debug log
	console.log('---Card', cardId + '---', '\n\n\n');
	console.log('Inputs >', '\n\n');
	console.log('monthsHoldingCard:', monthsHoldingCard, '\n');
	console.log('introApr:', introApr, '\n');
	console.log('introAprPeriod:', introAprPeriod, '\n');
	console.log('regularApr:', regularApr, '\n\n');
	console.log('Calculations >', '\n\n');
	console.log('monthlyPayment:', monthlyPayment, '\n');
	console.log('totalPayment:', totalPayment, '\n');
	console.log('endingBalanceIntro:', endingBalanceIntro, '\n');
	console.log('endingBalanceOngoing:', endingBalanceOngoing, '\n');
	console.log('financeCharge:', financeCharge, '\n');
	console.log('trueInterest:', trueInterest, '\n\n');
}

// initialize slider
function calculate() {

	// Get all items on page before next calculate run
	$periodSlider = $("#amount");
	$sliderRangeMax = $("#slider-range-max");
	$showModalButtons = $('.true-interest-button');
	$calculateButton = $('#calculate-button');

	$sliderRangeMax.slider({
		range: "max",
		min: 2,
		max: 6,
		value: 2,
		slide: function(event, ui) {
			$periodSlider.val(ui.value);
		}
	});

	$periodSlider.val($sliderRangeMax.slider("value"));

	// display default calculations for 2 year intro apr
	$showModalButtons.each(function () {
		performCalculations(this);
	});

}


/* "Main Method" */
$(document).ready(function () {

	calculate();

	// calculate button event listener
	$calculateButton.click(function (event) {
		$showModalButtons.each(function () {
			performCalculations(this);
		});
	});
});
