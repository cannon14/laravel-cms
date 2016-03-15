<div id="bt-calculator-modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times-circle"></i></button>
				<h3 class="modal-adverdis-title" id="myModalLabel" style="padding-bottom: 0; font-size:24px;">Transfer Savings Estimate</h3>
			</div>
			<div class="modal-body">
				<p>The Transfer Savings Estimate (TSE) is a calculation of how much you might save by transferring your balances to a new card after factoring in fees, length of promotional periods and interest charges.  TSE is based on the transfer amount and does not assume rewards or purchases, since those will vary per individual.</p>
				<h2 style="font-weight:bold">Personalize It</h2>
				<p>Change the inputs below to update the listings with custom calculations that match your personal situation.</p>
				<form role="calculator-form">
					<div class="bt-calc-field-rows">
						<div class="bt-calc-row form-group">
							<div class='bt-calc-label'>
								<label class="bt-calculator-label" for="bt-calculator-transfer">Transfer Amount</label>
								<div class="bt-calc-help">
									<i class="fa fa-question-circle" data-toggle="tooltip" title="Enter the total amount of balances you're considering transferring to a new card.  The default value is $1,500."></i>
								</div>
							</div>
							<div class="bt-calc-field">
								<input placeholder="$1,500" value="1500" class="bt-calculator-text" id="bt-calculator-transfer" type="text"/>
								<p class="bt-calc-hint">$500 - $20,000</p>
							</div>

							<div id="bt-calc-transfer-error" class="calc-error alert alert-danger" role="alert"><br></div>
						</div>

						<div class="bt-calc-row form-group">
							<div class='bt-calc-label'>
								<label class="bt-calculator-label" for="bt-calculator-current-apr">Current APR</label>
								<div class="bt-calc-help">
									<i class="fa fa-question-circle" data-toggle="tooltip" title="Enter the APR you're currently paying.  The calculation estimates your savings compared to this rate. The default value is 15.00%."></i>
								</div>
							</div>
							<div class="bt-calc-field">
								<input placeholder="15.00%" value="15" class="bt-calculator-text" id="bt-calculator-current-apr" type="text"/>
								<p class="bt-calc-hint">5.0% - 35.0%</p>
							</div>
							<div id="bt-calc-apr-error" class="calc-error alert alert-danger" role="alert"><br></div>
						</div>

						<div class="bt-calc-row form-group">
							<div class="bt-calc-label">
								<label class="bt-calculator-label" for="bt-calculator-monthly-repay">Monthly Repayment</label>
								<div class="bt-calc-help">
									<i class="fa fa-question-circle" data-toggle="tooltip" title="Enter the amount you expect to pay down on the balances each month.  This excludes any new charges you make.  The default value is $33.75."></i>
								</div>
							</div>
							<div class="bt-calc-field">
								<input placeholder="$33.75" value="33.75" class="bt-calculator-text" id="bt-calculator-monthly-repay" type="text"/>
								<p class="bt-calc-hint">Up to $1,000</p>
							</div>
							<div id="bt-calc-repay-error" class="calc-error alert alert-danger" role="alert"><br></div>
						</div>

						<div class="bt-calc-row form-group">
							<div class="bt-calc-label">
								<label class="bt-calculator-label" for="bt-calculator-savings-period">Savings Period</label>
								<div class="bt-calc-help">
									<i class="fa fa-question-circle" data-toggle="tooltip" title="Enter the time frame you'd like the calculation to cover. This could be the promotional period on a new card, or the time you think it will take you to pay off your balances.  The default value is 24 months."></i>
								</div>
							</div>
							<div class="bt-calc-field">
								<input placeholder="24 mos." value="24" class="bt-calculator-text" id="bt-calculator-savings-period" type="text"/>
								<p class="bt-calc-hint">6 - 48 mos.</p>
							</div>
							<div id="bt-calc-period-error" class="calc-error alert alert-danger" role="alert"><br></div>
						</div>
					</div>
					<div class="bt-calculator-disclaimer">
						<p class="bt-calculator-disclaimer-text">Note: All calculations are estimates. While uniformly applied, certain assumptions and simplifications have been adopted to provide consistent and concise information. Default values used are for illustrative purposes only. Your actual savings, if any, may vary.</p>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="simplemodal-close bt-calculator-recalculate">
					<input value="" id="bt-calc-current-card-id" type="hidden"/>
					<button type="button"  id="bt-calculator-recalculate-btn" class="btn btn-primary">Recalculate</button>
				</div>
			</div>
		</div>
	</div>
</div>