/* 
 * Payoff Calculator calculates either the number of months to pay off a principal, or the minimum payment to pay off
 * the principal in a desired number of months.
 *
 * Math formula for compound interest
 *
 * Principal * Math.pow(1 + (apr/unit of time), time duration units)
 * 1200 * Math.pow(1 + (.1249/100), 6)
 *
 * @author David Cannon
 * @date Jan 2014
 */
function BalanceTransferCalculator() {

	if (!(this instanceof BalanceTransferCalculator)) {
		return new BalanceTransferCalculator();
	}

	Calculator.call(this); // call super constructor.

	this.introApr = 0.0;
	this.introTerm = 0;
	this.regularApr = 0.0;
	this.annualFee = 0.00;
	this.percentOfBalanceFee = 0.0;
	this.maximumBalanceFee = 0.00;
	this.totalTransferFees = 0.00;
	this.totalCurrentFees = 0.00;
	this.totalIntroInterest = 0.00;
	this.totalRegularInterest = 0.00;
	this.totalIntroSavings = 0.00;
	this.totalRegularSavings = 0.00;
	this.doIt = true;
	this.cards = [];
}

// inherit Calculator
BalanceTransferCalculator.prototype = new Calculator();

// correct the constructor pointer because it points to Calculator
BalanceTransferCalculator.prototype.constructor = BalanceTransferCalculator;

/**
 * Set the intro interest rate.
 * @param apr
 */
BalanceTransferCalculator.prototype.setIntroApr = function (apr) {
	this.introApr = toFloat(apr);
};

/**
 * Get the intro interest rate.
 * @returns {number}
 */
BalanceTransferCalculator.prototype.getIntroApr = function () {
	return this.introApr;
};

/**
 * Set the intro term in months.
 * @param term
 */
BalanceTransferCalculator.prototype.setIntroTerm = function (term) {
	this.introTerm = toInt(term);
};

/**
 * Get the intro term in months.
 * @returns {number}
 */
BalanceTransferCalculator.prototype.getIntroTerm = function () {
	return this.introTerm;
};

/**
 * Set the regular apr.
 * @param apr
 */
BalanceTransferCalculator.prototype.setRegularApr = function (apr) {
	this.regularApr = toFloat(apr);
};

/**
 * Get the regular apr.
 * @returns {number}
 */
BalanceTransferCalculator.prototype.getRegularApr = function () {
	return this.regularApr;
};

/**
 * Set the annual fee.
 * @param fee
 */
BalanceTransferCalculator.prototype.setAnnualFee = function (fee) {
	this.annualFee = toFloat(fee);
};

/**
 * Get the annual fee.
 * @returns {number}
 */
BalanceTransferCalculator.prototype.getAnnualFee = function () {
	return this.annualFee;
};

/**
 * Get the fee based on a percentage of the balance..
 * @param percent
 */
BalanceTransferCalculator.prototype.setPercentOfBalanceFee = function (percent) {
	percent = toFloat(percent);

	this.percentOfBalanceFee = toDecimal(percent);
};

/**
 * Get the fee based on a percentage of the balance.
 * @returns {number}
 */
BalanceTransferCalculator.prototype.getPercentOfBalanceFee = function () {
	return this.percentOfBalanceFee;
};

/**
 * Set the current fees total
 * @param fees
 */
BalanceTransferCalculator.prototype.setTotalCurrentFees = function (fees) {
	this.totalCurrentFees = toFloat(fees);
};

/**
 * Get the current fees total
 * @returns {number}
 */
BalanceTransferCalculator.prototype.getTotalCurrentFees = function () {
	return this.totalCurrentFees;
};

/**
 * Set the transfer fees total.
 * @param fees
 */
BalanceTransferCalculator.prototype.setTotalTransferFees = function (fees) {
	this.totalTransferFees = toFloat(fees);
};

/**
 * Get the transfer fees total.
 * @returns {number}
 */
BalanceTransferCalculator.prototype.getTotalTransferFees = function () {
	return this.totalTransferFees;
};


/**
 * Set the fee based on a maximum amount.
 * @param fee
 */
BalanceTransferCalculator.prototype.setMaximumBalanceFee = function (fee) {
	this.maximumBalanceFee = toFloat(fee);
};

/**
 * Get the fee based on a maximum amount.
 * @returns {number}
 */
BalanceTransferCalculator.prototype.getMaximumBalanceFee = function () {
	return this.maximumBalanceFee;
};

/**
 * Set a 2d array of cards...balance and apr
 * @param cards
 */
BalanceTransferCalculator.prototype.setCards = function (cards) {

	//Convert all the string values to numbers.
	for (var i = 0; i < cards.length; i++) {
		for (var j = 0; j < cards[i].length; j++) {
			cards[i][j] = toFloat(cards[i][j]);
		}
	}

	this.cards = cards;
};

/**
 * Get a 2d array of cards...balance and apr
 * @returns {Array}
 */
BalanceTransferCalculator.prototype.getCards = function () {
	return this.cards;
};

/**
 * Set the total intro interest total.
 * @param interest
 */
BalanceTransferCalculator.prototype.setTotalIntroInterest = function (interest) {
	this.totalIntroInterest = interest;
};

/**
 * Get the total intro interest total.
 * @returns {*}
 */
BalanceTransferCalculator.prototype.getTotalIntroInterest = function () {
	return this.totalIntroInterest;
};

/**
 * Set the regular interest total.
 * @param interest
 */
BalanceTransferCalculator.prototype.setTotalRegularInterest = function (interest) {
	this.totalRegularInterest = interest;
};

/**
 * Get the regular interest total.
 * @returns {*}
 */
BalanceTransferCalculator.prototype.getTotalRegularInterest = function () {
	return this.totalRegularInterest;
};

/**
 * Set the total savings during intro period.
 * @param amount
 */
BalanceTransferCalculator.prototype.setTotalIntroSavings = function (amount) {
	this.totalIntroSavings = toFloat(amount);
};

/**
 * Get the total savings during intro period.
 * @returns {Number|*}
 */
BalanceTransferCalculator.prototype.getTotalIntroSavings = function () {
	return this.totalIntroSavings;
};

/**
 * Set the total savings during regular period.
 * @param amount
 */
BalanceTransferCalculator.prototype.setTotalRegularSavings = function (amount) {
	this.totalRegularSavings = toFloat(amount);
};

/**
 * Get total savings during regular period.
 * @returns {Number|*}
 */
BalanceTransferCalculator.prototype.getTotalRegularSavings = function () {
	return this.totalRegularSavings;
};

/**
 * Set "DO IT" to true or false...meaning the promotion is worth it or not.
 * @param answer
 */
BalanceTransferCalculator.prototype.setDoIt = function (answer) {
	this.doIt = answer;
};

/**
 * Get the answer as to whether the promotion is worth it or not.
 * @returns {*}
 */
BalanceTransferCalculator.prototype.getDoIt = function () {
	return this.doIt;
};

/**
 * Calculates total principal for all cards
 */
BalanceTransferCalculator.prototype.calculateTotalPrincipal = function () {

	// reset principal
	this.principal = 0;

	// Iterate over all cards
	for (var key in this.cards) {
		this.principal += this.cards[key][0];
	}

};

/**
 * Calculate total monthly payment for all cards
 *
 */
BalanceTransferCalculator.prototype.calculateTotalMonthlyPayment = function () {

	// reset monthly payment
	this.monthlyPayment = 0;

	for (var key in this.cards) {
		this.monthlyPayment += this.cards[key][2];
	}

};

/**
 * Calculates
 *
 * @returns {number}
 */
BalanceTransferCalculator.prototype.calculateBalanceTransferCharge = function () {

	this.balanceTransferCharge = this.principal * this.percentOfBalanceFee;

	//if transfer fees are greater than maximum fee, use max fee
	if ((this.balanceTransferCharge > this.maximumBalanceFee) && (this.maximumBalanceFee != 0)) {
		this.balanceTransferCharge = this.maximumBalanceFee;
	}

};

/**
 * Calculate Total regular interest by iterating over months until paid off
 */
BalanceTransferCalculator.prototype.calculateTotalRegularInterest = function () {

	// reset regular interest
	this.totalRegularInterest = 0;
	this.totalRegularInterestPromotionPeriod = 0;

	//Iterate over all cards.
	for (var i = 0; i < this.cards.length; i++) {

		var principal = this.cards[i][0]; //Current Card Principal
		var rate = toMpr(this.cards[i][1]); //Current Card MPR
		var payment = this.cards[i][2]; //Current Monthly Payment
		var payments = 0;

		this.cards[i]['totalRegularInterest'] = 0;
		this.cards[i]['totalRegularInterestPromotionPeriod'] = 0;

		// Iterate over the balance until gone
		while (principal > 0) {

			// paid in full or never will pay it off
			if (principal <= 0 || payments > 1000) {
				break;
			}

			// Mark interest consumer would have paid during promotional period
			if (payments === this.introTerm) {
				this.cards[i]['totalRegularInterestPromotionPeriod'] += this.cards[i]['totalRegularInterest'];
			}

			var currentMonthInterest = principal * rate; //Calculate interest.
			this.cards[i]['totalRegularInterest'] += currentMonthInterest;
			principal += currentMonthInterest;

			//Subtract payment from principal
			principal -= payment;
			payments++;

		}

		// set the payoff time for this card
		this.cards[i]['monthsToPayoff'] = payments;
	}

	// Sum interest at the end from each card
	for (var i = 0; i < this.cards.length; i++) {

		this.totalRegularInterestPromotionPeriod += this.cards[i]['totalRegularInterestPromotionPeriod'];
		this.totalRegularInterest += this.cards[i]['totalRegularInterest'];

	}

};

/**
 * Calculate total transfer fees
 */
BalanceTransferCalculator.prototype.calculateTotalTransferFees = function () {
	this.totalTransferFees = roundMoney(this.balanceTransferCharge);
};

/**
 * Calculate total intro interest
 */
BalanceTransferCalculator.prototype.calculateTotalIntroInterest = function () {

	// do not want to affect our original principal
	var principal = this.principal;

	// reset total intro interest
	this.totalIntroInterest = 0;

	//Iterate over new card for the intro term months.
	for (var i = 0; i < this.introTerm; i++) {
		principal -= this.monthlyPayment;
		this.totalIntroInterest += principal * toMpr(this.introApr);
	}

};

/**
 * Calculate lifetime interest on promo card and months to payoff
 * if same monthly payments are kept
 */
BalanceTransferCalculator.prototype.calculateLifetimeInterestAndMonths = function () {

	// reset values
	this.totalLifetimeInterest = 0;
	this.totalIntroInterest = 0;
	this.monthsToPayoff = 0;

	var rate = toMpr(this.regularApr);
	var introRate = toMpr(this.introApr);
	var principal = this.principal;
	var thisMonthsRate = rate;

	// Calculate interest charges and payments beyond intro if not paid off
	while (principal > 0) {

		// for after the intro term
		if (this.monthsToPayoff < this.introTerm) {
			thisMonthsRate = introRate;

			// add totalIntroInterest here for intro months
			this.totalIntroInterest += principal * introRate;
		}
		else {
			thisMonthsRate = rate;
		}

		// current month interest added to principal for compound interest
		var currentMonthInterest = principal * thisMonthsRate;
		this.totalLifetimeInterest += currentMonthInterest;
		principal += currentMonthInterest;

		// track months beyond intro
		this.monthsToPayoff++;

		// subtract payment
		principal -= this.monthlyPayment;

		// for each year add the annual fee
		// to principal
		if (((i + 1) % 12) == 0) {
			principal += this.annualFee;
		}

		// for each year add the annual fee
		// to principal
		if ((this.monthsToPayoff % 12) == 0) {
			principal += this.annualFee;
		}

		if (this.monthsToPayoff > 1000)  {
			break;
		}

	}

};

/**
 * Calculate total intro savings
 */
BalanceTransferCalculator.prototype.calculateTotalIntroSavings = function () {
	this.totalIntroSavings = roundMoney(this.totalRegularInterest - (this.totalIntroInterest + this.totalTransferFees));
};

/**
 * Calculates total regular savings
 */
BalanceTransferCalculator.prototype.calculateTotalRegularSavings = function () {
	this.totalRegularSavings = roundMoney(this.totalRegularInterest - (this.totalLifetimeInterest + this.totalTransferFees));
};

/**
 * Calculates promotion payments to payoff during promotion period
 */
BalanceTransferCalculator.prototype.calculatePromotionPayments = function () {
	this.promotionPayments = roundMoney((parseFloat(this.principal) + parseFloat(this.totalTransferFees)) / parseInt(this.introTerm));
};

/**
 * Getter for Promotion Payments for promotion period
 *
 * @returns {number|*}
 */
BalanceTransferCalculator.prototype.getPromotionPayments = function () {
	return this.promotionPayments;
};

/**
 * Calculate the data needed for tables and charts.
 */
BalanceTransferCalculator.prototype.calculateDataPoints = function () {

	/**
	 * Abstracted calculation functions
	 */
	this.calculateTotalPrincipal();
	this.calculateTotalMonthlyPayment();
	this.calculateBalanceTransferCharge();
	this.calculateTotalTransferFees();
	this.calculateTotalRegularInterest();
	this.calculateLifetimeInterestAndMonths();
	this.calculateTotalIntroSavings();
	this.calculateTotalRegularSavings();
	this.calculatePromotionPayments();

	// months beyond intro breaks 1000, person will never pay it off
	if (this.monthsToPayoff > 1000) {
		this.setDoIt(false);
	}

};

