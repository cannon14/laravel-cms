<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = empty($this->title) ? 'CardMatch - CreditCards.com' : $this->title;
$metaDescription = empty($this->keywords) ? '' : $this->keywords;
$metaKeywords = empty($this->description) ? '' : $this->description;
include_once('templates/partials/htmlHead.php');
?>
	<style>
		a:visited {
			color: #156abd!important;
		}
	</style>
</head>

<body>

<?php include_once('templates/partials/header.php'); ?>

<!-- Steps Block-->
<div class="steps-block">
	<div class="container">
		<div class="row">
			<div class="col-xs-6 col-sm-5 col-md-6 inactive-step mobile-hide"><i class="fa fa-check-circle green-check"></i> About You</div>
			<div class="col-xs-3 col-sm-2 col-md-2 step-arrow-hldr mobile-hide"><i class="fa fa-long-arrow-right step-arrow"></i></div>
			<div class="col-xs-6 col-sm-7 col-md-8 inactive-step mobile-hide"><i class="fa fa-check-circle green-check"></i> Terms & Conditions</div>
			<div class="col-xs-3 col-sm-2 col-md-2 step-arrow-hldr mobile-hide"><i class="fa fa-long-arrow-right step-arrow"></i></div>
			<div class="col-xs-24 col-sm-8 col-md-6 active-step">
				<div class="blue-circle"><i class="fa fa-spinner fa-spin"></i></div>
				Card Matches</div>
		</div>
	</div>
</div>

<!-- Process Block-->
<div class="progress-block">
	<div class="container">
		<div class="row">
			<div class="col-md-24">
				<div class="searching-hldr">
					<div class="progress-header-text">We are <span class="progress-header-greentext">searching for your matches</span>, <?= $this->user->getFirstName() ?>...</div>
					<div class="progress-header-subtext">This should take less than 60 seconds</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-24">
				<div class="searching-hldr">
					<div class="progress-header-subtext" style="font-size: 16.5px">If your matches are not displayed, <a href="/site-feedback.php" target="_blank">please let us know</a></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include_once('templates/partials/footer.php');
include_once('templates/partials/footerScripts.php');
?>

<script>
	var ieUserAgentRegex = /MSIE\s9/;
	var ieAppName = "Microsoft Internet Explorer";

	function processInquiry() {

		var url = '/cardmatch/index.php';

		var params = {
			action: 'process_inquiry'
		};

		var timeout = 60; // seconds

		$.ajax({
			type: "POST",
			url: url,
			data: params,
			success: handleResponse,
			error: handleError,
			timeout: timeout * 1000,
			dataType: 'json' // If the session breaks, we get HTML
		});


	}

	function handleResponse(response) {
		var delay = 3000;
		setTimeout(function() {
			executeRedirect(response.action);
		}, delay);
	}

	function executeRedirect(action) {

		var url = location.protocol + '//' + location.hostname + '/cardmatch/index.php?action=' + action;
		// IE9 specific fix
		if (ieAppName == navigator.appName && ieUserAgentRegex.test(navigator.userAgent)) {
			var timestamp = (function() { return new Date().getTime(); })();
			url += '&timestamp=' + timestamp;
		}
		document.location = url;
	}

	function handleError(type, status) {
		var action = 'server_error';
		var url = location.protocol + '//' + location.hostname + '/cardmatch/index.php?action=' + action;
		document.location = url;
	}

	$(document).ready(function (){
		processInquiry();
	});
</script>

</body>
</html>
