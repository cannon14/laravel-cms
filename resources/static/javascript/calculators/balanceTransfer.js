var errors = {
	transfer_err: false,
	transfer_err_msg: "",
	repay_err: false,
	repay_err_msg: "",
	apr_err: false,
	apr_err_msg: "",
	months_err: false,
	months_err_msg: ""
};//we'll use this for validation errors. At the end of validation we'll roll
//everything into one error set and display each as it's own field error

function validateTransferAmount (transferAmount) {
	var dollarAmountRegex = /^[0-9]+\.?[0-9]{0,2}$/;
	var isTransferValid = dollarAmountRegex.test(transferAmount);
	var transferFloatAmount = parseFloat(transferAmount);

	if ((!isTransferValid || (transferFloatAmount < 500 || transferFloatAmount > 20000)) && transferAmount !== "") {
		errors.transfer_err = true;
		if (!isTransferValid) {
			errors.transfer_err_msg = "Please use only numbers for Transfer amount.";
		}
		else if (transferFloatAmount < 500 || transferFloatAmount > 20000) {
			errors.transfer_err_msg = "Enter an amount between $500 and $20,000. Smaller amounts are likely not worth transferring.  Larger amounts are more likely to exceed credit limits.";
		}
	}
	else {
		errors.transfer_err = false;
	}
}

function validateMonthlyRepay (transferAmount, monthlyRepay, currentApr) {
	var dollarAmountRegex = /^[0-9]+\.?[0-9]{0,2}$/;

	var isMonthlyRepayValid = dollarAmountRegex.test(monthlyRepay);
	var monthlyRepayFloatAmount = parseFloat(monthlyRepay);
	var transferFloatAmount = parseFloat(transferAmount);
	var currentAprFloatAmount = parseFloat(currentApr);
	//one calculation to perform: min monthly repay
	var minMonthlyRepay = parseInt((transferFloatAmount * ((currentAprFloatAmount / 100) / 12)) + (transferFloatAmount * 0.01));

	if ((!isMonthlyRepayValid || monthlyRepayFloatAmount > 1000 || monthlyRepayFloatAmount < minMonthlyRepay) && monthlyRepay !== "") {
		errors.repay_err = true;
		if (!isMonthlyRepayValid) {
			errors.repay_err_msg = "Please use only numbers for Monthly Repayment amount.";
		}
		else if (monthlyRepayFloatAmount > 1000) {
			errors.repay_err_msg = "Enter an amount greater than the minimum finance payment of $" + minMonthlyRepay + " and less than $1,000.  If you are able to make large monthly payments, you are likely better off not transferring your balances.";
		}
		else if (monthlyRepayFloatAmount < minMonthlyRepay) {
			errors.repay_err_msg = "Repayment value adjusted to the minimum financing amount of $" + minMonthlyRepay + ".  You can enter a higher monthly repayment (up to $1,000) or click 'Recalculate'  to continue.";
			$("#bt-calculator-monthly-repay").val(minMonthlyRepay);
		}
	}
	else {
		errors.repay_err = false;
	}

}

function validateCurrentApr(currentApr) {
	var aprPercentageRegex = /^[0-9]+\.?[0-9]*$/;
	var isAprValid = aprPercentageRegex.test(currentApr);
	var currentAprFloatAmount = parseFloat(currentApr);//note, we're not turning this into a real percentage yet. Makes the comparisons easier IMO.
	if ((!isAprValid || (currentAprFloatAmount < 5 || currentAprFloatAmount > 35)) && currentApr !== "") {
		errors.apr_err = true;
		if (!isAprValid) {
			errors.apr_err_msg = "Please use only numbers for Current APR amount.";
		}
		else if (currentAprFloatAmount < 5 || currentAprFloatAmount > 35) {
			errors.apr_err_msg = "Enter an APR between 5% and 35%. If your current APR is below 5%, you're likely better off not transferring your balances.";
		}
	}
	else {
		errors.apr_err = false;
	}
}

function validateSavingsPeriod(savingsPeriod) {
	var monthRegex = /^[1-9]{1}[0-9]*$/;//there is no month 0, so we need at least one digit that is > 0
	var isMonthsValid = monthRegex.test(savingsPeriod);
	var savingsPeriodIntAmount = parseInt(savingsPeriod);

	if ((!isMonthsValid || (savingsPeriodIntAmount < 6 || savingsPeriodIntAmount > 48)) && savingsPeriod !== "") {
		errors.months_err = true;
		if (!isMonthsValid) {
			errors.months_err_msg = "Please use only numbers for Savings Period months.";
		}
		else if (savingsPeriodIntAmount < 6 || savingsPeriodIntAmount > 48) {
			errors.months_err_msg = "Enter between 6 and 48 months. If you only plan to hold your card for 6 months, you're likely better off not transferring your balances.  Projections longer than 48 months are unreliable.";
		}
	}
	else {
		errors.months_err = false;
	}
}

function displayErrors() {
	if (errors.transfer_err) {
		$("#bt-calc-transfer-error").text(errors.transfer_err_msg);
		$("#bt-calc-transfer-error").show();
	}
	if (errors.repay_err) {
		$("#bt-calc-repay-error").text(errors.repay_err_msg);
		$("#bt-calc-repay-error").show();
	}
	if (errors.apr_err) {
		$("#bt-calc-apr-error").text(errors.apr_err_msg);
		$("#bt-calc-apr-error").show();
	}
	if (errors.months_err) {
		$("#bt-calc-period-error").text(errors.months_err_msg);
		$("#bt-calc-period-error").show();
	}
}

function hideErrors() {
	if (!errors.transfer_err) {
		$("#bt-calc-transfer-error").hide();
	}
	if (!errors.repay_err) {
		$("#bt-calc-repay-error").hide();
	}
	if (!errors.apr_err) {
		$("#bt-calc-apr-error").hide();
	}
	if (!errors.months_err) {
		$("#bt-calc-period-error").hide();
	}
}

function calculateSavingsEstimate(cardId, transferAmount, monthlyRepayment, savingsPeriod, currentApr) {

	var transferFee = parseFloat($("#bt-fee-" + cardId).val()) / 100;
	//it's a percentage
	//pre calculated these values to be the divided by 12 (1 year) value. The divide by a hundred is to convert
	//the whole number value into a numeric percentage
	var calculatedCurrentApr = ((currentApr / 100) / 12);
	var calculatedIntroApr = (parseFloat($("#bt-intro-apr-" + cardId).val()) / 100) / 12;//handle percentage
	var defaultIntroPeriod = parseInt($("#bt-intro-period-" + cardId).val());
	var calculatedRegApr = (parseFloat($("#bt-min-apr-" + cardId).val()) / 100) / 12;
	var finalResult = "";
	var rawResult = 0.00;
	//if any existing field is N/A or otherwise does not meet the
	//proper criteria, display N/A as the savings estimate, else do the calculations
	if ($("#bt-intro-apr-" + cardId).parent().text() == "N/A"
		|| $("#bt-intro-period-" + cardId).parent().text() == "N/A"
		|| $("#bt-fee-" + cardId).parent().text() == "N/A"
		|| $("#bt-min-apr-" + cardId).parent().text() == "N/A"
		|| transferFee > 1
		|| (calculatedIntroApr * 12) > 1
		|| defaultIntroPeriod == 0) {

		finalResult = "N/A";

	}
	else {//prevnet divide by zero. This will result in not 100% accurate calculation, but that's better than the universe exploding since 1/0 is GAHHHHH
		if (calculatedIntroApr == 0 || isNaN(calculatedIntroApr)) {
			calculatedIntroApr = 0.00001;
		}

		//A(1+i)^n - P/i((1+i)^n-1) where
		//A = Transfer Amount
		//i = current APR/12
		//P = Monthly Repayment amount
		//n = Savings period
		var numPayments = (-1 * Math.log(1 - (calculatedCurrentApr * (transferAmount / monthlyRepayment)))) / Math.log(1 + calculatedCurrentApr);
		if (numPayments < savingsPeriod) {
			savingsPeriod = numPayments.toFixed(0);
		}
		var endingBalanceNoTrans = (transferAmount * (Math.pow(1 + calculatedCurrentApr, savingsPeriod))) - ((monthlyRepayment / calculatedCurrentApr) * (Math.pow(1 + calculatedCurrentApr, savingsPeriod) - 1));

		//If Savings Period < Intro Period, result is just
		//A(1+i)^n - P/i((1+i)^n - 1)
		//A = Transfer Amount + Transfer Fee
		//i = Intro APR/12
		//P = Monthly Repayment amount
		//n = Savings period
		if (savingsPeriod < defaultIntroPeriod) {

			var endingBalanceWithTrans = ((transferAmount + (transferFee * transferAmount)) * Math.pow(1 + calculatedIntroApr, savingsPeriod)) - ((monthlyRepayment / calculatedIntroApr) * (Math.pow(1 + calculatedIntroApr, savingsPeriod) - 1));

			if ((endingBalanceNoTrans - endingBalanceWithTrans).toFixed(2) === -0.00) {
				finalResult = "$" + 0.00;
			}
			else {
				finalResult = "$" + (endingBalanceNoTrans - endingBalanceWithTrans).toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
				rawResult = (endingBalanceNoTrans - endingBalanceWithTrans).toFixed(2)
			}

		}

		//continue with calculation
		else {
			//first, determine A
			//T(1+i)^n - P/i((1+i)^n - 1)
			//T = Transfer Amount + Transfer Fee
			//i = Intro APR/ 12 unless intro apr is 0, in which case whole thing is 0.
			//P = monthly repayment amount
			//n = Intro period

			var valA = ((transferAmount + (transferAmount * transferFee)) * Math.pow(1 + calculatedIntroApr, defaultIntroPeriod)) - ((monthlyRepayment / calculatedIntroApr) * (Math.pow(1 + calculatedIntroApr, defaultIntroPeriod) - 1));

			//then plug A in to the main calculation
			//A(1+i)^n - P/i((1+i)^n - 1)
			//A = value of equation above
			//i = Regular APR / 12
			//P = Monthly repayment amount
			//n = Savings Period - Intro Period
			var endingBalanceWithTrans = (valA.toFixed(2) * Math.pow(1 + calculatedRegApr, (savingsPeriod - defaultIntroPeriod))) - ((monthlyRepayment / calculatedRegApr) * (Math.pow(1 + calculatedRegApr, savingsPeriod - defaultIntroPeriod) - 1));

			//var endingBalanceWithTrans = (3125.01 * Math.pow((1+0.01249999), (24 - 18))) - ((112.5/0.01249999) * (Math.pow((1 + 0.01249999),(24 - 18)) - 1));
			if ((endingBalanceNoTrans - endingBalanceWithTrans).toFixed(2) === -0.00) {
				finalResult = "$" + 0.00;
			}
			else {
				//regexp inserts commas in the correct spots for US currency only. Since we're using dollars, that's ok.
				finalResult = "$" + (endingBalanceNoTrans - endingBalanceWithTrans).toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
				rawResult = (endingBalanceNoTrans - endingBalanceWithTrans).toFixed(2);
			}

		}

		//edge case detection
		if (rawResult < 0.00 || isNaN(rawResult)) {
			finalResult = "$" + 0.00;

		}
		else if (transferFee > 1) {
			finalResult = "N/A";
		}
	}

	return finalResult;

}

function calculate() {
	$("[id^='bt-calc-result']").each(function () {

		var cardId = $(this).attr("id").split("-")[3];
		//calculate the defaults for each estimate.
		var defaultTransferAmount = 1500;
		var defaultSavingsPeriod = 24;
		var defaultCurrentApr = 15;

		var financeCharge = defaultTransferAmount * ((defaultCurrentApr / 100) / 12);
		var onePercentOfTransAmount = defaultTransferAmount * 0.01;
		var defaultMonthlyRepayment = financeCharge + onePercentOfTransAmount;
		var result = "";

		if ($("#bt-calc-exclude-" + cardId).val() === "0") {
			result = calculateSavingsEstimate(cardId, defaultTransferAmount, defaultMonthlyRepayment, defaultSavingsPeriod, defaultCurrentApr);
		}
		else {
			result = "See Terms";
		}

		//add a comma to defaultTransferAmount amount
		defaultTransferAmount = defaultTransferAmount.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
		// make defaultCurrentApr a decimal
		defaultCurrentApr = defaultCurrentApr.toFixed(2);
		// make defaultCurrentApr a decimal
		defaultMonthlyRepayment = defaultMonthlyRepayment.toFixed(2);

		//inject defaultTransferAmount
		$('#bt-calculator-transfer').attr("placeholder", "$" + defaultTransferAmount);
		$('#bt-calculator-transfer').attr("value", "$" + defaultTransferAmount);
		//inject defaultCurrentApr
		$('#bt-calculator-current-apr').attr("placeholder", defaultCurrentApr + "%");
		$('#bt-calculator-current-apr').attr("value", defaultCurrentApr + "%");
		//inject defaultMonthlyRepayment
		$('#bt-calculator-monthly-repay').attr("placeholder", "$" + defaultMonthlyRepayment);
		$('#bt-calculator-monthly-repay').attr("value", "$" + defaultMonthlyRepayment);


		$("#bt-calc-result-" + cardId).text(result);
	});
}


$(document).ready(function () {
	//Initial calculations for page on page load.
	calculate();

	var $btCalculatorTransfer = $("#bt-calculator-transfer");
	var $btCalculatorCurrentApr = $("#bt-calculator-current-apr");
	var $btCalculatorMonthlyRepay = $("#bt-calculator-monthly-repay");
	var $btCalculatorSavingsPeriod = $("#bt-calculator-savings-period");
	var replaceRegExp = /(,|%|\$|mos|mos\.)/g;
	//form will save values, clear it out
	$btCalculatorCurrentApr.val("");
	$btCalculatorMonthlyRepay.val("");
	$btCalculatorSavingsPeriod.val("");
	$btCalculatorTransfer.val("");


	function recalculateBlur() {
		var transferAmount = $btCalculatorTransfer.val().replace(replaceRegExp, "");
		var currentApr = $btCalculatorCurrentApr.val().replace(replaceRegExp, "");
		validateTransferAmount(transferAmount);
		validateCurrentApr(currentApr);
		hideErrors();
		displayErrors();

		if(transferAmount == ''){
			var transferAmount = $btCalculatorTransfer.attr("value").replace(replaceRegExp, "");
		}
		if(currentApr == ''){
			var currentApr = $btCalculatorCurrentApr.attr("value").replace(replaceRegExp, "");
		}

		var financeCharge = transferAmount * ((currentApr / 100) / 12);
		var onePercentOfTransAmount = transferAmount * 0.01;
		var monthlyRepay = financeCharge + onePercentOfTransAmount;
		// make monthlyRepay a decimal
		var monthlyRepay = monthlyRepay.toFixed(2);
		$('#bt-calculator-monthly-repay').attr("placeholder", "$"+monthlyRepay);
		$('#bt-calculator-monthly-repay').attr("value", "$"+monthlyRepay);
	}

	$btCalculatorTransfer.blur(function () {
		recalculateBlur();
	});

	$btCalculatorCurrentApr.blur(function () {
		recalculateBlur();
	});

	$btCalculatorMonthlyRepay.blur(function () {
		var transferAmount = $btCalculatorTransfer.val().replace(replaceRegExp, "");
		var monthlyRepay = $btCalculatorMonthlyRepay.val().replace(replaceRegExp, "");//another dollar amount, reuse that regex
		var currentApr = $btCalculatorCurrentApr.val().replace(replaceRegExp, "");
		validateMonthlyRepay(transferAmount, monthlyRepay, currentApr);
		hideErrors();
		displayErrors();
	});

	$btCalculatorSavingsPeriod.blur(function () {
		var savingsPeriod = $btCalculatorSavingsPeriod.val().replace(replaceRegExp, "");
		validateSavingsPeriod(savingsPeriod);
		hideErrors();
		displayErrors();
	});
	//setup the recalc button itself. This only needs to work for a single estimate at a time
	$("#bt-calculator-recalculate-btn").click(function () {
		var transferAmount = $btCalculatorTransfer.val();
		var currentApr = $btCalculatorCurrentApr.val();
		var monthlyRepay = $btCalculatorMonthlyRepay.val();
		var savingsPeriod = $btCalculatorSavingsPeriod.val();

		if(transferAmount == ''){
			var transferAmount = $btCalculatorTransfer.attr("value").replace(replaceRegExp, "");
		}

		if(currentApr == ''){
			var currentApr = $btCalculatorCurrentApr.attr("value").replace(replaceRegExp, "");
		}

		if (monthlyRepay == '') {
			var monthlyRepay = $btCalculatorMonthlyRepay.attr("value").replace(replaceRegExp, "");
		}

		if (savingsPeriod == '') {
			var savingsPeriod = $btCalculatorSavingsPeriod.attr("value").replace(replaceRegExp, "");
		}
		transferAmount = parseFloat(transferAmount);
		currentApr = parseFloat(currentApr);
		monthlyRepay = parseFloat(monthlyRepay);
		savingsPeriod = parseInt(savingsPeriod);
		validateTransferAmount(transferAmount);
		validateCurrentApr(currentApr);
		validateMonthlyRepay(transferAmount, monthlyRepay, currentApr);
		validateSavingsPeriod(savingsPeriod);

		$("[id^='bt-calc-result']").each(function () {
			if (!errors.apr_err && !errors.months_err && !errors.repay_err && !errors.transfer_err) {
				var cardId = $(this).attr("id").split("-")[3];
				var result = "";
				if ($("#bt-calc-exclude-" + cardId).val() === "0") {
					result = calculateSavingsEstimate(cardId, transferAmount, monthlyRepay, savingsPeriod, currentApr);
				}
				else {
					result = 'See Terms';
				}

				$("#bt-calc-result-" + cardId).text(result);
			}
		});


		if (errors.apr_err || errors.months_err || errors.repay_err || errors.transfer_err) {
			displayErrors();
			alert("Please correct input values before recalculating.");
		}
		else {
			hideErrors();
			$('#bt-calculator-modal').modal('hide');
		}

	});

	//record the card id for a selected card so that we can appropriately act upon it in the calculator.
	$("a[name='card-estimate-button']").click(function () {
		var cardId = $(this).attr("id").split("-")[2];
		$("#bt-calc-current-card-id").val(cardId);
	});


});