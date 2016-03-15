<?php
/*
 * File: crc_balance_transfer_calc.php
 * Description: This generates the CreditCards.com Balance Transfer Calculator
 *          by: M D Green
 *              6 January 2015
 *       Email: mike.green@saesolved.com
 *         Web: http://www.saesolved.com
 * 
 * Calculator created by SaeSolved::™ LLC for CreditCards.com. All Rights Reserved. Copyright (C) 2015 CreditCards.com. All Rights Reserved. 
 * This calculator is provided in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE. CreditCards.com may be contacted at webmaster@creditcards.com. SaeSolved::™ LLC may be contacted at webmaster@saesolved.com.
 *
 */ 

class BalanceTransferCalc {
	protected $affordable_monthly_payment	= 0; // $
	protected $amount_to_be_paid_each_month	= 0; // $
	protected $amount_to_be_transferred		= 0; // $
	protected $balance_transfer_fee			= 0; // % of $amount_to_be_transferred
	protected $error_message				= '';
	protected $extra_interest				= 0; // $
	protected $extra_months_repayment		= 0; //months
	protected $final_payment				= 0; // $
	protected $interest_rate_after_intro	= 0; // %
	protected $intro_rate_time_period		= 0; //months
	protected $total_cost					= 0; // $

	public function __construct () {
	}
	
	private function amountToBePaidEachMonth () {
		$this->amount_to_be_paid_each_month = $this->amount_to_be_transferred * (1.0 + $this->balance_transfer_fee / 100) / $this->intro_rate_time_period;
	}
	
	private function canBeAffordedCalcs () {
		$amount_to_be_repaid			= $this->amount_to_be_transferred * (1.0 + $this->balance_transfer_fee / 100);
		$amount_repaid_without_interest	= $this->intro_rate_time_period * $this->affordable_monthly_payment;
		$amount_to_repay_with_interest	= $amount_to_be_repaid - $amount_repaid_without_interest;
		$monthly_int_fractn_after_intro	= $this->interest_rate_after_intro / 1200;
		$balance_to_be_repaid			= $amount_to_repay_with_interest;
		$this->extra_interest			= 0;
		$this->extra_months_repayment	= 0;
		while ($balance_to_be_repaid > 0) {
			$this->extra_months_repayment++;
			$this->extra_interest += $balance_to_be_repaid * $monthly_int_fractn_after_intro;
			$balance_to_be_repaid  = $balance_to_be_repaid * (1 + $monthly_int_fractn_after_intro) - $this->affordable_monthly_payment;
		}
		$total_months_to_repay = $this->intro_rate_time_period + $this->extra_months_repayment;
		if ($balance_to_be_repaid < 0) {
			$this->final_payment	= $this->affordable_monthly_payment + $balance_to_be_repaid;
			$this->total_cost		= ($total_months_to_repay - 1) * $this->affordable_monthly_payment + $this->final_payment;
		} else {
			$this->total_cost		= $total_months_to_repay * $this->affordable_monthly_payment;
		}
	}
	
	private function getInput () {
		if (!isset($_REQUEST['amount_to_be_transferred'])) $_REQUEST['amount_to_be_transferred'] = 0;
		$this->amount_to_be_transferred	= str_replace(',', '', $_REQUEST['amount_to_be_transferred']);
		if (!isset($_REQUEST['balance_transfer_fee'])) $_REQUEST['balance_transfer_fee'] = 0;
		$this->balance_transfer_fee		= $_REQUEST['balance_transfer_fee'];
		if (!isset($_REQUEST['intro_rate_time_period'])) $_REQUEST['intro_rate_time_period'] = 0;
		$this->intro_rate_time_period	= $_REQUEST['intro_rate_time_period'];
		if (!isset($_REQUEST['calc_what'])) $_REQUEST['calc_what'] = '';
		switch ($_REQUEST['calc_what']) {
			case 'amount_to_be_paid_each_month':
				if ($this->intro_rate_time_period > 0) {
					$this->error_message = '';
					$this->amountToBePaidEachMonth();
					return true;
				} else {
					$this->error_message = 'Intro Rate Time Period must be greater than zero.';
					return false;
				}
			case 'can_be_afforded':
				if ($this->intro_rate_time_period <= 0) {
					$this->error_message = 'Intro Rate Time Period must be greater than zero.';
					return false;
				}
				$this->amountToBePaidEachMonth();
				$this->affordable_monthly_payment = str_replace( ',', '', $_REQUEST['affordable_monthly_payment']);
				if ($this->affordable_monthly_payment > 0) {
					$this->error_message = '';
					if (!isset($_REQUEST['interest_rate_after_intro'])) $_REQUEST['interest_rate_after_intro'] = 0;
					$this->interest_rate_after_intro 	= $_REQUEST['interest_rate_after_intro'];
					if ($this->interest_rate_after_intro > 0) {
						$this->canBeAffordedCalcs();
						return true;						
					} else {
						$this->error_message = 'Post-intro interest rate must be greater than zero.';
						return false;
					}
				} else {
					$this->error_message = 'Monthly payment you can afford must be greater than zero.';
					return false;
				}
				return true;
			default:
				$this->affordable_monthly_payment	= 0;
				$this->amount_to_be_paid_each_month	= 0;
				$this->amount_to_be_transferred		= 0;
				$this->balance_transfer_fee			= 0; 
				$this->error_message				= '';
				$this->extra_interest				= 0;
				$this->extra_months_repayment		= 0;
				$this->interest_rate_after_intro	= 0;
				$this->intro_rate_time_period		= 0;
				$this->total_cost					= 0;
				return true;
		}
	}

	public function showCalculator () {
		$this->getInput();
		$affordable_monthly_payment		= number_format($this->affordable_monthly_payment, 2);
		$amount_to_be_paid_each_month	= number_format($this->amount_to_be_paid_each_month, 2);
		$amount_to_be_transferred		= number_format($this->amount_to_be_transferred, 2);
		$balance_transfer_fee			= number_format($this->balance_transfer_fee, 2);
		$error_message					= $this->error_message;
		$extra_interest					= number_format($this->extra_interest, 2);
		$extra_months_repayment			= number_format($this->extra_months_repayment, 0);
		$final_payment					= number_format($this->final_payment, 2);
		$interest_rate_after_intro		= number_format($this->interest_rate_after_intro, 2);
		$intro_rate_time_period			= number_format($this->intro_rate_time_period, 0);
		$total_cost						= number_format($this->total_cost, 2);
		include('crc_balance_transfer_calc_view.php');
	}
	
}

$crc_balance_transfer_calc = new BalanceTransferCalc();

$crc_balance_transfer_calc->showCalculator();