<?php
/***
 * Note: The fid session variable uniquely maps to each category page. It is used as a key for the static content arrays below.
 */
$rightPanelIndex = array(
	11   => array('offersHeading' => 'Low Interest', 'newsHeading' => 'Low Interest'),                                    // Low Interest
	12   => array('offersHeading' => 'Balance Transfer', 'newsHeading' => 'Balance Transfer'),                            // Balance Transfer
	1477 => array('offersHeading' => '0 % APR', 'newsHeading' => '0 % APR'),                                            // 0 % APR
	14   => array('offersHeading' => 'Rewards Cards', 'newsHeading' => 'Rewards Credit Card'),                            // Rewards
	77   => array('offersHeading' => 'Points Credit Cards', 'newsHeading' => 'Rewards Points Credit Card'),               // Points
	79   => array('offersHeading' => 'Gas Cards', 'newsHeading' => 'Gas Credit Card'),                                    // Gas Cards
	78   => array('offersHeading' => 'Retail Credit Cards', 'newsHeading' => 'Retail Credit Card'),                       // Retail
	15   => array('offersHeading' => 'Cash Back', 'newsHeading' => 'Cash Back Credit Card'),                              // Cash Back
	16   => array('offersHeading' => 'Travel & Airline', 'newsHeading' => 'Travel & Airline Card'),                       // Travel & Airline
	2022 => array('offersHeading' => 'No Foreign Transaction Fee', 'newsHeading' => 'Foreign Transaction Fee Card'),    // No Foreign Transaction Fee
	2005 => array('offersHeading' => 'No Annual Fee', 'newsHeading' => 'Credit Card Annual Fee'),                       // No Annual Fee
	17   => array('offersHeading' => 'Business Credit Cards', 'newsHeading' => 'Business Credit Card'),                   // Business
	18   => array('offersHeading' => 'Students Credit Cards', 'newsHeading' => 'Student Credit Card'),                    // Students
	19   => array('offersHeading' => 'Prepaid Cards', 'newsHeading' => 'Prepaid Credit & Debit Card'),                    // Prepaid & Debit
	1768 => array('offersHeading' => 'Secured Credit Cards', 'newsHeading' => 'Secured Credit Card'),                   // Secured Cards
	13   => array('offersHeading' => 'Instant Approval Cards', 'newsHeading' => 'Instant Approval Offer Credit Card'),    // Instant Approval
	2116 => array('offersHeading' => 'Smart Chip', 'newsHeading' => 'EMV Chip Credit Card'),                            // EMV Chip
	2018 => array('offersHeading' => 'Limited Time Offers', 'newsHeading' => 'Related'),                                // Limited Time Offers
	76   => array('offersHeading' => 'Excellent Credit', 'newsHeading' => 'Excellent Credit'),                            // Excellent Credit
	75   => array('offersHeading' => 'Good Credit', 'newsHeading' => 'Good Credit'),                                      // Good Credit
	74   => array('offersHeading' => 'Fair Credit', 'newsHeading' => 'Fair Credit'),                                      // Fair Credit
	20   => array('offersHeading' => 'Bad Credit', 'newsHeading' => 'Bad Credit'),                                        // Bad Credit
	1077 => array('offersHeading' => 'Limited Credit', 'newsHeading' => 'Limited or No Credit'),                        // Limited Credit
	2314 => array('offersHeading' => 'Hotel Cards', 'newsHeading' => 'Hotel Credit Card')                               // Hotel
);

$offersIndex = array(
	11   => array('balanceTransfer', 'noAnnualFee', 'zeroApr'),       // Low Interest
	12   => array('zeroApr', 'lowInterest'),                          // Balance Transfer
	1477 => array('lowInterest', 'balanceTransfer'),                // 0 % APR
	14   => array('cashBack', 'travel'),                              // Rewards
	77   => array('rewards', 'airlines'),                             // Points
	79   => array('travel', 'rewards'),                               // Gas Cards
	78   => array('rewards', 'cashBack'),                             // Retail
	15   => array('rewards', 'gas'),                                  // Cash Back
	16   => array('rewards', 'noForeignTransactionFee'),              // Travel & Airline
	2022 => array('travel', 'hotel'),                               // No Foreign Transaction Fee
	2005 => array('lowInterest', 'zeroApr'),                        // No Annual Fee
	17   => array('travel', 'cashBack'),                              // Business
	18   => array('noCreditHistory', 'prepaidDebit'),                 // Students
	19   => array('secured', 'badCredit'),                            // Prepaid & Debit
	1768 => array('badCredit', 'prepaidDebit'),                     // Secured Cards
	13   => array('fairCredit', 'prepaidDebit'),                      // Instant Approval
	2116 => array('travel', 'noForeignTransactionFee'),             // EMV Chip
	2018 => array('topOffers', 'bestCreditCards'),                  // Limited Time Offers
	76   => array('travel', 'cashBack'),                              // Excellent Credit
	75   => array('excellentCredit', 'fairCredit'),                   // Good Credit
	74   => array('badCredit', 'noCreditHistory'),                    // Fair Credit
	20   => array('secured', 'prepaidDebit'),                         // Bad Credit
	1077 => array('student', 'badCredit'),                          // Limited Credit
	2314 => array('travel', 'noForeignTransactionFee')              // Hotel
);

$newsIndex = array(
	11 => array(     // Low Interest
		array(
			'title' => 'Ways to pay off high-interest debt',
			'articleText' => 'Getting into more debt to pay off old debt isn\'t always the best idea',
			'image' => '/credit-card-news/images/sally-herigstad-150.jpg',
			'link' => '/credit-card-news/high-interest-card-debt-payoff-solutions-1294.php'
		), array(
			'title' => 'Poll: Asking for better credit card terms pays off',
			'articleText' => 'Few ask, but those who do usually get rates lowered, late fees waived',
			'image' => '/credit-card-news/images/just-ask.jpg',
			'link' => '/credit-card-news/poll-ask-better-terms.php'
		)
	), 12 => array(     // Balance Transfer
		array(
			'title' => '2014 balance transfer survey: Beware combo deals, two-tier fees',
			'articleText' => 'Long-lasting 0-percent offers abound, but watch for the new tweaks',
			'image' => '/credit-card-news/images/balance-transfer-5.jpg',
			'link' => '/credit-card-news/2014-balance-transfer-survey-1266.php'
		),

		array(
			'title' => '9 things you should know about balance transfers',
			'articleText' => 'If you\'ve racked up debt on a high-interest credit card, transferring',
			'image' => '/credit-card-news/images/melody-warnick-author-photo.jpg',
			'link' => '/credit-card-news/help/9-things-you-should-know-about-balance-transfers-6000.php'
		)
	), 1477 => array(   // 0 % APR
		array(
			'title' => 'CFPB warns card issuers: Reveal costs of 0% promotional offers',
			'articleText' => 'Careful -- that 0 percent balance transfer deal might actually cost you',
			'image' => '/credit-card-news/images/authors/fred-williams-main.jpg',
			'link' => '/credit-card-news/cfpb-warns-promotional-costs-grace-period-1282.php'
		),

		array(
			'title' => 'Making 0% cards work for your small business',
			'articleText' => 'If your mailbox is filling up with 0-percent-interest credit card offers',
			'image' => '/credit-card-news/images/zero-percent-sm-business.jpg',
			'link' => '/credit-card-news/making-zero-percent-cards-work-small_business-1269.php'
		)
	), 14 => array(     // Rewards
		array(
			'title' => 'Getting started with rewards cards',
			'articleText' => 'The options can seem daunting, but a little bit of research can be',
			'image' => '/credit-card-news/images/tony-mecia-150.jpg',
			'link' => '/credit-card-news/getting-started-rewards-cards-1433.php'
		), array(
			'title' => 'Trip canceled? Your credit card may reimburse you',
			'articleText' => 'Many cards offer free, but limited, alternative to trip cancellation',
			'image' => '/credit-card-news/images/travel-insurance-suitcases.jpg',
			'link' => '/credit-card-news/card-trip-travel-cancel-reimburse-1273.php'
		)
	), 77 => array(     // Points
		array(
			'title' => 'Is there any easy way to track points and miles?',
			'articleText' => 'I just discovered some reward points and bought myself a $100',
			'image' => '/credit-card-news/images/expert-mccarthy.jpg',
			'link' => '/credit-card-news/track-mileage-points-1433.php'
		), array(
			'title' => '8 ways to maximize your credit card rewards points',
			'articleText' => 'Once you\'ve earned all those bonus points, spend them wisely',
			'image' => '/credit-card-news/images/maximize-rewards.png',
			'link' => '/credit-card-news/8-tips-maximize-spending-rewards-points-1277.php'
		)
	), 79 => array(     // Gas Cards
		array(
			'title' => 'Drive for rewards pushes old-style gas cards in ditch',
			'articleText' => 'A generation ago, gas credit cards issued by oil companies were widely',
			'image' => '/credit-card-news/images/article-gas-station-card-skimmers-1282.jpg',
			'link' => '/credit-card-news/gas-credit-cards-1277.php'
		),

		array(
			'title' => 'Compare rewards cards for business gas spending',
			'articleText' => 'I have a small business and I need credit cards for the employees to',
			'image' => '/credit-card-news/images/elaine-pofeldt-main.jpg',
			'link' => '/credit-card-news/rewards-business-gas-1585.php'
		)
	), 78 => array(     // Retail
		array(
			'title' => 'Retail card survey 2014: APRs get higher, rewards more complicated',
			'articleText' => 'The cost of borrowing from your favorite retailer has gone up',
			'image' => '/credit-card-news/images/retail-cards-survey.jpg',
			'link' => '/credit-card-news/retail_card-stores-survey-apr_2014-1276.php'
		), array(
			'title' => 'Study: Data breaches pose a greater risk',
			'articleText' => 'The risk level is growing for anyone whose information is stolen in a',
			'image' => '/credit-card-news/images/data-breach-greater-risk.jpg',
			'link' => '/credit-card-news/data-breach-id-theft-risk-increase-study-1282.php'
		)
	), 15 => array(     // Cash Back
		array(
			'title' => 'Cash-back credit cards survey: More generous, but more complicated',
			'articleText' => 'Cash-back credit cards are becoming more lucrative for cardholders',
			'image' => '/credit-card-news/images/cash-back-survey.jpg',
			'link' => '/credit-card-news/cash-back-credit-card-survey-2012-1277.php'
		), array(
			'title' => 'What\'s the best low-hassle cash-back card?',
			'articleText' => 'If you travel mostly by car, you want to maximize cash back, not air',
			'image' => '/credit-card-news/images/expert-mccarthy.jpg',
			'link' => '/credit-card-news/low_hassle-cash_back-driver-rewards-1433.php'
		)
	), 16 => array(     // Travel & Airline
		array(
			'title' => 'Using points when holiday award seats are full',
			'articleText' => 'There are creative ways to use credit card points or perks to travel',
			'image' => '/credit-card-news/images/tony-mecia-150.jpg',
			'link' => '/credit-card-news/using-points-during-holidays-1433.php'
		), array(
			'title' => 'Trip canceled? Your credit card may reimburse you',
			'articleText' => 'Many cards offer free, but limited, alternative to trip cancellation',
			'image' => '/credit-card-news/images/travel-insurance-suitcases.jpg',
			'link' => '/credit-card-news/card-trip-travel-cancel-reimburse-1273.php'
		)
	), 2022 => array(   // No Foreign Transaction Fee
		array(
			'title' => 'Credit card foreign transaction fees mostly up',
			'articleText' => 'Seeking big spenders, a few card issuers buck the trend and drop the fee',
			'image' => '/credit-card-news/images/foreign-transactions-fees.jpg',
			'link' => '/credit-card-news/foreign-exchange-fees-going-up-1267.php'
		),

		array(
			'title' => 'Cards with no foreign transaction fee cards surge',
			'articleText' => 'Fees reduced or waived to lure well-heeled travelers',
			'image' => '/credit-card-news/images/cc-foreign-transaction-fees.jpg',
			'link' => '/credit-card-news/credit-card-foreign-transaction-fees-disappearing-1280.php'
		)
	), 2005 => array(   // No Annual Fee
		array(
			'title' => 'New high-end cards boost average cost of annual fee cards',
			'articleText' => 'Study pegs average annual fee at $163, nearly double a year ago',
			'image' => '/credit-card-news/images/cc-annual-fee.jpg',
			'link' => '/credit-card-news/annual-fee-cost-rise.php'
		),

		array(
			'title' => '5 questions to ask before getting a credit card with an annual fee',
			'articleText' => 'More card issuers are adding them; make sure they\'re worth it',
			'image' => '/credit-card-news/images/gen/help-symbol.png',
			'link' => '/credit-card-news/help/5-key-questions-credit-card-annual-fee-6000.php'
		)
	),

	17 => array(     // Business
		array(
			'title' => '8 steps to build your business credit profile',
			'articleText' => 'When it comes to growing your business, co-mingling personal and business',
			'image' => '/credit-card-news/images/business-credit-profile.jpg',
			'link' => '/credit-card-news/8-steps-build-business_credit_profile-1269.php'
		),

		array(
			'title' => 'Financing your small business with plastic: A capital idea?',
			'articleText' => 'Credit cards can get your business off and running, but not without hurdles',
			'image' => '/credit-card-news/images/sm-business-creditcards.jpg',
			'link' => '/credit-card-news/financing-small_businesses-credit_cards-1269.php'
		)
	),

	18 => array(     // Students
		array(
			'title' => '10 ways students can build good credit',
			'articleText' => 'There are tricks and techniques, but it boils down to being responsible',
			'image' => '/credit-card-news/images/jeremy-simon-150.jpg',
			'link' => '/credit-card-news/help/10-ways-students-get-good-credit-6000.php'
		),

		array(
			'title' => 'Top 10 ways students ruin their credit',
			'articleText' => 'No one wants to ruin their credit, but students who have never handled credit',
			'image' => '/credit-card-news/images/people-and-their-plastic.jpg',
			'link' => '/credit-card-news/top-10-ways-students-ruin-credit-1279.php'
		)
	),

	19 => array(     // Prepaid & Debit
		array(
			'title' => '9 things you need to know about prepaid cards',
			'articleText' => 'Thinking about picking up a reloadable prepaid card? Here\'s what you should',
			'image' => '/credit-card-news/images/gen/help-symbol.png',
			'link' => '/credit-card-news/help/9-things-you-need-to-know-about-prepaid-cards-6000.php'
		),

		array(
			'title' => 'Prepaid debit cards: With all the scams, are they worth it?',
			'articleText' => 'New scams involving prepaid debit cards are making headlines: fake',
			'image' => '/credit-card-news/images/prepaid-cards-prey.jpg',
			'link' => '/credit-card-news/prepaid-debit-card-scams.php'
		)
	),

	1768 => array(   // Secured Cards
		array(
			'title' => 'Best ways to manage a secured card',
			'articleText' => 'I was offered a credit card with a $300 credit limit. How do these cards',
			'image' => '/credit-card-news/images/expert-sandberg-2.jpg',
			'link' => '/credit-card-news/secured-card-management-tips-1377.php'
		),

		array(
			'title' => '7 questions to ask when choosing a secured credit card',
			'articleText' => 'If you\'re shopping for a secured card, chances are you\'re anything but',
			'image' => '/credit-card-news/images/secured-cc.jpg',
			'link' => '/credit-card-news/7-questions-choosing-secured-credit-cards-1265.php'
		)
	),

	13 => array(     // Instant Approval
		array(
			'title' => 'Applying for a credit card? Your odds for approval',
			'articleText' => 'If you\'re in the market for a credit card, you probably are wondering whether',
			'image' => '/credit-card-news/images/approval-rates.jpg',
			'link' => '/credit-card-news/application-odds-approval-1267.php'
		),

		array(
			'title' => 'Instant in-store credit card offers in danger of extinction',
			'articleText' => 'Instant in-store credit card offers -- you know, the ones pitched by pesky',
			'image' => '/credit-card-news/images/catching-credit-card.jpg',
			'link' => '/credit-card-news/retail-store-instant-credit-card-offers-impact-1282.php'
		)
	),

	2116 => array(   // EMV Chip
		array(
			'title' => 'Preparing your business for EMV migration',
			'articleText' => 'Beginning Oct. 1, 2015, businesses without credit card terminals designed',
			'image' => '/credit-card-news/images/hourglass-emv-deadline.jpg',
			'link' => '/credit-card-news/preparing-your-business-emv-migration.php'
		),

		array(
			'title' => '8 FAQs about the new EMV credit cards',
			'articleText' => 'The nationwide shift to EMV has begun. EMV -- which stands for Europay',
			'image' => '/credit-card-news/images/emv-confusion.jpg',
			'link' => '/credit-card-news/emv-faq-chip-cards-answers-1264.php'
		)
	),

	2018 => array(   // Limited Time Offers
		array(
			'title' => 'Pre-screened offers don\'t guarantee card approval',
			'articleText' => 'I received a letter from my national bank to apply for a credit card',
			'image' => '/credit-card-news/images/expert-sandberg-2.jpg',
			'link' => '/credit-card-news/prescreened-offers-not-automatical-approval-credit-cards-1377.php'
		),

		array(
			'title' => '\'Free trial\' offers can bring unwanted credit card charges',
			'articleText' => 'Log on to the Internet and prepare to be greeted with advertisements offering',
			'image' => '/credit-card-news/images/scam.jpg',
			'link' => '/credit-card-news/beware-free-trial-scams-1280.php'
		)
	),

	76 => array(     // Excellent Credit
		array(
			'title' => '10 worst credit card mistakes',
			'articleText' => 'Whether you\'re in a financial crunch, dream of an island vacation or want to',
			'image' => '/credit-card-news/images/gen/help-symbol.png',
			'link' => '/credit-card-news/help/worst-credit-card-mistakes-6000.php'
		),

		array('title' => 'Even with high credit score, some card applicants rejected',
		      'articleText' => 'I signed up for an American Express card that offered a 30,000 point',
		      'image' => '/credit-card-news/images/tony-mecia-150.jpg',
		      'link' => '/credit-card-news/high-score-rejected-churn-reward-1433.php')
	),

	75 => array(     // Good Credit
		array('title' => 'Credit limit tricks: Keep a high score while still using your card',
		      'articleText' => 'Here\'s an axiom familiar to borrowers: Using too much of your available credit',
		      'image' => '/credit-card-news/images/card-up-sleeve.jpg',
		      'link' => '/credit-card-news/credit-limit-utilization-ratio-use-charge-1267.php'),

		array(
			'title' => 'Charge a lot? Pay early and often to avoid score damage',
			'articleText' => 'I have always paid off my credit card balances in full every month, for',
			'image' => '/credit-card-news/images/barry-paperno-150.jpg',
			'link' => '/credit-card-news/low-score-high-credit-utilization-1586.php'
		)
	),

	74 => array(     // Fair Credit
		array(
			'title' => 'How to cancel a credit card',
			'articleText' => 'You want to cancel your credit card. Before you pick up your scissors, know',
			'image' => '/credit-card-news/images/gen/help-symbol.png',
			'link' => '/credit-card-news/help/cancel-credit-card-6000.php'
		),

		array(
			'title' => '8 legitimate ways to improve your credit score now',
			'articleText' => 'Your credit card personality: The Avoider. Your traits: The less you know',
			'image' => '/credit-card-news/images/TheVeteran_150x250.gif',
			'link' => '/credit-card-news/help/credit-card-financial-personalities-avoider-6000.php'
		)
	),

	20 => array(     // Bad Credit
		array(
			'title' => '10 worst credit card mistakes',
			'articleText' => 'Whether you\'re in a financial crunch, dream of an island vacation or',
			'image' => '/credit-card-news/images/gen/help-symbol.png',
			'link' => '/credit-card-news/help/worst-credit-card-mistakes-6000.php'
		),

		array(
			'title' => 'How wage garnishment works -- and how to avoid it',
			'articleText' => 'Whether you\'re in a financial crunch, dream of an island vacation or',
			'image' => '/credit-card-news/images/garnishment.jpg',
			'link' => '/credit-card-news/help/worst-credit-card-mistakes-6000.php'
		)
	), 1077 => array(   // Limited Credit
		array(
			'title' => '9 things you need to know about prepaid cards',
			'articleText' => 'Thinking about picking up a reloadable prepaid card? Here\'s what you should',
			'image' => '/credit-card-news/images/gen/help-symbol.png',
			'link' => '/credit-card-news/help/9-things-you-need-to-know-about-prepaid-cards-6000.php'
		),

		array(
			'title' => '10 things NOT to do when you apply for a credit card',
			'articleText' => 'As with any loan, applying for a credit card involves preparation, especially',
			'image' => '/credit-card-news/images/whammy-large.png',
			'link' => '/credit-card-news/10-things-not-to-do-before-applying-for-credit-card-1270.php'
		)
	), 2314 => array(  // Hotel
		array(
			'title' => 'Third-party booking sites trip up hotel rewards',
			'articleText' => 'Reward programs can be a pretty sweet deal for business travelers: Your company picks up the tab for travel',
			'image' => '/images/tony-mecia-150.jpg',
			'link' => '/credit-card-news/third_party-booking-sites-hotel-rewards-1433.php'
		),

		array(
			'title' => 'Spotting and avoiding hidden hotel fees',
			'articleText' => 'Locking away your laptop in a hotel room safe for safekeeping? Looking for a quick workout after sitting in a business meeting all day?',
			'image' => '/images/hotel-fees.jpg',
			'link' => '/credit-card-news/hotel-hidden-fees-1273.php'
		),

		array(
			'title' => 'Can I get more rewards by using my hotel\'s app?',
			'articleText' => 'I\'ve had a Marriott Rewards Visa for about a year, but just discovered the hotel\'s app and earned some extra points by',
			'image' => '/images/expert-mccarthy.jpg',
			'link' => '/credit-card-news/rewards-hotel-apps-1433.php'
		)
	)

);

$recommendationsIndex = array(
	11   => array('cash-back-or-low-interest', 'better-offers-with-cardmatch'),       // Low Interest
	12   => array('better-offers-with-cardmatch', 'balance-transfer-calculator'),     // Balance Transfer
	1477 => array('better-offers-with-cardmatch'),                                  // 0 % APR
	14   => array('try-wallet-up', 'better-offers-with-cardmatch'),                   // Rewards
	77   => array('try-wallet-up', 'better-offers-with-cardmatch'),                   // Points
	79   => array('better-offers-with-cardmatch', 'try-wallet-up'),                   // Gas Cards
	78   => array('try-wallet-up'),                                                   // Retail
	15   => array('better-offers-with-cardmatch', 'try-wallet-up'),                   // Cash Back
	16   => array('try-wallet-up', 'better-offers-with-cardmatch'),                   // Travel & Airline
	2022 => array('try-wallet-up', 'better-offers-with-cardmatch'),                 // No Foreign Transaction Fee
	2005 => array('try-wallet-up', 'better-offers-with-cardmatch'),                 // No Annual Fee
	17   => array('try-wallet-up'),                                                   // Business
	18   => array('guard-your-credit', 'credit-score-estimator'),                     // Students
	19   => array('guard-your-credit'),                                               // Prepaid & Debit
	1768 => array('guard-your-credit', 'my-creditcards'),                           // Secured Cards
	13   => array('guard-your-credit'),                                               // Instant Approval
	2116 => array('try-wallet-up', 'better-offers-with-cardmatch'),                 // EMV Chip
	2018 => array('try-wallet-up'),                                                 // Limited Time Offers
	76   => array('better-offers-with-cardmatch', 'try-wallet-up'),                   // Excellent Credit
	75   => array('try-wallet-up', 'better-offers-with-cardmatch'),                   // Good Credit
	74   => array('guard-your-credit', 'my-creditcards'),                             // Fair Credit
	20   => array('guard-your-credit', 'my-creditcards'),                             // Bad Credit
	1077 => array('guard-your-credit', 'my-creditcards'),                           // Limited Credit
	2314 => array('try-wallet-up', 'better-offers-with-cardmatch'),                 // Hotel
	37   => array('try-wallet-up-top-offers', 'better-offers-with-cardmatch')         // Top Offers
);

$recommendationTypes = array(
	'cash-back-or-low-interest'    => array(
		'title' => 'Cash Back or Low Interest?',
		'image' => '<i class="fa fa-percent"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'text' => 'Find out whether a Cash Back or Low Interest card is better for your unique situation.',
		'link' => '/calculators/cash-back-or-low-interest.php'),

	'better-offers-with-cardmatch' => array(
		'title' => 'Better Offers with CardMatch&#8482;',
		'image' => '<img src="/images/homepage/cardmatch-icon.png"/>',
		'class' => 'gutter-icon-hldr-greyicn-img',
		'text' => 'You could be matched with special offers only available here.',
		'link' => '/cardmatch/?action=show_form'),

	'minimum-payment-calculator' => array(
		'title' => 'Minimum Payment Calculator',
		'image' => '<i class="fa fa-calculator"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'text' => 'Find out how much you pay in interest if you only make minimum payments.',
		'link' => '/calculators/minimum-payment.php'),

	'balance-transfer-calculator' => array(
		'title' => 'Balance Transfer Calculator',
		'image' => '<i class="fa fa-arrows-h"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'text' => 'Calculate the amount of interest you\'ll save by transferring existing balances to a lower rate card.',
		'link' => '/calculators/balance-transfer.php'),

	'try-wallet-up' => array(
		'title' => 'Try WalletUp&reg;',
		'image' => '<img src="/images/homepage/walletup-icon.png"/>',
		'class' => 'gutter-icon-hldr-greyicn-img',
		'text' => 'Maximize your points. Get card recommendations based on your spending profile.',
		'link' => 'https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=left_nav&utm_campaign=walletup'),

	'try-wallet-up-top-offers' => array(
		'title' => 'Try WalletUp&reg;',
		'image' => '<img src="/images/homepage/walletup-icon.png"/>',
		'class' => 'gutter-icon-hldr-greyicn-img',
		'text' => 'Maximize your points. Get card recommendations based on your spending profile.',
		'link' => 'https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=topcards_right&utm_campaign=walletup'),

	'guard-your-credit' => array(
		'title' => 'Guard your Credit',
		'image' => '<img src="/images/homepage/cardmatch-icon.png"/>',
		'class' => 'gutter-icon-hldr-greyicn-img',
		'text' => 'CardMatch&#8482; matches you with offers you are more likely to qualify for.',
		'link' => '/cardmatch/?action=show_form'),

	'credit-score-estimator' => array(
		'title' => 'Credit Score Estimator',
		'image' => '<i class="fa fa-calculator"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'text' => 'Answer a few questions and get an estimate of your credit score -  free.',
		'link' => '/credit-score-estimator'),

	'my-creditcards' => array(
		'title' => 'Get a FREE Credit Score',
		'image' => '<img src="/images/homepage/mycc-icon.png"/>',
		'class' => 'gutter-icon-hldr-greyicn-img',
		'text' => 'Get a free credit score, free credit report and more.',
		'link' => 'https://my.creditcards.com/?qls=MCC_RGHTGUTT.080315CRED')
);

// Commenting out links for categories that are not yet ready on Staff Reviews side.
$reviewsIndex = array(
	11   => array('low-interest-reviews'),				// Low Interest
	12   => array('balance-transfer-reviews'),			// Balance Transfer
	14   => array('rewards-reviews'),					// Rewards
	15   => array('cash-back-reviews'),					// Cash Back
//	16   => array('travel-reviews'),					// Travel & Airline
//	17   => array('business-reviews'),					// Business
	18   => array('students-reviews'),					// Students
//	2314 => array('hotel-reviews'),						// Hotel
);

$reviewTypes = array(
	'low-interest-reviews' => array(
		'title' => 'Read Reviews On Low Interest Credit Cards',
		'image' => '<i class="fa fa-star"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'link' => '/reviews/low-interest'
	),
	'balance-transfer-reviews' => array(
		'title' => 'Read Reviews On Balance Transfer Credit Cards',
		'image' => '<i class="fa fa-star"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'link'  => '/reviews/balance-transfer'
	),
	'rewards-reviews' => array(
		'title' => 'Read Reviews on Rewards Credit Cards',
		'image' => '<i class="fa fa-star"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'link'  => '/reviews/rewards'
	),
	'cash-back-reviews' => array(
		'title' => 'Read Reviews On Cash Back Credit Cards',
		'image' => '<i class="fa fa-star"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'link'  => '/reviews/cash-back'
	),
	'travel-reviews' => array(
		'title' => 'Read Reviews On Travel &amp; Airline Credit Cards',
		'image' => '<i class="fa fa-star"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'link'  => '/reviews/travel'
	),
	'business-reviews' => array(
		'title' => 'Read Reviews On Business Credit Cards',
		'image' => '<i class="fa fa-star"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'link'  => '/reviews/business'
	),
	'students-reviews' => array(
		'title' => 'Read Reviews On Student Credit Cards',
		'image' => '<i class="fa fa-star"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'link'  => '/reviews/students'
	),
	'hotel-reviews' => array(
		'title' => 'Read Reviews On Hotel Credit Cards',
		'image' => '<i class="fa fa-star"></i>',
		'class' => 'gutter-icon-hldr-grey',
		'link'  => '/reviews/hotel'
	),
);

$categoryFid = $_SESSION['fid'] ? $_SESSION['fid'] : "";
$offersHeading = $rightPanelIndex[$categoryFid]['offersHeading'];
$newsHeading = $rightPanelIndex[$categoryFid]['newsHeading'];
$offers = $offersIndex[$categoryFid];
$newsItems = $newsIndex[$categoryFid];
$recommendations = $recommendationsIndex[$categoryFid];
$reviews = $reviewsIndex[$categoryFid];

?>
<!-- Staff Reviews Link -->
<?php if (isset($reviews)): ?>
	<div class="panel panel-grey">
		<div class="panel-heading">Credit Card Reviews</div>
		<div class="panel-body">
			<?php foreach($reviews as $review) : ?>
				<div class="list-group">
					<a href="<?= $reviewTypes[$review]['link'] ?>" class="list-group-item list-group-item-greyicn">
						<span class="<?= $reviewTypes[$review]['class']; ?> pull-left">
							<?= $reviewTypes[$review]['image']; ?>
						</span>
						<div class="list-group-item-heading">
							<?= $reviewTypes[$review]['title'] ?>
						</div>
					</a>
				</div>

			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

<!-- Related Offers -->
<?php if(isset($offers)): ?>
	<div class="panel panel-grey">
		<!--on the Prepaid page we would like to display "Related Offers" -->
		<?php if($offersHeading == 'Prepaid Cards'): ?>
			<div class="panel-heading">Related Offers</div>
		<?php else: ?>
			<div class="panel-heading">Offers related to <?= $offersHeading ?></div>
		<?php endif; ?>
		<div class="panel-body">
			<?php foreach($offers as $offer) {
				include_once('related-offers/' . $offer . '.php');
			} ?>
		</div>
	</div>
<?php endif; ?>
<!-- End Related Offers -->

<!-- My.CreditCards.com Module-->
<?php
$myCreditCardsModule = array(
	'title' => 'All three for FREE',
	'image' =>'<img src="/images/homepage/mycc-icon.png"/>',
	'class' => 'gutter-icon-hldr-greyicn-img',
	'text' => 'Get a credit score, credit report and credit monitoring for FREE. Updated each month',
	'link' => 'https://my.creditcards.com/?qls=MCC_RGHTGUTT.080315CRED');
$allowedCategories = array('75', '76', '1477', '19', '16');
if(isset($myCreditCardsModule) && in_array($categoryFid, $allowedCategories)): ?>
	<div class="panel panel-grey">
		<div class="panel-heading">My.CreditCards.com</div>
		<div class="panel-body">
			<div class="list-group">
				<a href="<?= $myCreditCardsModule['link'] ?>" class="list-group-item list-group-item-greyicn"
				   target="_blank">
				<span class="<?= $myCreditCardsModule['class'] ?> pull-left"><?= $myCreditCardsModule['image'] ?></span>

					<div class="list-group-item-heading"><?= $myCreditCardsModule['title'] ?></div>
					<p class="list-group-item-text"><?= $myCreditCardsModule['text'] ?></p>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>
<!-- End My.CreditCards.com Module-->
<!-- Recommendations -->
<?php if(isset($recommendations)): ?>
	<div class="panel panel-grey">
		<div class="panel-heading">Need a Recommendation?</div>
		<div class="panel-body">
			<?php foreach($recommendations as $recommendation):
				$isWalletUp = ($recommendation == 'try-wallet-up' || $recommendation == 'try-wallet-up-top-offers');
				$isCardMatch = ($recommendation == 'better-offers-with-cardmatch');
				$isMyCCCOM = ($recommendation == 'my-creditcards');
				?>
				<div class="list-group">
					<a href="<?= $recommendationTypes[$recommendation]['link'] ?>"
					   class="list-group-item list-group-item-greyicn" <?php if($isWalletUp || $isCardMatch || $isMyCCCOM) {
						echo 'target="_blank"';
					} ?>>
						<span class="<?= $recommendationTypes[$recommendation]['class'];?> pull-left">
                                <?= $recommendationTypes[$recommendation]['image']; ?></span>
						<div class="list-group-item-heading"><?= $recommendationTypes[$recommendation]['title'] ?></div>
						<p class="list-group-item-text"><?= $recommendationTypes[$recommendation]['text'] ?></p>
					</a>
				</div>

			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
<!-- End Recommendations -->

<!-- News -->
<?php if(isset($newsItems)): ?>
	<div class="panel panel-grey">
		<div class="panel-heading"><?= $newsHeading ?> News</div>
		<div class="panel-body">
			<?php foreach($newsItems as $newsItem): ?>
				<div class="list-group">
					<a href="<?= $newsItem['link'] ?>" class="list-group-item list-group-item-grey">
						<div class="list-group-item-heading"><?= $newsItem['title'] ?></div>
						<p class="list-group-item-text"><?= $newsItem['articleText'] ?>...</p>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?> <!-- End News --> <!-- Content container to add padding -->
