			<table id="Table2">
				<tbody>
					<tr>
						<td>Annual Percentage Rate for Purchases</td>
						<td><?= $cardDetails['annualRate'] ?></td>
					</tr>
					<tr>
						<td>Other Annual Percentage Rates+</td>
						<td>
							APR for Cash Advances <?= $cardDetails['cashAdvanceAPR'] ?> and Penalty <?= $cardDetails['purchasPenaltyAPR'] ?> for Purchases.<br>
							See Penalty Explanation below.
						</td>
					</tr>
					<tr>
							<td><strong>Fees for Issuance or Availability of Credit</strong></td>
							<?php if (isset($cardDetails['issuanceLiabityA'])): ?>
								<td>
									<a name="1"></a>Account Set-up Fee: $<?= $cardDetails['issuanceLiabityA']['setupFee'] ?> (one-time fee)<br>
									Program Fee: $<?= $cardDetails['issuanceLiabityA']['programFee'] ?> (one-time fee)<br>
									Annual Fee: $<?= $cardDetails['issuanceLiabityA']['annualFee'] ?> <br>
									Service Fee: $<?= $cardDetails['issuanceLiabityA']['serviceFee'] ?> Annually++<br>
									Additional Card Fee: $<?= $cardDetails['issuanceLiabityA']['additionalCardFee'] ?> Annually per card, (if applicable)
								</td>
							<?php elseif (isset($cardDetails['issuanceLiabityB'])): ?>
								<td>
									<a name="1"></a>Up Front Processing Fee: $$<?= $cardDetails['issuanceLiabityB']['processingFee'] ?> (one-time fee)<br>
									Acceptance Fee: $$<?= $cardDetails['issuanceLiabityB']['acceptanceFee'] ?> (one-time fee)<br>
									Annual Fee: $$<?= $cardDetails['issuanceLiabityB']['firstYearAnnualFee'] ?> the First Year, $<?= $cardDetails['issuanceLiabityB']['annualFee'] ?> thereafter;<br>
									Participation Fee: $<?= $cardDetails['issuanceLiabityB']['participationFee'] ?> Annually++
								</td>
							<?php endif;?>
					</tr>
					<tr>
						<td>Grace Period for Repayment of Balances for Purchases </td>
						<td>
							If you pay your previous balance in full on or before the due date shown on your previous statement you will have a grace period on purchases of <?= $cardDetails['gracePeriod'] ?> days (from the statement closing date to the payment due date), and can avoid finance charges on current purchases by paying the statement balance in full on or before the due date.
						</td>
					</tr>
					<tr>
						<td>Method of Computing Balance for Purchases</td>
						<td><?= $cardDetails['computationMethod'] ?></td>
					</tr>
					<tr>
						<td>Minimum Finance Charge</td>
						<td>$<?= $cardDetails['minFinanceCharge'] ?></td>
					</tr>
					<tr>
						<td>Transaction Fee for Cash Advances</td>
						<td>Greater of $<?= $cardDetails['cashAdvanceFee'] ?> or <?= $cardDetails['cashAdvancePercentage'] ?>% of the amount of the cash advance</td>
					</tr>
					<tr>
						<td>Late Payment Fee</td>
						<td>$<?= $cardDetails['latePaymentFee'] ?></td>
					</tr>
					<tr>
						<td>Over Limit Fee</td>
						<td>$<?= $cardDetails['overLimitFee'] ?></td>
					</tr>
					<tr>
						<td>Monthly Account Maintenance Fee </td>
						<td>$<?= $cardDetails['maintainaceFee'] ?> per month on closed accounts with an outstanding balance of $<?= $cardDetails['outstandingBalance'] ?> or more. </td>
					</tr>
					<tr>
						<td>Fee for Transactions in Foreign Currencies</td>
						<td><?= $cardDetails['foreignTransactionFee'] ?>% of the transaction amount</td>
					</tr>
				</tbody>
			</table>

			<h2><?= $cardDetails['serviceOrParticipationText'] ?></h2>

			<p><strong>Other Charges:</strong> Credit Limit Increase Fee: Each time your Account is eligible and approved for a credit limit increase, a $25.00 fee is imposed. Internet Access Fee: $3.95; Copying Fee: $3.00 per item. Wire transfer fee: $5.00 per transaction. For description of FINANCE CHARGES see below.</p>

			<p><strong>Additional Fees:</strong> Return Item Charge: $25.00; Autodraft Fee: We impose an $11.00 charge for each payment made through an autodraft service we provide. Autodraft payments requested through our automated systems (i.e. Voice Response or Internet) are assessed $7.00 per transaction. Express Delivery Fee: We impose a $25.00 fee for the express delivery of your Card(s) sent Priority 2-day airmail. This service is only available on lost, stolen or replacement cards.</p>

			<p><strong>Penalty Pricing Information:</strong> If your Account goes past the due date two times in any six month period or goes past the due date for two consecutive billing cycles the APR for purchases will increase to 19.9%. The APR for purchases will be reduced back to 9.9% if the Account is kept current for 3 consecutive months or is paid in full.</p>

			<p><strong>Account Terms:</strong> This credit card account ("Account") is offered and credit cards are issued by First PREMIER Bank (Sioux Falls, SD). When your application is approved, the complete terms applicable to the Account will be furnished to you with the card. In the following disclosures, "Bank," "we," "our," and "us" refer to First PREMIER Bank, and "you" and "your" each refer to the person applying to us for an Account.</p>

			<p><strong>Changes to Rate, Fees and Terms:</strong> We may change the terms of your account, including the APR's at any time in accordance with the Credit Card Contract that will be sent with your Card.</p>
 
			<p><strong>Available Credit and Cash Advance Limitations: The initial minimum credit limit will be at least $250 and the following fees will be billed to your first statement: Account Set-Up Fee of $29.00, the Program Fee of $95.00, the Annual Fee of $48.00, the Additional Card Fee of $20.00 per card (if applicable) and monthly Service Fee of $7.00. These fees will reduce your available credit until they are paid. If you are assigned the minimum credit limit of $250 your initial available credit will be $72 ($52 if you select the additional card option).</strong></p> 

			<p><strong>Your initial cash advance line will be 10% of your assigned credit line. Once your account has been open and active for a minimum of 90 days, has two consecutive months of current payment history, is not currently delinquent and has had no return payments for 60 days, your cash advance availability may be increased to 50% of the assigned credit line. If your initial credit line is $250, your beginning cash advance line will be $25 and may increase to $125 once the criteria above is met.</strong></p>

			<p><strong>FINANCE CHARGES:</strong> Your Account will also be subject to the following FINANCE CHARGES, each of which will be billed to your Account as a purchase:</p>

			<p><strong>Periodic FINANCE CHARGES: FINANCE CHARGES</strong> are imposed when you obtain a Cash Advance and when a Purchase is posted to your Credit Account. <strong>FINANCE CHARGES</strong> are imposed from the time a Purchase is posted until it is paid in full. However, if you pay your previous balance in full on or before the Payment Due Date shown on your previous Statement, you will have a grace period on Purchases of twenty-five (25) days (from the Statement Closing Date to the Payment Due Date) and can avoid <strong>FINANCE CHARGES</strong> on current Purchases by paying the current Statement in full on or before that Payment Due Date. There is no grace period for transactions that post to the account as Cash Advances or Balance Transfers. These transactions are subject to <strong>FINANCE CHARGES</strong> from the date of the transaction.</p>

			<p><strong>Computing Periodic FINANCE CHARGES:</strong> The <strong>FINANCE CHARGE</strong> is determined by multiplying the "Average Daily Balance" for purchases and for cash advances outstanding during the monthly billing cycle by the monthly "Periodic Rate." The monthly "Periodic Rate" for purchases is 0.825%, which is equivalent to an <strong>ANNUAL PERCENTAGE RATE</strong> of 9.9%. The monthly "Periodic Rate" for penalty pricing for purchases is 1.658%, which is equivalent to an <strong>ANNUAL PERCENTAGE RATE</strong> of 19.9%. The monthly "Periodic Rate" for cash advances is 1.658%, which is equivalent to an <strong>ANNUAL PERCENTAGE RATE</strong> of 19.9%. The "Average Daily Balance" is computed by taking the beginning balance of your Account on each day, calculated separately for purchases and cash advances, adding new purchases and/or cash advances and subtracting any payments or credits to get each day's daily balance. The daily balances are then added together and divided by the number of days in the billing cycle to get the "Average Daily Balance." The minimum <strong>FINANCE CHARGE</strong> is $.50 for each billing cycle during which a <strong>FINANCE CHARGE</strong> based upon a periodic rate is imposed.</p>

			<p><strong>Cash Advance Fee:</strong> In addition to the monthly calculation of the cash advance <strong>FINANCE CHARGE</strong>, there is an additional <strong>FINANCE CHARGE</strong> of the greater of $5.00 or 3% of the amount of cash advance for each cash advance obtained that month.</p>

			<p><strong>Account Set-Up Fee: We impose a one-time Account Set-Up Fee of $29.00 as a condition of extending credit to you. This fee is a FINANCE CHARGE.</strong></p>

			<p><strong>Program Fee: We impose a one-time Program Fee of $95.00 as a condition of extending credit to you. This fee is a FINANCE CHARGE.</strong></p>

			<p><strong>Internet Access Fee: We impose a fee of $3.95 for Internet Access to your account. This is a one-time fee, which will only be assessed after you have agreed to this service. This fee is a FINANCE CHARGE.</strong></p>

			<p><strong>Credit Limit Increase Fee:</strong> Each time your Account is eligible and approved for an unsecured credit limit increase, a Credit Limit Increase Fee of $25.00 is imposed. This fee is automatically assessed upon approval of your credit limit increase, which could be as soon as six months. This fee is a <strong>FINANCE CHARGE</strong>.</p>

			<p><strong>Account Maintenance Fee:</strong> An account maintenance fee of $3.00 will be imposed for any month in which you have an outstanding balance of $20.00 or greater after you have closed your account. This fee is a <strong>FINANCE CHARGE</strong>.</p>

			<p><strong>Authorization:</strong> You certify that all information given in this application is true and correct and you are giving this information in order to obtain credit and authorize First PREMIER Bank ("Bank") to obtain information concerning any statements herein. You agree to furnish the Bank with all requested information. You authorize the Bank to charge the Account Set-Up Fee, the Program Fee, the Annual Fee, monthly Service Fee and Additional Card Fee (if applicable) to your Account.</p>

			<p><strong>Qualify For Future Credit Limit Increases: You will be eligible for consideration of a credit limit increase after 6 months. This program is designed to allow individuals to increase their credit limit based on their credit performance.</strong></p>

			<p><strong>Refund Disclosure:</strong> Your Annual, Program, Account Set-Up, monthly Service and Additional Card Fee (if applicable) are membership fees for Truth in Lending purposes. When your Account is approved, you will be sent a cardholder contract containing all of the terms applicable to your Account. If you elect to close your Account(s) within 30 days of receiving your cardholder contract and before you make any additional charges to the card, the Annual Fee, Account Set-Up Fee, Program Fee, monthly Service Fee and Additional Card Fee (if applicable) will be refunded to you. You may have the Credit Limit Increase Fee refunded upon request within 30 days of billing, which will result in a reversal of the credit limit increase. After this 30-day period these fees are no longer refundable and you are responsible for the account.</p>

			<p><strong>Arbitration:</strong> If you are issued a credit card, your cardholder contract will contain a binding arbitration provision. In the event of any dispute relating to your credit card or cardholder contract, the dispute will be resolved by binding arbitration pursuant to the rules of the National Arbitration Forum or the American Arbitration Association. Both you and we agree to waive the right to go to court or to have the dispute heard by a jury (except in regard to any collection activities on your account). You and we will be waiving any right to a jury trial and you also would not have the right to participate as part of a class of claimants relating to any dispute with us. Other rights available to you in court may also be unavailable in arbitration. When you receive your cardholder contract you should read the arbitration provision in your contract carefully and not accept or use the card unless you agree to be bound by the arbitration provision.</p>

			<p><strong>YOUR BILLING RIGHTS:</strong> Keep this notice for future use. This notice contains important information about your rights and our responsibilities under the Fair Credit Billing Act.</p>

			<p><strong>Notify Us In Case Of Errors Or Questions About Your Statement.</strong> If you think your statement is wrong, or if you need more information about a transaction on your statement, write us on a separate sheet at the address listed on your statement. Write to us as soon as possible. We must hear from you no later than sixty (60) days after we send you the first Statement on which the error or problem appeared. You can telephone us, but doing so will not preserve your rights. In your letter, give us the following information: Your name and Credit Account Number; and the dollar amount of the suspected error. Describe the error and explain, if you can, why you believe there is an error. If you need more information, describe the item you are not sure about. If you have authorized us to pay your credit card bill automatically from your savings or checking account, you can stop payment on any amount you think is wrong. To stop the payment, your letter must reach us three (3) business days before the automatic payment is scheduled to occur.</p>

			<p><strong>Your Rights And Our Responsibilities After We Receive Your Written Notice.</strong> We must acknowledge your letter within thirty (30) days, unless we have corrected the error by then. Within ninety (90) days, we must either correct the error or explain why we believe the statement was correct. After we receive your letter, we cannot try to collect any amount you question, or report you as delinquent. We can continue to bill you for the amount you question, including <strong>FINANCE CHARGES</strong>, and we can apply any unpaid amount against your credit limit. You do not have to pay any questioned amount while we are investigating, but you are still obligated to pay the parts of your statement that are not in question. If we find that we have made a mistake on your statement, you will not have to pay any <strong>FINANCE CHARGES</strong> related to any questioned amount. If we didn't make a mistake, you may have to pay <strong>FINANCE CHARGES</strong> and you will have to make up any missed payments on the questioned amount. In either case, we will send you a statement of the amount you owe and the date that it is due. If you fail to pay the amount that we think you owe, we may report you as delinquent. However, if our explanation does not satisfy you and you write us within ten (10) days telling us that you still refuse to pay, we must tell anyone we report you to that you have a question about your statement. And, we must tell you the name of anyone we reported you to. We must tell anyone we report you to that the matter has been settled between us when it finally is. If we do not follow these rules, we cannot collect the first $50.00 of the questioned amount, even if your statement was correct.</p>

			<p><strong>Special Rules Regarding Credit Card Purchases.</strong> If you have a problem with the quality of property or services that you purchased with a credit card, and you have tried in good faith to correct the problem with the merchant, you may have the right not to pay the remaining amount due on the property or services. There are two limitations on this right: A) You must have made the purchase in your home state or, if not within your home state, within 100 miles of your current mailing address; and B) The purchase price must have been more than $50.00. These limitations do not apply if we own or operate the merchant, or if we mailed you the advertisement for the property or services.</p>

			<p><strong>Your Liability For Unauthorized Use Of Your Card.</strong> You will not be liable for unauthorized use of your Card. However, to protect your rights, you are required to notify us orally or in writing as soon as you are aware that your Card has been lost, stolen or used without your consent. Certain exceptions apply and you may be liable for up to $50.00.</p>

			<p><strong>Information Sharing:</strong> The following describes your agreement with us with respect to information sharing. By requesting, obtaining, or using a credit card from us you agree that we may release information in our records regarding you and your Account: to comply with any properly served subpoena or similar request issued by a state or federal agency or court; to share your credit performance with credit reporting agencies and other creditors who we reasonably believe are or may be doing business with you on your Account; to provide information on your Account to any third party who we believe is conducting an inquiry in accordance with the Federal Fair Credit Reporting Act; to share information with our employees, agents or representatives performing work for the Bank in connection with your Account; or to communicate information as to our transactions or experiences with you to persons or entities related by common ownership or affiliated by the corporate control or with any third party (including non-affiliates). <strong>We may also share information such as (1) information other than our own transactions with you with persons or entities related to the Bank by common ownership or corporate control or</strong> (2) information on your Account with certain companies to provide or offer you selected products, services, or cardholder benefits. <strong>You may direct us not to share one or both of these. If this is your request, call #605-335-7321 or submit in writing to First PREMIER Bank, Card Services, P.O. Box 5524, Sioux Falls, South Dakota 57117-5524.</strong> Be sure to include your name, address and Credit Account Number. You may receive a copy of our information on your Account by writing or calling us at the address or telephone number listed above. By requesting or obtaining a credit card, you authorize us to check your credit history. You authorize your employer, bank and any other references listed to release and/or verify information to us and our affiliates in order to determine your eligibility for the credit card and any renewal or future extension of credit. If you ask, you will be told whether or not consumer reports on you were requested and the names of the credit bureaus, with their addresses, that provided the reports. If you designate an authorized user to use your card, you understand that Account information may also be reported to credit bureaus in the authorized user's name.</p>

			<h2>State Disclosures</h2>

			<p><strong>Ohio Residents:</strong> The Ohio laws against discrimination require that all creditors make credit equally available to all credit worthy customers, and that credit reporting agencies maintain separate credit histories on each individual upon request. The Ohio Civil Rights Commission administers compliance with this law. <strong>Kentucky Residents:</strong> You may pay the unpaid balance of your account in whole or in part at any time. <strong>New York and Vermont Residents:</strong> First PREMIER Bank may obtain a consumer report for any legitimate purpose in connection with your account or your application, including but not limited to reviewing, modifying, renewing and collecting on your account. Upon your request, we (First PREMIER Bank) will inform you of the names and addresses of any consumer reporting agencies that have furnished the reports. New York residents may contact the New York State Banking Department (1-800-518-8866) to obtain a comparative list of credit card rates, fees and grace points. <strong>California Residents:</strong> A married applicant may apply for a separate account. As required by law, you are hereby notified that a negative credit reporting reflecting on your credit record may be submitted to a credit reporting agency if you fail to fulfill the terms of your credit obligations. After credit approval, each applicant shall have the right to use the credit card account up to the limit of the account. Each applicant may be liable for amounts extended under the plan to any joint applicant. <strong>Delaware Residents:</strong> Service charges not in excess of those permitted by law will be charged on the outstanding balances from month to month. <strong>Maine Residents:</strong> Credit insurance provided herein is voluntary and you have the right to cancel such credit insurance at any time. <strong>Married Wisconsin Residents:</strong> No provision of any marital property agreement, unilateral statement, or court order applying to marital property will adversely affect a creditor's interests unless prior to the time credit is granted, the creditor is furnished with a copy of the agreement, statement or court order, or has actual knowledge of that provision.</p>

			<h2>Optional PREMIER Credit Protection&reg;</h2>

			<p>PREMIER Credit Protection is an optional benefit of your First PREMIER Bank Credit Card. Whether or not you purchase PREMIER Credit Protection is not required to obtain credit or will not affect the terms of any existing credit agreement you have with First PREMIER Bank.</p>

			<p>The monthly fee for the PREMIER Credit Protection is based on your outstanding balance multiplied by $0.89 per $100. The fee is included on your monthly First PREMIER Bank Credit Card Statement.</p>

			<p>Subject to the limitations and exclusions listed in the Conditions and Requirements of the PREMIER Credit Protection Contract, PREMIER Credit Protection cancels the Current Month Minimum Payment, as reflected on your account billing statement, in the event of Job Loss, Disability, Family Leave and Hospitalization.</p>

			<p>PREMIER Credit Protection will cancel the full outstanding balance on your account as of the date of death upon benefit approval. Subject to the limitations and exclusions listed in the Conditions and Requirements of the PREMIER Credit Protection Contract and a maximum aggregate limit of $5,000.</p>

			<p>After 30 consecutive days of Job Loss or Family Leave and upon benefit approval, PREMIER Credit Protection will cancel your next Current Month Minimum payment due until: (a) 6 continuous payments have been canceled; (b) you return to work; or (c) the account balance is zero, whichever occurs first.</p>

			<p>After 30 consecutive days of Disability and upon benefit approval, PREMIER Credit Protection will cancel your next Current Month Minimum payment due until: (a) 6 continuous payments have been canceled; (b) you are no longer disabled; or (c) the account balance is zero, whichever occurs first.</p>

			<p>After one or more consecutive nights of Hospitalization and upon benefit approval, PREMIER Credit Protection will cancel your next Current Month Minimum payment due.</p>

			<p>PREMIER Credit Protection will not cancel past due or over limit amounts. You will be responsible for the delinquent and over limit amounts during the Protected Event Period. During any period in which payments for your account is canceled, you may not be able to use your account to make purchases, take cash advances or for any other purpose.</p>

			<p>You will continue to be charged for PREMIER Credit Protection Fees during any benefit activation for Job Loss, Disability, Family Leave or Hospitalization.</p>

			<p>You must be enrolled in PREMIER Credit Protection for 30 days before a Protected Event may be activated.</p>

			<p>At least 120 days must elapse between the end of one Activation period and the beginning of another for the same type of event. There is a maximum aggregate limit of $5,000 of protection that you may have with First PREMIER Bank under PREMIER Credit Protection.</p>

			<p>If you are not completely satisfied, you'll have 30 days after enrollment to cancel and receive a full refund of any PREMIER Credit Protection Fees. You may cancel your enrollment in PREMIER Credit Protection at any time.</p>

			<p>Please carefully read the PREMIER Credit Protection Conditions and Requirements applicable to all protected events provided in the fulfillment kit, which will be sent to you after enrollment, for a full explanation of each of these eligibility requirements, conditions and exclusions that could prevent you from receiving benefits under PREMIER Credit Protection.</p>

			<h2>Privacy Notice </h2>

			<p>Protecting your privacy is of the utmost importance to First PREMIER Bank and PREMIER Bankcard Inc. We want you to understand what information we collect and how we use it.</p> 

			<p>What Information We Collect:
			We may collect "nonpublic personal information" about you from various sources including applications, account forms, transactions with us or affiliates, or consumer reporting agencies.</p>

			<p>What Information We Disclose:
			We may disclose all of the information about you that we collect.</p>

			<p>You may opt out of First PREMIER Bank disclosing to nonaffiliated third parties or our affiliates, by simply printing and completing the linked form: <a href="https://www.centennialcards.com/privacy_notice.asp">First PREMIER Bank Privacy Notice</a> or you may obtain a copy by calling 1-800-987-5521.</p>

			<p>The information described in this website is accurate as of the date you accessed it. If you have questions, please write us at First PREMIER Bank, P.O. Box 5542, Sioux Falls, SD 57117-5524.</p>