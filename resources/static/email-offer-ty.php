<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = '';
$metaKeywords = '';
$metaDescription = '';
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
?>

<link href="/css/cc-misc.css" rel="stylesheet">
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">

			<div class="alert alert-success" role="alert">
				<strong>Thank you!</strong> The link to the credit card offer will be emailed to the recipient.
			</div>

			<p style="cursor:pointer; text-decoration:underline;" onClick="parent.tb_remove();">Continue browsing cards</p>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');
?>

</body>
</html>