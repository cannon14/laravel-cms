<?php
$pagefid = "1581";

include_once('templates/partials/initTracking.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<?php

$error_class = 'has-error';
$this->title = 'Online Credit Check - We match you with the right credit cards';
$this->description = "CardMatch can help you find special credit card deals by matching your credit profile with offers you're likely to qualify for. It's free and doesn't impact your credit score.";
$this->keywords = 'credit cards, credit profile, offers, match, tool, qualify, deals, score, find a card';
$states = array(
	"AL" => "Alabama",
	"AK" => "Alaska",
	"AZ" => "Arizona",
	"AR" => "Arkansas",
	"CA" => "California",
	"CO" => "Colorado",
	"CT" => "Connecticut",
	"DE" => "Delaware",
	"DC" => "District of Columbia",
	"FL" => "Florida",
	"GA" => "Georgia",
	"HI" => "Hawaii",
	"ID" => "Idaho",
	"IL" => "Illinois",
	"IN" => "Indiana",
	"IA" => "Iowa",
	"KS" => "Kansas",
	"KY" => "Kentucky",
	"LA" => "Louisiana",
	"ME" => "Maine",
	"MD" => "Maryland",
	"MA" => "Massachusetts",
	"MI" => "Michigan",
	"MN" => "Minnesota",
	"MS" => "Mississippi",
	"MO" => "Missouri",
	"MT" => "Montana",
	"NE" => "Nebraska",
	"NV" => "Nevada",
	"NH" => "New Hampshire",
	"NJ" => "New Jersey",
	"NM" => "New Mexico",
	"NY" => "New York",
	"NC" => "North Carolina",
	"ND" => "North Dakota",
	"OH" => "Ohio",
	"OK" => "Oklahoma",
	"OR" => "Oregon",
	"PA" => "Pennsylvania",
	"RI" => "Rhode Island",
	"SC" => "South Carolina",
	"SD" => "South Dakota",
	"TN" => "Tennessee",
	"TX" => "Texas",
	"UT" => "Utah",
	"VT" => "Vermont",
	"VA" => "Virginia",
	"WA" => "Washington",
	"WV" => "West Virginia",
	"WI" => "Wisconsin",
	"WY" => "Wyoming"
);

$htmlTitle = $this->title;
$metaDescription = $this->description;
$metaKeyword = $this->keywords;
include_once("templates/partials/htmlHead.php");
include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
</head>

<?php include_once("templates/partials/header.php"); ?>

<!-- Progress Bar -->
<div class="steps-block">
	<div class="container">
		<div class="row">
			<div class="col-xs-24 col-sm-6 active-step">
				<div class="blue-circle">1</div>
				About You
			</div>

			<div class="col-xs-3 col-sm-3 step-arrow-hldr mobile-hide"><i class="fa fa-long-arrow-right step-arrow"></i></div>
			<div class="col-xs-6 col-sm-6 inactive-step mobile-hide">
				<div class="grey-circle">2</div>
				Terms &amp; Conditions
			</div>

			<div class="col-xs-3 col-sm-3 step-arrow-hldr mobile-hide"><i class="fa fa-long-arrow-right step-arrow"></i></div>
			<div class="col-xs-6 col-sm-6 inactive-step mobile-hide">
				<div class="grey-circle">3</div>
				Card Matches
			</div>
		</div>
	</div>
</div>

<?php if ($this->showResultsLink) : ?>
	<a href="../templates/?action=<?= $this->showResultsAction ?>&amp;prev=true">Show previous results</a>
<?php endif; ?>

<!-- Main Content and Form -->
<div class="about-block">
	<div class="container">
		<div class="row">
			<div class="col-md-24">
				<div class="header-description">We&#8217;ll match you with offers from our participating partners in <span style="color:#429e5d;"><strong>less than 60 seconds. </strong></span></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-24 col-sm-12 col-sm-push-12 col-md-12 col-md-push-12 col-lg-12 col-lg-push-12">
							<div class="cm-disclosure-hldr"><a data-target="#myModalDisclosure" data-toggle="modal" href="#"><img src="images/advertiser_dis_text.png" class="pull-right"></a>
					<div class="clearfix"></div>
				</div>

				<?php

				$errors  = array(
					'firstName' => $this->getError('firstName'),
					'lastName' => $this->getError('lastName'),
					'streetAddress' => $this->getError('streetAddress'),
					'city' => $this->getError('city'),
					'state' => $this->getError('state'),
					'zipCode' => $this->getError('zipCode'),
					'ssn' => $this->getError('ssn')
				);

				$userInput = array(
					'firstName' => $_REQUEST['firstName'],
					'lastName' => $_REQUEST['lastName'],
					'streetAddress' => $_REQUEST['streetAddress'],
					'city' => $_REQUEST['city'],
					'state' => $_REQUEST['state'],
					'zipCode' => $_REQUEST['zipCode'],
					'ssn' => $_REQUEST['ssn']
				);

				$hasPreviousInput = array(
					'firstName' => isset($userInput['firstName']) && !empty($userInput['firstName']),
					'lastName' => isset($userInput['lastName']) && !empty($userInput['lastName']),
					'streetAddress' => isset($userInput['streetAddress']) && !empty($userInput['streetAddress']),
					'city' => isset($userInput['city']) && !empty($userInput['city']),
					'state' => isset($userInput['state']) && !empty($userInput['state']),
					'zipCode' => isset($userInput['zipCode']) && !empty($userInput['zipCode']),
					'ssn' => isset($userInput['ssn']) && !empty($userInput['ssn'])
				);

				$formValueAttribute =  array(
					'firstName' => ($hasPreviousInput['firstName']) ? 'value="'.$userInput['firstName'].'"' : '',
					'lastName' => ($hasPreviousInput['lastName']) ? 'value="'.$userInput['lastName'].'"' : '',
					'streetAddress' => ($hasPreviousInput['streetAddress']) ? 'value="'.$userInput['streetAddress'].'"' : '',
					'city' => ($hasPreviousInput['city']) ? 'value="'.$userInput['city'].'"' : '',
					'state' => ($hasPreviousInput['state']) ? 'value="'.$userInput['state'].'"' : '',
					'zipCode' => ($hasPreviousInput['zipCode']) ? 'value="'.$userInput['zipCode'].'"' : '',
					'ssn' => ($hasPreviousInput['ssn']) ? 'value="'.$userInput['ssn'].'"' : ''
				);

				$optionSelected = ' selected="selected"';

				/*var_dump($errors);
				var_dump($userInput);
				var_dump($formValueAttribute);*/

				$has_errors = false;
				foreach ($errors as $key => $value) {
					if (isset($errors[$key]) && $value != false) {
						$has_errors = true;
					}
				}

				$selected = ' selected="selected"';

				?>

				<div class="form-hldr">
					<div id="error-message" class="all-fields-req cm-error" style="display: <?= $has_errors ? 'block' : 'none' ?>;">All fields required</div>

					<form class="form-horizontal" role="form" name="userInfoForm" action="./" method="POST" id="userInfoForm" onsubmit="return isValidForm();">

						<input type="hidden" name="action" value="<?= $this->processFormAction ?>">
						<div class="form-group form-group-lg">
							<div class="row">
								<div class="col-sm-12 form-pad">
									<input type="text" id="first-name" placeholder="First Name" name="firstName" maxlength="50" class="form-control" <?= $formValueAttribute['firstName'] ?>>
									<input type="hidden" id="middle-initial" name="middleInitial" maxlength="50" value=" ">
								</div>
								<div class="col-sm-12">
									<input type="text" id="last-name" placeholder="Last Name" name="lastName" maxlength="50" class="form-control" <?= $formValueAttribute['lastName'] ?>>
								</div>
							</div>
						</div>

						<div class="form-group form-group-lg">
							<div class="row">
								<div class="col-sm-24">
									<input type="text" id="address" placeholder="Street Address" name="streetAddress" maxlength="60"
									       class="form-control" <?= $formValueAttribute['streetAddress'] ?>>
								</div>
							</div>
						</div>

						<div class="form-group form-group-lg">
							<div class="row">
								<div class="col-sm-12 form-pad">
									<input type="text" id="city" placeholder="City" name="city" maxlength="50" class="form-control" <?= $formValueAttribute['city'] ?>>
								</div>
								<div class="col-sm-6 form-pad">
									<select id="state" name="state" class="form-control input-lg">

										<option value="ST"<?= ($userInput['state'] == 'ST') ? $optionSelected : '' ?>>State</option>

										<?php foreach($states as $abreviation => $state) : ?>

											<option value="<?= $abreviation ?>"<?= ($userInput['state'] == $abreviation) ? $optionSelected : '' ?>><?= $state ?></option>

										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-6">
									<input type="text" id="zip" placeholder="Zip" name="zipCode" maxlength="5" class="form-control" <?= $formValueAttribute['zipCode'] ?>>
								</div>
							</div>
						</div>

						<div class="form-group form-group-lg">

							<div class="row">

								<div class="col-xs-24 col-sm-24 col-md-10 col-lg-8 ssn-text"> Last 4 Digits of SSN <br>
									<span style="font-size:11px;">We don't store your information</span> </div>
									<div class="col-xs-9 col-sm-6 col-md-4 col-lg-3 cm-ssn-xxx-field"> XXX-XX-</div>
								<div class="col-xs-10 col-sm-8 col-md-5 col-lg-5">
									<input type="text" id="ssn-display" placeholder="_  _  _  _" maxlength="4" name="ssn-display" class="form-control" autocomplete="off">
									<input type="hidden" id="ssn" maxlength="4" name="ssn" style="display: none;" autocomplete="off">
								</div>
							</div>
						</div>

						<div class="cm-btn-hldr">
							<button class="btn btn-success btn-lg" id="form-submit" type="submit" name="submit" onclick="validateCardMatch(document.getElementById('userInfoForm'))"><i class="fa fa-lock fa-lg"></i>&nbsp;&nbsp;NEXT</button>
							<button class="btn btn-primary btn-lg btn-hide" id="go-back"> <i class="fa fa-angle-left" style="padding-right:10px;"></i>BACK</button>&nbsp;&nbsp;
						</div>
					</form>
				</div>

			</div>
			<div class="col-xs-24 col-sm-12 col-sm-pull-12 col-md-12 col-md-pull-12 col-lg-12 col-lg-pull-12 about-left-panel">
				<div class="row">
					<div class="col-md-24"><br>
						<br>
						<div class="row">
							<div class="col-xs-4 col-sm-3 col-md-3 about-icn-hldr"><img src="images/green-thumbsup-icn.png" width="61" height="61"></div>
							<div class="col-xs-20 col-sm-21 col-md-21 about-content-hldr">
								<h2>No impact to your credit score</h2>
								<p>A soft credit check will be performed when you fill out this form. This will be noted on your credit history but is not reported to lenders. This does not impact your credit score in any way.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-24"><br>
						<br>
						<div class="row">
							<div class="col-xs-4 col-sm-3 col-md-3 about-icn-hldr"><img src="images/green-lock-icn.png" width="61" height="61"></div>
							<div class="col-xs-20 col-sm-21 col-md-21 about-content-hldr">
								<h2>Your information is secure</h2>
								<p>We use 128-bit encryption to match you with offers. Your information will not be stored.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-24"><br>
						<br>
						<div class="row">
							<div class="col-xs-4 col-sm-3 col-md-3 about-icn-hldr"><img src="images/green-key-icn.png" width="61" height="61"></div>
							<div class="col-xs-20 col-sm-21 col-md-21 about-content-hldr">
								<h2>Your privacy is important</h2>
								<p>Your information will only be used to match you with offers which could include lower rates or better rewards.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include_once('templates/partials/footer.php');
include_once('templates/partials/footerScripts.php');

$channel = 'tools';
$pageName = 'tools:cardmatch_form';
$analyticsServer = '';
$pageType = '';
$prop1 = $pageName;
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'cardmatch';
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = '';
$analyticsProducts = '';
$purchaseId = '';
$eVar1 = '';
$eVar2 = '';
$eVar3 = '';
$eVar4 = '';
$eVar5 = '';
$eVar6 = '';
$eVar7 = '';
$eVar8 = '';
$eVar9 = '';
$eVar10 = '';
$eVar11 = '';
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>

<script>
	var learn_why = '<?= LANG_WHY_NOT_AFFECT_CREDIT ?>';
	var ssl_security = '<?= LANG_SSL_SECURITY ?>';
	var why_ssn = '<?= LANG_WHY_NEED_SSN ?>';

	function forceNumeric(obj) {
		obj.value = obj.value.replace(/\D/g, '');
	}

	// Validation variables
	var nameRx = /^[a-z.A-Z '0-9-]+$/;
	var addressRx = /^[a-z.A-Z '0-9#-]+$/;
	var cityRx = /^[a-z A-Z.'-]+$/;
	var zipRx = /(^\d{5}$)|(^\d{5}-\d{4}$)/;
	var digitsOnlyRx = /^[\d]+$/;
	var ssnRx = /(^\d{4}$)/;
	var ieAppName = "Microsoft Internet Explorer";
	var ieUserAgentRegex = /MSIE\s9/;
	var formComplete = false;
	var formCompletion = {
		firstName: false,
		lastName: false,
		address: false,
		city: false,
		state: false,
		zip: false,
		ssn: false
	};


	// Input references
	var $formInputs = $('#userInfoForm input');
	var $firstName = $('#first-name');
	var $lastName = $('#last-name');
	var $address = $('#address');
	var $city = $('#city');
	var $stateSelect = $('#state');
	var $zipInput = $('#zip');
	var $ssn = $('#ssn');
	var $ssnDisplay = $('#ssn-display');
	var $submitButton = $('#form-submit');
	var $backButton = $('#go-back');
	var $inputs = $('input');
	var $errorMessage = $('#error-message');


	// Error wrappers
	var $firstNameWrapper = $firstName.parent();
	var $lastNameWrapper = $lastName.parent();
	var $addressWrapper = $address.parent();
	var $cityWrapper = $city.parent();
	var $stateSelectWrapper = $stateSelect.parent();
	var $zipInputWrapper = $zipInput.parent();
	var $ssnDisplayWrapper = $ssnDisplay.parent();


	// Custom event override variables
	var shiftTabKeyMap = { 9: false, 16: false};
	var zipTextSelected = false;
	var ssnTextSelected = false;
	var zipTextSelection = null;
	var ssnTextSelection = null;

	function isNonEmpty(inputValue) {
		if (inputValue === null || inputValue == '' || typeof inputValue == 'undefined') {
			return false;
		}
		return true;
	}

	function isValidFirstName() {
		var inputValue = $firstName.val().trim();
		var isValid = isNonEmpty(inputValue) && nameRx.test(inputValue);
		return isValid;
	}

	function isValidLastName() {
		var inputValue = $lastName.val().trim();
		var isValid = isNonEmpty(inputValue) && nameRx.test(inputValue);
		return isValid;
	}

	function isValidAddress() {
		var inputValue = $address.val().trim();
		var isValid = isNonEmpty(inputValue) && addressRx.test(inputValue);
		return isValid;
	}

	function isValidCity() {
		var inputValue = $city.val().trim();
		var isValid = isNonEmpty(inputValue) && cityRx.test(inputValue);
		return isValid;
	}

	function isValidState() {
		var selectedValue = $stateSelect.val();
		var isValid = true;
		if (selectedValue === null || selectedValue == 'ST' || typeof selectedValue == 'undefined') {
			isValid = false;
		}
		return isValid;
	}

	function isValidZip() {
		var inputValue = $zipInput.val().trim();

		return zipRx.test(inputValue);
	}

	function isValidSsn() {
		var inputValue = $ssn.val().trim();

		if ($ssn.val().length != $ssnDisplay.val().length) {
			$ssn.val('');
			$ssnDisplay.val('');
		}

		return ssnRx.test(inputValue);
	}

	function isValidForm() {
		formCompletion.firstName = isValidFirstName();
		formCompletion.lastName = isValidLastName();
		formCompletion.address = isValidAddress();
		formCompletion.city = isValidCity();
		formCompletion.state = isValidState();
		formCompletion.zip = isValidZip();
		formCompletion.ssn = isValidSsn();

		formComplete = formCompletion.firstName && formCompletion.lastName && formCompletion.address && formCompletion.city && formCompletion.state && formCompletion.zip && formCompletion.ssn;

		if (!formComplete) {
			toggleErrors();
		}

		return formComplete;
	}

	function toggleErrors() {
		if (!formCompletion.firstName) {
			$firstNameWrapper.addClass('has-error');
		} else {
			$firstNameWrapper.removeClass('has-error');
		}
		if (!formCompletion.lastName) {
			$lastNameWrapper.addClass('has-error');
		} else {
			$lastNameWrapper.removeClass('has-error');
		}
		if (!formCompletion.address) {
			$addressWrapper.addClass('has-error');
		} else {
			$addressWrapper.removeClass('has-error');
		}
		if (!formCompletion.city) {
			$cityWrapper.addClass('has-error');
		} else {
			$cityWrapper.removeClass('has-error');
		}
		if (!formCompletion.state) {
			$stateSelectWrapper.addClass('has-error');
		} else {
			$stateSelectWrapper.removeClass('has-error');
		}
		if (!formCompletion.zip) {
			$zipInputWrapper.addClass('has-error');
		} else {
			$zipInputWrapper.removeClass('has-error');
		}
		if (!formCompletion.ssn) {
			$ssnDisplayWrapper.addClass('has-error');
		} else {
			$ssnDisplayWrapper.removeClass('has-error');
		}

		if (!formComplete) {
			$errorMessage.show();
		} else {
			$errorMessage.hide();
		}
	}

	$(document).ready(function() {
		// IE9 fix, populate inputs with placeholder text & submit form correctly
		if (ieAppName == navigator.appName && ieUserAgentRegex.test(navigator.userAgent)) {
			$inputs.each(function (){
				$(this).val($(this).attr('placeholder'));
			});

			$inputs.focusin(function() {
				if ($(this).attr('placeholder') == $(this).val()){
					$(this).val('');
				}
			});

			$inputs.focusout(function() {
				if ($(this).val() == '') {
					$(this).val($(this).attr('placeholder'));
				}
			});

			$('input[name="action"]').val('process_form');
		}

		// on page load, make sure font color is darker if user input values are used for form inputs
		$formInputs.each(function() {
			var value = $(this).val();
			var valueIsPlaceholder = value == 'First Name' || value == 'Last Name' || value == 'Street Address' || value == 'City' || value == 'Zip Code';
			if (value != '' && !valueIsPlaceholder) {
				$(this).attr('style', 'color: #787878;');
			} else {
				$(this).attr('style', '');
			}
		});
		// on page load, make sure font color is darker if user input values are used for form select
		var validState = $stateSelect.find('option:selected').val() != 'ST';
		if (validState) {
			$stateSelect.attr('style', 'color: #787878;');
		}

		// special toggle & listener for tab / tab + shift on zip and ssn fields
		$(document).keydown(function (e){
			if (e.keyCode == 9 || e.keyCode == 16) {
				shiftTabKeyMap[e.keyCode] = true;
				if (shiftTabKeyMap[9] && shiftTabKeyMap[16]) {
					shiftTabKeyMap[9] = false;
					shiftTabKeyMap[16] = false;
					if ($zipInput.is(':focus')) {
						$stateSelect.focus();
					}
					else if ($ssnDisplay.is(':focus')) {
						$zipInput.focus();
					}
				}
			}
		});
		$(document).keyup(function (e){
			if (e.keyCode == 9 || e.keyCode == 16) {
				shiftTabKeyMap[e.keyCode] = false;
			}
		});

		// check for text highlight selection on ssn and zip
		$ssnDisplay.on('mouseup', function(){
			var startPos = this.selectionStart;
			var endPos = this.selectionEnd;
			var length = endPos - startPos;
			var inputText = $ssn.val();

			if (length == 0) {
				ssnTextSelected = false;
			} else {
				ssnTextSelected = true;
			}

			ssnTextSelection = inputText.substr(startPos, length);
		});

		$zipInput.on('mouseup', function(){
			var startPos = this.selectionStart;
			var endPos = this.selectionEnd;
			var length = endPos - startPos;
			var inputText = $zipInput.val();

			if (length == 0) {
				zipTextSelected = false;
			} else {
				zipTextSelected = true;
			}

			zipTextSelection = inputText.substr(startPos, length);
		});

		// event listeners to prevent non numeric input for ssn and zip
		$ssnDisplay.keydown(function (e) {
			e.preventDefault();
			var inputIsNumeric = (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105);
			var inputIsDelete = (e.keyCode == 46);
			var inputIsBackspace = e.keyCode == 8;
			var inputIsEnter = e.keyCode == 13;
			var inputValue = $ssnDisplay.val();
			var outputValue = $ssn.val();
			var numericKeycode = e.keyCode;

			// tested in Chrome, for some reason String.fromCharCode() for 96 -> 105 doesn't return the right numeric key
			if (e.keyCode >= 96 && e.keyCode <= 105) {
				numericKeycode = e.keyCode - 48;
			}

			// on tab, go to next form element (back button)
			if (e.keyCode == 9 && !shiftTabKeyMap[16]) {
				$backButton.focus();
			}

			if (inputIsNumeric && inputValue.length < 4 && !shiftTabKeyMap[16]) {
				$ssn.val(outputValue + String.fromCharCode(numericKeycode));
				$ssnDisplay.val(inputValue + '*');
			}
			if (inputIsBackspace && inputValue.length > 0) {
				$ssn.val(outputValue.substring(0, outputValue.length - 1));
				$ssnDisplay.val(inputValue.substring(0, inputValue.length - 1));
			}
			if (inputIsDelete) {
				$ssn.val('');
				$ssnDisplay.val('');
			}
			if (outputValue.length == 4) {
				if (isValidSsn()) {
					formCompletion.ssn = true;
				} else {
					formCompletion.ssn = false;
				}
				if (inputIsEnter && isValidForm()) {
					$submitButton.trigger('click');
				}
			}
		});

		$zipInput.keydown(function (e) {
			e.preventDefault();
			var inputIsNumeric = (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105);
			var inputIsDelete = (e.keyCode == 46);
			var inputIsBackspace = e.keyCode == 8;
			var inputIsEnter = e.keyCode == 13;
			var inputValue = $(this).val();
			var numericKeycode = e.keyCode;

			// on tab, go to next input (ssn)
			if (e.keyCode == 9 && !shiftTabKeyMap[16]) {
				$ssnDisplay.focus();
			}

			// tested in Chrome, for some reason String.fromCharCode() for 96 -> 105 doesn't return the right numeric key
			if (e.keyCode >= 96 && e.keyCode <= 105) {
				numericKeycode = e.keyCode - 48;
			}

			if (inputIsNumeric && inputValue.length < 5 && !shiftTabKeyMap[16]) {
				$(this).val(inputValue + String.fromCharCode(numericKeycode));
			}
			if (inputIsBackspace && inputValue.length > 0) {
				$(this).val(inputValue.substring(0, inputValue.length - 1));
			}
			if (inputIsDelete) {
				$(this).val('');
			}
			if (inputValue.length == 5) {
				if (isValidZip()) {
					formCompletion.zip = true;
				} else {
					formCompletion.zip = false;
				}
				if (inputIsEnter && isValidForm()) {
					$submitButton.trigger('click');
				}
			}
		});

		// event listeners to toggle next button and change text color
		$formInputs.keyup(function (e) {
			var inputEmpty = $(this).val() == '';

			if (!inputEmpty) {
				$(this).attr('style', 'color: #787878;');
			} else {
				$(this).attr('style', '');
			}
		});

		$formInputs.change(function (e) {
			var inputEmpty = $(this).val() == '';

			if (!inputEmpty) {
				$(this).attr('style', 'color: #787878;');
			} else {
				$(this).attr('style', '');
			}
		});

		$backButton.click(function(event){
			event.preventDefault();
			var url = location.protocol + '//' + location.hostname + '/cardmatch/index.php?action=index';
			document.location = url;
		});
	});
</script>


</body>
</html>
