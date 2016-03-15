<?php

define( 'ERR_USER_INFO_FORM', 'Please address the errors listed below');
define( 'ERR_CAPTCHA_INCORRECT', 'Verification text incorrect. Please try again.');
define( 'ERR_UNKNOWN_ERROR', '' );
define( 'ERR_COMM_ERROR', 'There was an error communicating with the credit bureau, please try again later.' );
define( 'ERR_CB_DATA_ERROR', '%s Please check your information and try again.' );

define( 'VALIDATION_ERR_BLANK', 'cannot be blank.' );
define( 'VALIDATION_ERR_NUMERIC_ONLY', 'must contain only numbers.' );
define( 'VALIDATION_ERR_ALPHANUMERIC_ONLY', 'must contain only letters and numbers.' );
define( 'VALIDATION_ERR_ALPHA_ONLY', 'must contain only letters.' );
define( 'VALIDATION_ERR_MIN_LENGTH', 'must be at least %d %s long.' ); // %d for the integer length val, %s for "numbers" or "characters"
define( 'VALIDATION_ERR_MAX_LENGTH', 'cannot be more than %d %s long.' ); // %d for the integer length val, %s for "numbers" or "characters"

define( 'LANG_CAPTCHA_CASE_INSENSITIVE', 'Please type the characters that you see on this picture. Note: The verification code is NOT case sensitive.');

define( 'LOG_UNEXPECTED_INQUIRY_ERROR', 'An unexpected inquiry error occurred.' );
define( 'LOG_COMM_ERROR', 'A communication error occurred.' );
define( 'LOG_INQUIRY_FORMAT_ERROR', 'An inquiry format error occurred.' );

define( 'LANG_NO_MATCHES', <<<TEXT
	%s, based on the information provided by you, we could not find a match with the credit
	bureau. This is <u>not</u> a reflection of your credit quality, it only means that the
	credit bureau we use did not find a match based on the information you entered.
TEXT
);

define( 'LANG_TECHNICAL_DIFFICULTIES', <<<TEXT
	%s, we are experiencing technical difficulties communicating with the credit bureau. 
	Please try the CARD<i>MATCH<i> tool in 10 minutes.
TEXT

);


define( 'LANG_RESULTS_LEGAL', <<<LEGAL

<p>At this stage in the process, you have not applied for credit and you have not been approved or denied for any credit card product.  If you wish to apply for a credit card with any participating issuer, you will need to click through and make an application directly with that issuer. CreditCards.com does not retain any of your information, including your name, address, social security number or credit score or other credit report information, after you use the filter feature, except as a record of your authorization, and CreditCards.com will not be able to tell you why you did or did not appear to be a match with any particular credit card product.</p>
<p>If you click through to apply for some of the credit card products shown, some issuers will know that you have come through the filtering process and that you meet certain criteria established by the issuer.  If you do not click through and apply, the issuer will not know this information about you.</p>

LEGAL
);

define( 'LANG_WHY_NOT_AFFECT_CREDIT', 'A soft credit check is performed when you fill out this form. A soft credit check describes an inquiry that <i>does not</i> affect your credit score. Each soft pull is noted on your credit history file but they are only available for you to see and are not reported to lenders.');

define( 'LANG_WHY_NEED_SSN', 'Providing your SSN greatly increases the chance of finding a match with the credit bureau. This helps us better determine the credit card offers that match your credit profile. We do not store your SSN on our systems.');

define( 'LANG_WHY_NO_MATCH', 'Based on the information you entered, the credit bureau we use could not locate a file in your name. This is not a reflection of your credit quality.<br /><br />Entering your Social Security Number greatly increases your chances of finding a match, if you have not already done so.');

define( 'LANG_SSL_SECURITY', 'We use 128-bit SSL encryption to secure your information.');

