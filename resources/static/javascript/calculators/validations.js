function validateTransferAmount (transferAmount) {

	var dollarAmountRegex = /^[0-9]+\.?[0-9]{0,2}$/;
	var isTransferValid = dollarAmountRegex.test(transferAmount);

	var transferFloatAmount = parseFloat(transferAmount);
	if ((!isTransferValid || (transferFloatAmount < 1000 || transferFloatAmount > 20000)) && transferAmount !== "") {
		errors.transfer_err = true;
		if (!isTransferValid) {
			errors.transfer_err_msg = "Please use only numbers for Transfer amount.";
		}
		else if (transferFloatAmount < 1000 || transferFloatAmount > 20000) {
			errors.transfer_err_msg = "Enter an amount between $1,000 and $20,000. Smaller amounts are likely not worth transferring.  Larger amounts are more likely to exceed credit limits.";
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
			errors.repay_err_msg = "Repayment value adjusted to the minimum financing amount of $" + minMonthlyRepay + ".  You can enter a higher monthly repayment (up to $1,000) or click ‘Recalculate’ to continue.";
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
			errors.apr_err_msg = "Enter an APR between 5% and 35%. If your current APR is below 5%, you’re likely better off not transferring your balances.";
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
			errors.months_err_msg = "Enter between 6 and 48 months. If you only plan to hold your card for 6 months, you’re likely better off not transferring your balances.  Projections longer than 48 months are unreliable.";
		}
	}
	else {
		errors.months_err = false;
	}
}