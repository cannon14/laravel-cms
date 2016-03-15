<?php

/*
 * File: crc_fiscal_cliff_calc.php
 * Description: This generates the CreditCards.com Fiscal Cliff Calculator
 *          by: M D Green
 *              21 November 2012
 *       Email: mike.green@saesolved.com
 *         Web: http://www.saesolved.com
 * 
 * Calculator created by SaeSolved::™ LLC for CreditCards.com. All Rights Reserved. Copyright (C) 2012 CreditCards.com. All Rights Reserved. 
 * This calculator is provided in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE. CreditCards.com may be contacted at webmaster@creditcards.com. SaeSolved::™ LLC may be contacted at webmaster@saesolved.com.
 *
 */
 
class FiscalCliffCalc {
	protected $base_deduction				= array(
													'single'					=> array('a' => 6050,  'b' => 6050,),
													'married_filing_jointly'	=> array('a' => 12100, 'b' => 10150,),
													'head_of_household'			=> array('a' => 8900,  'b' => 8900,),
													);
    protected $current_total_taxes			= '';
	protected $doc_root						= '';
	protected $error_message				= '';
    protected $exemptions					= 0;
    protected $filing_status				= 'single';
    protected $fiscal_cliff_total_taxes	= '';
	protected $gross_income					= 0;
	protected $tax_rate						= array(
													'single'					=> array(
																						0		=> array('a' => 0.1,  'b' => 0.15,  'top' => 8900,),
																						8901	=> array('a' => 0.15, 'b' => 0.15,  'top' => 36150,),
																						36151	=> array('a' => 0.25, 'b' => 0.28,  'top' => 87550,),
																						87551	=> array('a' => 0.28, 'b' => 0.31,  'top' => 182600,),
																						182601	=> array('a' => 0.33, 'b' => 0.36,  'top' => 397000,),
																						397001	=> array('a' => 0.35, 'b' => 0.396, 'top' => 9999999,),
																						),
													'married_filing_jointly'	=> array(
																						0		=> array('a' => 0.1,  'b' => 0.15,  'top' => 17800,),
																						17801	=> array('a' => 0.15, 'b' => 0.15,  'top' => 60350,),
																						60351	=> array('a' => 0.15, 'b' => 0.28,  'top' => 72300,),
																						72301	=> array('a' => 0.25, 'b' => 0.28,  'top' => 145900,),
																						145901	=> array('a' => 0.28, 'b' => 0.31,  'top' => 222300,),
																						222301	=> array('a' => 0.33, 'b' => 0.36,  'top' => 397000,),
																						397001	=> array('a' => 0.35, 'b' => 0.396, 'top' => 9999999,),
																						),
													'head_of_household'			=> array(
																						0		=> array('a' => 0.1,  'b' => 0.15,  'top' => 12700,),
																						12701	=> array('a' => 0.15, 'b' => 0.15,  'top' => 48400,),
																						48401	=> array('a' => 0.25, 'b' => 0.28,  'top' => 125000,),
																						125001	=> array('a' => 0.28, 'b' => 0.31,  'top' => 202450,),
																						202451	=> array('a' => 0.33, 'b' => 0.36,  'top' => 397000,),
																						397001	=> array('a' => 0.35, 'b' => 0.396, 'top' => 9999999,),
																						),
													);

	public function __construct () {
		$this->doc_root		= 'http://'.$_SERVER['SERVER_NAME'];
	}
	
	private function calculateTaxes () {
		$this->taxes = array();
		if ($this->gross_income > 113700) {
			$this->taxes['a'] = 0.042 * 113700;
			$this->taxes['b'] = 0.062 * 113700;
		} else {
			$this->taxes['a'] = 0.042 * $this->gross_income;
			$this->taxes['b'] = 0.062 * $this->gross_income;
		}
		$taxable_income = array();
		$taxable_income['a'] = max(0, $this->gross_income - $this->base_deduction[$this->filing_status]['a'] - $this->exemptions * 3850);
		$taxable_income['b'] = max(0, $this->gross_income - $this->base_deduction[$this->filing_status]['b'] - $this->exemptions * 3850);
		foreach ($taxable_income as $key => $val) {
			foreach ($this->tax_rate[$this->filing_status] as $income => $rates) {
				if ($val > $rates['top']) {
					$this->taxes[$key]	+= $rates[$key] * ($rates['top'] - $income + 1);
				} else {
					$this->taxes[$key] 	+= $rates[$key] * ($val - $income + 1);
					break;
				}
			}
			if ('a' == $key) {
				$this->current_total_taxes			= $this->taxes[$key];
			} elseif ('b' == $key) {
				$this->fiscal_cliff_total_taxes		= $this->taxes[$key];
			}
		}
	}
	
	private function getInput () {
		if ("Calculate" == $_REQUEST['calc']) {
			$this->exemptions		= intval($_REQUEST['exemptions']);
			$this->filing_status	= $_REQUEST['filing_status'];
			$this->gross_income		= round(floatval(preg_replace("/[^0-9.]/", '', trim($_REQUEST['gross_income']))));
			if ($this->gross_income > 0) {
				return true;
			} elseif ($this->gross_income > 9999999) {
				$this->error_message	= 'Income value must be less than $9,999,999 for this calculator.';
				$this->gross_income		= 9999999;
				return false;				
			} else {
				$this->error_message	= 'Income value must be greater than zero.';
				$this->gross_income		= 0;
				return false;				
			}
		} else {
			$this->exemptions		= 0;
			$this->filing_status	= 'single';
			$this->gross_income		= 0;
			return true;
		}
	}

	public function showCalculator () {
		if ($this->getInput()) {
			$this->calculateTaxes();
		} else {
			echo "<div style=\"color: red;\">$this->error_message</div>";
			$this->current_net_income		= '';
			$this->fiscal_cliff_net_income	= '';
		}
		$current_total_taxes		= number_format($this->current_total_taxes);
		$fiscal_cliff_total_taxes	= number_format($this->fiscal_cliff_total_taxes);
		$current_net_income			= number_format($this->gross_income - $this->current_total_taxes);
		$fiscal_cliff_net_income	= number_format($this->gross_income - $this->fiscal_cliff_total_taxes);
		$gross_income				= number_format($this->gross_income);
		include('crc_fiscal_cliff_calc_view.php');
	}
	
}

$crc_fiscal_cliff_calc = new FiscalCliffCalc();

$crc_fiscal_cliff_calc->showCalculator();

?>