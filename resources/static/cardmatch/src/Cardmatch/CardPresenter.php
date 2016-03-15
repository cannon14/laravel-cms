<?php


class Cardmatch_CardPresenter {

	protected $card;

	public function __construct(Cardmatch_Card $card) {
		$this->card = $card;
	}

	public function getPurchaseIntroApr() {

		$aprValue = $this->card->getQIntroApr();
		$aprDisplay = $this->card->getIntroApr();
		$apr = $this->getBalanceTransferIntroAprText($aprDisplay, $aprValue, '@@introApr@@');
		//$aprPeriodValue = $this->card->getQIntroAprPeriod();
		$introAprPeriodDisplay = $this->card->getIntroAprPeriod();
		$text = $this->getDisplayText(1, $aprValue, $apr, $introAprPeriodDisplay);
		return $text;
	}



	public function getBalanceTransferIntroApr() {

		$value = $this->card->getBalanceTransferIntroAprValue();
		$btText = $this->getBalanceTransferIntroAprText($this->card->getBalanceTransferIntroAprDisplay(), $value, '@@balanceTransferIntroApr@@');
		$periodValue = $this->card->getBalanceTransferIntroAprPeriodValue();
		$periodDisplay = str_replace('@@balanceTransferIntroAprPeriod@@', $periodValue, $this->card->getBalanceTransferIntroAprPeriodDisplay());


		$enabled = $this->card->getQBalanceTransfers();
		$apr = $this->getDisplayText($enabled, $value, $btText, $periodDisplay);

		return $apr;
	}


	/**
	 * This is the same logic used in CMS for the other CCCOM shumer boxes
	 *
	 * @param $display
	 * @param $value
	 * @param $placeholder
	 * @return string
	 */
	protected function getBalanceTransferIntroAprText($display, $value, $placeholder) {

		if($display == '') {
			$text = $value . '%';
		} else {
			if (strpos($display, "@@") === false) {
				$text = $display;
			} else {
				if($value != '999.00') {
					if($value == 0) {
						$value = '0';
					}

					$override = $display;

					// Don't add another '%' if the override already has one
					$override = str_replace("{$placeholder} %", $value.' %', $override);
					$override = str_replace("{$placeholder}%", $value.'%', $override);
					$override = str_replace("{$placeholder}", $value.'%', $override);

					$text = $override;
				} else {
					$text = 'N/A';
				}
			}
		}

		return $text;
	}



	protected function isNA($arg, $arg2) {
		return preg_match('/n\/a/i',strtolower($arg)) == 1 && preg_match('/n\/a/i',strtolower($arg2)) == 1;
	}

	protected function isNone($arg, $arg2) {
		return preg_match('/none/i', strtolower($arg)) == 1 && preg_match('/none/i',strtolower($arg2)) == 1;
	}

	protected function isUntil($arg) {
		return preg_match('/until/i',strtolower($arg)) == 1;
	}

	protected function isSeeTerms($arg, $arg2) {
		return preg_match('/see terms/i',strtolower($arg)) == 1 && preg_match('/see terms/i',strtolower($arg2)) == 1;
	}

	/**
	 * @param $enabled
	 * @param $value
	 * @param $display
	 * @param $period
	 * @return string
	 */
	protected function getDisplayText($enabled, $value, $display, $period) {

		$lowApr = $display;
		$lowPeriod = $period;

		if (!$enabled || $this->isNA($lowApr, $lowPeriod) || $value == 999) {
			$text = $display;
		} elseif ($this->isNone($lowApr, $lowPeriod)) {
			$text = 'None';
		} elseif ($this->isSeeTerms($lowApr, $lowPeriod)) {
			$text = 'See Terms';
		} elseif ($this->isUntil($lowPeriod)) {
			$text = $display . " " . $period;
		} else {
			$text = $display . " for " . $period;
		}

		return $text;
	}

}