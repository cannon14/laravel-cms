<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "2387";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/geoip.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<?php

$htmlTitle = 'Finding the Best Card for You';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
?>
<link href="/css/cc-misc.css" rel="stylesheet" type="text/css">
</head>
<body>
								
<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>
								
<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">
			<!--Beginning of main text-->
			<a data-target="#myModalDisclosure" data-toggle="modal" href="#"><img width="120" height="9" src="/images/advertiser_dis_text.png" class="pull-right"></a>
			<h1>Finding the Best Card for You</h1>
			<p>To some, credit cards are perceived as an 'evil'	ploy  that can easily cause someone to spiral into debt. However, recently more  personal finance experts are turning a new leaf on the subject and supporting  the claim that when used <em>responsibly</em>,  credit cards can help you manage money and earn you tremendous perks while  doing it. </p>
			<p>So then, how do you  know which type of card is right for you? Let us break out the perks of each category.</p>

			<a href="/airline-miles.php"><img src="../features/images/travel-rewards-cards.jpg">
				<br><div class="btn btn-learn-more btn-lg">Learn More</div><br>
				<p><b>Travel Reward Cards</b></p>
			</a>
			<p>On top of offering sign up bonuses ranging $100-$400 simply for hitting a minimum spend  requirements in the first few months of account opening, travel credit cards offer  anywhere from 1-10x points on purchases you are already making. These can add  up quickly and can be redeemed for valuable travel rewards such as flights,  hotels, or cruises. These cards only work in your favor if you pay the  statement balance each month, so only spend within your monthly budget.</p>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tbody>
						<tr>
	                        <td colspan='2'><strong>What to Know:</strong></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Points can be used to splurge on a flight upgrade you normally wouldn't pay for.</li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Some cards come with perks such as priority boarding, elite status, or free checked luggage.</li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>These cards typically come with higher than average annual fees, and interest rates. Be sure these expenses don't cost more than the value you earn from membership.</li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Be on the lookout for limited time offers, or sign-up bonuses. These can help justify an annual fee.</li></ul></td>
						</tr>
					</tbody>
				</table>
			</div>

			<a href="/balance-transfer.php"><img src="../features/images/balance-transfer-cards.jpg">
				<br><div class="btn btn-learn-more btn-lg">Learn More</div><br>
				<b>Balance Transfer Cards:</b>
			</a>
			<p>Balance  transfer credit cards allow you to transfer a balance from a high interest  credit card you currently have to a new card with a lower interest rate. Depending  on your circumstances, you could save hundreds of dollars on interest each year.</p>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tbody>
						<tr>
	                        <td colspan='2'><strong>What to Know:</strong></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Most banks offer a product with an intro balance transfer rate of 0% for between 12 - 21 months.</li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Be sure to take note of what the standard interest rate will default to after your intro period ends. You don't want to end up with a card that has a higher interest rate than what is already in your wallet.</li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Many banks charge fees ranging from 3-5% to transfer a balance. Take this into account before you apply for any product.</li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Keep an eye out for special offers. Often times, you can find a card that waives the balance transfer fee, if you transfer a balance within the first 60 days of account opening.</li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Balance transfer products are typically pretty bare bones. Don't expect new customer bonuses, or flashy rewards.</li></ul></td>
						</tr>
					</tbody>
				</table>
			</div>

			<a href="/cash-back.php"><img src="../features/images/cash-back-cards.jpg">
				<br><div class="btn btn-learn-more btn-lg">Learn More</div><br>
				<b>Cash Back Cards:</b>
			</a>
			<p>This  type of credit card allows you to earn cash rewards for making purchases. The  more the card is used, the more cash rewards you receive.</p>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tbody>
						<tr>
	                        <td colspan='2'><strong>What to Know:</strong></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Some cards offer a fixed rate of 1 or 2% cash back on all purchases, while others offer 5% cash back in rotating categories.  Be on the lookout for categories you have to sign-up for. </li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Many cash back cards have a sign-up bonus. A popular bonus right now is $100 after meeting a spending requirement within 3 months. </li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Like travel rewards cards, many cash back cards will carry an annual fee, and a slightly higher interest rate.  Will you use your card enough to justify any added expenses?</li></ul></td>
						</tr>
					</tbody>
				</table>
			</div>
								
			<a href="/low-interest.php"><img src="../features/images/low-interest-cards.jpg">
				<br><div class="btn btn-learn-more btn-lg">Learn More</div><br>
				<b>Low Interest Cards:</b>
			</a>
			<p>Low interest credit cards offer either a low introductory APR for a certain period, or a single low rate APR. Low interest cards can be very useful for consumers that know they will be carrying a balance.</p>
				<div class="table-responsive">
					<table class="table table-bordered">
						<tbody>
							<tr>
	                            <td colspan='2'><strong>What to Know:</strong></td>
							</tr>
							<tr>
								<td colspan='2'><ul><li>Before using a low interest card, read all the terms and conditions of the introductory rate so you're not surprised by fees or accumulated interest.</li></ul></td>
							</tr>
							<tr>
								<td colspan='2'><ul><li>Cards may offer 0% on purchases for as many as 21 months. This can be a great tool for those looking to pay a large purchase off over a period of time.</li></ul></td>
							</tr>
							<tr>
								<td colspan='2'><ul><li>Be sure you pay your bill each month. Missing a payment can result in the loss of any promotional APR period.</li></ul></td>
							</tr>
						</tbody>
					</table>
				</div>

			<a href="https://www.creditcards.com/cardmatch/?action=show_form"><img src="../features/images/cardmatch.jpg">
				<br><div class="btn btn-learn-more btn-lg">Learn More</div><br>
				<b>CardMatch:</b>
			</a>
			<p>Still unsure? It can be overwhelming to sort through all of the credit card offers available to consumers. Let CardMatch help by matching your credit profile to offers that you are more likely to qualify for. Matched cards are sorted by card type for your convenience. This will help you save time by narrowing down your list of potential cards to apply for, and help prevent any unnecessary credit inquires.</p>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tbody>
						<tr>
			                <td colspan='2'><strong>What to Know:</strong></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>Cards are matched to your credit profile.</li></ul></td>
						</tr>
						<tr>
							<td colspan='2'><ul><li>CardMatch is not an application for credit. Your credit score will not be affected.</li></ul></td>
						</tr>
					</tbody>
				</table>
			</div>
			<br>
			<br>
			<br>
			<p><em>This promotional feature was produced by the CreditCards.com marketing team. Content has not been reviewed, approved or otherwise endorsed by any party mentioned in the feature. The CreditCards.com Editorial staff was not involved in the creation of this content.</em></p>
		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->


		<!-- Adobe Marketing Cloud Tag Loader Code
Copyright 1996-2013 Adobe, Inc. All Rights Reserved
More info available at http://www.adobe.com/solutions/digital-marketing.html --> 
		<script type="text/javascript">//<![CDATA[
var amc=amc||{};if(!amc.on){amc.on=amc.call=function(){}};
document.write("<scr"+"ipt type=\"text/javascript\" src=\"//www.adobetag.com/d1/v2/ZDEtY3JlZGl0Y2FyZHNjb20tNTY5NS0yMTg0/amc.js\"></sc"+"ript>");
//]]></script> 
		<!-- End Adobe Marketing Cloud Tag Loader Code --> 
		<script language="JavaScript" type="text/javascript">
/* You may give each page an identifying name, server, and channel on
the next lines. */
s.pageName="features:finding-the-best-card-for-you"
s.server=""
s.channel="features"
s.pageType=""
s.prop1="finding-the-best-card-for-you"
s.prop2=""
s.prop3=""
s.prop4=""
s.prop5=""
s.prop6=""
s.prop7=""
s.prop8=""
/* Conversion Variables */
s.campaign="<?= isset($_SESSION['aid']) ? $_SESSION['aid'] : 0;?>-<?= isset($_SESSION['banner_id']) ? $_SESSION['banner_id'] : 0;?>-<?= isset($_SESSION['cid']) ? $_SESSION['cid'] : 0;?>-<?= isset($_SESSION['did']) ? $_SESSION['did'] : 0;?>"
s.state=""
s.zip=""
s.events=""
s.products=""
s.purchaseID=""
s.eVar1=""
s.eVar2=""
s.eVar3=""
s.eVar4=""
s.eVar5=""
s.eVar6=""
s.eVar7=""
s.eVar8=""
s.eVar9=""
s.eVar10=""
s.eVar11=""
s.eVar27="";
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script> 
		<script language="JavaScript" type="text/javascript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script>
		<noscript>
		<img src="http://creditcardscom.112.2o7.net/b/ss/ccardsccdc-us/1/H.25--NS/0"
height="1" width="1" border="0" alt="" />
		</noscript>
		<!--/DO NOT REMOVE/--> 
		<!-- End SiteCatalyst code version: H.25. -->
<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');
?>			
</body>
</html>