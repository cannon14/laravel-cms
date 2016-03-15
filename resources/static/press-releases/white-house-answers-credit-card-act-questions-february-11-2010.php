<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1350';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'The White House to Answer Consumer Questions About the Credit CARD Act at CreditCards.com';
$metaKeywords = 'creditcards.com, credit cards, credit card, Visa, Mastercard, Discover, American Express, offers, apply online, credit card application, articles';
$metaDescription = 'On Feb 22, 2010, CreditCards.com will host a live, interactive town hall with the White House to discuss the newly enacted credit card laws. The Credit CARD Act of 2009 is the most sweeping credit card reform in history, and the White House is inviting consumers to ask questions and share opinions with Austan Goolsbee from the Council of Economic Advisers. Join the conversation live at 2pm EST by visiting CreditCards.com/askthewhitehouse.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
?>
</head>

<body>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">

			<div class="other-subnav-hldr">
				<ol class="breadcrumb-other">
					<li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/about-us.php">About Us</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/about-us/press-releases.php">Press Releases</a> <i class="fa fa-angle-right"></i></li>
					<li>The White House to Answer Consumer Questions About the Credit CARD Act at CreditCards.com</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<h1>The White House to Answer Consumer Questions About the Credit CARD Act at CreditCards.com</h1>

			<p><span class="press-release-date">Date: Feb. 11, 2010</span></p>

			<p>Austin, Texas</p>
			<h2 class="alignLeft">Summary</h2><br/>
			<p>On Feb. 22, 2010, CreditCards.com will host a live,  interactive online video <strong>town hall discussion of credit card reform </strong>during  which consumers can directly ask questions of White House economic adviser  Austan Goolsbee <strong>. </strong><br>
			<strong>American consumers are invited to participate</strong> by  submitting questions, responding to real-time polls and viewing live streaming  video from the White House.</p>

			<ul>
			<li>What: Credit CARD Act online video town hall  with Austan Goolsbee, of the president&rsquo;s Council of Economic Advisers.</li>
			<li>When: Feb. 22, 2010 &ndash; the day the law goes into  effect &ndash; at 2PM Eastern time</li>
			<li>Where:&nbsp; <a href="http://www.creditcards.com/askthewhitehouse">www.creditcards.com/askthewhitehouse</a></li>
			</ul>
			<br/>
			<h2 class="alignLeft">The News</h2>

			<p>The Credit CARD Act of 2009 is the most sweeping credit card  reform in history and offers consumers new protection from unfair or deceptive  credit card practices.<br>
			CreditCards.com is pleased to host a live, interactive CARD  Act town hall meeting.&nbsp; In the meeting,  Goolsbee will describe the impact of the reform and field questions submitted  by consumers.<br>
			The town hall event will be Monday, Feb. 22, 2010 at 2PM  Eastern, and can be found at <a href="http://www.creditcards.com/askthewhitehouse">www.creditcards.com/askthewhitehouse</a>&nbsp; <br>
			Answering questions from the White House will be Austan  Goolsbee, a member of the president&rsquo;s Council of Economic Advisers.<br>
			Consumers are encouraged to join the conversation by submitting  questions, offering opinions and responding to real-time poll questions. Consumers  may submit their questions in advance on the same page, or by posing questions  on the social networking site Twitter using the hashtag #cardlaw.<br>
			For more information on what is &ndash; and isn&rsquo;t &ndash; covered in the  Credit CARD Act, consumers are invited to review CreditCards.com Guide to the  Credit CARD Act of 2009 at <a href="http://www.creditcards.com/reform">www.creditcards.com/reform</a> <br>

			<h2 class="alignLeft">Quotes</h2><br/>

			<p>CreditCards.com President and CEO Elisabeth  DeMarse <br>
			&ldquo;The Credit CARD Act gives cardholders new rights and protections, and  fundamentally changes the relationship between cardholders and card  issuers.&nbsp; We&rsquo;re excited to work with the  White House to ensure that the reform message reaches American consumers.&rdquo; </p>

			<h2 class="alignLeft">About CreditCards.com</h2><br/>
			<p>CreditCards.com is the leading online credit card  marketplace connecting consumers with multiple credit card issuers.  CreditCards.com, (<a href="http://www.creditcards.com">http://www.creditcards.com</a> ), enables consumers to search for, compare and apply for credit cards and  offers credit card advice, news, statistics and tools.&nbsp; In 2009, more than 12 million consumers used  CreditCards.com to make smart choices about credit cards. CreditCards.com was  recently named a &ldquo;Best Site for Managing Your Credit&rdquo; by <em>MSN Money.</em></p>
			<p>
			Contact:
			<br />
			CreditCards.com, Austin
			<br />
			Ben Woolsey, 512-996-8663, ext. 106
			<br />
			Director of Marketing
			<br />
			<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com">				</p>
			<p>NOTE TO EDITORS: The information contained in this release is available for print or
			broadcast with attribution to CreditCards.com.</p>
			<p>Source: CreditCards.com</p>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');
?>

</body>
</html>
