var calculatorApp = angular.module('CalculatorApplication', []);

calculatorApp.directive('selectOnClick', function () {
	return {
		restrict: 'A',
		link: function (scope, element, attrs) {
			element.on('click', function () {
				this.select();
			});
		}
	};
});

calculatorApp.controller('BalanceTransferController', ['$scope', function ($scope) {

	var calc = new BalanceTransferCalculator();

	$scope.intro_int_rate = 0;
	$scope.intro_term = 12;
	$scope.regular_apr = 15.0
	$scope.annual_fee = 0.00;
	$scope.percent_of_balance_fee = 3.0;
	$scope.maximum_balance_fee = 0.00;

	$scope.balance1 = 3000.00;
	$scope.apr1 = 17.00;
	$scope.payment1 = 200.00;
	$scope.balance2 = 1000.00;
	$scope.apr2 = 24.0;
	$scope.payment2 = 75.00;
	$scope.balance3 = 0.00;
	$scope.apr3 = 0.0;
	$scope.payment3 = 0.00;
	$scope.balance4 = 0.00;
	$scope.apr4 = 0.0;
	$scope.payment4 = 0.00;

	$scope.calculate = function () {

		// Scroll to top of page upon calculate
		// to compensate for losing height of form
		window.scrollTo(0,0);

		//Retrieve the variables from the view...give them default values in case the user hits calculate.
		var introApr = $scope.intro_int_rate ? $scope.intro_int_rate : 0.0;
		var introTerm = $scope.intro_term ? $scope.intro_term : 0;
		var regularApr = $scope.regular_apr ? $scope.regular_apr : 0.0;
		var annualFee = $scope.annual_fee ? $scope.annual_fee : 0.00;
		var percentOfBalanceFee = $scope.percent_of_balance_fee ? $scope.percent_of_balance_fee : 0.0;
		var maximumBalanceFee = $scope.maximum_balance_fee ? $scope.maximum_balance_fee : 0.00;

		var balance1 = $scope.balance1 ? $scope.balance1 : 0.00;
		var apr1 = $scope.apr1 ? $scope.apr1 : 0.00;
		var payment1 = $scope.payment1 ? $scope.payment1 : 0.00;
		var balance2 = $scope.balance2 ? $scope.balance2 : 0.00;
		var apr2 = $scope.apr2 ? $scope.apr2 : 0.0;
		var payment2 = $scope.payment2 ? $scope.payment2 : 0.00;
		var balance3 = $scope.balance3 ? $scope.balance3 : 0.00;
		var apr3 = $scope.apr3 ? $scope.apr3 : 0.0;
		var payment3 = $scope.payment3 ? $scope.payment3 : 0.00;
		var balance4 = $scope.balance4 ? $scope.balance4 : 0.00;
		var apr4 = $scope.apr4 ? $scope.apr4 : 0.0;
		var payment4 = $scope.payment4 ? $scope.payment4 : 0.00;

		calc.setIntroApr(introApr);
		calc.setIntroTerm(introTerm);
		calc.setRegularApr(regularApr);
		calc.setAnnualFee(annualFee);
		calc.setPercentOfBalanceFee(percentOfBalanceFee);
		calc.setMaximumBalanceFee(maximumBalanceFee);
		var cardArray = [[balance1, apr1, payment1], [balance2, apr2, payment2], [balance3, apr3, payment3], [balance4, apr4, payment4]];
		calc.setCards(cardArray);

		//Build the table, principal, and interest data for the charts and tables.
		calc.calculateDataPoints();

		//If your savings is greater than or equal to zero...do it.
		$scope.doIt = calc.getDoIt();
		$scope.totalFees = toCurrency(calc.getTotalTransferFees());
		$scope.totalIntroSavings = toCurrency(calc.getTotalIntroSavings());
		$scope.totalRegularSavings = toCurrency(calc.getTotalRegularSavings());
		$scope.monthsToPayoff = calc.getMonthsToPayoff();
		$scope.totalPrincipal = calc.getPrincipal();
		$scope.promoPayments = toCurrency(calc.getPromotionPayments());
		$scope.monthlyPayment = toCurrency(calc.getMonthlyPayment());

		window.calculator = calc;

		$scope.displayChart();
	};

	$scope.displayChart = function () {
		$('#high_chart').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: 'Relative Cost During the ' + calc.getIntroTerm() + ' Month Promotional Period',
				style: {"font-size": "14px", "font-weight": "bold"}
			},
			xAxis: {
				categories: ['Current Card(s)', 'Balance Transfer Card', 'Balance Transfer Card']
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Cost of Interest and Fees ($)'
				},
				stackLabels: {
					enabled: true,
					style: {
						fontWeight: 'bold',
						color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
					}
				}
			},
			legend: {
				align: 'right',
				x: 0,
				verticalAlign: 'top',
				y: 25,
				floating: true,
				backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
				borderColor: '#CCC',
				borderWidth: 1,
				layout: 'vertical',
				shadow: false
			},
			tooltip: {
				formatter: function () {
					return '<strong>' + this.series.name + '</strong>: $' + this.y + '<br/>' +
						'<strong>Total:</strong> $' + this.point.stackTotal;
				}
			},
			plotOptions: {
				column: {
					stacking: 'normal',
					dataLabels: {
						enabled: true,
						color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
					}
				}
			},
			series: [{
				name: 'Fee(s)',
				data: [roundMoney(calc.getTotalCurrentFees()), roundMoney(calc.getTotalTransferFees())]
			}, {
				name: 'Interest',
				data: [roundMoney(calc.totalRegularInterestPromotionPeriod), roundMoney(calc.getTotalIntroInterest())]
			}]
		});
	}
}]);