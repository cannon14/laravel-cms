<?php


class Cardmatch_CardPresenterTest extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider cardBtProvider
	 * @param $card
	 * @param $expected
	 */
	public function testGetBalanceTransferIntroApr(Cardmatch_Card $card, $expected) {
		$presenter = new Cardmatch_CardPresenter($card);
		$this->assertEquals($expected, $presenter->getBalanceTransferIntroApr());
	}

	/**
	 * @dataProvider cardPurchaseIntroAprProvider
	 * @param $card
	 * @param $expected
	 */
	public function testGetPurchaseIntroApr(Cardmatch_Card $card, $expected) {
		$presenter = new Cardmatch_CardPresenter($card);
		$this->assertEquals($expected, $presenter->getPurchaseIntroApr());
	}

	public function cardBtProvider() {

		$cases = [
			// value, display, period value, period display, active, expected
			[0,     '',     15, '15 months',   1,  '0% for 15 months'],
			[999,   'N/A',  0, 'N/A',          1,  'N/A'],
			[999,   'N/A*', 0, 'N/A*',         1,  'N/A*'],
			[0,     'N/A',  15, '15 months',   0,  'N/A'],
			[999,   'N/A*', 15, 'N/A*',        0,  'N/A*'],
			[0,     '0%',   18, '18 billing cycles for balance transfers made in the first 60 days', 1, '0% for 18 billing cycles for balance transfers made in the first 60 days'],
			[0.00,  '@@balanceTransferIntroApr@@', 15,  '@@balanceTransferIntroAprPeriod@@ months', 1, '0% for 15 months']
		];


		$data = [];
		foreach($cases as $case) {
			$card = new Cardmatch_Card();
			$card->setBalanceTransferIntroAprValue($case[0]);
			$card->setBalanceTransferIntroAprDisplay($case[1]);
			$card->setBalanceTransferIntroAprPeriodValue($case[2]);
			$card->setBalanceTransferIntroAprPeriodDisplay($case[3]);
			$card->setQBalanceTransfers($case[4]);

			$data[] = [$card, $case[5]];
		}

		return $data;

	}


	public function cardPurchaseIntroAprProvider() {

		$cases = [
			// value, display, period value, period display, expected
			[999,   'N/A',  0, 'N/A', 'N/A'],
			[999,   'N/A*',  0, 'N/A', 'N/A*'],
			[0,     '@@introApr@@%', 0, '15 months',  '0% for 15 months'],
			['0.00', '@@introApr@@%', 0, 'until October 2016', '0% until October 2016'],
		];

		$data = [];
		foreach($cases as $case) {
			$card = new Cardmatch_Card();
			$card->setQIntroApr($case[0]);
			$card->setIntroApr($case[1]);
			$card->setQIntroAprPeriod($case[2]);
			$card->setIntroAprPeriod($case[3]);

			$data[] = [$card, $case[4]];
		}

		return $data;

	}

}
