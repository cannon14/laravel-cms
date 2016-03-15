<link rel="stylesheet" href="/css/true-interest-calculator.css">
<link rel="stylesheet" href="/css/jquery-ui-1.11.2.css">

<div id="true-interest-calculator-modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times-circle"></i></button>
				<h3 class="modal-adverdis-title" id="myModalLabel" style="padding-bottom: 0; font-size:24px;">True Interest Calculator</h3>
			</div>

			<div class="modal-body">
				<p>The True Interest Rate (TIR) is a simple calculation of what your real interest rate will be based on promotion periods, promotional APRs and the on-going APR for the offer shown.  The initial estimate assumes a 2-year holding period and minimum payments.  Rewards features, additional purchases, annual fees, and other fees are not a factor in the calculation.</p>

				<div id="year-slider-container">
					<div id="slider">
						<p>
							<label for="amount">How long do you intend to keep the card?</label>
							<input type="text" id="amount" readonly>
						</p>
						<div id="slider-controls">
							<div id="slider-range-max"></div>
							<button type="button"  id="calculate-button" class="btn btn-primary simplemodal-close" data-dismiss="modal">Recalculate</button>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<p id="calculator-disclaimer-text">Note: All calculations are estimates and are not provided by the issuing bank. While uniformly applied, certain assumptions and simplifications have been adopted to provide consistent and concise information. Default values used are for illustrative purposes only. Your actual cost and credit line, if any, may vary.</p>
				</div>
			</div>
		</div>
	</div>
</div>
