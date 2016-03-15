/**
 * Created by justing on 3/6/15.
 */

// Global calculator
var calculator;

QUnit.module( "Balance Transfer Calculator", {
	setup: function(assert) {

		calculator = new BalanceTransferCalculator();
		calculator.setIntroApr(0);
		calculator.setIntroTerm(12);
		calculator.setRegularApr(15);
		calculator.setAnnualFee(0);
		calculator.setPercentOfBalanceFee(3);
		calculator.setMaximumBalanceFee(0);

	},
	teardown: function(assert) {

	}
} );

QUnit.test( "Two Transfer Cards: [3000,17,200], [1000,24,75]", function( assert ) {

	calculator.setCards([[3000,17,200], [1000,24,75]]);
	calculator.calculateDataPoints();

	assert.equal(toInt(calculator.totalRegularInterest), 491, toCurrency(calculator.totalRegularInterest) + ': Total interest for the original cards without transfer' );
	assert.equal(calculator.monthsToPayoff, 15, calculator.monthsToPayoff + ' months: Total months to payoff new card at same amount' );
	assert.equal(roundMoney(calculator.totalLifetimeInterest), 16.22, toCurrency(calculator.totalLifetimeInterest) + ': Total Lifetime interest  with new card');
	assert.equal(calculator.getTotalIntroSavings(), 371.14, toCurrency(calculator.getTotalIntroSavings()) + ': Interest saved during intro');
	assert.equal(calculator.totalTransferFees, 120, toCurrency(calculator.totalTransferFees) + ': Transfer fees');

	assert.equal(calculator.promotionPayments, 343.33, toCurrency(calculator.promotionPayments) + ': Monthly payment to payoff during intro');

	var currentCardPayoffs = [];
	for (var i in calculator.cards) {
		currentCardPayoffs.push('Card ' + (parseInt(i) + parseInt(1)) + ': ' + calculator.cards[i].monthsToPayoff + ' months');
	}

	assert.equal(currentCardPayoffs, currentCardPayoffs, 'Current cards payoff time: ' + currentCardPayoffs.join(', '));

});

QUnit.test( "One Card: [3000,17,200]", function( assert ) {

	calculator.setCards([[3000,17,200]]);
	calculator.calculateDataPoints();

	assert.equal(toInt(calculator.totalRegularInterest), 343, toCurrency(calculator.totalRegularInterest) + ': Total interest for the original cards without transfer');
	assert.equal(calculator.monthsToPayoff, 16, calculator.monthsToPayoff + ' months: Total months to payoff new card at same amount');
	assert.equal(roundMoney(calculator.totalLifetimeInterest), 15.44, toCurrency(calculator.totalLifetimeInterest) + ': Total Lifetime interest  with new card');
	assert.equal(calculator.getTotalIntroSavings(), 253.22, toCurrency(calculator.getTotalIntroSavings()) + ': Interest saved during intro');
	assert.equal(calculator.totalTransferFees, 90, toCurrency(calculator.totalTransferFees) + ': Transfer fees');

	assert.equal(calculator.promotionPayments, 257.50, toCurrency(calculator.promotionPayments) + ': Monthly payment to payoff during intro');

	var currentCardPayoffs = [];
	for (var i in calculator.cards) {
		currentCardPayoffs.push('Card ' + (parseInt(i) + parseInt(1)) + ': ' + calculator.cards[i].monthsToPayoff + ' months');
	}

	assert.equal(currentCardPayoffs, currentCardPayoffs, 'Current cards payoff time: ' + currentCardPayoffs.join(', '));

});

QUnit.test( "One Card: [1000,24,75]", function( assert ) {

	calculator.setCards([[1000,24,75]]);
	calculator.calculateDataPoints();

	assert.equal(toInt(calculator.totalRegularInterest), 147, toCurrency(calculator.totalRegularInterest) + ': Total interest for the original cards without transfer');
	assert.equal(calculator.monthsToPayoff, 14, calculator.monthsToPayoff + ' months: Total months to payoff new card at same amount');
	assert.equal(roundMoney(calculator.totalLifetimeInterest), 1.58, toCurrency(calculator.totalLifetimeInterest) + ': Total Lifetime interest  with new card');
	assert.equal(calculator.getTotalIntroSavings(), 117.92, toCurrency(calculator.getTotalIntroSavings()) + ': Interest saved during intro');
	assert.equal(calculator.totalTransferFees, 30, toCurrency(calculator.totalTransferFees) + ': Transfer fees');

	assert.equal(calculator.promotionPayments, 85.83, toCurrency(calculator.promotionPayments) + ': Monthly payment to payoff during intro');

	var currentCardPayoffs = [];
	for (var i in calculator.cards) {
		currentCardPayoffs.push('Card ' + (parseInt(i) + parseInt(1)) + ': ' + calculator.cards[i].monthsToPayoff + ' months');
	}

	assert.equal(currentCardPayoffs, currentCardPayoffs, 'Current cards payoff time: ' + currentCardPayoffs.join(', '));

});

QUnit.module( "Payoff Calculator", {
	setup: function(assert) {

		//calculator = new PayoffCalculator();
		//calculator.setIntroApr(0);
		//calculator.setIntroTerm(12);
		//calculator.setRegularApr(15);
		//calculator.setAnnualFee(0);
		//calculator.setPercentOfBalanceFee(3);
		//calculator.setMaximumBalanceFee(0);

	},
	teardown: function(assert) {

	}
} );